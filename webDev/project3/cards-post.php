<?php
/**
 * Created by PhpStorm.
 * User: kevinwilson
 * Date: 2019-02-18
 * Time: 18:54
 */

require __DIR__ . '/lib/game.inc.php';
$controller = new Game\CardsController($game, $_POST);
if ($controller->isDone()){
    header("location: game.php");
}
else{
    header("location: cards.php");
}
exit;