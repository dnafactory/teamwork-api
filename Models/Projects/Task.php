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
 * @property-read Tag[] $tags
 * @property-read User[] $responsibleParties
 * @property-read Team[] $assignedToTeams
 * @property-read User[] $allAssignees
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

    public function hasEveryTag(array $tags)
    {
        $ownTags = $this->tags;
        foreach ($tags as $tag) {
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
            if (in_array($tag, $ownTags)) {
                return true;
            }
        }
        return false;
    }
}
