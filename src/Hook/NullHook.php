<?php

declare(strict_types=1);

namespace StreetFight\Hook;

/**
 * NULL hook
 */
final class NullHook implements HookInterface
{
    /**
     * Run the callback
     *
     * @return void
     */
    public function run(): void
    {
    }
}
