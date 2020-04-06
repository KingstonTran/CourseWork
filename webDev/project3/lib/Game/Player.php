<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2/19/2019
 * Time: 6:23 PM
 */

namespace Game;


class Player{
    /**
     * @param string $name
     * @param Node $startNode
     */
    public function __construct($name, $image, $startNode=null) {
        $this->name = $name;
        $this->icon = $image;
        if($startNode===null){
            $this->location = null;
        }
        else{
            $this->setLoc($startNode);
        }

    }

    public function getName(){
        return $this->name;
    }

    public function getHand(){
        return $this->hand;
    }

    public function getOtherCards() {
        return $this->otherCards;
    }

    public function setOtherCards($cards) {
        $this->otherCards = $cards;
    }


    /**
     * Used for general game movement
     *
     * @returm Node $this->location
     */
    public function getLoc(){
        return $this->location;
    }

    public function getRealPos(){
        if ($this->getLoc()->roomCheck()){
            $rm_player = array_search($this, $this->getLoc()->getContains());
            return $this->shiftRoomPos($rm_player);
        }
        return $this->getLoc()->getPos();
    }

    public function shiftRoomPos($room_ind){
        $room_ind = $room_ind%count(Game::PLAYERS);
        $index = $this->getLoc()->getPosIndex();
        if($room_ind==1){
            $index -= GameView::COLUMNS;
        }
        else if($room_ind==2){
            $index -= 1;
        }
        else if($room_ind==3){
            $index += GameView::COLUMNS;
        }
        else if($room_ind==4){
            $index += 1;
        }
        else if($room_ind==5){
            $index -= 2;
        }

        $row = (int)($index/GameView::COLUMNS);
        $column = $index%GameView::COLUMNS;
        return "$row,$column";
    }

    public function addToHand($card){
        $this->hand[] = $card;
    }

    public function addToOtherCards($card) {
        $this->otherCards[] = $card;
    }


    /**
     * Used for general game movement
     *
     * @param Node $node
     */
    public function moveTo($node){
        if ($node->isReachable()){
            if ($this->location !== null){
                $this->location->leftBy($this);
            }
            $node->movedIntoBy($this);
            $this->location = $node;
        }

    }

    /**
     * bypasses check for reachability, use for initializing player locations or summoning
     * do no use for normal game movement
     *
     * @param Node $node
     */
    public function setLoc($node){
        if ($this->location !== null){
            $this->location->leftBy($this);
        }
        $node->movedIntoBy($this);
        $this->location = $node;
    }

    public function setActualLoc($node) {
        $this->actualLocation = $node;
    }

    public function getActualLoc() {
        return $this->actualLocation;
    }

    public function setCodes($codes) {
//        $this->codes = $codes;
        $i = 0;
        foreach ($this->otherCards as $card) {
            $card->setCode($codes[$i]);
            $this->codes[$card->getName()] = $codes[$i++];
        }
    }

    public function getCodes() {
        return $this->codes;
    }

    public function hasMoved(){
        return $this->moved;
    }

    public function setMoved($bool){
        $this->moved = $bool;
    }

    /**
     * @param bool $failed
     */
    public function setFailed($failed)
    {
        $this->failed = $failed;
    }

    public function hasFailed(){
        return $this->failed;
    }

    /**
     * @param bool $summoned
     */
    public function setSummoned($summoned)
    {
        $this->summoned = $summoned;
    }

    public function wasSummoned(){
        return $this->summoned;
    }




    private $name;
    private $icon;
    private $hand = [];
    private $otherCards = [];
    private $codes = [];
    private $location;
    private $moved = false;
    private $summoned = false;
    private $failed = false;
    private $actualLocation;


}
