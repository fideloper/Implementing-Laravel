<?php namespace Impl\Repo\Article;

use Impl\Repo\RepoAbstract;
use Impl\Service\Cache\CacheInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentArticle extends RepoAbstract implements ArticleInterface {

    protected $article;
    protected $tag;
    protected $cache;

    // Class expects an Eloquent model
    public function __construct(Model $article, Model $tag, CacheInterface $cache)
    {
        $this->article = $article;
        $this->tag = $tag;
        $this->cache = $cache;
    }

    /**
     * Retrieve article by id
     * regardless of status
     *
     * @param  int $id Article ID
     * @return stdObject object of article information
     */
    public function byId($id)
    {
        // Build the cache key, unique per article slug
        $key = md5('id.'.$id);

        if( $this->cache->has($key) )
        {
            return $this->cache->get($key);
        }

        // Item not cached, retrieve it
        $article = $this->article->with('status')
                            ->with('author')
                            ->with('tags')
                            ->where('id', $id)
                            ->first();

        // Store in cache for next request
        $this->cache->put($key, $article);

        return $article;
    }

    /**
     * Get paginated articles
     *
     * @param int $page Number of articles per page
     * @param int $limit Results per page
     * @param boolean $all Show published or all
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page=1, $limit=10, $all=false)
    {
        // Build our cache item key, unique per page number,
        // limit and if we're showing all
        $allkey = ($all) ? '.all' : '';
        $key = md5('page.'.$page.'.'.$limit.$allkey);

        if( $this->cache->has($key) )
        {
            return $this->cache->get($key);
        }

        // Item not cached, retrieve it
        $query = $this->article->with('status')
                               ->with('author')
                               ->with('tags')
                               ->orderBy('created_at', 'desc');

        // All posts or only published
        if( ! $all )
        {
            $query->where('status_id', 1);
        }

        $articles = $query->skip( $limit * ($page-1) )
                        ->take($limit)
                        ->get();

        // Store in cache for next request
        $cached = $this->cache->putPaginated(
            $page,
            $limit,
            $this->totalArticles($all),
            $articles->all(),
            $key
        );

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
        $article = $this->article->with('status')
                            ->with('author')
                            ->with('tags')
                            ->where('slug', $slug)
                            ->where('status_id', 1)
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

        $articles = $this->tag->articles()
                        ->where('articles.status_id', 1)
                        ->orderBy('articles.created_at', 'desc')
                        ->skip( $limit * ($page-1) )
                        ->take($limit)
                        ->get();

        // Store in cache for next request
        $cached = $this->cache->put(
            $page,
            $limit,
            $this->totalByTag(),
            $articles->all(),
            $key
        );

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
        $article = $this->article->create(array(
            'user_id' => $data['user_id'],
            'status_id' => $data['status_id'],
            'title' => $data['title'],
            'slug' => $this->slug($data['title']),
            'excerpt' => $data['excerpt'],
            'content' => $data['content'],
        ));

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
        $article->slug = $this->slug($data['title']);
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
    protected function syncTags(Model $article, array $tags)
    {
        // Create or add tags
        $tags = $this->tag->findOrCreate( $tags );

        $tagIds = array();
        $tags->each(function($tag) use ($tagIds)
        {
            $tagIds[] = $tag->id;
        });

        // Assign set tags to article
        $this->article->tags()->sync($tagIds);
    }

    /**
     * Get total article count
     *
     * @return int  Total articles
     */
    protected function totalArticles($all = false)
    {
        if( ! $all )
        {
            return $this->article->where('status_id', 1)->count();
        }

        return $this->article->count();
    }

    /**
     * Get total article count per tag
     *
     * @param  string  $tag  Tag slug
     * @return int     Total articles per tag
     */
    protected function totalByTag($tag)
    {
        return $this->tag->bySlug($tag)
                    ->articles()
                    ->where('status_id', 1)
                    ->count();
    }


}