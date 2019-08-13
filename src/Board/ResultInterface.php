<?php

declare(strict_types=1);

namespace StreetFight\Board;

use StreetFight\Challenger\ChallengerInterface;

/**
 * Result interface
 */
interface ResultInterface
{
    /**
     * Get the challenger
     *
     * @return ChallengerInterface
     */
    public function challenger(): ChallengerInterface;

    /**
     * Get the resulting time
     *
     * @return float
     */
    public function time(): float;
}
