<?php

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
    public function tell() : string;

    /**
     * Run the callback
     *
     * @param Psr\Container\ContainerInterface $container
     * @return void
     */
    public function kick(ContainerInterface $container) : void;
}
