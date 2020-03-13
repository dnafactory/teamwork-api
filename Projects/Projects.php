<?php

namespace App\TeamWork;

// https://developer.teamwork.com/projects/projects/retrieve-all-projects

class Projects extends Object
{
    public function getAllProjects()
    {
        return $this->call("projects.json")->projects;
    }

    public function getProject($projectId)
    {
        return $this->call("projects/".$projectId.".json")->project;
    }
}
