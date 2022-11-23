<?php

namespace src;

class Board
{
    public array $board = [];
    public int $generation = 1;

    public function __construct(int $width, int $height) {
        $this->board = array_fill(0, $height, array_fill(0, $width, false));
    }

    public function setCell(int $x, int $y, bool $alive): void {
        if (isset($this->board[$y][$x])) {
            $this->board[$y][$x] = $alive;
        }
    }

    public function viewInTerminal(): void
    {
        print '---------------------' . PHP_EOL;
        foreach ($this->board as $row) {
            foreach ($row as $cell) {
                echo $cell ? ' X' : ' .';
            }
            echo PHP_EOL;
        }
        print 'Generation: ' . $this->generation . PHP_EOL;
    }

    public function getCell(int $x, int $y): bool
    {
        return $this->board[$y][$x] ?? $this->log($x, $y);
    }

    public function log(int $x, int $y): bool
    {
        return false;
    }

    public function getNeighbors(int $x, int $y) {
        $neighbors = [];
        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {
                if ($i === 0 && $j === 0) {
                    continue;
                }
                $neighbors[] = $this->getCell($x + $i, $y + $j);
            }
        }
        return $neighbors;
    }

    public function survives(int $x, int $y): bool {
        $neighbors = $this->getNeighbors($x, $y);
        $aliveNeighbors = array_filter($neighbors, static fn($neighbor) => $neighbor);
        $alive = $this->getCell($x, $y);
        if ($alive && (count($aliveNeighbors) === 2 || count($aliveNeighbors) === 3)) {
            return true;
        }
        if (!$alive && count($aliveNeighbors) === 3) {
            return true;
        }
        return false;
    }

    public function advance(): void
    {
        $this->generation++;

        $clonedBoard = $this->board;

        foreach ($this->board as $i => $row) {
            foreach ($row as $j => $cell) {
                $clonedBoard[$i][$j] = $this->survives($j, $i);
            }
        }

        $this->board = $clonedBoard;
    }
}
