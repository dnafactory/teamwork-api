<?php

namespace DNAFactory\Teamwork\Projects;

use DNAFactory\Teamwork\Proxy;

/**
 * Class Projects
 *
 * see https://developer.teamwork.com/projects/api-v1/ref/projects/get-projects-json
 * @package DNAFactory\Teamwork\Projects
 */
class Projects extends Proxy
{
    public function getAllProjects()
    {
        return $this->call("projects.json")->projects;
    }

    public function getSingleProject($projectId)
    {
        return $this->call("projects/".$projectId.".json")->project;
    }
}
