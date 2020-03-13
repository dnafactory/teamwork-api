<?php

namespace App\TeamWork;

// https://developer.teamwork.com/projects/tags/list-all-tags

class Tags extends Object
{
    public function getAllTags($params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("tags.json", $params)->tags;
    }

    public function getTag($tagId, $params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("tags/".$tagId.".json", $params)->tag;
    }
}
