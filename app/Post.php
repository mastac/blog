<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'name', 'text'];

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
     * Get attribute tag_list
     * @return mixed
     */
    public function getTagListAttribute()
    {
        return $this->tags->pluck('name')->toArray();
    }

    /**
     * Get related posts
     * @param null $post_id
     * @return mixed
     */
    public static function getRelatedPosts($post_id = null)
    {

        $tagIds = Post::find($post_id)->tags()->get()->pluck('id')->all();

        $posts = Post::whereHas('tags', function ($query) use ($tagIds, $post_id){
                $query->whereIn('tags.id',$tagIds);
                $query->where('post_id' ,'<>',  $post_id);
        })->orderBy('created_at', 'desc')->take(5)->get();

        return $posts;
    }

}
