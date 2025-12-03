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

    public function showArticlesList(array $articles): string
    {
        $html = $this->twigService->render('articles/articles_list.twig', [
            'articles' => $articles,
            'title' => 'СССР',
            'articles_count' => count($articles)
        ]);
        
        return $html;
    }

    public function showArticle(array $article): string
    {
        if (empty($article)) {
            return $this->showNotFound();
        }

        $html = $this->twigService->render('articles/article_detail.twig', [
            'article' => $article,
            'title' => $article['title'] ?? '������'
        ]);
        
        return $html;
    }

    public function showNotFound(): string
    {
        http_response_code(404);
        $html = $this->twigService->render('errors/404.twig', [
            'title' => '(',
            'message' => ')'
        ]);
        
        return $html;
    }

    public function showHomePage(): string
    {
        $html = $this->twigService->render('pages/home.twig', []);
        return $html;

    }
    public function calc(string $history, ?double $num1 = null, ?double $num2 = null, ?string $operator = null, ?string $result = null): string
    {
        $html = $this->twigService->render('pages/calc.twig', ['history' => $history, 'num1' => $num1,'num2' => $num2,
            'operator' => $operator, 'result' => $result]);
        return $html;
    }
}