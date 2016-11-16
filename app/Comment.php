<?php

namespace App;

use App\Post;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['name', 'email', 'comment', 'post_id'];

    /**
     * Relation comments and posts as belongsTo
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }


    /**
     * Relation comments and likes as morphMany
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany('App\Like', 'likable');
    }


    public function getDislikeAttribute()
    {
        return $this->likes()->whereState('dislike')->count();
    }

    public function getLikeAttribute()
    {
        return $this->likes()->whereState('like')->count();
    }

}
