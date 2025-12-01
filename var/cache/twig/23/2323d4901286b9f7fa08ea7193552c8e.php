<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* base.twig */
class __TwigTemplate_ef2efffe8ddeba8047b2159efd939d82 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"ru\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>";
        // line 6
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield "</title>
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
    <div class=\"container\">
        <header class=\"header\">
            <h1>";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_name"] ?? null), "html", null, true);
        yield "</h1>
        </header>
        
        <nav class=\"nav\">
            <a href=\"/\">Главная</a>
            <a href=\"/articles\">Статьи</a>
            <a href=\"/calc\">Калькулятор</a>
            <a href=\"/novosti\">Новости</a>
        </nav>

        <main class=\"content\">
            ";
        // line 36
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 39
        yield "        </main>

        <footer class=\"footer\">
            <p>&copy; ";
        // line 42
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["current_year"] ?? null), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_name"] ?? null), "html", null, true);
        yield "</p>
        </footer>
    </div>
</body>
</html>";
        yield from [];
    }

    // line 6
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_name"] ?? null), "html", null, true);
        yield from [];
    }

    // line 36
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 37
        yield "                <p>Содержимое страницы будет здесь.</p>
            ";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "base.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  124 => 37,  117 => 36,  106 => 6,  94 => 42,  89 => 39,  87 => 36,  73 => 25,  51 => 6,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"ru\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
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
    <div class=\"container\">
        <header class=\"header\">
            <h1>{{ app_name }}</h1>
        </header>
        
        <nav class=\"nav\">
            <a href=\"/\">Главная</a>
            <a href=\"/articles\">Статьи</a>
            <a href=\"/calc\">Калькулятор</a>
            <a href=\"/novosti\">Новости</a>
        </nav>

        <main class=\"content\">
            {% block content %}
                <p>Содержимое страницы будет здесь.</p>
            {% endblock %}
        </main>

        <footer class=\"footer\">
            <p>&copy; {{ current_year }} {{ app_name }}</p>
        </footer>
    </div>
</body>
</html>", "base.twig", "/home/user/www/calkylDg/templates/base.twig");
    }
}
