<?php

declare(strict_types=1);

namespace StreetFight\Board;

use StreetFight\Challenger\ChallengerInterface;

/**
 * Result
 */
final class Result implements ResultInterface
{
    /**
     * The challenger
     *
     * @var ChallengerInterface
     */
    private $challenger;

    /**
     * The time
     *
     * @var float
     */
    private $time;

    /**
     * Constructor
     *
     * @param ChallengerInterface $challenger
     * @param float $time
     */
    public function __construct(ChallengerInterface $challenger, float $time)
    {
        $this->challenger = $challenger;
        $this->time = $time;
    }

    /**
     * Get the challenger
     *
     * @return ChallengerInterface
     */
    public function challenger(): ChallengerInterface
    {
        return $this->challenger();
    }

    /**
     * Get the time
     *
     * @return float
     */
    public function time(): float
    {
        return $this->time();
    }
}
