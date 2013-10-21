<?php namespace Impl\Repo\Article;

abstract class AbstractArticleDecorator implements ArticleInterface {

    protected $nextArticle;

    public function __construct(ArticleInterface $nextArticle)
    {
        $this->nextArticle = $nextArticle;
    }

    /**
     * {@inheritdoc}
     */
    public function byId($id)
    {
        return $this->nextArticle->byId($id);
    }

    /**
     * {@inheritdoc}
     */
    public function byPage($page=1, $limit=10, $all=false)
    {
        return $this->nextArticle->byPage($page, $limit, $all);
    }

    /**
     * {@inheritdoc}
     */
    public function bySlug($slug)
    {
        return $this->nextArticle->bySlug($slug);
    }

   /**
     * {@inheritdoc}
     */
    public function byTag($tag, $page=1, $limit=10)
    {
        return $this->nextArticle->byTag($tag, $page, $limit);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        return $this->nextArticle->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(array $data)
    {
        return $this->nextArticle->update($data);
    }

}