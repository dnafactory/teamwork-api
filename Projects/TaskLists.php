<?php

namespace App\TeamWork;

// https://developer.teamwork.com/projects/task-lists/get-all-task-lists

class TaskLists extends Object
{
    public function getAllTaskLists($params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("tasklists.json", $params)->tasklists;
    }

    public function getAllTaskListsByProject($projectId)
    {
        return $this->call("projects/".$projectId."/tasklists.json")->tasklists;
    }

    public function getTaskList($taskListId)
    {
        return $this->call("tasklists/".$taskListId.".json")->{'todo-list'};
    }
}
