<?php
/**
 * Created by PhpStorm.
 * User: kevinwilson
 * Date: 2019-02-22
 * Time: 10:16
 */

use Game\Game as Game;
use Game\StartView as View;

class StartViewTest extends \PHPUnit\Framework\TestCase {
    public function test_presentStartPage() {
        $game = new Game;
        $view = new View($game);

        $check = <<<HTML
<form id="select-players" action="start-post.php" method="post">
<p><a id=gameinstructions href="instructions.php">Instructions</a></p>
    <p><input type="checkbox" name="owen" id="owen"><label for="owen">Prof. Owen</label></p>
    <p><input type="checkbox" name="mccullen" id="mccullen"><label for="mccullen">Prof. McCullen</label></p>
    <p><input type="checkbox" name="onsay" id="onsay"><label for="onsay">Prof. Onsay</label></p>
    <p><input type="checkbox" name="enbody" id="enbody"><label for="enbody">Prof. Enbody</label></p>
    <p><input type="checkbox" name="plum" id="plum"><label for="plum">Prof. Plum</label></p>
    <p><input type="checkbox" name="day" id="day"><label for="day">Prof. Day</label></p>
    <p id="instructions">Select at least 2 players to play the game.</p>
    <p><input type="submit" name="sub" id="sub"></p>
</form>
HTML;

        $this->assertContains($check, $view->present());
    }
}