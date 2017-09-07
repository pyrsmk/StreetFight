<?php

namespace StreetFight;

use Closure;
use Psr\Container\ContainerInterface;

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
     * Run the callable
     *
     * @param Psr\Container\ContainerInterface $container
     * @return void
     */
    public function kick(ContainerInterface $container) : void
    {
        $chrono = new Chrono(new TimeStamp());
        ($this->closure)($container);
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
