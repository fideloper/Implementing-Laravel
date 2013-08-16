<?php

class Article extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'user_id',
        'status_id',
        'title',
        'slug',
        'excerpt',
        'content',
    );

    /**
     * Indicates if the model should soft delete.
     *
     * @var bool
     */
    protected $softDelete = true;

    /**
     * Define a one-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->hasOne('User');
    }

    /**
     * Define a one-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function status()
    {
        return $this->hasOne('Status');
    }

    /**
     * Define a many-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('Tag', 'articles_tags', 'tag_id', 'article_id');
    }

}