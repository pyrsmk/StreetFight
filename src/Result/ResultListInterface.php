<?php

declare(strict_types=1);

namespace StreetFight\Result;

use Generator;

/**
 * Result list interface
 */
interface ResultListInterface
{
    /**
     * Get the results
     *
     * @return Generator
     */
    public function results(): Generator;
}
