<?php

declare(strict_types=1);

namespace StreetFight\Board;

use Generator;

/**
 * Round board interface
 */
interface RoundBoardInterface
{
    /**
     * Merge additional results to a new collection
     *
     * @param ResultInterface[] $results
     * @return self
     */
    public function with(ResultInterface ...$results): self;

    /**
     * Get the results
     *
     * @return Generator
     */
    public function results(): Generator;
}
