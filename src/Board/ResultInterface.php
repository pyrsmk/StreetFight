<?php

declare(strict_types=1);

namespace StreetFight\Board;

/**
 * Result interface
 */
interface ResultInterface
{
    /**
     * Add the time to an array of results
     *
     * @return array
     */
    public function addTo(array $results): array;
}
