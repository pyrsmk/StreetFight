<?php

declare(strict_types=1);

namespace StreetFight\Challenger;

use Generator;

/**
 * Challenger list interface
 */
interface ChallengerListInterface
{
    /**
     * Get the challengers
     *
     * @return Generator
     */
    public function items(): Generator;
}
