<?php

declare(strict_types=1);

namespace StreetFight\Match;

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
