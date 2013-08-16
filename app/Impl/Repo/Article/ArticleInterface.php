<?php namespace Impl\Repo\Article

interface ArticleInterface {

    /**
     * Get paginated articles
     *
     * @param int  Number of articles per page
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page=1, $limit=10);

    /**
     * Get single article by URL
     *
     * @param string  URL slug of article
     * @return object object of article information
     */
    public function bySlug($slug);

   /**
     * Get articles by their tag
     *
     * @param string  URL slug of tag
     * @param int Number of articles per page
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byTag($tag, $page=1, $limit=10);

}