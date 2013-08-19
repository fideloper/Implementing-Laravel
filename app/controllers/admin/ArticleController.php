<?php

use Impl\Repo\Article\ArticleInterface;
use Impl\Service\Form\Article\ArticleForm;

class ArticleController extends BaseController {

    protected $layout = 'layout';

    protected $articleform;

    public function __construct(ArticleInterface $article, ArticleForm $articleform)
    {
        $this->article = $article;
        $this->articleform = $articleform;
    }

    /**
     * List articles
     * GET /admin/article
     */
    public function index()
    {
        $page = Input::get('page', 1);

        // Candidate for config item
        $perPage = 3;

        $pagiData = $this->article->byPage($page, $perPage);

        $articles = Paginator::make($pagiData->items, $pagiData->totalItems, $perPage);

        $this->layout->content = View::make('admin.article_list')->with('articles', $articles);
    }

    /**
     * Create article form
     * GET /admin/article/create
     */
    public function create()
    {
        $this->layout->content = View::make('admin.article_create', array(
            'input' => Session::getOldInput()
        ));
    }

    /**
     * Create article form processing
     * POST /admin/article
     */
    public function store()
    {
        if( $this->articeform->save( Input::all() ) )
        {
            // Success!
            Redirect::to('admin.article')
                    ->with('status', 'success');
        } else {

            Redirect::to('admin.article_create')
                    ->withInput()
                    ->withErrors( $this->articleform->errors() )
                    ->with('status', 'error');
        }
    }

    /**
     * Create article form
     * GET /admin/article/{id}/edit
     */
    public function edit()
    {
        $this->layout->content = View::make('admin.article_edit', array(
            'input' => Session::getOldInput()
        ));
    }

    /**
     * Create article form
     * PUT /admin/article/{id}
     */
    public function update()
    {
        if( $this->articeform->update( Input::all() ) )
        {
            // Success!
            Redirect::to('admin.article')
                    ->with('status', 'success');
        } else {

            Redirect::to('admin.article_edit')
                    ->withInput()
                    ->withErrors( $this->articleform->errors() )
                    ->with('status', 'error');
        }
    }

}