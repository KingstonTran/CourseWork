<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/21/2019
 * Time: 3:41 PM
 */
use Game\Game as Game;
use Game\CardsController as Controller;
use Game\CardsView as CardsView;
use Game\Player as Player;

class CardsViewTest extends \PHPUnit\Framework\TestCase{
    /** Tests that the correct Professor names are being displayed in cards.php */
    public function test_presentCards(){
        $game = new Game();
        $owenPlayer = new Player('Owen', 'owen'."-piece.png");
        $dayPlayer = new Player('Day', 'day'."-piece.png");
        $mccullenPlayer = new Player('Mccullen', 'mccullen'."-piece.png");
        $plumPlayer = new Player('Plum', 'plum'."-piece.png");
        $onsayPlayer = new Player('Onsay', 'onsay'."-piece.png");
        $enbodyPlayer = new Player('Enbody', 'enbody'."-piece.png");
        $array1 = array();
        array_push($array1, $owenPlayer);
        array_push($array1, $dayPlayer);
        array_push($array1, $mccullenPlayer);
        array_push($array1, $plumPlayer);
        array_push($array1, $onsayPlayer);
        array_push($array1, $enbodyPlayer);

        $game->setPlayers($array1);
        $view = new CardsView($game);
        $this->assertContains('Prof. Owen',$view->presentCards());
        new Controller($game,array('next' => 'Next'));
        $this->assertContains('Prof. Day',$view->presentCards());
        new Controller($game,array('next' => 'Next'));
        $this->assertContains('Prof. Mccullen',$view->presentCards());
        new Controller($game,array('next' => 'Next'));
        $this->assertContains('Prof. Plum',$view->presentCards());
        new Controller($game,array('next' => 'Next'));
        $this->assertContains('Prof. Onsay',$view->presentCards());
        new Controller($game,array('next' => 'Next'));
        $this->assertContains('Prof. Enbody',$view->presentCards());
    }

    public function test_presentPrintCards() {
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
        $this->assertEquals($ary,$game->getPlayers());
        //$cards = new Cards($game);
    }

}
