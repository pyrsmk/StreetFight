<?php

namespace StreetFight\Challenger;

use Illuminator\TimedTask;
use StreetFight\Result\ResultInterface;
use StreetFight\Result\Result;
use function Funktions\mute;
use function Funktions\clean;

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
     * The callback to time
     *
     * @var callable
     */
    private $timedTask;

    /**
     * Constructor
     *
     * @param string $name
     * @param callable $callback
     */
    public function __construct(string $name, callable $callback)
    {
        $this->name = $name;
        $this->timedTask = new TimedTask($callback);
    }

    /**
     * Run the callback and return the elapsed time
     *
     * @return ResultInterface
     */
    public function kick(): ResultInterface
    {
        return clean(function () {
            return mute(function () {
                return new Result(
                    $this->name,
                    $this->timedTask->read()
                );
            });
        });
    }
}
