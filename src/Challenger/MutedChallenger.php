<?php

namespace StreetFight;

/**
 * Run a challenger but mute the output
 */
class MutedChallenger implements ChallengerInterface
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
        ob_start();
        $time = $this->challenger->kick();
        ob_end_clean();
        return $time;
    }
}
