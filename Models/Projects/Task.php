<?php

namespace DNAFactory\Teamwork\Models\Projects;

use DNAFactory\Teamwork\Models\BaseModel;

/**
 * @property-read int $id
 * @property-read string $description
 * @property-read string $content
 * @property-read string $link
 * @property-read int $projectId
 * @property-read string $projectName
 * @property-read int $todoListId
 * @property-read string $todoListName
 * @property-read \Carbon\Carbon $dueDate
 * @property-read array $responsibleParties
 * @property-read array $assignedToTeams
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

    protected function getResponsibleParties()
    {
        $rawResponsiblePartyIds = $this->getRawAttribute('responsible-party-ids') ?: null;
        if (is_null($rawResponsiblePartyIds)) {
            return [];
        }
        $ids = explode(',', $rawResponsiblePartyIds);
        $references = array_map(fn($id) => ['id' => (int)$id, 'type' => 'users'], $ids);
        return $this->retriveManyReferences($references);
    }

    protected function getAssignedToTeams()
    {
        $rawAssignedToTeams = $this->getRawAttribute('assignedToTeams') ?? [];
        $references = [];
        foreach ($rawAssignedToTeams as $rawTeam) {
            $references[] = ['id' => $rawTeam['teamId'], 'type' => 'team'];
        }
        return $this->retriveManyReferences($references);
    }

    protected function getLink()
    {
        return sprintf('%s/#/tasks/%d', $this->endpoint->getBaseUrl(), $this->id);
    }
}
