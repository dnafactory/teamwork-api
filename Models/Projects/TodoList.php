<?php

namespace DNAFactory\Teamwork\Models\Projects;

use DNAFactory\Teamwork\Models\BaseModel;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $description
 * @property-read Project $project
 * @property-read int $projectId
 * @property-read string $projectName
 * @property-read Tag[] $tags
 */
class TodoList extends BaseModel
{
    protected function getProjectId()
    {
        $value = $this->getRawAttribute('projectId');
        return $value ? (int)$value : null;
    }

    protected function getProjectName()
    {
        return $this->getRawAttribute('projectName');
    }

    protected function getProject()
    {
        $reference = ['id' => $this->projectId, 'type' => 'projects'];
        return $this->endpoint->retriveReference($reference);
    }

    protected function getTags()
    {
        $rawReferences = $this->getRawAttribute('tags', []);
        $references = [];
        foreach ($rawReferences as $rawReference) {
            $references[] = ['id' => (int)$rawReference['id'], 'type' => 'tags'];
        }
        return $this->retriveManyReferences($references);
    }

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
