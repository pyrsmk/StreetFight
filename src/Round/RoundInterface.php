<?php

declare(strict_types=1);

namespace StreetFight\Round;

use StreetFight\Board\BoardInterface;

/**
 * Round interface
 */
interface RoundInterface
{
    /**
     * Run the round
     *
     * @return BoardInterface
     */
    public function fight(): BoardInterface;
}
