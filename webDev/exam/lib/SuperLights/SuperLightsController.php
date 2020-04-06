<?php
/**
 * Created by PhpStorm.
 * User: Kingston Tran
 * Date: 4/27/2019
 * Time: 11:25 AM
 */

namespace SuperLights;


class SuperLightsController
{
    public function __construct(SuperLights $lights, $post){
        $this->lights = $lights;
//        echo "<pre>";
//        print_r($post);
//        echo "</pre>";
        $root = $lights->getRoot();

        if ($post['start'] == "start"){
            $lights->setPlayerName($post['name']);
            $this->redirect = "$root/lights.php";
            return;
        }
        else if($post['start'] == "game"){
            if (isset($post['check'])){
                $this->redirect = "$root/lights.php";
                $this->lights->setChecking($post['check'] == "Check");
                return;
            }

            else if (isset($post['newgame']) && $post['newgame'] == "New Game"){
                $this->redirect = "$root/lights.php";
                $this->lights->setIsWinner(false);
                $this->lights->setChecking(false);
                $this->lights->reset();

                return;
            }
            else if (isset($post['giveup']) && $post['giveup'] == "Give Up"){
                $this->redirect = "$root/lights.php";
                $this->lights->setBoard($lights->getSolution());
                $this->lights->setChecking(false);
                $this->lights->setIsWinner(true);
                return;
            }
            $board = $lights->getBoard();
            $chosen = explode(",", $post['cell']);
            $this->lights->setChecking(false);
            $row = $chosen[0];
            $col = $chosen[1];
            $chosen = $board[$row][$col];
            if($chosen < 1 || $chosen>5){
                if($chosen == -1){
                    $board[$row][$col] = 10;
                }
                else if($chosen == 10){
                    $board[$row][$col] = 11;
                }
                else if($chosen == 11){
                    $board[$row][$col] = -1;
                }
                $this->lights->setBoard($board);
                $this->redirect = "$root/lights.php";
                $this->lights->setIsWinner(true);
                for($r=0; $r<count($board); $r++) {
                    for($c=0; $c<count($board[$r]); $c++) {
                        if($board[$r][$c] != 10 && $this->lights->getSolution()[$r][$c] == 10){
                            $this->lights->setIsWinner(false);
                        }
                        else if(!in_array(-1,$board) && $board[$r][$c] == 10 && $this->lights->getSolution()[$r][$c] != 10 ){
                            $this->lights->setIsWinner(false);
                        }
                    }
                }

            }
            return;
        }


    }

        /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }	// Page we will redirect the user to.

    private $lights;
    private $redirect;

}