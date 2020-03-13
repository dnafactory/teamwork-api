<?php

namespace App\TeamWork;

// https://developer.teamwork.com/projects/people/get-all-people

class People extends Object
{
    public function getAllPeople($params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("people.json", $params)->people;
    }

    public function getPerson($personid, $params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("people/".$personid.".json", $params)->person;
    }
}
