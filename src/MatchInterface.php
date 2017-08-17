<?php

namespace StreetFight;

/**
 * Match interface
 */
interface MatchInterface
{
    /**
     * Let's start the fight!
     *
     * @return array
     */
    public function fight() : array;
}
