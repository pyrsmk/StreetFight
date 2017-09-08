<?php

namespace StreetFight;

/**
 * Chronometer
 */
final class Chrono implements ChronoInterface
{
    /**
     * Seconds
     */
    const S = 1;

    /**
     * Milliseconds
     */
    const MS = 10**3;

    /**
     * Microseconds
     */
    const µS = 10**6;

    /**
     * Initial time
     *
     * @var float
     */
    private $initialTime;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->initialTime = $this->_getTime();
    }

    /**
     * Get the elapsed time
     *
     * @param int $unit
     * @return float
     */
    public function getElapsedTime(int $unit = self::S)
    {
        $this->_verifyUnit($unit);
        return ($this->_getTime() - $this->initialTime) * $unit;
    }

    /**
     * Get the current time
     *
     * @return float
     */
    private function _getTime() : float
    {
        return microtime(true);
    }

    /**
     * Verify if the passed unit is supported
     *
     * @param int $unit
     * @return void
     */
    private function _verifyUnit(int $unit) : void
    {
        switch($unit)
        {
            case self::S:
            case self::MS:
            case self::µS:
                break;
            default:
                throw new Exception('Invalid unit specified');
        }
    }
}
