<?php

use Impl\Repo\Article\ArticleInterface;

class ContentController extends BaseController {

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

        return View::make('home')->with('articles', $articles);
    }

}