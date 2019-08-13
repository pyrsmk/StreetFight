<?php

declare(strict_types=1);

namespace StreetFight\Round;

use StreetFight\Board\BoardInterface;

/**
 * Rounds interface
 */
interface RoundsInterface
{
    /**
     * Run the rounds
     *
     * @return BoardInterface
     */
    public function fight(): BoardInterface;
}
