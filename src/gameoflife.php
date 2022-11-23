<?php

namespace src;

require_once __DIR__ . '/../vendor/autoload.php';

$width = 50;
$height = 10;

$board = new Board($width, $height);

$template = 'random';

switch ($template){
    case 'blinker':
        $board->setCell(3, 3, true);
        $board->setCell(3, 4, true);
        $board->setCell(3, 5, true);
        break;
    case 'spaceship':
        $board->setCell(3, 3, true);
        $board->setCell(3, 4, true);
        $board->setCell(3, 5, true);
        $board->setCell(4, 5, true);
        $board->setCell(5, 4, true);
        break;
    case 'random':
        for ($i = 0; $i < 100; $i++) {
            $board->setCell(random_int(0, $width-1), random_int(0, $height-1), true);
        }
        break;
}

while (true){
    $board->viewInTerminal();
    $board->advance();
    usleep(100000);
}
