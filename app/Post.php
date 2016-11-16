<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'name', 'text', 'youtube', 'image'];

    /**
     * Relation post and user as BelongsTo
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation post and tags as BelongsToMany
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    /**
     * Relation post and comments as hasMany
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    /**
     * Relation posts and likes as morphMany
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany('App\Like', 'likable');
    }

    /**
     * Get attribute tag_list
     * @return mixed
     */
    public function getTagListAttribute()
    {
        return $this->tags->pluck('name')->toArray();
    }

    public function getDislikeAttribute()
    {
        return $this->likes()->whereState('dislike')->count();
    }

    public function getLikeAttribute()
    {
        return $this->likes()->whereState('like')->count();
    }

    /**
     * Get related posts
     * @param int $take
     * @return mixed
     */
    public function getRelatedPosts($take = 5)
    {

        $tagIds = $this->tags()->get()->pluck('id')->all();

        $post_id = $this->id;

        $posts = $this->whereHas('tags', function ($query) use ($tagIds, $post_id){
                $query->whereIn('tags.id',$tagIds);
                $query->where('post_id' ,'<>',  $post_id);
        })->orderBy('created_at', 'desc')->take($take)->get();

        return $posts;
    }


    public function getRecentPosts($take = 5)
    {
        return $this->orderBy('created_at','desc')->take($take)->get(['id', 'name', 'created_at']);
    }

    /**
     * Get attribute tag_list
     * @return mixed
     */
    public function getYoutubeUrlAttribute()
    {
        return $this->youtubeIdFromUrl($this->youtube);
    }

    public function youtubeIdFromUrl($url) {
        $pattern =
            '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
        $result = preg_match($pattern, $url, $matches);
        if ($result) {
            return $matches[1];
        }
        return false;
    }

}
