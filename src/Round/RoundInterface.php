<?php

declare(strict_types=1);

namespace StreetFight\Round;

use StreetFight\Board\RoundBoardInterface;

/**
 * Round interface
 */
interface RoundInterface
{
    /**
     * Run the round
     *
     * @return RoundBoardInterface
     */
    public function fight(): RoundBoardInterface;
}
