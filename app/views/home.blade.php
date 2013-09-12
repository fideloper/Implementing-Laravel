@foreach( $articles as $article )
    <article class="row">
        <h1 class="lead"><a href="/{{ $article->slug }}">{{ $article->title }}</a></h1>
        {{ \Michelf\MarkdownExtra::defaultTransform($article->excerpt) }}
    </article>
@endforeach
    <div class="row">
    {{ $articles->links() }}
    </div>