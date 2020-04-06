<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/15/2019
 * Time: 12:59 PM
 */

namespace Game;



/**
 * View class for the game.
 */
class CardsView
{
    /** Constructor
     * @param $game Game game object */
    public function __construct(Game $game) {
        $this->game = $game;
    }

    /**
     * Create the HTML we present for cards page
     * @return string HTML to present
     */
    public function presentCards(){
        $player = $this->game->getPlayers()[$this->game->getCurrent()]->getName();
        $html = <<<HTML
<form method="post" action="cards-post.php"><!-- FILL THIS IN LATER -->
<div class="cards">
<h1>Cards for Prof. $player</h1>
<br>
<input type="submit" name="print" value="Print" onclick="window.print()">
<input type="submit" name="next" id="next" value="Next">
</div>
</form>
HTML;

        return $html;
    }

    public function presentPrintCards(){
        $player = $this->game->getPlayers()[$this->game->getCurrent()];
        $playerName = $player->getName();
        $cards = $player->getHand();
        $otherCards = $player->getOtherCards();
        $codes = $player->getCodes();

        $html= <<<HTML
<div class="printcards">
<h1>Cards for Prof. $playerName</h1>
<h2>Held Cards</h2>
HTML;

        $html .= "<p>";
        foreach ($cards as $card) {
            $html .= "<div><img src=".$card->getImage()." alt='game card' ></div>";
        }
        $html .= "</p>";

        $html .= "<h2>Other Cards</h2>";
        $rowTracker = 0;
        $cnt = 0;
        foreach ($otherCards as $card) {
            if ($rowTracker == 0) {
                $html .= "<p>";
            }
            $html .= "<div><img src=".$card->getImage()." alt='game card' >";
//            $html .= "<p>".$codes[$cnt++]."</p></div>";
            $html .= "<p>".$codes[$card->getName()]."</p></div>";
            $rowTracker++;
            if ($rowTracker == 6) {
                $html .= "</p>";
                $rowTracker = 0;
            }
        }

        return $html;
    }

    private function getCards($cards){
        echo "Test";
        foreach ($cards as $card){
            $image = $card->getImage();
            echo "image";
        }
    }

    private $game;	// Game object
}
