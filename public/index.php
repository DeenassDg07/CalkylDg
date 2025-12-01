<?php
//
//use App\Controllers\ArticleController;
//use App\Views\ArticleView;
//use App\Models\Article;
//
//
//require '/home/user/www/calkylDg/vendor/autoload.php';
//require '/home/user/www/calkylDg/config/settings.php';
//
////require_once('src/Models/Article.php');
////require_once('src/Views/ArticleView.php');
////require_once('src/Controllers/ArticleController.php');
//
//error_reporting(E_ALL);
//ini_set('display_errors', 'on');
//$whoops = new Whoops\Run;
//$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
//$whoops->register();
//
//$article = new Article();
//$article_view = new ArticleView();
//$article_controller = new ArticleController($article, $article_view);
//
//$uri = $_SERVER['REQUEST_URI'];
//switch ($uri) {
//    case '/':
//        include_once('../templates/pages/index.php');
//        break;
//    case '/articles':
//        $article_controller->showArticlesList();
//        break;
//    case '/calc':
//        include_once ('../templates/pages/calc.php');
//        break;
//    default:
//        include_once('../templates/pages/404.php');
//        break;
//}
require '/home/user/www/calkylDg/vendor/autoload.php';
require '/home/user/www/calkylDg/config/settings.php';

use App\Services\TwigService;
use App\Views\ArticleView;
use App\Controllers\ArticleController;
use App\Models\Article;
use Laminas\Diactoros\ServerRequestFactory;
use League\Container\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// �������� ����� ������ (������ ��� ����������)
error_reporting(E_ALL);
ini_set('display_errors', 'on');
$whoops = new Whoops\Run;
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
$whoops->register();

$container = new Container();
// Добавление окружения Twig
$container->add(Environment::class, function () {
    $loader = new FilesystemLoader(ROOT_DIR . '/templates');
    return new Environment($loader, []);
});
// Добавление TwigService-а
$container->add(TwigService::class, TwigService::class)->addArgument(Environment::class);
// Добавление view
$container->add(ArticleView::class, ArticleView::class)->addArgument($container->get(TwigService::class));
//Добавление model
$container->add(Article::class, Article::class);
//Добавление controller
$container->add(ArticleController::class, ArticleController::class)->addArgument($container->get(ArticleView::class))->addArgument($container->get(Article::class));
$strategy = (new League\Route\Strategy\ApplicationStrategy)->setContainer($container);
$router = (new \League\Route\Router);
$router->setStrategy($strategy);




// ������� �������
//$twigService = new TwigService();
//$articleView = new ArticleView($twigService);
//$articleModel = new Article();
//$articleController = new ArticleController($articleView, $articleModel);

//Получение запроса
$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);

//Создание маршрутов
$router->map('GET', '/', 'App\Controllers\ArticleController::showHome');
$router->map('GET', '/articles', 'App\Controllers\ArticleController::showArticlesList');

$response = $router->dispatch($request);
(new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);

//// �������� ������� URL
//$uri = $_SERVER['REQUEST_URI'];
//
//// �������������
//switch ($uri) {
//    case '/artcles':
//        $articleController->list();
//        break;
//}
//if ($uri === '/articles') {
//    // ���������� ������ ������
//    $articleController->list();
//} elseif (preg_match('#^/article/(\d+)$#', $uri, $matches)) {
//    // ���������� ���������� ������
//    $articleController->show((int)$matches[1]);
//} else {
//    // ������� ��������
//    $twig = $twigService->getTwig();
//    echo $twig->render('pages/home.twig', [
//        'title' => '������� ��������'
//    ]);
//}
