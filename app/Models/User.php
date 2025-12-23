<?php

namespace App\Models;

use App\Core\FileManeger;

class User
{
    private const USERS_FILE = ROOT_DIR . 'data/users.json';
    private array $users = [];

    public function __construct()
    {
        $this->loadUsers();
    }

    private function loadUsers(): void
    {
        $content = FileManeger::read(self::USERS_FILE);
        if ($content) {
            $this->users = json_decode($content, true) ?? [];
        }
    }

    private function saveUsers(): bool
    {
        return FileManeger::write(self::USERS_FILE, json_encode($this->users, JSON_PRETTY_PRINT));
    }

    public function create(string $username, string $password): bool
    {
        if ($this->findByUsername($username)) {
            return false;
        }

        $this->users[] = [
            'id' => uniqid('user_', true),
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
            'role' => 'user'
        ];

        return $this->saveUsers();
    }

    public function findByUsername(string $username): ?array
    {
        foreach ($this->users as $user) {
            if ($user['username'] === $username) {
                return $user;
            }
        }
        return null;
    }

    public function findById(string $id): ?array
    {
        foreach ($this->users as $user) {
            if ($user['id'] === $id) {
                return $user;
            }
        }
        return null;
    }

    public function validateCredentials(string $username, string $password): ?array
    {
        $user = $this->findByUsername($username);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return null;
    }

    public function getAll(): array
    {
        return $this->users;
    }
}