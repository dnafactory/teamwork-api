<?php

require "../../vendor/autoload.php";

if (file_exists("config.php")) {
    require "config.php";
} else {
    $baseUrl = "BASE_URL_HERE";
    $token = "TOKEN_HERE";
}


$project = new \DNAFactory\Teamwork\Projects\Projects($baseUrl, $token);

var_dump($project->getAllProjects());
var_dump($project->getSingleProject(1));