<?php

use Impl\Repo\Article\ArticleInterface;

class ArticleController extends BaseController {

    protected $articleform;

    public function __construct(ArticleForm $articleform)
    {
        $this->articleform = $articleform;
    }

    /**
     * Create article form
     * GET /admin/article/create
     */
    public function create()
    {
        View::make('admin.article_create', array(
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
            Redirect::to('admin/article')
                    ->with('status', 'success');
        } else {

            Redirect::to('admin/article')
                    ->withInput()
                    ->withErrors( $this->articleform->errors() )
                    ->with('status', 'error');
        }
    }

}