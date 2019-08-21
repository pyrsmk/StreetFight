<?php

declare(strict_types=1);

namespace StreetFight\Match;

use StreetFight\Round\RoundInterface;
use function Funktions\clean;
use function Funktions\loop;

/**
 * A match with an auto-computed maximum time
 */
final class AutoTimedMatch implements MatchInterface
{
    private const ROUNDS = 10000;

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
        return loop(range(1, self::ROUNDS), function () {
            yield clean(function () {
                return $this->round->fight();
            });
        });
    }
}
