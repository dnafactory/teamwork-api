<?php

namespace DNAFactory\Teamwork\Models\Projects;


/**
 * @property-read int $id
 * @property-read string $description
 * @property-read string $content
 * @property-read int $projectId
 * @property-read string $projectName
 * @property-read int $todoListId
 * @property-read string $todoListName
 * @property-read \Carbon\Carbon $dueDate
 */
class Task extends \DNAFactory\Teamwork\Models\BaseModel
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
}
