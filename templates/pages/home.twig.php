{% extends "base.twig" %}

{% block title %}Главная страница - {{ parent() }}{% endblock %}

{% block content %}
<div class="home-page">
    <h1>Добро пожаловать на наш сайт!</h1>
    <p>Это учебный проект для группы 1135 КГА ПОУ ППК 2025 год</p>
    
    <div class="features">
        <h2>Что у нас есть:</h2>
        <ul>
            <li>📚 <a href="/articles">Статьи</a> - читайте наши материалы</li>
            <li>🧮 <a href="/calc">Калькулятор</a> - полезные вычисления</li>
            <li>📰 <a href="/novosti">Новости</a> - свежие обновления</li>
        </ul>
    </div>
</div>
{% endblock %}