<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 3/1/2019
 * Time: 9:29 PM
 */

use Game\Game as Game;
use Game\Player as Player;

class GameTest extends  \PHPUnit\Framework\TestCase
{

    public function testAddPlayer()
    {
        $game = new Game();
        $players = array();
        $newPlayer1 = new Player("Owen", "owen-piece.png" );
        array_push($players, $newPlayer1);
        $game->setPlayers($players);
        $this->assertCount(1, $game->getPlayers());
        $newPlayer = new Player("Day", "day-piece.png");
        $game->addPlayer($newPlayer);
        $this->assertCount(2, $game->getPlayers());

    }


}
