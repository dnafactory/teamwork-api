<?php

namespace DNAFactory\Teamwork\Projects;

use DNAFactory\Teamwork\Proxy;

/**
 * Class TaskLists
 *
 * see https://developer.teamwork.com/projects/api-v1/ref/task-lists/get-tasklists-json
 * @package DNAFactory\Teamwork\Projects
 */
class TaskLists extends Proxy
{
    public function getAllTaskLists($params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("tasklists.json", $params)->tasklists;
    }

    public function getSingleTaskList($taskListId)
    {
        return $this->call("tasklists/".$taskListId.".json")->{'todo-list'};
    }

    public function getAllTaskListsByProject($projectId)
    {
        return $this->call("projects/".$projectId."/tasklists.json")->tasklists;
    }
}
