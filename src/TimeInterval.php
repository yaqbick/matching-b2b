<?php
namespace tinder;

class TimeInterval
{
    protected $id;
    protected $value;
    protected $isTaken;

    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
        $this->isTaken = 'nic';
    }

    public function take($participantName): void
    {
        $this->isTaken = $participantName;
    }

    public function getID()
    {
        return $this->id;
    }

    
    public function getValue()
    {
        return $this->value;
    }

    public function getAvailability()
    {
        return $this->isTaken;
    }
}
