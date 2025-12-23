<?php

namespace App\Controllers;

use App\Models\User;
use App\Views\AuthView;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthController
{
    private User $userModel;
    private AuthView $authView;

    public function __construct(User $userModel, AuthView $authView)
    {
        $this->userModel = $userModel;
        $this->authView = $authView;
    }

    public function showRegister(): ResponseInterface
    {
        $html = $this->authView->showRegisterForm();
        return $this->responseWrapper($html);
    }

    public function showLogin(): ResponseInterface
    {
        $html = $this->authView->showLoginForm();
        return $this->responseWrapper($html);
    }

    public function register(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        
        $username = trim($data['username'] ?? '');
        $password = $data['password'] ?? '';
        $confirm_password = $data['confirm_password'] ?? '';
        
        $errors = $this->validateRegistration($username, $password, $confirm_password);
        
        if (!empty($errors)) {
            $html = $this->authView->showRegisterForm($errors, ['username' => $username]);
            return $this->responseWrapper($html);
        }

        if ($this->userModel->create($username, $password)) {
            $user = $this->userModel->findByUsername($username);
            $this->startSession($user);
            
            $response = new Response();
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/');
        }

        $errors['username'] = 'Этот логин уже занят';
        $html = $this->authView->showRegisterForm($errors, ['username' => $username]);
        return $this->responseWrapper($html);
    }

    public function login(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        
        $username = trim($data['username'] ?? '');
        $password = $data['password'] ?? '';
        
        $errors = $this->validateLogin($username, $password);
        
        if (!empty($errors)) {
            $html = $this->authView->showLoginForm($errors, ['username' => $username]);
            return $this->responseWrapper($html);
        }

        $user = $this->userModel->validateCredentials($username, $password);

        if ($user) {
            $this->startSession($user);
            
            $response = new Response();
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/');
        }

        $errors['general'] = 'Неверный логин или пароль';
        $html = $this->authView->showLoginForm($errors, ['username' => $username]);
        return $this->responseWrapper($html);
    }

    public function logout(): ResponseInterface
    {
        $this->destroySession();
        
        $response = new Response();
        return $response
            ->withStatus(302)
            ->withHeader('Location', '/');
    }

    private function validateRegistration(string $username, string $password, string $confirmPassword): array
    {
        $errors = [];

        if (empty($username)) {
            $errors['username'] = 'Логин обязателен';
        } elseif (strlen($username) < 3) {
            $errors['username'] = 'Логин должен быть не менее 3 символов';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $errors['username'] = 'Логин может содержать только буквы, цифры и подчеркивание';
        }

        if (empty($password)) {
            $errors['password'] = 'Пароль обязателен';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'Пароль должен быть не менее 6 символов';
        }

        if ($password !== $confirmPassword) {
            $errors['confirm_password'] = 'Пароли не совпадают';
        }

        return $errors;
    }

    private function validateLogin(string $username, string $password): array
    {
        $errors = [];

        if (empty($username)) {
            $errors['username'] = 'Логин обязателен';
        }

        if (empty($password)) {
            $errors['password'] = 'Пароль обязателен';
        }

        return $errors;
    }

    private function startSession(array $user): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];
    }

    private function destroySession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
    }

    public static function isAuthenticated(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['user']);
    }

    public static function getCurrentUser(): ?array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return $_SESSION['user'] ?? null;
    }

    public static function isAdmin(): bool
    {
        $user = self::getCurrentUser();
        return $user && $user['role'] === 'admin';
    }

    public static function getUsername(): ?string
    {
        $user = self::getCurrentUser();
        return $user['username'] ?? null;
    }

    private function responseWrapper(string $html): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write($html);
        return $response;
    }
}