<?php

require __DIR__ . '/lib/game.inc.php';

$controller = new Game\GameController($game, $_POST);
if ($controller->isReset()) {
    header("location: index.php");
} else if (!$controller->isDone()) {
    header("location: game.php");
}
exit;