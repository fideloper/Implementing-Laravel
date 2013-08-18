<?php

use Impl\Repo\Article\ArticleInterface;

class ContentController extends BaseController {

    protected $layout = 'layout';

    protected $article;

    public function __construct(ArticleInterface $article)
    {
        $this->article = $article;
    }

    /**
     * Paginated articles
     * GET /
     */
    public function home()
    {
        $page = Input::get('page', 1);

        // Candidate for config item
        $perPage = 3;

        $pagiData = $this->article->byPage($page, $perPage);

        $articles = Paginator::make($pagiData->items, $pagiData->totalItems, $perPage);

        $this->layout->content = View::make('home')->with('articles', $articles);
    }

    /**
     * Single article
     * GET /{slug}
     */
    public function article($slug)
    {
        $article = $this->article->bySlug($slug);

        if( ! $article )
        {
            App::abort(404);
        }

        $this->layout->content = View::make('article')->with('article', $article);
    }

}