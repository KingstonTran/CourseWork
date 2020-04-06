<?php
/**
 * Created by PhpStorm.
 * User: Kingston Tran
 * Date: 2/18/2019
 * Time: 3:30 PM
 */

namespace Game;


class Cards
{
    const CODES = array('Architect', 'violin', 'kitchen', 'rum', 'lounge', 'nightmare', 'global', 'amnesia', 'tomato', 'couscous',
        'scholar', 'earlobe', 'whiskey', 'coconut', 'flamingo', 'duck', 'radio', 'maraca', 'menagerie', 'eyeball',
        'robin', 'dog', 'cat', 'lion', 'rhino', 'ball', 'basket', 'run', 'gun',
        'glasses', 'class', 'code', 'zoo', 'car', 'truck', 'buck', 'bed', 'red',
        'orange', 'banana', 'soup', 'chowder', 'tall', 'girl', 'boy', 'toy', 'baby',
        'adult', 'teenager', 'grandpa', 'random', 'word', 'bathroom', 'college',
        'highschool', 'jeans', 'comedy', 'wash', 'fence', 'giant', 'teacher', 'game',
        'beer', 'cheer', 'fear', 'pear', 'care', 'share', 'bear', 'chair', 'air', 'tear',
        'fair', 'cab', 'bus', 'plane', 'boat', 'jetski', 'snow', 'water', 'otter', 'shirt',
        'pants', 'coat', 'fast', 'beach', 'ocean', 'jog', 'athlete', 'cool', 'dumb', 'lame',
        'football', 'weave', 'long', 'blond', 'dark', 'black', 'yellow', 'ring', 'club',
        'golf', 'rat', 'trash', 'grandma', 'bad', 'ugly', 'hot', 'rot', 'bot', 'fry');

    public function __construct(Game $game) {
        $this->game = $game;
        $this->generateCards();
        $this->shuffle();
        $this->dealCards();
    }

    /**
     * The name, code, and image for card are made here, then Cards are made and added into the deck
     */
    private function generateCards(){
        $name = ['Prof. Day', 'Prof. Enbody', 'Prof. McCullen', 'Prof. Onsay', 'Prof. Owen', 'Prof. Plum',
            'Beaumont Tower', 'Breslin Center', 'Engineering Building', 'International Center',
            'Library', 'Art Museum', 'Spartan Stadium', 'University Union', 'Wharton Center',
            'Final Exam', 'Midterm Exam', 'Programming Assignment', 'Project', 'Quiz', 'Writing Assignment'];


        $image = ['day', 'enbody', 'mccullen', 'onsay', 'owen', 'plum',
            'beaumont', 'breslin', 'engineering', 'international',
            'library', 'museum', 'stadium', 'union', 'wharton',
            'final', 'midterm', 'programming', 'project', 'quiz', 'written'];

        for ($i = 0; $i < 21; $i++) {
            if ($i < 6) {
                $type = 'Person';
            } else if ($i < 15) {
                $type = 'Place';
            } else {
                $type = 'Weapon';
            }
            $newCard = new Card($type, $name[$i],"images/".$image[$i].".jpg");
            $this->addCard($newCard);
        }
    }

    /**
     * Adds the card into the array of cards
     */
    public function addCard($card){
        $this->cards[] = $card;
    }

    /**
     * Shuffles the deck
     */
    public function shuffle(){
        shuffle($this->cards);
    }

    public function dealCards() {
        $dealDeck = $this->cards;


        // generate murder cards
        $murder = array();
        $types = array();
        $toDel = array();
        for ($i = 0; $i < count($dealDeck); $i++) {
            if (($this->cards[$i]->getType() == "Person") and (in_array($this->cards[$i]->getType(), $types) === false) and (count($murder)==0)) {
                array_push($types, $dealDeck[$i]->getType());
                array_push($murder, $dealDeck[$i]);
                array_push($toDel, $i);
            } else if (($this->cards[$i]->getType() == "Place") and (in_array($this->cards[$i]->getType(), $types) === false)and (count($murder)==1)) {
                array_push($types, $dealDeck[$i]->getType());
                array_push($murder, $dealDeck[$i]);
                array_push($toDel, $i);
            } else if (($this->cards[$i]->getType() == "Weapon") and (in_array($this->cards[$i]->getType(), $types) === false)and (count($murder)==2)) {
                array_push($types, $dealDeck[$i]->getType());
                array_push($murder, $dealDeck[$i]);
                array_push($toDel, $i);
            }

            if (count($murder) == 3) {
                break;
            }
        }

        for ($i = 0; $i < count($toDel); $i++) {
            array_splice($dealDeck, $toDel[$i]-$i, 1);
        }

        $this->game->setMurder($murder);

        // deal cards to players
        if (count($this->game->getPlayers()) == 2 || count($this->game->getPlayers()) == 3)
            $cardsPer = 6;
        else if (count($this->game->getPlayers()) == 4) {
            $cardsPer = 4;
        } else {
            $cardsPer = 3;
        }

        $playerNdx = 0;
        for ($i = 0; $i < (count($this->game->getPlayers())*$cardsPer); $i++) {
            $this->game->getPlayers()[$playerNdx]->addToHand($dealDeck[$i]);
            for ($j = 0; $j < count($this->game->getPlayers()); $j++) {
                if ($j != $playerNdx) {
                    $this->game->getPlayers()[$j]->addToOtherCards($dealDeck[$i]);
                }
            }
            $playerNdx = ($playerNdx+1)%(count($this->game->getPlayers()));
        }
        array_splice($dealDeck, 0, count($this->game->getPlayers())*$cardsPer);

        $i = 0;
        foreach ($this->game->getPlayers() as $player) {
            $player->setOtherCards(array_merge($dealDeck, $player->getOtherCards()));
            $player->setOtherCards(array_merge($murder, $player->getOtherCards()));
            $cnt = count($player->getOtherCards());
            $player->setCodes(array_slice(self::CODES, $i*$cnt, $cnt));
            $i++;
        }
    }
    
    public function getDeck(){
        return $this->cards;
    }

    private $cards = [];
    private $game;
}
