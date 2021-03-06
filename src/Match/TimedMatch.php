<?php

declare(strict_types=1);

namespace StreetFight\Match;

use Illuminator\LazyChrono;
use StreetFight\Round\RoundInterface;
use function Funktions\above;
use function Funktions\loop_until;

/**
 * A match with a maximum time
 */
final class TimedMatch implements MatchInterface
{
    /**
     * The maximum time
     *
     * @var integer
     */
    private $time;

    /**
     * The round
     *
     * @var RoundInterface
     */
    private $round;

    /**
     * Constructor
     *
     * @param int $time
     * @param RoundInterface $round
     */
    public function __construct(int $time, RoundInterface $round)
    {
        $this->time = above($time, 0);
        $this->round = $round;
    }

    /**
     * Run the match
     *
     * @return array
     */
    public function fight(): array
    {
        $chrono = new LazyChrono();
        return loop_until(function () use ($chrono) {
            yield $this->round->fight();
            return $chrono->readAsMilliseconds() >= $this->time;
        });
    }
}
