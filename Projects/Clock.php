<?php

namespace App\TeamWork;

// https://developer.teamwork.com/projects/clock-in-clock-out/get-all-clock-ins

class Clock extends Object
{
    public function getAllClocks($personId, $params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("people/".$personId."/clockins.json", $params)->clockIns;
    }

    public function clockIn()
    {
        return $this->call("/me/clockin.json", [], "POST");
    }

    public function clockOut()
    {
        return $this->call("/me/clockout.json", [], "POST");
    }
}
