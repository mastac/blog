<?php

namespace App;

use App\Comment;
use Illuminate\Database\Eloquent\Model;
use App\Tag;

class Post extends Model
{
    protected $fillable = ['user_id', 'name', 'text'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    /**
     *
     * @return mixed
     */
    public function getTagListAttribute()
    {
        return $this->tags->pluck('name')->toArray();
    }

    public static function getRelatedPosts($post_id = null)
    {
        $tagIds = null;
        if (!empty($tagIds)) {
            $tagIds = Post::find($post_id)->tags()->get()->pluck('id')->all();
        }

        $posts = Post::whereHas('tags', function ($query) use ($tagIds){
            if (!is_null($tagIds)){
                $query->whereIn('tags.id',$tagIds);
            }
        })
            ->withCount('tags')
            ->orderBy('tags_count', 'desc')
            ->take(5)
            ->get();

        return $posts;
    }

}
