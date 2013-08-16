<?php namespace Impl\Repo\Article;

use Impl\Repo\RepoAbstract;

class EloquentArticle extends RepoAbstract implements ArticleInterface {

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

    /**
     * Create a new Article
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data)
    {
        // Create the article
        $article = Article::create(
            'user_id' => $data['user_id'],
            'status_id' => $data['status_id'],
            'title' => $data['title'],
            'slug' => $this->slug($data['slug']),
            'excerpt' => $data['excerpt'],
            'content' => $data['content'],
        );

        if( ! $article )
        {
            return false;
        }

        $this->syncTags($article, $data['tags']);

        return true;
    }

    /**
     * Update an existing Article
     *
     * @param array  Data to update an Article
     * @return boolean
     */
    public function update(array $data)
    {
        $article = $this->article->find($data['id']);
        $article->user_id = $data['user_id'];
        $article->status_id = $data['status_id'];
        $article->title = $data['title'];
        $article->slug = $this->slug($data['slug']),
        $article->excerpt = $data['excerpt'];
        $article->content = $data['content'];
        $article->save();

        $this->syncTags($article, $data['tags']);

        return $true;
    }

    /**
     * Sync tags for article
     *
     * @param \Illuminate\Database\Eloquent\Model  $article
     * @param array  $tags
     * @return void
     */
    protected function syncTags($article, $tags)
    {
        // Create or add tags
        $tags = $this->tag->findOrCreate( $data['tags'] );

        $tagIds = array();
        $tags->each(function($tag) use ($tagIds)
        {
            $tagIds[] = $tag->id;
        });

        // Assign set tags to article
        $this->article->tags()->sync($tagIds);
    }

}