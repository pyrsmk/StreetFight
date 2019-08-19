<?php

declare(strict_types=1);

namespace StreetFight\Round;

use StreetFight\Challenger\ChallengerListInterface;
use StreetFight\Hook\HookInterface;
use StreetFight\Hook\NullHook;
use StreetFight\Result\ResultListInterface;
use StreetFight\Result\ResultList;
use StreetFight\Result\Result;
use function Funktions\loop;

/**
 * Run the round
 */
final class Round implements RoundInterface
{
    /**
     * Challenger list
     *
     * @var ChallengerListInterface
     */
    private $challengerList;

    /**
     * BEFORE hook
     *
     * @var HookInterface
     */
    private $beforeHook;

    /**
     * AFTER hook
     *
     * @var HookInterface
     */
    private $afterHook;

    /**
     * Constructor
     *
     * @param ChallengerListInterface $challengerList
     * @param HookInterface|null $beforeHook
     * @param HookInterface|null $afterHook
     */
    public function __construct(
        ChallengerListInterface $challengerList,
        ?HookInterface $beforeHook = null,
        ?HookInterface $afterHook = null
    )
    {
        $this->challengerList = $challengerList;
        $this->beforeHook = $beforeHook ?? new NullHook();
        $this->afterHook = $afterHook ?? new NullHook();
    }

    /**
     * Run the round
     *
     * @return ResultListInterface
     */
    public function fight(): ResultListInterface
    {
        return new ResultList(
            ...loop($this->challengerList->items(), function ($challenger) {
                $this->beforeHook->run();
                yield $challenger->kick();
                $this->afterHook->run();
            })
        );
    }
}
