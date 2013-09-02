<?php namespace Impl\Service\Form\Article;

use Impl\Service\Validation\ValidableInterface;
use Impl\Repo\Article\ArticleInterface;

class ArticleForm {

    /**
     * Form Data
     *
     * @var array
     */
    protected $data;

    /**
     * Validator
     *
     * @var \Impl\Form\Service\ValidableInterface
     */
    protected $validator;

    /**
     * Article repository
     *
     * @var \Impl\Repo\Article\ArticleInterface
     */
    protected $article;

    public function __construct(ValidableInterface $validator, ArticleInterface $article)
    {
        $this->validator = $validator;
        $this->article = $article;
    }

    /**
     * Create an new article
     *
     * @return boolean
     */
    public function save(array $input)
    {
        if( ! $this->valid($input) )
        {
            return false;
        }

        $input['tags'] = $this->processTags($input['tags']);

        return $this->article->create($input);
    }

    /**
     * Update an existing article
     *
     * @return boolean
     */
    public function update(array $input)
    {
        if( ! $this->valid($input) )
        {
            return false;
        }

        $input['tags'] = $this->processTags($input['tags']);

        return $this->article->update($input);
    }

    /**
     * Return any validation errors
     *
     * @return array
     */
    public function errors()
    {
        return $this->validator->errors();
    }

    /**
     * Test if form validator passes
     *
     * @return boolean
     */
    protected function valid(array $input)
    {
        return $this->validator->with($input)->passes();
    }

    /**
     * Convert string of tags to
     * array of tags
     *
     * @param  string
     * @return array
     */
    protected function processTags($tags)
    {
        $tags = explode(',', $tags);

        foreach( $tags as $key => $tag )
        {
            $tags[$key] = trim($tag);
        }

        return $tags;
    }

}