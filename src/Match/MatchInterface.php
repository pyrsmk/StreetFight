<?php

declare(strict_types=1);

namespace StreetFight\Match;

use StreetFight\Board\BoardInterface;

/**
 * Match interface
 */
interface MatchInterface
{
    /**
     * Run the match
     *
     * @return BoardInterface
     */
    public function fight(): BoardInterface;
}
