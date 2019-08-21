<?php

declare(strict_types=1);

namespace StreetFight\Match;

use StreetFight\Round\RoundInterface;
use function Funktions\above;
use function Funktions\loop;

/**
 * A street fight match
 */
final class Match implements MatchInterface
{
    /**
     * The number of rounds
     *
     * @var integer
     */
    private $rounds;

    /**
     * The round
     *
     * @var RoundInterface
     */
    private $round;

    /**
     * Constructor
     *
     * @param int $rounds
     * @param RoundInterface $round
     */
    public function __construct(int $rounds, RoundInterface $round)
    {
        $this->rounds = above($rounds, 1);
        $this->round = $round;
    }

    /**
     * Run the match
     *
     * @return array
     */
    public function fight(): array
    {
        return loop(range(1, $this->rounds), function () {
            yield $this->round->fight();
        });
    }
}
