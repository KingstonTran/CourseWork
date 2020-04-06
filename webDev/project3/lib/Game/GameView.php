<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/14/2019
 * Time: 4:51 PM
 */

namespace Game;

/**
 * View class for the game.
 */
class GameView
{
    const ROWS = 25; // Rows in grid
    const COLUMNS = 24; // Columns in grid

    /** Constructor
     * @param $game Game game object */
    public function __construct(Game $game) {
        $this->game = $game;
    }

    /** Present Grid function
     * @return string The game grid for the game
     */

    public function playerStart($player){
        $html = "<img src='images/$player-piece.png' alt='$player' width='37' height='37'>";
        return $html;
    }
    public function presentGrid(){
        $this->game->getCurrentPlayer()->getName();
        foreach($this->game->getPlayers() as $player){
            $name = $player->getName();
            if ($name == "Owen"){
                $Owen = $player;
            }
            else if ($name == "McCullen"){
                $McCullen = $player;
            }
            else if ($name == "Day"){
                $Day = $player;
            }
            else if ($name == "Onsay"){
                $Onsay = $player;
            }
            else if ($name == "Enbody"){
                $Enbody = $player;
            }
            else if ($name == "Plum"){
                $Plum = $player;
            }
        }

        if ($this->game->getTemp()) {
            $Temp = $this->game->getTemp();
        }
        $html = <<<HTML
<form class="gameform" id="gameform" method="post" action="game-post.php">
<div class="game">
<div class="board">
HTML;

        // Handle Dice roll and what spots a player can reach
        $board = $this->game->getBoard();
        $board->resetReachables();
        $players2 = $this->game->getPlayers();
        $currentPlayer = $players2[$this->game->getCurrent()];

        $diceroll = $this->game->getDiceRolled();
        $currentPlayer->getLoc()->searchReachableStart($diceroll);


        for($row=0;$row<GameView::ROWS;$row++){
            $html .= '<div class="row">';
            for($column=0;$column<GameView::COLUMNS;$column++){
                $tile = $board->getNodeCoords($row,$column); // Get the current tile

                if(count($tile->getContains())>=1) {
                    foreach ($this->game->getPlayers() as $play) {
                        if ($play->getRealPos() == "$row,$column" or (isset($Temp) and $Temp->getRealPos()=="$row,$column")) {
                            $html .= '<div class="cell">';
                            if (isset($McCullen)) {
                                if ($McCullen->getRealPos() == "$row,$column") {
                                    if ($McCullen == $currentPlayer and !$currentPlayer->hasMoved()) {
                                        $html .= "<button type='submit' name='cell' value='$row,$column'>";
                                        $html .= $this->playerStart("mccullen");
                                        $html .= '</button>';
                                    } else {
                                        $html .= $this->playerStart("mccullen");
                                    }
                                }
                            }
                            if (isset($Owen)) {

                                if ($Owen->getRealPos() == "$row,$column") {
                                    if ($Owen == $currentPlayer and !$currentPlayer->hasMoved()) {
                                        $html .= "<button type='submit' name='cell' value='$row,$column'>";
                                        $html .= $this->playerStart("owen");
                                        $html .= '</button>';
                                    } else {
                                        $html .= $this->playerStart("owen");
                                    }
                                }
                            }
                            if (isset($Day)) {

                                if ($Day->getRealPos() == "$row,$column") {
                                    if ($Day == $currentPlayer and !$currentPlayer->hasMoved()) {
                                        $html .= "<button type='submit' name='cell' value='$row,$column'>";
                                        $html .= $this->playerStart("day");
                                        $html .= '</button>';
                                    } else {
                                        $html .= $this->playerStart("day");
                                    }
                                }
                            }
                            if (isset($Onsay)) {

                                if ($Onsay->getRealPos() == "$row,$column") {
                                    if ($Onsay == $currentPlayer and !$currentPlayer->hasMoved()) {
                                        $html .= "<button type='submit' name='cell' value='$row,$column'>";
                                        $html .= $this->playerStart("onsay");
                                        $html .= '</button>';
                                    } else {
                                        $html .= $this->playerStart("onsay");
                                    }
                                }
                            }
                            if (isset($Enbody)) {

                                if ($Enbody->getRealPos() == "$row,$column") {
                                    if ($Enbody == $currentPlayer and !$currentPlayer->hasMoved()) {
                                        $html .= "<button type='submit' name='cell' value='$row,$column'>";
                                        $html .= $this->playerStart("enbody");
                                        $html .= '</button>';
                                    } else {
                                        $html .= $this->playerStart("enbody");
                                    }
                                }
                            }
                            if (isset($Plum)) {
                                if ($Plum->getRealPos() == "$row,$column") {
                                    if ($Plum == $currentPlayer and !$currentPlayer->hasMoved()) {
                                        $html .= "<button type='submit' name='cell' value='$row,$column'>";
                                        $html .= $this->playerStart("plum");
                                        $html .= '</button>';
                                    } else {
                                        $html .= $this->playerStart("plum");
                                    }
                                }
                            }
                            if (isset($Temp)) {
                                if ($Temp->getRealPos() == "$row,$column") {
                                    $html .= $this->playerStart(strtolower($Temp->getName()));
                                }
                            }
                            $html .= '</div>';
                            break;
                        }
                    }
                    if ($play->getRealPos() == "$row,$column"){
                        continue;
                    }
                }

                if($tile->isReachable()) {

                    $html .= '<div class="cell">';
                    if(!$currentPlayer->hasMoved()) {
                        $html .= "<button type='submit' name='cell' value='$row,$column'>";
                        $html .= '</button>';
                    }
                    $html .= '</div>';

                }

                else{
                    $html .= '<div class="cell">';
                    $html .= '</div>';

                }
            }
            $html .= '</div>';
        }
        $html .= <<<HTML
</div>
<div class="play">
HTML;
        // Set current player name in middle play area
        $playerName = $this->game->getPlayers()[$this->game->getCurrent()]->getName();
        $playerName = "Prof. " . $playerName;
        $html .="<h2>Player</h2>";
        $html .="<h2>$playerName</h2>";

        if(!$currentPlayer->hasMoved()){
            // Set the dice images
            $html .='<div class="dice">';
            $dice1 = $this->game->getDiceImage($this->game->getDiceOne());
            $dice2 = $this->game->getDiceImage($this->game->getDiceTwo());
            $html .= "<img src='$dice1' alt='Dice 1 Image' width=auto height=auto />";
            $html .= "<img src='$dice2' alt='Dice 2 Image' width=auto height=auto />";
            $html .= "</div>";
        }
        else if($currentPlayer->hasMoved() and $currentPlayer->getLoc()->roomCheck()){
            if(!$this->game->isAccuse() and !$this->game->isSuggest()) {
                $html .= $this->presentOptions();
            }
            else if($this->game->isWho()){
                $html .= $this->presentWho();
            }
            else if($this->game->isWhat()){
                $html .= $this->presentWhat();
            }
            else if($this->game->isResult()){
                if ($this->game->isSuggest()){
                    $html .= $this->presentCode();
                }
                else {
                    if ($this->game->getCurrentPlayer()->hasFailed()) {
                        if ($this->game->allFailed()){
                            $html .= '<p>Everyone has failed! Nobody can win :(</p>';
                            $html .= '<p><button type="submit" name="reset" id="reset" value="reset">New Game?</button></p>';
                        }
                        else {
                            $html .= '<p>You failed!</p>';
                            $html .= '<input type="submit" name="pass" id="pass" value="Go">';
                        }
                    } else {
                        $html .= '<p>You Won!</p>';
                        $html .= '<p><button type="submit" name="reset" id="reset" value="reset">New Game?</button></p>';
                    }
                }
            }
        }

        $html .= <<<HTML
</div>
</div>
<p><button type="submit" name="reset" id="reset" value="reset">New Game</button></p>
<div class="message"></div>
HTML;

//        $html .= "<p>[".$this->game->getMurder()[0]->getName().", ".$this->game->getMurder()[1]->getName().", ". $this->game->getMurder()[2]->getName()."]</p>"; // see murder cards for fast gameplay
        $html .= "</form>";
        return $html;
    }

    public function presentOptions(){
        $html = <<<HTML

<p>What do you wish to do?</p>
    <p><input type="radio" name="actChoice" id="pass" value="pass"><label for="pass">Pass</label></p>
    <p><input type="radio" name="actChoice" id="suggest"  value="suggest"><label for="suggest">Suggest</label></p>
HTML;
        if(!$this->game->getCurrentPlayer()->hasFailed()) {
            $html .= '<p ><input type = "radio" name = "actChoice" id = "accuse" value = "accuse"><label for="accuse" >Accuse</label ></p >';
            }

        $html .= <<<HTML
    <input type="submit" name="go" id="go" value="Go">
HTML;
        return $html;
    }

    public function presentWho(){
        $html = <<<HTML

<p>Who did it?</p>
    <p><input type="radio" name="whodiddit" id="owen" value="owen"><label for="owen">Prof. Owen</label></p>
    <p><input type="radio" name="whodiddit" id="mccullen" value="mccullen"><label for="mccullen">Prof. McCullen</label></p>
    <p><input type="radio" name="whodiddit" id="onsay" value="onsay"><label for="onsay">Prof. Onsay</label></p>
    <p><input type="radio" name="whodiddit" id="enbody" value="enbody"><label for="enbody">Prof. Enbody</label></p>
    <p><input type="radio" name="whodiddit" id="plum" value="plum"><label for="plum">Prof. Plum</label></p>
    <p><input type="radio" name="whodiddit" id="day" value="day"><label for="day">Prof. Day</label></p>

    <input type="submit" name="go" id="go" value="Go">
HTML;
        return $html;
    }

    public function presentWhat(){
        $html = <<<HTML

<p>With what?</p>
    <p><input type="radio" name="whatdiddit" id="final" value="final"><label for="exam">Final Exam</label></p>
    <p><input type="radio" name="whatdiddit" id="midterm" value="midterm"><label for="midterm">Midterm Exam</label></p>
    <p><input type="radio" name="whatdiddit" id="programming" value="programming"><label for="programming">Programming Assignment</label></p>
    <p><input type="radio" name="whatdiddit" id="project" value="project"><label for="project">Project</label></p>
    <p><input type="radio" name="whatdiddit" id="written"  value="written"><label for="written">Written Assignment</label></p>
    <p><input type="radio" name="whatdiddit" id="quiz" value="quiz"><label for="quiz">Quiz</label></p>

    <input type="submit" name="go" id="go" value="Go">
HTML;
        return $html;
    }

    public function presentCode(){
        $code = $this->game->getCode();
        $html = <<<HTML

    <p>Word on the street is:</p>
    <p><i>
HTML;
        $html .= $code;
        $html .= <<<HTML
        </i></p> 
    <input type="submit" name="pass" id="pass" value="Go">
HTML;
        return $html;
    }
    private $game;	// Game object
}