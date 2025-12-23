<?php

function getArticles(): array
{
    return json_decode(file_get_contents('db/articles.json'), true);
}

function getArticleById(int $id): array
{
    $articleList = getArticles();
    $curentArticle = [];
    if (array_key_exists($id, $articleList)) {
        $curentArticle = $articleList[$id];
    }
    return $curentArticle;
}


function dd($some)
{
    echo '<pre>';
    print_r($some);
    echo '</pre>';
   
}


function goUrl(string $url)
{
    echo '<script type="text/javascript">location="';
    echo $url;
    echo '";</script>';
}
