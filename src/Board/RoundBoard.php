<?php

declare(strict_types=1);

namespace StreetFight\Board;

use Generator;
use function Funktions\array_to_generator;

/**
 * Round board
 */
final class RoundBoard implements RoundBoardInterface
{
    /**
     * Result list
     *
     * @var ResultInterface[]
     */
    private $results;

    /**
     * Constructor
     *
     * @param ResultInterface[] $results
     */
    public function __construct(ResultInterface ...$results = [])
    {
        $this->results = $results;
    }

    /**
     * Merge additional results to a new collection
     *
     * @param ResultInterface[] $results
     * @return self
     */
    public function with(ResultInterface ...$results): self
    {
        return new self(
            ...$this->results,
            ...$results
        );
    }

    /**
     * Get the results
     *
     * @return Generator
     */
    public function results(): Generator
    {
        yield from array_to_generator($this->results);
    }
}
