<?php

namespace StreetFight;

class Challenger implements ChallengerInterface
{

    /**
     * The callable
     *
     * @var callable
     */
    protected $callable;

    /**
     * Constructor
     *
     * @param string $name
     * @param callable $callable
     * @return void
     */
    public function __construct(callable $callable)
    {
        ob_start();
        $this->callable = $callable;
        ob_end_clean();
    }

    /**
     * Kick!
     *
     * @return void
     */
    public function kick() : void
    {
        call_user_func($this->callable);
    }
}
