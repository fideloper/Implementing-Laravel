<?php namespace Impl\Repo\Article;

abstract class AbstractArticleDecorator implements ArticleInterface {

    protected $nextArticle;

    public function __construct(ArticleInterface $article)
    {
        $this->nextArticle = $article;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function byId($id);

    /**
     * {@inheritdoc}
     */
    abstract public function byPage($page=1, $limit=10, $all=false);

    /**
     * {@inheritdoc}
     */
    abstract public function bySlug($slug);

   /**
     * {@inheritdoc}
     */
    abstract public function byTag($tag, $page=1, $limit=10);

    /**
     * {@inheritdoc}
     */
    abstract public function create(array $data);

    /**
     * {@inheritdoc}
     */
    abstract public function update(array $data);

}