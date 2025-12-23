<?php

namespace App\Controllers;

use App\Core\FileManeger;
use App\Views\ArticleView;
use App\Models\Article;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ArticleController
{


    public function showArticlesList() : ResponseInterface
    {
        $articles = $this->articleModel->all();
        $path = ROOT_DIR . '/templates/articles/articles_list.php';
        $html = $this->articleView->showArticlesList($articles);
        return $this->responseWrapper($html);
    }
    private ArticleView $articleView;
    private Article $articleModel;

    public function __construct(ArticleView $articleView, Article $articleModel)
    {
        $this->articleView = $articleView;
        $this->articleModel = $articleModel;
    }

    public function list(): void
    {
        $articles = $this->articleModel->all();
        $this->articleView->showArticlesList($articles);
    }

    public function showHome() : ResponseInterface
    {
        $html = $this->articleView->showHomePage();
        return $this->responseWrapper($html);
    }
    private function responseWrapper(string $html) : ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write($html);
        return $response;
    }

    public function show(int $id): void
    {
        $articles = $this->articleModel->all();
        $article = $articles[$id] ?? null;
        $this->articleView->showArticle($article);
    }
    public function calc() : ResponseInterface
    {
        $history = FileManeger::read(ROOT_DIR . "calculator_history.txt");
        $html = $this->articleView->calc($history);
        return $this->responseWrapper($html);
    }
    public function historycalc(ServerRequestInterface $request) : ResponseInterface
    {
        $data = $request->getParsedBody();
        $num1 = (double)$data["num1"];
        if ($num1 != null) {
            $num2 = (double)$data["num2"];
            $operator = (string)$data["operator"];
            switch ($operator){
                case '+':
                $result = $num1 + $num2;
                break;
                case '-':
                    $result = $num1 - $num2;
                    break;
                    case '*':
                        $result = $num1 * $num2;
                        break;
                case '/':
                    if ($num2 == 0) {
                        $result = "Ошибка: деление на ноль в союзе запрещено!";
                    } else {
                        $result = $num1 / $num2;
                    }
                    break;
                default:
                    $result = "Неверный наш оператор!";
            }
            $historyFile = ROOT_DIR . 'calculator_history.txt';
            $historyData = date('Y-m-d H:i:s') . " - $num1 $operator $num2 = $result\n";
            FileManeger::write($historyFile, $historyData);
        }
        $response = new Response();
        return $response->withStatus(302)->withHeader("Location", "/calc");
    }


}