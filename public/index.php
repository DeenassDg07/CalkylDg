<?php

require '/home/user/www/calkylDg/vendor/autoload.php';
require '/home/user/www/calkylDg/config/settings.php';
use App\Controllers\ArticleController;
use App\Controllers\AuthController;
use App\Models\Article;
use App\Models\User;
use App\Services\TwigService;
use App\Views\ArticleView;
use App\Controllers\ArticleController;
use App\Models\Article;
use Laminas\Diactoros\ServerRequestFactory;
use League\Container\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


//---------------------------------------------------------------------------------
require __DIR__ . '/../vendor/autoload.php';

// Настройка ошибок
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Настройка Whoops для отображения ошибок
$whoops = new \Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();

// Создаем контейнер зависимостей
$container = new League\Container\Container;

// Настройка Twig
$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader, [
    'debug' => true,
    'cache' => __DIR__ . '/../cache',
]);

// Регистрируем сервисы
$container->add(TwigService::class)->addArgument(Environment::class);
$container->add(Environment::class, $twig);

// Регистрируем модели
$container->add(Article::class);
$container->add(User::class);

// Регистрируем Views
$container->add(ArticleView::class)->addArgument(TwigService::class);
$container->add(AuthView::class)->addArgument(TwigService::class);

// Регистрируем контроллеры
$container->add(ArticleController::class)
    ->addArgument(ArticleView::class)
    ->addArgument(Article::class);

$container->add(AuthController::class)
    ->addArgument(User::class)
    ->addArgument(AuthView::class);

// Создаем роутер
$router = new League\Route\Router;

// Настраиваем роуты
$router->get('/', function () use ($container) {
    $controller = $container->get(ArticleController::class);
    return $controller->showHome();
});

$router->get('/articles', function () use ($container) {
    $controller = $container->get(ArticleController::class);
    return $controller->list();
});

$router->get('/article/{id}', function ($args) use ($container) {
    $controller = $container->get(ArticleController::class);
    $controller->show($args['id']);
});

$router->get('/calc', function () use ($container) {
    $controller = $container->get(ArticleController::class);
    return $controller->calc();
});

$router->post('/calc', function ($request) use ($container) {
    $controller = $container->get(ArticleController::class);
    return $controller->historycalc($request);
});

// Маршруты авторизации
$router->get('/auth/register', function () use ($container) {
    $controller = $container->get(AuthController::class);
    return $controller->showRegister();
});

$router->post('/auth/register', function ($request) use ($container) {
    $controller = $container->get(AuthController::class);
    return $controller->register($request);
});

$router->get('/auth/login', function () use ($container) {
    $controller = $container->get(AuthController::class);
    return $controller->showLogin();
});

$router->post('/auth/login', function ($request) use ($container) {
    $controller = $container->get(AuthController::class);
    return $controller->login($request);
});

$router->get('/auth/logout', function () use ($container) {
    $controller = $container->get(AuthController::class);
    return $controller->logout();
});

// Запуск роутера
$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$response = $router->dispatch($request);

// Отправка ответа
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
//---------------------------------------------------------------------------------


session_start();

error_reporting(E_ALL);
ini_set('display_errors', 'on');
$whoops = new Whoops\Run;
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
$whoops->register();

$container = new Container();

$container->add(Environment::class, function () {
    $loader = new FilesystemLoader(ROOT_DIR . '/templates');
    return new Environment($loader, []);
});

$container->add(TwigService::class, TwigService::class)->addArgument(Environment::class);

$container->add(ArticleView::class, ArticleView::class)->addArgument($container->get(TwigService::class));

$container->add(Article::class, Article::class);

$container->add(ArticleController::class, ArticleController::class)->addArgument($container->get(ArticleView::class))->addArgument($container->get(Article::class));
$strategy = (new League\Route\Strategy\ApplicationStrategy)->setContainer($container);
$router = (new \League\Route\Router);
$router->setStrategy($strategy);




$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);

$router->map('GET', '/', 'App\Controllers\ArticleController::showHome');
$router->map('GET', '/articles', 'App\Controllers\ArticleController::showArticlesList');
$router->map('GET', '/calc', 'App\Controllers\ArticleController::calc');
$router->map('POST', '/operation', 'App\Controllers\ArticleController::historycalc');



$response = $router->dispatch($request);
(new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);

