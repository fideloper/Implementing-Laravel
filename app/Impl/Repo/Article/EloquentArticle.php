<?php namespace Impl\Repo\Article;

class EloquentArticle implements ArticleInterface {

    protected $article;
    protected $cache;

    // Class expects an Eloquent model
    public function __construct(Model $article, CacheInterface $cache)
    {
        $this->article = $article;
        $this->cache = $cache;
    }

    /**
     * Get paginated articles
     *
     * @param int  Number of articles per page
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page=1, $limit=10)
    {
        // Build our cache item key, unique per page number and limit
        $key = md5('page.'.$page.'.'.$limit);

        if( $this->cache->has($key) )
        {
            return $this->cache->get($key);
        }

        // Item not cached, retrieve it
        $articles = $this->article->orderBy('created_at', 'desc')
                                   ->skip(($page-1)*$limit)
                                   ->take($limit)
                                   ->get();

        $count = $this->article->count();

        // Store in cache for next request
        $cached = $this->cache->putPaginated($page, $limit, $count, $articles, $key);

        return $cached;
    }

    /**
     * Get single article by URL
     *
     * @param string  URL slug of article
     * @return object object of article information
     */
    public function bySlug($slug)
    {
        // Build the cache key, unique per article slug
        $key = md5('slug.'.$slug);

        if( $this->cache->has($key) )
        {
            return $this->cache->get($key);
        }

        // Item not cached, retrieve it
        $article = $this->article->with('tags')
                             ->where('slug', $slug)
                             ->first();

        // Store in cache for next request
        $this->cache->put($key, $article);

        return $article;

    }

   /**
     * Get articles by their tag
     *
     * @param string  URL slug of tag
     * @param int Number of articles per page
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byTag($tag, $page=1, $limit=10)
    {
        // Build our cache item key, unique per tag, page number and limit
        $key = md5('tag.'.$tag.'.'.$page.'.'.$limit);

        if( $this->cache->has($key) )
        {
            return $this->cache->get($key);
        }

        // Item not cached, retrieve it
        $foundTag = $this->tag->where('slug', $tag)->first();

        if( !$foundTag )
        {
            // Likely an error, return no tags
            return false;
        }

        // Do our joining a little manually here to accomplish article ordering
        // and to paginate results more easily
        $articles = $this->article->join('articles_tags', 'articles.id', '=', 'articles_tags.article_id')
                             ->where('articles_tags.tag_id', $foundTag->id)
                             ->orderBy('articles.created_at', 'desc')
                             ->skip(($page-1)*$limit)
                             ->take($limit)
                             ->get();

        $count = $this->article->join('articles_tags', 'articles.id', '=', 'articles_tags.article_id')
                                ->where('articles_tags.tag_id', $foundTag->id)
                                ->count();

        // Store in cache for next request
        $cached = $this->cache->put($page, $limit, $count, $articles, $key);

        return $cached;

    }

}