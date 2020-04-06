<?php
/**
 * Created by PhpStorm.
 * User: kevinwilson
 * Date: 2019-02-18
 * Time: 18:54
 */

require __DIR__ . '/lib/game.inc.php';
$controller = new Game\StartController($game, $_POST);
if ($controller->isDone()){
    // initialize cards
    new Game\Cards($game);
    header("location: cards.php");
}
else{
    header("location: index.php");
}
exit;
