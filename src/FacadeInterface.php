<?php

namespace StreetFight;

use StreetFight\Board\BoardInterface;

/**
 * Facade interface
 */
interface FacadeInterface
{
    const SECONDS_REPORT = 1;
    const ROUNDEDSECONDS_REPORT = 2;
    const MICROSECONDS_REPORT = 3;
    const MILLISECONDS_REPORT = 4;
    const PERCENTAGE_REPORT = 5;

    /**
     * Add a new challenger
     *
     * @param string $name
     * @param callable $callback
     * @return void
     */
    public function add(string $name, callable $callback): void;

    /**
     * Add a hook to run at initialization
     *
     * @param callable $callback
     * @return void
     */
    public function init(callable $callback): void;

    /**
     * Add a hook to run before each kick
     *
     * @param callable $callback
     * @return void
     */
    public function before(callable $callback): void;

    /**
     * Add a hook to run after each kick
     *
     * @param callable $callback
     * @return void
     */
    public function after(callable $callback): void;

    /**
     * Let's start the fight!
     *
     * @param integer $time
     * @return array
     */
    public function fight(int $time = -1): array;
}
