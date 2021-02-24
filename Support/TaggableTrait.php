<?php

namespace DNAFactory\Teamwork\Support;

trait TaggableTrait
{
    public function hasEveryTag(array $tags)
    {
        $ownTags = $this->tags;
        foreach ($tags as $tag) {
            if (is_int($tag)) {
                $tag = $this->endpoint->retriveReference(['id' => $tag, 'type' => 'tags']);
            }
            if (!in_array($tag, $ownTags)) {
                return false;
            }
        }
        return true;
    }

    public function hasAnyTag(array $tags)
    {
        $ownTags = $this->tags;
        foreach ($tags as $tag) {
            if (is_int($tag)) {
                $tag = $this->endpoint->retriveReference(['id' => $tag, 'type' => 'tags']);
            }
            if (in_array($tag, $ownTags)) {
                return true;
            }
        }
        return false;
    }
}
