<?php

namespace App\TeamWork;

// https://developer.teamwork.com/projects/tasks/get-all-tasks-across-all-projects

class Tasks extends Object
{
    public function getAllTasks($params = array('page' => 1, 'pageSize' => 250, 'includeCompletedTasks' => true))
    {
        return $this->call("tasks.json", $params)->{'todo-items'};
    }

    public function getAllTasksByProject($projectId, $params = array('page' => 1, 'pageSize' => 250, 'includeCompletedTasks' => true))
    {
        return $this->call("projects/".$projectId."/tasks.json", $params)->{'todo-items'};
    }

    public function getAllTasksByTaskList($taskListid, $params = array('page' => 1, 'pageSize' => 250, 'includeCompletedTasks' => true))
    {
        return $this->call("tasklists/".$taskListid."/tasks.json", $params)->{'todo-items'};
    }

    public function getTaskById($taskId)
    {
        return $this->call("tasks/".$taskId.".json")->{'todo-item'};
    }

    public function updateTask($taskId, $params = array())
    {
        return $this->call("tasks/".$taskId.".json", ['todo-item' => $params], 'PUT');
    }
}
