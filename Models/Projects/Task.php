<?php

namespace DNAFactory\Teamwork\Models\Projects;

use DNAFactory\Teamwork\Models\BaseModel;

/**
 * @property-read int $id
 * @property-read string $description
 * @property-read string $content
 * @property-read int $projectId
 * @property-read string $projectName
 * @property-read int $todoListId
 * @property-read string $todoListName
 * @property-read \Carbon\Carbon $dueDate
 * @property-read array $responsibleParty
 */
class Task extends BaseModel
{
    protected function getProjectId()
    {
        return $this->getRawAttribute('project-id');
    }

    protected function getProjectName()
    {
        return $this->getRawAttribute('project-name');
    }

    protected function getTodoListId()
    {
        return $this->getRawAttribute('todo-list-id');
    }

    protected function getTodoListName()
    {
        return $this->getRawAttribute('todo-list-name');
    }

    protected function getDueDate()
    {
        $rawDueDate = $this->getRawAttribute('due-date') ?: null;
        return $this->convertDate($rawDueDate);
    }

    public function getResponsibleParties()
    {
        $rawResponsiblePartyIds = $this->getRawAttribute('responsible-party-ids') ?: '';
        $ids = explode(',',$rawResponsiblePartyIds);
        $references = array_map(fn($id) => ['id' => (int)$id, 'type' => 'users'], $ids);
        return $this->retriveManyReferences($references);
    }

    public function getLink()
    {
        return sprintf('%s/#/tasks/%d', $this->endpoint->getBaseUrl(), $this->id);
    }
}
