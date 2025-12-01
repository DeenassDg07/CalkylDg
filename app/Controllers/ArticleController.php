<?php

namespace App\Controllers;

use App\Views\ArticleView;
use App\Models\Article;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;

class ArticleController
{
//    public Article $article;
//    public ArticleView $articleView;

//    public function __construct(Article $article, ArticleView $articleView)
//    {
//        $this->article = $article;
//        $this->articleView = $articleView;
//
//    }

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
}