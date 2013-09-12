<?php namespace Impl\Repo;

abstract class RepoAbstract {

    /**
     * Make a string "slug-friendly" for URLs
     * @param  string $string  Human-friendly tag
     * @return string       Computer-friendly tag
     */
    protected function slug($string)
    {
        return filter_var( str_replace(' ', '-', strtolower( trim($string) ) ), FILTER_SANITIZE_URL);
    }

}