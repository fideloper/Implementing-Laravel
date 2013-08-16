<?php namespace Impl\Service\Form\Article;

use Impl\Service\Validation\AbstractLaravelValidation;

class ArticleFormValidation extends LaravelValidationAbstract {

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'title' => 'required',
        'user_id' => 'required|exists:users,id', // Assumes db connection
        'status_id' => 'required|exists:statuses,id', // Assumes db connection
        'slug' => 'required',
        'excerpt' => 'required',
        'content' => 'required',
        'tags' => 'required',
    );

}