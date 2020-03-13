<?php

namespace DNAFactory\Teamwork\Projects;

// https://developer.teamwork.com/projects/people/get-all-people

use DNAFactory\Teamwork\Proxy;

/**
 * Class People
 *
 * see https://developer.teamwork.com/projects/api-v1/ref/people/get-people-json
 * @package DNAFactory\Teamwork\Projects
 */
class People extends Proxy
{
    public function getAllPeople($params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("people.json", $params)->people;
    }

    public function getSpecificPerson($personid, $params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("people/".$personid.".json", $params)->person;
    }
}
