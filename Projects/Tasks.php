<?php

namespace DNAFactory\Teamwork\Projects;

use DNAFactory\Teamwork\Proxy;

/**
 * Class Tasks
 *
 * see https://developer.teamwork.com/projects/api-v1/ref/tasks/get-tasks-json
 * @package DNAFactory\Teamwork\Projects
 */
class Tasks extends Proxy
{
    public function getAllTasks($params = array('page' => 1, 'pageSize' => 250, 'includeCompletedTasks' => true))
    {
        return $this->call("tasks.json", $params)->{'todo-items'};
    }

    public function getSingleTask($taskId)
    {
        return $this->call("tasks/".$taskId.".json")->{'todo-item'};
    }

    public function getAllTasksByProject($projectId, $params = array('page' => 1, 'pageSize' => 250, 'includeCompletedTasks' => true))
    {
        return $this->call("projects/".$projectId."/tasks.json", $params)->{'todo-items'};
    }

    public function getAllTasksByTaskList($taskListid, $params = array('page' => 1, 'pageSize' => 250, 'includeCompletedTasks' => true))
    {
        return $this->call("tasklists/".$taskListid."/tasks.json", $params)->{'todo-items'};
    }

    public function updateTask($taskId, $params = array())
    {
        return $this->call("tasks/".$taskId.".json", ['todo-item' => $params], 'PUT');
    }
}
