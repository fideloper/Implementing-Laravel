    <article class="row">
        <h1 class="lead">{{ $article->title }}</h1>
        {{ \Michelf\MarkdownExtra::defaultTransform($article->content) }}
    </article>