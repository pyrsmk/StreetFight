<?php

namespace StreetFight;

/**
 * Match interface
 */
interface MatchInterface
{
    /**
     * Add a challenger
     *
     * @param string $name
     * @param callable $challenger
     * @return void
     */
    public function add($name, callable $challenger) : void;

    /**
     * Let's start the fight!
     *
     * @return array
     */
    public function fight() : array;
}
