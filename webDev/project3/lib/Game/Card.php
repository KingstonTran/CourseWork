<?php
/**
 * Created by PhpStorm.
 * User: Kingston Tran
 * Date: 2/18/2019
 * Time: 3:13 PM
 */

namespace Game;


class Card
{
    /**
     * Constructs the card. Has 3 parameter
     * @param string for the name
     * @param string for the code
     * @param string for the image source
     */
    public function __construct($type, $name, $image) {
        $this->type = $type;
        $this->name = $name;
//        $this->code = $code;
        $this ->image = $image;
    }

    public function getType() {
        return $this->type;
    }

    /**
     * returns the name of the card
     * @return string name
     */
    public function getName(){
        return $this->name;
    }

    /**
     * returns the code of the card
     * @return string code
     */
    public function getCode(){
        return $this->code;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    /**
     * returns the image source of the card
     * @return string image
     */
    public function getImage(){
        return $this->image;
    }

    private $type;
    private $name;
    private $code;
    private $image;

}
