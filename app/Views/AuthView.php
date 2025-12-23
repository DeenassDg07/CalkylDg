<?php

namespace App\Views;

use App\Services\TwigService;

class AuthView
{
    private TwigService $twigService;

    public function __construct(TwigService $twigService)
    {
        $this->twigService = $twigService;
    }

    public function showRegisterForm(array $errors = [], array $data = []): string
    {
        $html = $this->twigService->render('auth/register.twig', [
            'errors' => $errors,
            'data' => $data,
            'title' => 'Регистрация'
        ]);
        
        return $html;
    }

    public function showLoginForm(array $errors = [], array $data = []): string
    {
        $html = $this->twigService->render('auth/login.twig', [
            'errors' => $errors,
            'data' => $data,
            'title' => 'Вход'
        ]);
        
        return $html;
    }
}