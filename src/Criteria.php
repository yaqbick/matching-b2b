<?php
namespace tinder;

class Criteria
{
    protected $timeinterval;
    protected $factorY;
    protected $factorZ;

    public function __construct($timeInterval, array $factorY)
    {
        $this->timeinterval = $timeInterval;
        $this->factorY = $factorY;
    }

    public function getTimeInterval()
    {
        return $this->timeInterval;
    }
}
