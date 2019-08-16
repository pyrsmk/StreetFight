<?php

declare(strict_types=1);

namespace StreetFight\Result;

use function Funktions\condition;

/**
 * Result
 */
final class Result implements ResultInterface
{
    /**
     * The challenger's name
     *
     * @var string
     */
    private $name;

    /**
     * The time
     *
     * @var float
     */
    private $time;

    /**
     * Constructor
     *
     * @param string $name
     * @param float $time
     */
    public function __construct(string $name, float $time)
    {
        $this->name = $name;
        $this->time = $time;
    }

    /**
     * Add the time to an array of results
     *
     * @return array
     */
    public function addTo(array $results): array
    {
        return condition(
            !isset($results[$this->name]),
            function () {
                return $this->time;
            },
            function () use ($results) {
                return $results[$this->name] + $this->time;
            }
        );
    }
}
