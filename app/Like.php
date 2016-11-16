<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['state', 'ip'];

    public function likable()
    {
        return $this->morphTo();
    }
}
