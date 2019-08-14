<?php

namespace StreetFight\Challenger;

/**
 * Run a challenger and clean up memory
 */
class GarbageCollectedChallenger implements ChallengerInterface
{
    /**
     * The challenger
     *
     * @var ChallengerInterface
     */
    private $challenger;

    /**
     * Constructor
     *
     * @param ChallengerInterface $challenger
     */
    public function __construct(ChallengerInterface $challenger)
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
