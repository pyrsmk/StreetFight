<?php

declare(strict_types=1);

namespace StreetFight\Board;

use Generator;
use StreetFight\Challenger\ChallengerInterface;

/**
 * Board interface
 */
interface BoardInterface
{
    /**
     * Merge additional round boards to a new match board
     *
     * @param RoundBoardInterface[] $boards
     * @return self
     */
    public function with(RoundBoardInterface ...$boards): self;

    /**
     * Get the round boards
     *
     * @return Generator
     */
    public function boards(): Generator;

    /**
     * Filter results by challenger
     *
     * @param ChallengerInterface $challenger
     * @return Generator
     */
    public function filter(ChallengerInterface $challenger): Generator;
}
