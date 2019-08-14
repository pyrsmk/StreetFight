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
     * @var ChallengerInterface[]
     */
    private $challengers;

    /**
     * Constructor
     *
     * @param ChallengerInterface[] $challengers
     */
    public function __construct(ChallengerInterface ...$challengers = [])
    {
        $this->challengers = $challengers;
    }

    /**
     * Merge additional challengers to a new collection
     *
     * @param ChallengerInterface[] $challengers
     * @return self
     */
    public function with(ChallengerInterface ...$challengers): self
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
