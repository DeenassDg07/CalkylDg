<?php

namespace App\Services;

use App\Controllers\AuthController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

class TwigService
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;

      
        $this->twig->addExtension(new DebugExtension());

        
        $this->addGlobalVariables();
    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }

   
    public function render(string $template, array $context = []): string
    {
        return $this->twig->render($template, $context);
    }

    private function addGlobalVariables(): void
    {
        $this->twig->addGlobal('current_year', date('Y'));
        $this->twig->addGlobal('app_name', 'Наш сайт');
        $this->twig->addGlobal('base_url', $this->getBaseUrl());
        
     
        $this->twig->addGlobal('auth', [
            'isAuthenticated' => AuthController::isAuthenticated(),
            'username' => AuthController::getUsername(),
            'isAdmin' => AuthController::isAdmin(),
            'user' => AuthController::getCurrentUser()
        ]);
    }

  
    private function getBaseUrl(): string
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
            ? 'https' 
            : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        
        return $protocol . '://' . $host;
    }
}