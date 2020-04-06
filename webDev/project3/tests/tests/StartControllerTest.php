<?php
/**
 * Created by PhpStorm.
 * User: kevinwilson
 * Date: 2019-02-22
 * Time: 10:16
 */

use Game\Game as Game;
use Game\StartController as Controller;
use Game\Player as Player;

class StartControllerTest extends \PHPUnit\Framework\TestCase {
    public function test_submit() {
        $game = new Game();

        $controller = new Controller($game, array());
        $this->assertFalse($controller->isDone());

        $controller = new Controller($game, array('owen' => 'Owen'));
        $this->assertFalse($controller->isDone());

        $ary = array('owen' => 'Owen', 'enbody' => 'Enbody');
        $controller = new Controller($game, $ary);
        $this->assertTrue($controller->isDone());

        foreach ($game->getPlayers() as $player) {
            $this->assertContains($player->getName(), $ary);
        }

        $game = new Game();
        $ary = array('owen' => 'Owen', 'enbody' => 'Enbody', 'mccullen' => 'McCullen',
            'onsay' => 'Onsay', 'plum' => 'Plum', 'day' => 'Day');

        $controller = new Controller($game, $ary);
        $this->assertTrue($controller->isDone());

        foreach ($game->getPlayers() as $player) {
            $this->assertContains($player->getName(), $ary);
        }
    }
}