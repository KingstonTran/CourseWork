<?php
/**
 * Created by PhpStorm.
 * User: Kingston Tran
 * Date: 2/22/2019
 * Time: 4:13 PM
 */

use Game\Game as Game;
use Game\Cards as Cards;
use Game\Player as Player;

class CardsTest extends \PHPUnit\Framework\TestCase{

    public function testDeck(){
        $game = new Game();
        $cards = new Cards($game);
        $this->assertEquals(21,count($cards->getDeck()));
        $deck = $cards->getDeck();
        $this->assertNotEquals($deck, $cards->shuffle());
    }

    public function testDeal() {
        $game = new Game();
        $ary = array();
        $owen = new Player("Owen", "owen-piece.png");
        $ary[] = $owen;
        $day = new Player("Day", "day-piece.png");
        $ary[] = $day;
        $mccullen = new Player("McCullen", "mccullen-piece.png");
        $ary[] = $mccullen;
        $plum = new Player("Plum", "plum-piece.png");
        $ary[] = $plum;
        $onsay = new Player("Onsay", "onsay-piece.png");
        $ary[] = $onsay;
        $enbody = new Player("Enbody", "enbody-piece.png");
        $ary[] = $enbody;
        $game->setPlayers($ary);
        $cards = new Cards($game);

        $murder = $game->getMurder();
        $this->assertEquals(count($murder), 3);
        foreach ($game->getPlayers() as $player) {
            $hand = $player->getHand();
            $this->assertEquals(count($hand), 3);
        }
    }

}