<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{% block title %}{{ app_name }}{% endblock %}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; line-height: 1.6; background: #f4f4f4; }
        .container { max-width: 1200px; margin: 0 auto; background: white; min-height: 100vh; }
        .header { background: #790604; color: white; padding: 1rem; text-align: center; }
        .nav { background: #d7d5d5; padding: 1rem; display: flex; gap: 2rem; justify-content: center; }
        .nav a { text-decoration: none; color: black; font-size: 18px; }
        .nav a:hover { color: #790604; }
        .content { padding: 2rem; }
        .footer { background: #790604; color: white; text-align: center; padding: 1rem; margin-top: 2rem; }
        .article-card { border: 1px solid #ddd; padding: 1rem; margin: 1rem 0; border-radius: 5px; }
        .article-card h2 { color: #790604; }
        .read-more { color: #790604; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>{{ app_name }}</h1>
        </header>
        
        <nav class="nav">
            <a href="/">Главная</a>
            <a href="/articles">Статьи</a>
            <a href="/calc">Калькулятор</a>
            <a href="/novosti">Новости</a>
        </nav>

        <main class="content">
            {% block content %}
                <p>Содержимое страницы будет здесь.</p>
            {% endblock %}
        </main>

        <footer class="footer">
            <p>&copy; {{ current_year }} {{ app_name }}</p>
        </footer>
    </div>
</body>
</html>