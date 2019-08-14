<?php

namespace StreetFight\Challenger;

use Illuminator\TimedTask;

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
     * @var callable
     */
    private $task;

    /**
     * Constructor
     *
     * @param string $name
     * @param callable $callback
     */
    public function __construct(string $name, callable $callback)
    {
        $this->name = $name;
        $this->task = new TimedTask($callback);
    }

    /**
     * Return the challenger's name
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Run the callback and return the elapsed time
     *
     * @return float
     */
    public function kick(): float
    {
        return $this->task->read();
    }
}
