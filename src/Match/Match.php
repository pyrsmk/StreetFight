<?php

declare(strict_types=1);

namespace StreetFight\Match;

use StreetFight\Challenger\ChallengerListInterface;
use StreetFight\Hook\HookInterface;
use StreetFight\Board\BoardInterface;
use StreetFight\Board\Board;
use function Funktions\above;

/**
 * A street fight match
 */
final class Match implements MatchInterface
{
    /**
     * The number of rounds
     *
     * @var integer
     */
    private $rounds;

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
     * @param int $rounds
     * @param ChallengerListInterface $challengerList
     * @param HookInterface $beforeHook
     * @param HookInterface $afterHook
     */
    public function __construct(
        int $rounds,
        ChallengerListInterface $challengerList,
        HookInterface $beforeHook,
        HookInterface $afterHook
    )
    {
        $this->rounds = above($rounds, 1);
        $this->challengerList = $challengerList;
        $this->beforeHook = $beforeHook;
        $this->afterHook = $afterHook;
    }

    /**
     * Run the match
     *
     * @return BoardInterface
     */
    public function fight(): BoardInterface
    {
        $board = new Board();
        foreach (range(1, $this->rounds) as $i) {
            $round = new Round(
                $this->challengerList,
                $this->beforeHook,
                $this->afterHook
            );
            $board = $board->with(
                $round->fight()
            );
        }
        return $board;
    }
}
