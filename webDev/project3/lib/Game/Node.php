<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2/22/2019
 * Time: 3:49 PM
 */

namespace Game;


class Node{
    /**
     * @param array $neighbors
     * */
    public function __construct($pos, $neighbors, $capacity = 1, $room = false, $blocked = false, $type='tile') {
        $this->pos = $pos;
        $this->neighbors = $neighbors;
        $this->blocked = $blocked;
        $this->type=$type;
        $this->capacity = $capacity;
        $this->isRoom = $room;
    }


    /**
     * Add a neighboring node
     * @param Node $to Node we can step into
     */
    public function addTo($to) {
        $this->neighbors[] = $to;
    }


    /**
     * @return string
     */
    public function getPos()
    {
        return $this->pos;
    }

    public function getPosIndex(){
//        if($this->roomCheck()){
//            return $this->pos;
//        }
        $split = explode(',',$this->pos);
        return $split[0]*GameView::COLUMNS+$split[1];
    }

    /**
     * @param string $pos
     */
    public function setPos($pos)
    {
        $this->pos = $pos;
    }

    /**
     * @return array
     */
    public function getNeighbors()
    {
        return $this->neighbors;
    }

    public function getNeighborIndices(){
        $neighborInds = [];
        for($i=0;$i<count($this->getNeighbors());$i++){
            $neighborInds[] = $this->neighbors[$i]->getPosIndex();
        }
        return $neighborInds;
    }

    /**
     * @param array $neighbors
     */
    public function setNeighbors($neighbors)
    {
        $this->neighbors = $neighbors;
    }

    /**
     * @return array of Player
     */
    public function getContains()
    {
        return $this->contains;
    }

    /**
     * @return int
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param Player $player
     */
    public function leftBy($player){
        $rm_player = array_search($player, $this->contains);
        unset($this->contains[$rm_player]);
        if(count($this->contains)<$this->capacity){
            $this->blocked = false;
        }
    }

    /**
     * @param Player $player
     */
    public function movedIntoBy($player){
        if (!$this->isBlocked()){
            $this->contains[] = $player;
            if(count($this->contains)>=$this->capacity){
                $this->blocked = true;
            }
        }


    }

    public function roomCheck(){
        return $this->isRoom;
    }

    /**
     * @return bool
     */
    public function isBlocked()
    {
        return $this->blocked;
    }

    /**
     * @return bool
     */
    public function isOnPath()
    {
        return $this->onPath;
    }

    /**
     * @param bool $onPath
     */
    public function setOnPath($onPath)
    {
        $this->onPath = $onPath;
    }

    /**
     * @param bool $reachable
     */
    public function setReachable($reachable)
    {
        $this->reachable = $reachable;
    }
    /**
     * @return bool
     */
    public function isReachable()
    {
        return $this->reachable;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    public function searchReachableStart($distance) {
        // The path is done if it at the end of the distance
        $this->reachable = true;
        if ($this->roomCheck()){
            foreach($this->neighbors as $to) {
//            echo $to->getPosIndex().' from '.$this->getPosIndex().'<br>';
                if(!$to->blocked && !$to->onPath) {
                    $to->searchReachable($distance-1);
                }
            }
        }
        else{
            $this->searchReachable($distance);
        }
    }

    public function searchReachable($distance) {
        // The path is done if it at the end of the distance

        if($distance === 0 ) {
            $this->reachable = true;
            return;
        }

        $this->onPath = true;

        if ($this->roomCheck()){
            $this->reachable = true;
        }
        else{
            foreach($this->neighbors as $to) {
//            echo $to->getPosIndex().' from '.$this->getPosIndex().'<br>';
                if(!$to->blocked && !$to->onPath) {
                    $to->searchReachable($distance-1);
                }
            }
        }


        $this->onPath = false;
    }


    private $pos;  // string pair row-column coordinates
    private $contains = [];
    private $capacity;
    private $neighbors = [];
    private $isRoom = false;
    private $type; //string either 'tile' or room number R0-R8, M

    // Used for path finding algorithm
    // This node is blocked and cannot be visited
    private $blocked = false;
    // This node is on a current path
    private $onPath = false;
    // Node is reachable in the current move
    private $reachable = false;
    // tells if a player can safely move into room
    private $roomSafe = false;
}