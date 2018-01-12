<?php

namespace StreetFight;

use Closure;

/**
 * Match interface
 */
interface MatchInterface
{
    /**
     * Let's start the fight!
     *
     * @return BoardInterface
     */
    public function fight() : BoardInterface;
}
