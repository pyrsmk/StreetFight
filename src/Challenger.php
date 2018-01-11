<?php

namespace StreetFight;

use Closure;
use Psr\Container\ContainerInterface;

/**
 * A challenger
 */
class Challenger implements ChallengerInterface
{
    /**
     * Challenger's name
     *
     * @var string
     */
    private $name;

    /**
     * The callback to run
     *
     * @var Closure
     */
    private $callback;

    /**
     * Constructor
     *
     * @param string $name
     * @param Closure $callback
     */
    public function __construct(string $name, Closure $callback)
    {
        $this->name = $name;
        $this->callback = $callback;
    }

    /**
     * Return the challenger's name
     *
     * @return string
     */
    public function tell() : string
    {
        return $this->name;
    }

    /**
     * Run the callback
     *
     * @param Psr\Container\ContainerInterface $container
     * @return void
     */
    public function kick(ContainerInterface $container) : void
    {
        ($this->callback)($container);
    }
}
