<?php

declare(strict_types=1);

namespace StreetFight\Hook;

/**
 * Hook interface
 */
interface HookInterface
{
    /**
     * Run the callback
     *
     * @return void
     */
    public function run(): void;
}
