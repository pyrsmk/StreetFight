<?php

namespace StreetFight;

/**
 * Challenger interface
 */
interface ChallengerInterface
{
    /**
     * Run the closure
     *
     * @return void
     */
    public function kick() : void;
}
