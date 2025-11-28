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
