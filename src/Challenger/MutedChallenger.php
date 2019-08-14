<?php

namespace StreetFight\Challenger;

/**
 * Run a challenger but mute the output
 */
class MutedChallenger implements ChallengerInterface
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
        ob_start();
        $time = $this->challenger->kick();
        ob_end_clean();
        return $time;
    }
}
