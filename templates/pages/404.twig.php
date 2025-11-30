{% extends "base.twig" %}

{% block title %}Страница не найдена - {{ parent() }}{% endblock %}

{% block content %}
<div class="error-page">
    <h1>404 - Страница не найдена</h1>
    <p>Запрашиваемая страница не существует.</p>
    <a href="/">Вернуться на главную</a>
</div>
{% endblock %}