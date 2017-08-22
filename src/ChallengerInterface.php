<?php

namespace StreetFight;

/**
 * Challenger interface
 */
interface ChallengerInterface
{
    /**
     * Constructor
     *
     * @param callable $callable
     */
    public function __construct(callable $callable);

    /**
     * Run the callable and return the elapsed time
     *
     * @return void
     */
    public function kick() : void;
}
