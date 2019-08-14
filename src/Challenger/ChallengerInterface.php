<?php

namespace StreetFight\Challenger;

use StreetFight\Board\ResultInterface;

/**
 * Challenger interface
 */
interface ChallengerInterface
{
    /**
     * Run the callback and return the elapsed time
     *
     * @return ResultInterface
     */
    public function kick(): ResultInterface;
}
