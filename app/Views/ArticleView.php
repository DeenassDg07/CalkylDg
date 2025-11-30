<?php

namespace App\Views;

use App\Services\TwigService;

class ArticleView
{
    private TwigService $twigService;

    public function __construct(TwigService $twigService)
    {
        $this->twigService = $twigService;
    }

    public function showArticlesList(array $articles): void
    {
        $html = $this->twigService->render('articles/articles_list.twig', [
            'articles' => $articles,
            'title' => 'Список статей',
            'articles_count' => count($articles)
        ]);
        
        echo $html;
    }

    public function showArticle(array $article): void
    {
        if (empty($article)) {
            $this->showNotFound();
            return;
        }

        $html = $this->twigService->render('articles/article_detail.twig', [
            'article' => $article,
            'title' => $article['title'] ?? 'Статья'
        ]);
        
        echo $html;
    }

    public function showNotFound(): void
    {
        http_response_code(404);
        $html = $this->twigService->render('errors/404.twig', [
            'title' => 'Статья не найдена',
            'message' => 'Запрашиваемая статья не существует.'
        ]);
        
        echo $html;
    }
}