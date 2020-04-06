<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/21/2019
 * Time: 2:46 PM
 */
use Game\Game as Game;
use Game\CardsController as Controller;
use Game\Player as Player;

class CardsControllerTest extends \PHPUnit\Framework\TestCase{
    /** Test for the controller, creates game objects and tests if the next button is working */
    public function test_next(){
        // Test with 2 players
        $game = new Game();
        $owenPlayer = new Player('Owen', 'owen'."-piece.png");
        $dayPlayer = new Player('Day', 'day'."-piece.png");
        $mccullenPlayer = new Player('Mccullen', 'mccullen'."-piece.png");
        $plumPlayer = new Player('Plum', 'plum'."-piece.png");
        $onsayPlayer = new Player('Onsay', 'onsay'."-piece.png");
        $enbodyPlayer = new Player('Enbody', 'enbody'."-piece.png");
        $array1 = array();
        $array2 = array();
        array_push($array1, $owenPlayer);
        array_push($array1, $dayPlayer);

        array_push($array2, $owenPlayer);
        array_push($array2, $dayPlayer);
        array_push($array2, $mccullenPlayer);
        array_push($array2, $plumPlayer);
        array_push($array2, $onsayPlayer);
        array_push($array2, $enbodyPlayer);

        $game->setPlayers($array1);
        $controller = new Controller($game,array());
        $this->assertFalse($controller->isDone());
        $controller = new Controller($game,array('next' => 'Next'));
        $this->assertFalse($controller->isDone());
        $controller = new Controller($game,array('next' => 'Next'));
        $this->assertTrue($controller->isDone());

        // Test with 6 players
        $game = new Game();
        $game->setPlayers($array2);
        $controller = new Controller($game,array());
        $this->assertFalse($controller->isDone());
        $controller = new Controller($game,array('next' => 'Next'));
        $this->assertFalse($controller->isDone());
        $controller = new Controller($game,array('next' => 'Next'));
        $this->assertFalse($controller->isDone());
        $controller = new Controller($game,array('next' => 'Next'));
        $this->assertFalse($controller->isDone());
        $controller = new Controller($game,array('next' => 'Next'));
        $this->assertFalse($controller->isDone());
        $controller = new Controller($game,array('next' => 'Next'));
        $this->assertFalse($controller->isDone());
        $controller = new Controller($game,array('next' => 'Next'));
        $this->assertTrue($controller->isDone());
    }
}
