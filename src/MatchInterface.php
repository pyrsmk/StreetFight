<?php

namespace StreetFight;

/**
 * Match interface
 */
interface MatchInterface
{
    /**
     * Constructor
     *
     * @param int|null $matchTime
     */
    public function __construct(?int $matchTime = null);

    /**
     * Add a new challenger
     *
     * @param string $name
     * @param Challenger $challenger
     * @return void
     */
    public function add($name, Challenger $challenger) : void;

    /**
     * Let's start the fight!
     *
     * @return array
     */
    public function fight() : array;
}
