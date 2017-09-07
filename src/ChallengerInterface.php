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
     * @param Psr\Container\ContainerInterface $container
     * @return void
     */
    public function kick(ContainerInterface $container) : void;
}
