<?php

namespace DNAFactory\Teamwork\Models\Projects;

use DNAFactory\Teamwork\Models\BaseModel;
use DNAFactory\Teamwork\Support\TaggableTrait;

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
    use TaggableTrait;

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
}
