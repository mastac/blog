<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class Tag extends Model
{
    protected $fillable = ['name'];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function getPostsByTagName($tag)
    {
        return $this->whereName($tag)->firstOrFail()->posts();
    }

    public function getTagsWithCountPosts()
    {
        return $this->withCount('posts')->has('posts', '>', 0)->get();
    }

}
