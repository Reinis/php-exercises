<?php

namespace Survey;

class Survey
{
    private int $surveyed;
    private float $energyDrinkers;
    private float $preferCitrus;

    public function __construct(int $surveyed, float $energyDrinkers, float $preferCitrus)
    {
        $this->surveyed = $surveyed;
        $this->energyDrinkers = $energyDrinkers;
        $this->preferCitrus = $preferCitrus;
    }

    public function getEnergyDrinkerCount(): int
    {
        return $this->surveyed * $this->energyDrinkers;
    }

    public function getCitrusLoverCount(): int
    {
        return $this->surveyed * $this->energyDrinkers * $this->preferCitrus;
    }
}
