<?php

namespace App\Services;


class PostScrollService
{

    private $skip = 0;

    private $take = 5;

    /**
     * @return int
     */
    public function getSkip()
    {
        return $this->skip * $this->take;
    }

    /**
     * @param int $skip
     */
    public function setSkip($skip)
    {
        $this->skip = $skip;
    }

    /**
     * @return int
     */
    public function getTake()
    {
        return $this->take;
    }

    /**
     * @param int $take
     */
    public function setTake($take)
    {
        $this->take = $take;
    }

    public function scroll($posts)
    {
        return $posts->withCount('comments')
            ->with('tags')
            ->take($this->getTake())
            ->skip($this->getSkip())
            ->orderBy('created_at','desc')->get();
    }

}