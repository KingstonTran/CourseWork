<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2/23/2019
 * Time: 8:57 PM
 */


use Game\Game as Game;
use Game\Node as Node;
use Game\Board as Board;
use Game\Player as Player;
class PlayerTest extends \PHPUnit\Framework\TestCase{
    public function testMoveTo(){
        $board = new Board();
        $player1 = new Player('Enbody', 'enbody'."-piece.png");
        $startNode1 = $board->getNodeCoords(24, 7);
        $player1->moveTo($startNode1);

        $startNode2 = $board->getNodeCoords(0, 14);
        $player2 = new Player('Owen', 'owen'."-piece.png", $startNode2);

        $this->assertFalse(in_array($player1,$startNode1->getContains()));
        $this->assertTrue(in_array($player2,$startNode2->getContains()));
        $this->assertTrue($startNode2->isBlocked());
        $player1->setLoc($startNode1);
        $this->assertTrue(in_array($player1,$startNode1->getContains()));

        $player1->getLoc()->searchReachableStart(12);
        $room6 = $board->getNodeIndex(507);
        $player1->moveTo($room6);
        $this->assertTrue(in_array($player1,$room6->getContains()));
        $this->assertFalse(in_array($player1,$startNode1->getContains()));
        $this->assertFalse($startNode1->isBlocked());
        $board->resetReachables();

        $startNode3 = $board->getNodeCoords(7, 23);
        $player3 = new Player('Day', 'day'."-piece.png", $startNode3);
        $player3->getLoc()->searchReachableStart(12);
        $room2 = $board->getNodeIndex(92);
        $player3->moveTo($room2);
        $this->assertFalse(in_array($player3,$startNode3->getContains()));
        $this->assertFalse($startNode3->isBlocked());
        $this->assertTrue(in_array($player3,$room2->getContains()));
        $board->resetReachables();

//        echo '<br>Search from R2<br>';
        $player3->getLoc()->searchReachableStart(12);
//        echo '<br>Neighbors of R2 [';
//        foreach($room2->getNeighborIndices() as $result){
//            echo $result.', ';
//        }
//        echo ']<br>';
//        echo '<br>Neighbors of player3 [';
//        foreach($player3->getLoc()->getNeighborIndices() as $result){
//            echo $result.', ';
//        }
//        echo ']<br>';
//        $reachables = $board->getReachableIndices();
//
//        echo '<br>Reachables [';
//        foreach($reachables as $result){
//            echo $result.', ';
//        }
//        echo ']<br>';


        $this->assertSame($room2->getNeighbors()[1], $room6);
        $this->assertTrue($room6->isReachable());
        $this->assertSame($board->getNodeCoordsStr("3,21"),$board->getNodeCoords(3,21));
        $this->assertContains($board->getNodeCoordsStr("21,3")->getPosIndex(), $player3->getLoc()->getNeighborIndices());
        $this->assertContains($board->getNodeCoordsStr("21,3")->getPosIndex(), $board->getReachableIndices());
        $this->assertEquals($player3->getRealPos(), "3,21");
        $this->assertEquals($player1->getRealPos(), "21,3");
//        echo '<br>Room 2 contains: [';
//        foreach($room2->getContains() as $result){
//            $rm_player = array_search($result, $room2->getContains());
//            echo '('.$result->getName().', '.$rm_player.'), ';
//        }
//        echo ']<br>';
//        echo '<br>Room 6 contains: [';
//        foreach($room6->getContains() as $result){
//            $rm_player = array_search($result, $room6->getContains());
//            echo '('.$result->getName().', '.$rm_player.'), ';
//        }
//        echo ']<br>';
        $player3->moveTo($room6);

        $this->assertEquals($player3->getRealPos(), "20,3");
        $this->assertEquals($player1->getRealPos(), "21,3");
        $this->assertTrue(in_array($player1,$room6->getContains()));
        $this->assertTrue(in_array($player3,$room6->getContains()));
        $this->assertFalse(in_array($player3,$room2->getContains()));
        $this->assertEquals($player3->getLoc()->getPosIndex(), 507);
        $this->assertEquals($player3->getLoc()->getType(), "R6");

//        $node3->searchReachableStart(5);
    }
}