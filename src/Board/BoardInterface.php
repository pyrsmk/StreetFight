<?php

declare(strict_types=1);

namespace StreetFight\Board;

use Generator;

/**
 * Board interface
 */
interface BoardInterface
{
    /**
     * Get the results
     *
     * @return Generator
     */
    public function results(): Generator;
}
