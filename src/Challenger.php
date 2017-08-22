<?php

namespace StreetFight;

/**
 * Here comes a new challenger!
 */
final class Challenger
{
    /**
     * The callable to run
     *
     * @var callable
     */
    private $callable;

    /**
     * Total time passed to fight
     *
     * @var float
     */
    private $fightingTime;

    /**
     * Constructor
     *
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
        $this->totalTime = 0;
    }

    /**
     * Run the callable and return the elapsed time
     *
     * @return void
     */
    public function kick() : void
    {
        $chrono = new Chrono();
        call_user_func($this->callable);
        $this->fightingTime += $chrono->getElapsedTime();
    }

    /**
     * Return the total fighting time
     *
     * @return float
     */
    public function getFightingTime() : float
    {
        return $this->fightingTime;
    }
}
