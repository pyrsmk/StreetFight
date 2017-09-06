<?php

namespace StreetFight;

use Closure;

/**
 * Challenger interface
 */
interface ChallengerInterface
{
    /**
     * Run the callable
     *
     * @return void
     */
    public function kick() : void;
}
