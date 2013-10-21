<?php namespace Impl\Repo\Article;

use Impl\Repo\RepoAbstract;
use Impl\Repo\Tag\TagInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentArticle extends RepoAbstract implements ArticleInterface {

    protected $article;
    protected $tag;

    // Class expects an Eloquent model
    public function __construct(Model $article, TagInterface $tag)
    {
        $this->article = $article;
        $this->tag = $tag;
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
        return $this->article->with('status')
                ->with('author')
                ->with('tags')
                ->where('id', $id)
                ->first();
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
        $result = new \StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->article->with('status')
                               ->with('author')
                               ->with('tags')
                               ->orderBy('created_at', 'desc');

        if( ! $all )
        {
            $query->where('status_id', 1);
        }

        $articles = $query->skip( $limit * ($page-1) )
                        ->take($limit)
                        ->get();

        $result->totalItems = $this->totalArticles($all);
        $result->items = $articles->all();

        return $result;
    }

    /**
     * Get single article by URL
     *
     * @param string  URL slug of article
     * @return object object of article information
     */
    public function bySlug($slug)
    {
        return $this->article->with('status')
                            ->with('author')
                            ->with('tags')
                            ->where('slug', $slug)
                            ->where('status_id', 1)
                            ->first();
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
        $foundTag = $this->tag->where('slug', $tag)->first();

        $result = new \StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        if( !$foundTag )
        {
            return $result;
        }

        $articles = $this->tag->articles()
                        ->where('articles.status_id', 1)
                        ->orderBy('articles.created_at', 'desc')
                        ->skip( $limit * ($page-1) )
                        ->take($limit)
                        ->get();

        $result->totalItems = $this->totalByTag();
        $result->items = $articles->all();

        return $result;
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

        return true;
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
        $found = $this->tag->findOrCreate( $tags );

        $tagIds = array();

        foreach($found as $tag)
        {
            $tagIds[] = $tag->id;
        }

        // Assign set tags to article
        $article->tags()->sync($tagIds);
    }

    /**
     * Get total article count
     *
     * @todo I hate that this is public for the decorators.
     *       Perhaps interface it?
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
     * @todo I hate that this is public for the decorators
     *       Perhaps interface it?
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
