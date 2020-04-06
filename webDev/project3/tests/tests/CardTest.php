<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 3/1/2019
 * Time: 9:32 PM
 */

use Game\Card as card;

class CardTest extends \PHPUnit\Framework\TestCase
{
    public function test__construct()
    {
        $newCard = new Card("Weapon", "Final Exam","images/final.jpg");
        $this->assertEquals("Weapon",$newCard->getType());
        $this->assertEquals("Final Exam",$newCard->getName());
        $this->assertEquals("images/final.jpg",$newCard->getImage());
        $newCard->setCode("Banana");
        $this->assertEquals("Banana",$newCard->getCode());
    }
}
