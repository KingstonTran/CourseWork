<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2/23/2019
 * Time: 7:00 PM
 */

use Game\Game as Game;
use Game\Node as Node;
use Game\Board as Board;

class NodeTest extends \PHPUnit\Framework\TestCase{
    public function testNeighbors(){
        $node1 = new Node("1,1",null);
        $node2 = new Node("2,2",[$node1]);

        $this->assertTrue(in_array($node1,$node2->getNeighbors()));
        $node1->addTo($node2);
        $this->assertTrue(in_array($node2,$node1->getNeighbors()));

        $R0Node = new Node("0",null, count(Game::PLAYERS),true);

    }

    public function testContains(){
        $R0Node = new Node("0",null, count(Game::PLAYERS),true);
        $this->assertTrue(count($R0Node->getContains())<$R0Node->getCapacity());

    }

    public function testSearchReachable(){
        $board = new Board();
        $node1 = $board->getNodeIndex(9);
        $node2 = $board->getNodeIndex(33);
        $node1->searchReachableStart(1);
        $this->assertTrue($node2->isReachable());
        $this->assertTrue($node1->isReachable());

        $board->resetReachables();
        $node1->searchReachableStart(2);
        $this->assertFalse($node2->isReachable());

        $board->resetReachables();
        $node2->searchReachableStart(1);
        $this->assertFalse($node1->isReachable());

        $board->resetReachables();
        $node3 = $board->getNodeIndex(174);
        $node4 = $board->getNodeIndex(148);
        $node5 = $board->getNodeIndex(99);
        $node3->searchReachableStart(2);
        $this->assertFalse($node4->isReachable());
        $this->assertFalse($node5->isReachable());

        $board->resetReachables();
        $node3->searchReachableStart(3);
        $this->assertTrue($node4->isReachable());
        $this->assertTrue($node5->isReachable());

        $board->resetReachables();
        $node3->searchReachableStart(5);
        $this->assertTrue($node4->isReachable());
        $this->assertTrue($node5->isReachable());
    }


}