<?php

/**
 * Timestamp interface
 */
interface TimeStampInterface
{
    /**
     * Second unit
     */
    const S = 0;

    /**
     * Millisecond unit
     */
    const MS = 1;

    /**
     * Microsecond unit
     */
    const µS = 2;

    /**
     * Get the timestamp
     *
     * @param int $unit
     * @return void
     */
    public function get(int $unit = self::MS);
}
