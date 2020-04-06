<?php
/**
 * Created by PhpStorm.
 * User: kevinwilson
 * Date: 2019-02-15
 * Time: 13:25
 */

namespace Game;


class StartController
{
    public function __construct(Game $game, $post)
    {
        $this->game = $game;

        $players = array();
        $playerNames = array();
        foreach ($game::PLAYERS as $player => $capPlayer) {
            if (isset($post[$player])) {
                $newPlayer = new Player($capPlayer, $player."-piece.png");
                array_push($players, $newPlayer);
                array_push($playerNames, $player);
            }
        }
        $this->game->setPlayers($players);
        $this->game->setPlayerNames($playerNames);
    }

    public function isDone()
    {
        if (Game::PLAYER_MIN <= count($this->game->getPlayers())) {
            return true;
        }
        return false;
    }

    private $game;
}
