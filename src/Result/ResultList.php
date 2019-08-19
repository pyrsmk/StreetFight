<?php

declare(strict_types=1);

namespace StreetFight\Result;

use Generator;
use function Funktions\array_to_generator;

/**
 * A result list for each round
 */
final class ResultList implements ResultListInterface
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
    public function __construct(ResultInterface ...$results)
    {
        $this->results = $results;
    }

    /**
     * Get the results
     *
     * @return Generator
     */
    public function items(): Generator
    {
        yield from array_to_generator($this->results);
    }
}
