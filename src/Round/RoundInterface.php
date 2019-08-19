<?php

declare(strict_types=1);

namespace StreetFight\Round;

use StreetFight\Result\ResultListInterface;

/**
 * Round interface
 */
interface RoundInterface
{
    /**
     * Run the round
     *
     * @return ResultListInterface
     */
    public function fight(): ResultListInterface;
}
