<?php
/**
 * Created by PhpStorm.
 * User: Kingston Tran
 * Date: 4/27/2019
 * Time: 11:14 AM
 */

namespace SuperLights;


class SuperLights
{
    public function __construct() {
        // Puzzle location values
        // -1 Empty
        // 0-4 Shaded and numbers
        // 5 Shaded only (no number)
        $this->root = "/~tranking/exam";

        // Puzzle solution
        // 11,0-5 = no light
        // 10 = light
        $solution = [
            [11, 10, 11, 11, 0, 11, 0],
            [0, 11, 10, 11, 11, 11, 11],
            [11, 5, 11, 10, 2, 10, 11],
            [10, 11, 11, 11, 11, 5, 10],
            [11, 10, 2, 11, 10, 1, 11],
            [5, 11, 10, 11, 11, 11, 1],
            [10, 11, 11, 11, 5, 5, 10]
        ];
        $this->reset();
        $this->solution = $solution;

    }

    /**
     * @return string
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param mixed $playerName
     */
    public function setPlayerName($playerName)
    {
        $this->playerName = $playerName;
    }

    /**
     * @return array
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * @return array
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * @return string
     */
    public function getPlayerName()
    {
        return $this->playerName;
    }
    public function setBoard($boardArray){
        $this->board = $boardArray;
    }
    public function reset(){
        $values = [
            [-1, -1, -1, -1, 0, -1, 0],
            [0, -1, -1, -1, -1, -1, -1],
            [-1, 5, -1, -1, 2, -1, -1],
            [-1, -1, -1, -1, -1, 5, -1],
            [-1, -1, 2, -1, -1, 1, -1],
            [5, -1, -1, -1, -1, -1, 1],
            [-1, -1, -1, -1, 5, 5, -1]
        ];
        $this->setBoard($values);
    }

    /**
     * @return bool
     */
    public function isWinner()
    {
        return $this->isWinner;
    }

    /**
     * @param bool $isWinner
     */
    public function setIsWinner($isWinner)
    {
        $this->isWinner = $isWinner;
    }
    /**
     * @return bool
     */
    public function isChecking()
    {
        return $this->checking;
    }

    /**
     * @param bool $checking
     */
    public function setChecking($checking)
    {
        $this->checking = $checking;
    }

    protected $playerName;
    protected $board;
    protected $solution;
    protected $root='';
    protected $isWinner=false;
    protected $checking=false;



}