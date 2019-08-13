<?php

namespace StreetFight\Challenger;

/**
 * Challenger interface
 */
interface ChallengerInterface
{
    /**
     * Return the challenger's name
     *
     * @return string
     */
    public function name(): string;

    /**
     * Run the callback and return the elapsed time
     *
     * @return float
     */
    public function kick(): float;
}
