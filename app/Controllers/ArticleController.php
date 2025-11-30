<?php

namespace App\Controllers;

use App\Views\ArticleView;
use App\Models\Article;

class ArticleController
{
    public Article $article;
    public ArticleView $articleView;

    public function __construct(Article $article, ArticleView $articleView)
    {
        $this->article = $article;
        $this->articleView = $articleView;

    }

    public function showArticlesList()
    {
        $articles = $this->article->all();
        $path = ROOT_DIR . '/templates/articles/articles_list.php';
        $this->articleView->showArticlesList($path, $articles);

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

    public function show(int $id): void
    {
        $articles = $this->articleModel->all();
        $article = $articles[$id] ?? null;
        $this->articleView->showArticle($article);
    }
}