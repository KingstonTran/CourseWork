<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 2/15/2019
 * Time: 11:38 AM
 */

namespace Game;


class GameController
{
    public function __construct(Game $game, $post){
        $this->game = $game;

        //Do something here
        if (isset($post['cell'])) {
            $cell = $post['cell'];
            $game->getCurrentPlayer()->moveTo($game->getBoard()->getNodeCoordsStr($cell));
            $game->getCurrentPlayer()->setMoved(true);
            if (!$game->getCurrentPlayer()->getLoc()->roomCheck()){
                $game->nextStart();
            }
            if ($this->game->getCurrent() == count($this->game->getPlayers())) {
                $this->game->resetCurrent();
            }
        }
        else if(isset($post['pass'])){
            $game->nextStart();
            if ($this->game->getCurrent() == count($this->game->getPlayers())) {
                $this->game->resetCurrent();
            }
        }
        else if(isset($post['actChoice']) and $post['actChoice'] == 'pass'){
            $game->nextStart();
            if ($this->game->getCurrent() == count($this->game->getPlayers())) {
                $this->game->resetCurrent();
            }
        }
        else if(isset($post['actChoice']) and $post['actChoice'] == 'suggest'){
            $this->game->setSuggest(true);
            $this->game->setIsWho(true);
        }
        else if(isset($post['actChoice']) and $post['actChoice'] == 'accuse') {
            $this->game->setAccuse(true);
            $this->game->setIsWho(true);
        }
        else if(isset($post['whodiddit']) and $post['whodiddit'] == 'owen'){
            $this->game->setWhoguess("Owen");
            $this->game->summon();
            $this->game->setIsWho(false);
            $this->game->setIsWhat(true);
        }
        else if(isset($post['whodiddit']) and $post['whodiddit'] == 'mccullen'){
            $this->game->setWhoguess("McCullen");
            $this->game->summon();
            $this->game->setIsWho(false);
            $this->game->setIsWhat(true);
        }
        else if(isset($post['whodiddit']) and $post['whodiddit'] == 'onsay'){
            $this->game->setWhoguess("Onsay");
            $this->game->summon();
            $this->game->setIsWho(false);
            $this->game->setIsWhat(true);
        }
        else if(isset($post['whodiddit']) and $post['whodiddit'] == 'enbody'){
            $this->game->setWhoguess("Enbody");
            $this->game->summon();
            $this->game->setIsWho(false);
            $this->game->setIsWhat(true);
        }
        else if(isset($post['whodiddit']) and $post['whodiddit'] == 'plum'){
            $this->game->setWhoguess("Plum");
            $this->game->summon();
            $this->game->setIsWho(false);
            $this->game->setIsWhat(true);
        }
        else if(isset($post['whodiddit']) and $post['whodiddit'] == 'day'){
            $this->game->setWhoguess("Day");
            $this->game->summon();
            $this->game->setIsWho(false);
            $this->game->setIsWhat(true);
        }
        else if(isset($post['whatdiddit']) and $post['whatdiddit'] == 'final'){
            $this->game->setWhatguess("Final Exam");
            $this->game->setIsWho(false);
            $this->game->setIsWhat(false);
            $this->game->compareCards();
            $this->game->setIsResult(true);
        }
        else if(isset($post['whatdiddit']) and $post['whatdiddit'] == 'midterm'){
            $this->game->setWhatguess("Midterm Exam");
            $this->game->setIsWho(false);
            $this->game->setIsWhat(false);
            $this->game->compareCards();
            $this->game->setIsResult(true);

        }
        else if(isset($post['whatdiddit']) and $post['whatdiddit'] == 'programming'){
            $this->game->setWhatguess("Programming Assignment");
            $this->game->setIsWho(false);
            $this->game->setIsWhat(false);
            $this->game->compareCards();
            $this->game->setIsResult(true);

        }
        else if(isset($post['whatdiddit']) and $post['whatdiddit'] == 'project'){
            $this->game->setWhatguess("Project");
            $this->game->setIsWho(false);
            $this->game->setIsWhat(false);
            $this->game->compareCards();
            $this->game->setIsResult(true);

        }
        else if(isset($post['whatdiddit']) and $post['whatdiddit'] == 'written'){
            $this->game->setWhatguess("Writing Assignment");
            $this->game->setIsWho(false);
            $this->game->setIsWhat(false);
            $this->game->compareCards();
            $this->game->setIsResult(true);
        }
        else if(isset($post['whatdiddit']) and $post['whatdiddit'] == 'quiz'){
            $this->game->setWhatguess("Quiz");
            $this->game->setIsWho(false);
            $this->game->setIsWhat(false);
            $this->game->compareCards();
            $this->game->setIsResult(true);
        }

        if (isset($post['whatdiddit'])) {
            foreach ($this->game->getPlayers() as $player) {
                if ($player->wasSummoned()) {
                    $player->setLoc($player->getActualLoc());
                    $player->setSummoned(false);
                }
            }
        }

        if(isset($post['reset'])){
            $this->reset = true;
            $game->resetGame();
        }

    }

    public function isDone() {
        return false;
    }

    public function isReset(){
        return $this->reset;
    }

    private $reset;
    private $game;
}