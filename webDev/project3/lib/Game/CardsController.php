<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/15/2019
 * Time: 1:06 PM
 */

namespace Game;


class CardsController
{
    public function __construct(Game $game, $post)
    {
        $this->game = $game;
        if (isset($post['next'])) {
            $game->nextStart();
        }
    }

    public function isDone() {
        if ($this->game->getCurrent() == count($this->game->getPlayers())) {
            // Set the current turn to the first player so that the game starts at player 1
            $this->game->resetCurrent();
            return true;
        }
        return false;
    }

    private $game;
}