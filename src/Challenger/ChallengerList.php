<?php

declare(strict_types=1);

namespace StreetFight\Challenger;

use Generator;
use function Funktions\array_to_generator;

/**
 * Challenger list
 */
final class ChallengerList implements ChallengerListInterface
{
    /**
     * The challengers
     *
     * @var Challenger[]
     */
    private $challengers;

    /**
     * Constructor
     *
     * @param Challenger[] $challengers
     */
    public function __construct(Challenger ...$challengers = [])
    {
        $this->challengers = $challengers;
    }

    /**
     * Merge additional challengers to a new collection
     *
     * @param Challenger[] $challengers
     * @return self
     */
    public function with(Challenger ...$challengers): self
    {
        return new self(
            ...$this->challengers,
            ...$challengers
        );
    }

    /**
     * Get the challengers
     *
     * @return Generator
     */
    public function items(): Generator
    {
        yield from array_to_generator($this->challengers);
    }
}
