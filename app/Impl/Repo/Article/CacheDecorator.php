<?php namespace Impl\Repo\Article;

use Impl\Service\Cache\CacheInterface;

class CacheDecorator extends AbstractArticleDecorator {

    protected $nextArticle;
    protected $cache;

    public function __construct(ArticleInterface $article, CacheInterface $cache)
    {
        $this->nextArticle = $article;
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

        $articles = $this->nextArticle->byPage($page, $limit);

        $cached = $this->cache->putPaginated(
            $page,
            $limit,
            $this->nextArticle->totalArticles($all),
            $articles->all(),
            $key
        );

        return $cached;
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

        $articles = $this->nextArticle->byId($tag, $page, $limit);

        $cached = $this->cache->put(
            $page,
            $limit,
            $this->nextArticle->totalByTag($tag),
            $articles->all(),
            $key
        );

        return $cached;
    }

    /**
     * Pass creation of article thru
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        return $this->nextArticle->byId($data);
    }

    /**
     * Pass update of article thru
     * {@inheritdoc}
     */
    public function update(array $data)
    {
        return $this->nextArticle->update($data);
    }

}