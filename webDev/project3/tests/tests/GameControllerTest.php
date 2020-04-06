<?php
/**
 * Created by PhpStorm.
 * User: Kingston Tran
 * Date: 2/28/2019
 * Time: 11:29 PM
 */

use Game\Game as Game;
use Game\GameController as GameController;
use Game\Player as Player;
use Game\Cards as Cards;

class GameControllerTest extends \PHPUnit\Framework\TestCase{

    public function test_pass(){
        $game = new Game();
        $players = array();
        $newPlayer1 = new Player("Owen", "owen-piece.png");
        array_push($players, $newPlayer1);
        $newPlayer = new Player("Day", "day-piece.png");
        array_push($players, $newPlayer);
        $game->setPlayers($players);
        $this->assertEquals($newPlayer1,$game->getCurrentPlayer());
        $controller = new GameController($game,array('actChoice'=> "pass"));
        $this->assertEquals($newPlayer,$game->getCurrentPlayer());
        $controller = new GameController($game,array('actChoice'=> "pass"));
        $this->assertEquals($newPlayer1,$game->getCurrentPlayer());
    }

    public function test_move(){
        $game = new Game();
        $players = array();
        $newPlayer1 = new Player("Owen", "owen-piece.png" );
        array_push($players, $newPlayer1);
        $newPlayer = new Player("Day", "day-piece.png");
        array_push($players, $newPlayer);
        $game->setPlayers($players);
//        $game->getCurrentPlayer()->getLoc()->searchReachableStart(12);
        $controller = new GameController($game,array('actChoice'=> "pass"));
        $this->assertSame($game->getBoard()->getNodeCoordsStr("8,10"),$game->getBoard()->getNodeCoords(8,10));
        $game->getCurrentPlayer()->getLoc()->searchReachableStart(12);
        $this->assertContains($game->getBoard()->getNodeCoordsStr("7,21")->getPosIndex(), $game->getBoard()->getReachableIndices());
        $controller = new GameController($game,array('cell'=> "7,21"));
        $this->assertSame($game->getBoard()->getNodeCoordsStr("7,21"),$newPlayer->getLoc());
        $this->assertNotContains($game->getBoard()->getNodeCoordsStr("7,21")->getPosIndex(), $game->getBoard()->getReachableIndices());

    }

    public function test_play(){
        $game = new Game();
        $players = array();
        $newPlayer1 = new Player("Owen", "owen-piece.png" );
        array_push($players, $newPlayer1);
        $newPlayer = new Player("Day", "day-piece.png");
        array_push($players, $newPlayer);
        $game->setPlayers($players);
        $cards = new Cards($game);
        $game->getCurrentPlayer()->getLoc()->searchReachableStart(12);
        $controller = new GameController($game,array('cell'=> "3,21"));
        $controller = new GameController($game,array('actChoice'=> "suggest"));
        $this->assertTrue($game->isSuggest());
        $this->assertTrue($game->isWho());
        $controller = new GameController($game,array('whodiddit'=> "mccullen"));
        $this->assertFalse($game->isWho());
        $this->assertTrue($game->isWhat());
        $this->assertTrue($game->getTemp()->wasSummoned());
        $this->assertTrue($game->getTemp()->getName()=="McCullen");
        $controller = new GameController($game,array('whatdiddit'=> "final"));
        $this->assertFalse($game->isWhat());
        $this->assertTrue($game->isResult());
        $this->assertEquals($game->getWhatguess(),'Final Exam');

        $game->getCurrentPlayer()->getLoc()->searchReachableStart(12);
        $controller = new GameController($game,array('cell'=> $game->getBoard()->toCoords(404)));
        $controller = new GameController($game,array('actChoice'=> "suggest"));
        $controller = new GameController($game,array('whodiddit'=> "enbody"));
        $controller = new GameController($game,array('whatdiddit'=> "programming"));

        $game->getCurrentPlayer()->getLoc()->searchReachableStart(12);
        $controller = new GameController($game,array('cell'=> $game->getBoard()->toCoords(548)));
        $controller = new GameController($game,array('whodiddit'=> "plum"));
        $controller = new GameController($game,array('whatdiddit'=> "project"));

        $game->getCurrentPlayer()->getLoc()->searchReachableStart(12);
        $controller = new GameController($game,array('cell'=> $game->getBoard()->toCoords(507)));
        $controller = new GameController($game,array('whodiddit'=> "day"));
        $controller = new GameController($game,array('whatdiddit'=> "written"));

        $game->getCurrentPlayer()->getLoc()->searchReachableStart(12);
        $controller = new GameController($game,array('cell'=> $game->getBoard()->toCoords(507)));
        $controller = new GameController($game,array('whodiddit'=> "day"));
        $controller = new GameController($game,array('whatdiddit'=> "quiz"));

        $game->getCurrentPlayer()->getLoc()->searchReachableStart(12);
        $controller = new GameController($game,array('cell'=> $game->getBoard()->toCoords(291)));
        $controller = new GameController($game,array('whodiddit'=> "day"));
        $controller = new GameController($game,array('whatdiddit'=> "written"));

        $game->getCurrentPlayer()->getLoc()->searchReachableStart(12);
        $controller = new GameController($game,array('cell'=> $game->getBoard()->toCoords(74)));
        $controller = new GameController($game,array('whodiddit'=> "day"));
        $controller = new GameController($game,array('whatdiddit'=> "quiz"));
        $controller = new GameController($game,array('actChoice'=> "pass"));

        $game->getCurrentPlayer()->getLoc()->searchReachableStart(12);
        $controller = new GameController($game,array('cell'=> $game->getBoard()->toCoords(260)));
        $controller = new GameController($game,array('actChoice'=> "accuse"));
        $controller = new GameController($game,array('whodiddit'=> "owen"));
        $controller = new GameController($game,array('whatdiddit'=> "programming"));
        $this->assertTrue($game->getCurrentPlayer()->hasFailed());

        $controller = new GameController($game,array('actChoice'=> "pass"));
        $this->assertFalse($game->getCurrentPlayer()->hasFailed());

        $game->getCurrentPlayer()->getLoc()->searchReachableStart(12);
        $controller = new GameController($game,array('cell'=> $game->getBoard()->toCoords(107)));
        $controller = new GameController($game,array('actChoice'=> "accuse"));
        $controller = new GameController($game,array('whodiddit'=> "onsay"));
        $controller = new GameController($game,array('whatdiddit'=> "midterm"));
        $this->assertTrue($game->getCurrentPlayer()->hasFailed());
        $this->assertTrue($game->allFailed());

    }
    public function test_reset(){
        $game = new Game();
        $players = array();
        $newPlayer1 = new Player("Owen", "owen-piece.png" );
        array_push($players, $newPlayer1);
        $newPlayer = new Player("Day", "day-piece.png");
        array_push($players, $newPlayer);
        $game->setPlayers($players);
        $game->getCurrentPlayer()->getLoc()->searchReachableStart(12);
        $controller = new GameController($game,array('reset'=> "reset"));

        $this->assertTrue($game->getPlayers()==array());
        $this->assertTrue($game->getMurder()==array());
        $this->assertTrue($game->getCurrent()==0);
        $this->assertFalse($game->isAccuse());
        $this->assertFalse($game->isSuggest());
        $this->assertFalse($game->isWhat());
        $this->assertFalse($game->isWho());
        $this->assertFalse($game->isCode());
        $this->assertFalse($game->isResult());
        $this->assertTrue($game->getDiceImage(1)=='images/dice1.png');
        $this->assertTrue($game->getTemp()==null);
        $this->assertTrue($game->getDiceRolled()==7);
        $this->assertTrue($game->getDiceOne()==1);
        $this->assertTrue($game->getDiceTwo()==6);
    }
};