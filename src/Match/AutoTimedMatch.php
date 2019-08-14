<?php

declare(strict_types=1);

namespace StreetFight\Match;

use Illuminator\LazyChrono;
use StreetFight\Round\RoundInterface;
use function Funktions\loop_until;
use function Funktions\clean;

/**
 * A match with an auto-computed maximum time
 */
final class AutoTimedMatch implements MatchInterface
{
    /**
     * The round
     *
     * @var RoundInterface
     */
    private $round;

    /**
     * Constructor
     *
     * @param RoundInterface $round
     */
    public function __construct(RoundInterface $round)
    {
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
        $max_time = null;
        return loop_until(function () use ($chrono, &$max_time) {
            yield clean(function () {
                return $this->round->fight();
            });
            return $chrono->readAsMilliseconds()
                < $max_time ?? $chrono->readAsMilliseconds() * 10;
        });
    }
}
