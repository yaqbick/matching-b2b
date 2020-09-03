<?php

namespace tinder;

class Trade
{
    protected $id;
    protected $value;
    protected $isAvailable;

    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
        $this->isAvailable= true;
    }

    public function take(): void
    {
        $this->isAvailable = false;
    }

    public function getID()
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getAvailability(): boolean
    {
        return $this->isAvailable;
    }
}
