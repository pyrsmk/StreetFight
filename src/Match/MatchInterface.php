<?php

declare(strict_types=1);

namespace StreetFight\Match;

use StreetFight\Board\MatchBoardInterface;

/**
 * Match interface
 */
interface MatchInterface
{
    /**
     * Run the match
     *
     * @return array
     */
    public function fight(): array;
}
