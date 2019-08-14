<?php

declare(strict_types=1);

namespace StreetFight\Challenger;

/**
 * Challenger list interface
 */
interface ChallengerListInterface
{
    /**
     * Merge additional challengers to a new collection
     *
     * @param ChallengerInterface[] $challengers
     * @return self
     */
    public function with(ChallengerInterface ...$challengers): self;

    /**
     * Get the challengers
     *
     * @return Generator
     */
    public function items(): Generator;
}
