<?php namespace Impl\Repo\Article;

use Impl\Service\Cache\CacheInterface;

class CacheDecorator extends AbstractArticleDecorator {

    protected $cache;

    public function __construct(ArticleInterface $nextArticle, CacheInterface $cache)
    {
        parent::__construct($nextArticle);
        $this->cache = $cache;
    }

    /**
     * Attempt to retrieve from cache
     * by ID
     * {@inheritdoc}
     */
    public function byId($id)
    {
        $key = md5('id.'.$id);

        if( $this->cache->has($key) )
        {
            return $this->cache->get($key);
        }

        $article = $this->nextArticle->byId($id);

        $this->cache->put($key, $article);

        return $article;
    }

    /**
     * Attempt to retrieve from cache
     * {@inheritdoc}
     */
    public function byPage($page=1, $limit=10, $all=false)
    {
        $allkey = ($all) ? '.all' : '';
        $key = md5('page.'.$page.'.'.$limit.$allkey);

        if( $this->cache->has($key) )
        {
            return $this->cache->get($key);
        }

        $paginated = $this->nextArticle->byPage($page, $limit);

        $this->cache->put($key, $paginated);

        return $paginated;
    }

    /**
     * Attempt to retrieve from cache
     * {@inheritdoc}
     */
    public function bySlug($slug)
    {
        $key = md5('slug.'.$slug);

        if( $this->cache->has($key) )
        {
            return $this->cache->get($key);
        }

        $article = $this->nextArticle->bySlug($slug);

        $this->cache->put($key, $article);

        return $article;
    }

    /**
     * Attempt to retrieve from cache
     * {@inheritdoc}
     */
    public function byTag($tag, $page=1, $limit=10)
    {
        $key = md5('tag.'.$tag.'.'.$page.'.'.$limit);

        if( $this->cache->has($key) )
        {
            return $this->cache->get($key);
        }

        $paginated = $this->nextArticle->byTag($tag, $page, $limit);

        $this->cache->put($key, $paginated);

        return $paginated;
    }

}
