<?php

namespace StreetFight;

use StreetFight\Board\BoardInterface;

/**
 * Facade interface
 */
interface FacadeInterface
{
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
     * @return BoardInterface
     */
    public function fight(int $time = -1): BoardInterface;
}
