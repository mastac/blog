<?php

namespace App\Helpers;


class Nav
{
    /**
     * Set active menu item by path
     * @param $path
     * @param $request
     * @param string $active
     * @return string
     */
    public static function setActive($path, $request, $active = 'active')
    {
        return $request->is($path) ? $active : '';
    }

    public static function getTagLinks($tags)
    {
        $values = [];
        foreach ($tags as $tag) {
            $values[] = (string) link_to("tag/".$tag->name, $tag->name);
        }

        return implode(', ', $values);
    }
}