<?php

namespace DNAFactory\Teamwork\Projects;

// https://developer.teamwork.com/projects/tags/list-all-tags

use DNAFactory\Teamwork\Proxy;

/**
 * Class Tags
 *
 * see https://developer.teamwork.com/projects/api-v1/ref/tags/get-tags-json
 * @package DNAFactory\Teamwork\Projects
 */
class Tags extends Proxy
{
    public function getAllTags($params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("tags.json", $params)->tags;
    }

    public function getSingleTag($tagId, $params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("tags/".$tagId.".json", $params)->tag;
    }
}
