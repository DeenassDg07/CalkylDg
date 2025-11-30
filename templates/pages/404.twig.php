{% extends "base.twig" %}

{% block title %}{{ title }} - {{ parent() }}{% endblock %}

{% block content %}
<div class="error-page">
    <h1>404 - Страница не найдена</h1>
    <p>{{ message }}</p>
    <a href="/">Вернуться на главную</a>
</div>
{% endblock %}