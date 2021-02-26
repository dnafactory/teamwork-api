<?php

namespace DNAFactory\Teamwork\Support;

trait TaggableTrait
{
    public function hasEveryTag(array $tags)
    {
        $ownTags = array_map(fn($tag) => $tag->id, $this->tags);
        foreach ($tags as $tag) {
            if (!is_int($tag)) {
                $tag = $tag->id;
            }
            if (!in_array($tag, $ownTags)) {
                return false;
            }
        }
        return true;
    }

    public function hasAnyTag(array $tags)
    {
        $ownTags = array_map(fn($tag) => $tag->id, $this->tags);
        foreach ($tags as $tag) {
            if (!is_int($tag)) {
                $tag = $tag->id;
            }
            if (in_array($tag, $ownTags)) {
                return true;
            }
        }
        return false;
    }
}
