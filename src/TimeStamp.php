<?php

namespace StreetFight;

use Exception;

/**
 * Timestamp
 */
final class TimeStamp implements TimeStampInterface
{
    /**
     * The timestamp
     *
     * @var float
     */
    private $time;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->time = microtime(true);
    }

    /**
     * Get the timestamp
     *
     * @param int $unit
     * @return void
     */
    public function get(int $unit = self::S)
    {
        switch($unit)
        {
            case self::S:
                $factor = 1;
                break;
            case self::MS:
                $factor = 10**3;
                break;
            case self::µS:
                $factor = 10**6;
                break;
            default:
                throw new Exception('Invalid specified unit');
        }
        return $this->time * $factor;
    }
}
