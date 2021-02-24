<?php

namespace DNAFactory\Teamwork\Models\Projects;

use DNAFactory\Teamwork\Models\BaseModel;
use DNAFactory\Teamwork\Support\TaggableTrait;

/**
 * @property-read int $id
 * @property-read string $description
 * @property-read string $content
 * @property-read string $link
 * @property-read Project $project
 * @property-read int $projectId
 * @property-read string $projectName
 * @property-read int $todoListId
 * @property-read string $todoListName
 * @property-read TodoList $todoList
 * @property-read int $parentTaskId
 * @property-read Task|null $parentTask
 * @property-read \Carbon\Carbon $dueDate
 * @property-read Tag[] $tags
 * @property-read User[] $responsibleParties
 * @property-read Team[] $assignedToTeams
 * @property-read User[] $allAssignees
 */
class Task extends BaseModel
{
    use TaggableTrait;

    protected function getProjectId()
    {
        $value = $this->getRawAttribute('project-id');
        return $value ? (int)$value : null;
    }

    protected function getProjectName()
    {
        return $this->getRawAttribute('project-name');
    }

    protected function getProject()
    {
        $reference = ['id' => $this->projectId, 'type' => 'projects'];
        return $this->endpoint->retriveReference($reference);
    }

    protected function getTodoListId()
    {
        $value = $this->getRawAttribute('todo-list-id');
        return $value ? (int)$value : null;
    }

    protected function getTodoListName()
    {
        return $this->getRawAttribute('todo-list-name');
    }

    protected function getTodoList()
    {
        $reference = ['id' => $this->todoListId, 'type' => 'tasklists'];
        return $this->endpoint->retriveReference($reference);
    }

    protected function getParentTaskId()
    {
        $value = $this->getRawAttribute('parentTaskId');
        return $value ? (int)$value : null;
    }

    protected function getParentTask()
    {
        $reference = ['id' => $this->parentTaskId, 'type' => 'tasks'];
        return $this->endpoint->retriveReference($reference);
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
        $references = array_map(fn($id) => ['id' => (int)$id, 'type' => 'user'], $ids);
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

    protected function getTags()
    {
        $rawReferences = $this->getRawAttribute('tags', []);
        $references = [];
        foreach ($rawReferences as $rawReference) {
            $references[] = ['id' => $rawReference['id'], 'type' => 'tags'];
        }
        return $this->retriveManyReferences($references);
    }

    protected function getAllAssignees()
    {
        $assignees = $this->responsibleParties;
        foreach ($this->assignedToTeams as $team) {
            /** @var Team $team */
            foreach ($team->members as $member) {
                if (!in_array($member, $assignees)) {
                    $assignees[] = $member;
                }
            }
        }
        return $assignees;
    }

    protected function getLink()
    {
        return sprintf('%s/#/tasks/%d', $this->endpoint->getBaseUrl(), $this->id);
    }
}
