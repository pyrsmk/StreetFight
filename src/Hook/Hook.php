<?php

declare(strict_types=1);

namespace StreetFight\Hook;

/**
 * A hook
 */
final class Hook implements HookInterface
{
    /**
     * The callable
     *
     * @var callable
     */
    private $callable;

    /**
     * Constructor
     *
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * Run the callback
     *
     * @return void
     */
    public function run(): void
    {
        call_user_func($this->callable);
    }
}
