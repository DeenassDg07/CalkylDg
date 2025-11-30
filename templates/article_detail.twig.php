{% extends "base.twig" %}

{% block title %}{{ article.title }} - {{ parent() }}{% endblock %}

{% block content %}
<article class="article-full">
    <h1>{{ article.title }}</h1>
    <div class="article-content">
        <p>{{ article.content }}</p>
    </div>
    <a href="/articles">← Назад к списку статей</a>
</article>
{% endblock %}