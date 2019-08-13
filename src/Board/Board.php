<?php

declare(strict_types=1);

namespace StreetFight\Board;

use Generator;
use StreetFight\Challenger\ChallengerInterface;
use function Funktions\array_to_generator;

/**
 * Board
 */
final class Board implements BoardInterface
{
    /**
     * Round boards
     *
     * @var RoundBoardInterface[]
     */
    private $boards;

    /**
     * Constructor
     *
     * @param RoundBoardInterface[] $boards
     */
    public function __construct(RoundBoardInterface ...$boards = [])
    {
        $this->boards = $boards;
    }

    /**
     * Merge additional round boards to a new match board
     *
     * @param RoundBoardInterface[] $boards
     * @return self
     */
    public function with(RoundBoardInterface ...$boards): self
    {
        return new self(
            ...$this->boards,
            ...$boards
        );
    }

    /**
     * Get the round boards
     *
     * @return Generator
     */
    public function boards(): Generator
    {
        yield from array_to_generator($this->boards);
    }

    /**
     * Filter results by challenger
     *
     * @param ChallengerInterface $challenger
     * @return Generator
     */
    public function filter(ChallengerInterface $challenger): Generator
    {
        foreach ($this->boards as $board) {
            foreach ($board->results() as $result) {
                if ($result->challenger() === $challenger) {
                    yield $result;
                }
            }
        }
    }
}
