<?php

require "../../vendor/autoload.php";

if (file_exists("config.php")) {
    require "config.php";
} else {
    $baseUrl = "BASE_URL_HERE";
    $token = "TOKEN_HERE";
}


$project = new \DNAFactory\Teamwork\Projects\Clock($baseUrl, $token);

var_dump($project->clockMeIn());
var_dump($project->clockMeOut());

$personId = 1;

var_dump($project->getAllClocksIns($personId));
