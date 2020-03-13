<?php

namespace DNAFactory\Teamwork\Projects;

use DNAFactory\Teamwork\Proxy;

/**
 * Class TimeTracking
 *
 * see https://developer.teamwork.com/projects/api-v1/ref/time-tracking/get-time-entries-json
 * @package DNAFactory\Teamwork\Projects
 */
class TimeTracking extends Proxy
{
    public function getAllTimes($params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("time_entries.json", $params)->{'time-entries'};
    }

    public function getSingleTime($timeId, $params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("time_entries/".$timeId.".json", $params)->{'time-entry'};
    }

    public function getAllTimesByProject($projectId, $params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("projects/".$projectId."/time_entries.json", $params)->{'time-entries'};
    }

    public function getTotalTimeOnProject($projectId, $params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("projects/".$projectId."/time/total.json", $params)->projects;
    }

    public function getTotalTimeOnProjectByUser($projectId, $userId, $params = array('page' => 1, 'pageSize' => 250))
    {
        $params['userId'] = $userId;
        return $this->getTotalTimeOnProject($projectId, $params);
    }

    public function getTotalTimeOnTaskList($taskListId, $params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("tasklists/".$taskListId."/time/total.json", $params)->projects;
    }

    public function getTotalTimeOnTaskListByUser($taskListId, $userId, $params = array('page' => 1, 'pageSize' => 250))
    {
        $params['userId'] = $userId;
        return $this->getTotalTimeOnTaskList($taskListId, $params);
    }

    public function getTotalTimeOnTask($taskId, $params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("tasks/".$taskId."/time/total.json", $params)->projects;
    }

    public function getTotalTimeOnTaskByUser($taskId, $userId, $params = array('page' => 1, 'pageSize' => 250))
    {
        $params['userId'] = $userId;
        return $this->getTotalTimeOnTask($taskId, $params);
    }
}
