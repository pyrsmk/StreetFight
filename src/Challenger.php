<?php

namespace StreetFight;

/**
 * Here comes a new challenger!
 */
final class Challenger
{
    /**
     * The closure to run
     *
     * @var Closure
     */
    private $closure;

    /**
     * Total time passed to fight
     *
     * @var float
     */
    private $fightingTime;

    /**
     * Constructor
     *
     * @param Closure $closure
     */
    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
        $this->totalTime = 0;
    }

    /**
     * Run the closure
     *
     * @return void
     */
    public function kick() : void
    {
        $chrono = new Chrono();
        call_user_func($this->closure);
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
