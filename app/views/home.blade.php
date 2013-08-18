@foreach( $articles as $article )
    <article class="row">
        <h1 class="lead">{{ $article->title }}</h1>
        {{ $article->content }}
    </article>
@endforeach