<?php

namespace StreetFight;

/**
 * Run a challenger and clean up memory
 */
class GarbageCollectedChallenger implements ChallengerInterface
{
    /**
     * The challenger
     *
     * @var Challenger
     */
    private $challenger;

    /**
     * Constructor
     *
     * @param Challenger $challenger
     */
    public function __construct(Challenger $challenger)
    {
        $this->challenger = $challenger;
    }

    /**
     * Return the challenger's name
     *
     * @return string
     */
    public function name(): string
    {
        return $this->challenger->name();
    }

    /**
     * Run the callback and return the elapsed time
     *
     * @return float
     */
    public function kick(): float
    {
        $time = $this->challenger->kick();
        gc_collect_cycles();
        return $time;
    }
}
