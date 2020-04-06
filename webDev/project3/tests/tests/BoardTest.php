<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2/23/2019
 * Time: 5:39 PM
 */

use Game\Game as Game;
use Game\Board as Board;
use Game\Node as Node;
use Game\Player as Player;

class BoardTest extends \PHPUnit\Framework\TestCase{
    public function testGenerateBoard(){
        $game = new Game();
        $board = $game->getBoard();
        $this->assertEquals(25,count($board->getGrid()));
        $this->assertEquals(24,count($board->getGrid()[24]));
//        $node = new \Game\Node('1000,1000',$neighbors);
        $this->assertFalse($board->getNodeIndex(462)->getNeighbors()===null);
        $this->assertEquals($board->getNodeIndex(462),$board->getNodeIndex(483));
        $this->assertSame($board->getNodeIndex(462),$board->getNodeIndex(483));
        $this->assertTrue(in_array($board->getNodeIndex(409),$board->getNodeIndex(410)->getNeighbors()));
        $this->assertTrue(in_array($board->getNodeIndex(410),$board->getNodeIndex(409)->getNeighbors()));
        $this->assertTrue(in_array($board->getNodeIndex(409),$board->getNodeIndex(408)->getNeighbors()));
        $this->assertFalse(in_array($board->getNodeIndex(408),$board->getNodeIndex(409)->getNeighbors()));

        $this->assertTrue(in_array($board->getNodeIndex(438),$board->getNodeIndex(462)->getNeighbors()));
        $this->assertTrue(in_array($board->getNodeIndex(437),$board->getNodeIndex(438)->getNeighbors()));
        $this->assertTrue(in_array($board->getNodeIndex(439),$board->getNodeIndex(438)->getNeighbors()));
        $this->assertTrue(in_array($board->getNodeIndex(414),$board->getNodeIndex(438)->getNeighbors()));

        $this->assertTrue(in_array($board->getNodeIndex(462),$board->getNodeIndex(438)->getNeighbors()));

    }

    public function testToCoords(){
        $board = new Board();

        $this->assertEquals('1,1', $board->toCoords(25));
    }

    public function testGetNodeIndex(){
        $board = new Board();
        $this->assertEquals($board->getGrid()[1][1], $board->getNodeIndex(25));

    }

}