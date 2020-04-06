<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/14/2019
 * Time: 4:32 PM
 */

namespace Game;

class Game
{
    const PLAYER_MIN = 2; // Minimum amount of players needed to play the game
    const PLAYERS = array('owen' => 'Owen', 'mccullen' => 'McCullen',
        'onsay' => 'Onsay', 'enbody' => 'Enbody', 'plum' => 'Plum',
        'day' => 'Day');
    const CODES = array();

    public function __construct() {
        $this->buildBoard();
    }

    /**
     * Gets the image src of the dice number fro mdiceImage array.
     * @param int $num the index + 1 into array of dice images.
     * @return string img src of dice.
     */
    public function getDiceImage($num){
        return $this->diceImage[$num - 1];
    }

    /**
     * rolls dice for game and save their respective numbers for each dice.
     */
    public function rollDice(){
        $this->diceOne = rand(1,6);
        $this->diceTwo = rand(1,6);
        $this->diceTotal =  $this->diceOne + $this->diceTwo;
    }

    /**
     * returns the total dice number
     * @return int diceTotal
     */
    public function getDiceRolled(){
        return $this->diceTotal;
    }

    /**
     * returns the value of first dice
     * @return int diceOne
     */
    public function getDiceOne(){
        return $this->diceOne;
    }

    /**
     * returns the value of second dice
     * @return int diceTwo
     */
    public function getDiceTwo(){
        return $this->diceTwo;
    }

    /**
     * @return array(Player)
     */
    public function getPlayers() {
        return $this->players;
    }

    public function setPlayers($players) {
        $this->players = $players;
        foreach($players as $player){
            $this->setPlayerStarting($player);
        }
    }

    public function getPlayerNames() {
        return $this->playerNames;
    }

    public function setPlayerNames($playerNames) {
        $this->playerNames = $playerNames;
    }

    /**
     * @param Player $player
     */
    public function setPlayerStarting($player){
        //In order or "column row";
        $name = $player->getName();

        if ($name == "Owen"){
            $startNode = $this->getBoard()->getNodeCoords(0, 14);
            $player->setLoc($startNode);
        }
        else if ($name == "McCullen"){
            $startNode = $this->getBoard()->getNodeCoords(0, 9);
            $player->setLoc($startNode);
        }
        else if ($name == "Day"){
            $startNode = $this->getBoard()->getNodeCoords(7, 23);
            $player->setLoc($startNode);
        }
        else if ($name == "Onsay"){
            $startNode = $this->getBoard()->getNodeCoords(17, 0);
            $player->setLoc($startNode);
        }
        else if ($name == "Enbody"){
            $startNode = $this->getBoard()->getNodeCoords(24, 7);
            $player->setLoc($startNode);
        }
        else if ($name == "Plum"){
            $startNode = $this->getBoard()->getNodeCoords(19, 23);
            $player->setLoc($startNode);
        }
    }

    public function isEmpty() {
        return count($this->players) <= 0;
    }

    public function getCurrent() {
        return $this->current;
    }

    public function getCurrentPlayer() {
        return $this->getPlayers()[$this->getCurrent()];
    }

    public function endTurn(){
        $this->nextStart();
    }

    public function nextStart() {
        $this->setIsResult(false);
        $this->setIsCode(false);
        $this->setIsWho(false);
        $this->setIsWhat(false);
        $this->setAccuse(false);
        $this->setSuggest(false);
        $this->getCurrentPlayer()->setMoved(false);
        if (isset($this->tempPlayer)){
            $this->tempPlayer->getLoc()->leftBy($this->tempPlayer);
            unset($this->tempPlayer);
        }

        $this->current = $this->current+1%count(Game::PLAYERS);
        $this->board->resetReachables();
        $this->rollDice();


    }

    public function resetCurrent(){
        $this->current = 0;
    }

    public function setMurder($murder) {
        $this->murderCards = $murder;
    }

    public function getMurder() {
        return $this->murderCards;
    }

    /**
     * @return Board
     */
    public function getBoard()
    {
        return $this->board;
    }

    public function buildBoard()
    {
        $this->board = new Board();
    }

    /**
     * @return bool
     */
    public function isAccuse()
    {
        return $this->isAccuse;
    }

    /**
     * @param bool $isAccuse
     */
    public function setAccuse($isAccuse)
    {
        $this->isAccuse = $isAccuse;
    }

    /**
     * @return bool
     */
    public function isSuggest()
    {
        return $this->isSuggest;
    }

    /**
     * @param bool $isSuggest
     */
    public function setSuggest($isSuggest)
    {
        $this->isSuggest = $isSuggest;
    }

    /**
     * @return mixed
     */
    public function getWhoguess()
    {
        return $this->whoguess;
    }

    /**
     * @param mixed $whoguess
     */
    public function setWhoguess($whoguess)
    {
        $this->whoguess = $whoguess;
    }

    /**
     * @return mixed
     */
    public function getWhatguess()
    {
        return $this->whatguess;
    }

    /**
     * @param mixed $whatguess
     */
    public function setWhatguess($whatguess)
    {
        $this->whatguess = $whatguess;
    }

    /**
     * @return bool
     */
    public function isWho()
    {
        return $this->isWho;
    }

    /**
     * @param bool $isWho
     */
    public function setIsWho($isWho)
    {
        $this->isWho = $isWho;
    }

    /**
     * @return bool
     */
    public function isWhat()
    {
        return $this->isWhat;
    }

    /**
     * @param bool $isWhat
     */
    public function setIsWhat($isWhat)
    {
        $this->isWhat = $isWhat;
    }

    /**
     * @return bool
     */
    public function isCode()
    {
        return $this->isCode;
    }

    /**
     * @param bool $isCode
     */
    public function setIsCode($isCode)
    {
        $this->isCode = $isCode;
    }

    public function getCode(){
        return $this->keyword;
    }

    /**
     * @return bool
     */
    public function isResult()
    {
        return $this->isResult;
    }

    /**
     * @param bool $isResult
     */
    public function setIsResult($isResult)
    {
        $this->isResult = $isResult;
    }
    public function compareCards(){
        $node = $this->getCurrentPlayer()->getLoc();
        $type = $node->getType();
        $room = null;
        if($type == "R0"){
            $room = "International Center";
        }
        else if($type == "R1"){
            $room = "Breslin Center";
        }
        else if($type == "R2"){
            $room = "Beaumont Tower";
        }
        else if($type == "R3"){
            $room = "University Union";
        }
        else if($type == "R4"){
            $room = "Art Museum";
        }
        else if($type == "R5"){
            $room = "Library";
        }
        else if($type == "R6"){
            $room = "Wharton Center";
        }
        else if($type == "R7"){
            $room = "Spartan Stadium";
        }
        else if($type == "R8"){
            $room = "Engineering Building";
        }

        $murderarray = $this->getMurder();
        if ($this->isSuggest)
        {
            $currentPlayer = $this->players[$this->current];
            $cards = $currentPlayer->getOtherCards();
            foreach ($cards as $card){
                if ($room == $card->getName() or $this->whoguess == $card->getName() or $this->whatguess == $card->getName()){
                    $this->keyword = $card->getCode();
                    $this->keyword .= "!";
                }
            }
            if (empty($this->keyword)){
                $this->keyword = "I got nothing!";
            }
        }
        else {
            if ($room == $murderarray[1]->getName() and strpos($murderarray[0]->getName(), $this->whoguess) != -1
                and $this->whatguess == $murderarray[2]->getName()) {
               $this->isWinner = true;
            } else {
                $this->getCurrentPlayer()->setFailed(true);
            }
        }
    }

    public function allFailed(){
        $fail = true;
        foreach($this->players as $player){
            if (!$player->hasFailed()){
                $fail = false;
            }
        }
        return $fail;
    }

    public function resetGame(){
        $this->diceImage = array('images/dice1.png','images/dice2.png','images/dice3.png','images/dice4.png','images/dice5.png','images/dice6.png');
        $this->diceTotal = 7;
        $this->diceOne = 1;
        $this->diceTwo = 6;
        $this->players = array();
        $this->murderCards = array();
        $this->current = 0;
        $this->board = new Board();
        $this->isAccuse = false; // The is variables are for determining which screen to output
        $this->isSuggest = false;
        $this->isWho = false;
        $this->isWhat = false;
        $this->isCode = false;
        $this->isResult = false;
        $this->whoguess; // Saves the string of the who guess made to be compared to the card name
        $this->whatguess; // Saves the string of the what guess made to be compared to the card name
        $this->isWinner = false;
        unset($this->keyword);
        $this->tempPlayer = null;
    }

    public function summon() {
        $inGame = false;
        foreach ($this->players as $player) {
            if ($player->getName() == $this->getWhoguess()) {
                // move to that room (must be able to move him back)
                $player->setActualLoc($player->getLoc());
                $player->setLoc($this->getCurrentPlayer()->getLoc());
                $player->setSummoned(true);
                $inGame = true;
                break;
            }
        }
        if (!$inGame) {
            $this->tempPlayer = new Player($this->getWhoguess(), strtolower($this->getWhoguess())."-piece.png");
            $this->tempPlayer->setLoc($this->getCurrentPlayer()->getLoc());
            $this->tempPlayer->setSummoned(true);
        }
    }

    public function addPlayer($player) {
        array_push($this->players, $player);
    }

    public function setTemp($player) {
        $this->tempPlayer = $player;
    }

    public function getTemp() {
        return $this->tempPlayer;
    }

    private $diceImage = array('images/dice1.png','images/dice2.png','images/dice3.png','images/dice4.png','images/dice5.png','images/dice6.png');
    private $diceTotal = 7;
    private $diceOne = 1;
    private $diceTwo = 6;
    private $players = array();
    private $playerNames = array();
    private $murderCards = array();
    private $current = 0;
    private $board;
    private $isAccuse = false; // The is variables are for determining which screen to output
    private $isSuggest = false;
    private $isWho = false;
    private $isWhat = false;
    private $isCode = false;
    private $isResult = false;
    private $whoguess; // Saves the string of the who guess made to be compared to the card name
    private $whatguess; // Saves the string of the what guess made to be compared to the card name
    private $isWinner = false;
    private $keyword;
    private $tempPlayer = null;
}
