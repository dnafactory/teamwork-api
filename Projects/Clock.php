<?php

namespace DNAFactory\Teamwork\Projects;

use DNAFactory\Teamwork\Proxy;

/**
 * Class Clock
 *
 * see https://developer.teamwork.com/projects/api-v1/ref/clock-in-clock-out/
 * @package DNAFactory\Teamwork\Projects
 */
class Clock extends Proxy
{
    public function getAllClocksIns($personId, $params = array('page' => 1, 'pageSize' => 250))
    {
        return $this->call("people/".$personId."/clockins.json", $params)->clockIns;
    }

    public function clockMeIn()
    {
        return $this->call("/me/clockin.json", [], "POST");
    }

    public function clockMeOut()
    {
        return $this->call("/me/clockout.json", [], "POST");
    }
}
