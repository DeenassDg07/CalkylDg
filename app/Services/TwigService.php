<?php

namespace App\Services;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

class TwigService
{
    private Environment $twig;

    public function __construct()
    {
        // Пути к шаблонам и кэшу
        $templatePath = __DIR__ . '/../../templates';
        $cachePath = __DIR__ . '/../../var/cache/twig';

        // Создаем папку для кэша, если её нет
        if (!is_dir($cachePath)) {
            mkdir($cachePath, 0755, true);
        }

        // Создаем загрузчик шаблонов
        $loader = new FilesystemLoader($templatePath);

        // Настройки Twig
        $options = [
            'cache' => $cachePath,
            'auto_reload' => true,
            'debug' => true
        ];

        // Создаем экземпляр Twig
        $this->twig = new Environment($loader, $options);

        // Добавляем расширение для отладки
        $this->twig->addExtension(new DebugExtension());

        // Добавляем глобальные переменные
        $this->addGlobalVariables();
    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }

    /**
     * Рендерит шаблон с переданными параметрами
     */
    public function render(string $template, array $context = []): string
    {
        return $this->twig->render($template, $context);
    }

    /**
     * Добавляет глобальные переменные доступные во всех шаблонах
     */
    private function addGlobalVariables(): void
    {
        $this->twig->addGlobal('current_year', date('Y'));
        $this->twig->addGlobal('app_name', 'Flat-File CMS');
        $this->twig->addGlobal('base_url', $this->getBaseUrl());
    }

    /**
     * Получает базовый URL приложения
     */
    private function getBaseUrl(): string
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
            ? 'https' 
            : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        
        return $protocol . '://' . $host;
    }
