<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/14/2019
 * Time: 4:10 PM
 */
require 'lib/game.inc.php';
$view = new Game\StartView($game);
?>

<!doctype html>
<html>
<head>
    <meta charset ="utf-8">
    <title>Instructions</title>
    <link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div class="instructions">
    <h1>How to Play</h1>
    <p>Who Murdered My Grade is a two to six player game. There are six suspects, all professors at MSU. You have six weapons such as written assignments and final exams.
        There are nine locations on the game board. Each player assumes the role of one of the suspects.
        The objective of the game is to guess who murdered your grade. This is done by moving around the board and entering rooms.
        When you enter a location, you can try to guess who murdered your grade: some
        suspect and weapon at that location. The system will indicate if one of your guesses is incorrect.
        By doing this you can narrow down who committed the crime and make an accusation. You win by guessing all three correctly.</p>
    <h2>Team Name: Holmes</h2>
    <ul>
        <li>Nicholas Cowles</li>
        <li>Andrew Ferguson</li>
        <li>Kingston Tran</li>
        <li>Kevin Wilson</li>
        <li>Jacob Wisniewski</li>
    </ul>
    <a href="index.php">Start Game</a>
</div>
</body>
</html>