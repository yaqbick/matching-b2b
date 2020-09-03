<?php
namespace tinder;

use TimeInterval;
use Trade;

class Participant
{
    public $ID;
    protected $name;
    public $timeInterval;
    public $myY;
    public $myZ;
    public $myChoiceY;
    public $myChoiceZ;
    public $weight;
    public $matched;

    public function __construct($ID, string $name, array $timeInterval, array $myY, array $myZ, array $myChoiseY, array $myChoiseZ)
    {
        $this->ID =$ID;
        $this->name = $name;
        $this->timeInterval = $timeInterval;
        $this->myY = $myY;
        $this->myZ = $myZ;
        $this->myChoiceY = $myChoiseY;
        $this->myChoiceZ = $myChoiseZ;
        $this->matched = 0;
        $this->weight = count($this->timeInterval)+count($this->myY)+count($this->myZ);//waga uzaleniana od maxymalnej dlugosci tablicy
    }

    public function getID()
    {
        return $this->ID;
    }

    
    public function getName()
    {
        return $this->name;
    }

    public function getTimeInterval()
    {
        return $this->timeInterval;
    }

    public function getMyY()
    {
        return $this->myY;
    }
 
    public function getMyZ()
    {
        return $this->myZ;
    }
    public function getMyChoiceY()
    {
        return $this->myChoiceY;
    }
    public function getMychoiceZ()
    {
        return $this->myChoiceZ;
    }
    public function getWeight()
    {
        return $this->weight;
    }
    public function getMatched()
    {
        return $this->matched;
    }

    public function getTimeIntervalByID($id)
    {
        foreach ($this->timeInterval as $item) {
            if ($item->getID()==$id) {
                return $item;
            }
        }
        return null;
    }

    public function getMyYItemByID($id)
    {
        foreach ($this->myY as $item) {
            if ($item->getID()==$id) {
                return $item;
            }
        }
    }
    public function getMyChoiceYItemByID($id)
    {
        foreach ($this->myChoiceY as $item) {
            if ($item->getID()==$id) {
                return $item;
            }
        }
    }
}
