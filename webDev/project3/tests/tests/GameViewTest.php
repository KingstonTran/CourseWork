<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/21/2019
 * Time: 4:00 PM
 */

use Game\Game as Game;
use Game\GameView as GameView;
use Game\Player as Player;

class GameViewTest extends \PHPUnit\Framework\TestCase{
    /** Tests if the grid is being outputted correctly */
    public function test_grid(){
        $game = new Game();
        $view = new GameView($game);
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
        $this->assertEquals(GameView::COLUMNS,24);
        $this->assertEquals(GameView::ROWS,25);
    }
    public function test_playerLocation(){

        $game = new Game();
        $view = new GameView($game);
        $players = array();
        $newPlayer = new Player("Owen", "owen-piece.png");
        array_push($players, $newPlayer);
        $newPlayer = new Player("Day", "day-piece.png");
        array_push($players, $newPlayer);
        $game->setPlayers($players);
        $this->assertContains('<div class="game">',$view->presentGrid());
        $this->assertContains("<img src='images/day-piece.png' alt='day' width='37' height='37'>", $view->playerStart('day'));
        $this->assertNotContains("<img src='images/mccullen-piece.png' alt='mccullen' width='37' height='37'>", $view->playerStart('mcculen'));
        $this->assertContains("<img src='images/day-piece.png' alt='day' width='37' height='37'>", $view->presentGrid());
        $this->assertContains("<img src='images/owen-piece.png' alt='owen' width='37' height='37'>", $view->presentGrid());
        $this->assertNotContains("<img src='images/onsay-piece.png' alt='onsay' width='37' height='37'>", $view->presentGrid());
        $this->assertNotContains("<img src='images/onsay-piece.png' alt='owen' width='37' height='37'>", $view->presentGrid());
    }

}
