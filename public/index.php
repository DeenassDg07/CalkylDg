<?php

use App\Controllers\ArticleController;
use App\Views\ArticleView;
use App\Models\Article;


require '/home/user/www/calkylDg/vendor/autoload.php';
require '/home/user/www/calkylDg/config/settings.php';

//require_once('src/Models/Article.php');
//require_once('src/Views/ArticleView.php');
//require_once('src/Controllers/ArticleController.php');

error_reporting(E_ALL);
ini_set('display_errors', 'on');
$whoops = new Whoops\Run;
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
$whoops->register();

$article = new Article();
$article_view = new ArticleView();
$article_controller = new ArticleController($article, $article_view);

$uri = $_SERVER['REQUEST_URI'];
switch ($uri) {
    case '/':
        include_once('../templates/pages/index.php');
        break;
    case '/articles':
        $article_controller->showArticlesList();
        break;
    case '/calc':
        include_once ('../templates/pages/calc.php');
        break;
    default:
        include_once('../templates/pages/404.php');
        break;
}
require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\TwigService;
use App\Views\ArticleView;
use App\Controllers\ArticleController;
use App\Models\Article;

// Включаем вывод ошибок (только для разработки)
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Создаем сервисы
$twigService = new TwigService();
$articleView = new ArticleView($twigService);
$articleModel = new Article();
$articleController = new ArticleController($articleView, $articleModel);

// Получаем текущий URL
$uri = $_SERVER['REQUEST_URI'];

// Маршрутизация
if ($uri === '/articles') {
    // Показываем список статей
    $articleController->list();
} elseif (preg_match('#^/article/(\d+)$#', $uri, $matches)) {
    // Показываем конкретную статью
    $articleController->show((int)$matches[1]);
} else {
    // Главная страница
    $twig = $twigService->getTwig();
    echo $twig->render('pages/home.twig', [
        'title' => 'Главная страница'
    ]);
}
