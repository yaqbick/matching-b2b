<?php
namespace tinder;

use tinder\Criteria;
use tinder\Participant;

class Match
{
    protected $matchID;
    protected $participantA;
    protected $participantB;
    protected $criteria;

    public function __construct(Participant $participantA, Participant $participantB)
    {
        $this->participantA = $participantA;
        $this->participantB = $participantB;
        $this->criteria = [];
    }

    public function setCriterium($key, $criterium)
    {
        $this->criteria[$key] = $criterium;
    }

    public function getCriterium($key)
    {
        if (is_array($this->criteria[$key])) {
            $this->criteria[$key] = implode(',', $this->criteria[$key]);
        }
        return $this->criteria[$key];
    }

    public function getParticipantA(): Participant
    {
        return $this->participantA;
    }

    public function getParticipantB(): Participant
    {
        return $this->participantB;
    }
}
