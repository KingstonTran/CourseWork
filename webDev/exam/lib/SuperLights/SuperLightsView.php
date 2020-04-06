<?php
/**
 * Created by PhpStorm.
 * User: Kingston Tran
 * Date: 4/27/2019
 * Time: 11:30 AM
 */

namespace SuperLights;


class SuperLightsView
{    public function __construct(SuperLights $lights) {
    $this->lights = $lights;
}
    public function present(){
            $name = $this->lights->getPlayerName();
            $sol = $this->lights->getSolution();
            $html = '<p>'.$name.'\'s Super Lights</p>';
            $html .= '<table>';
            $values = $this->lights->getBoard();
            for($r=0; $r<count($values); $r++) {
                $html .= '<tr>';
                $row = $values[$r];
                for($c=0; $c<count($row); $c++) {
                    $value = $values[$r][$c];
                    if($value < 0) {
                        $html .= '<td><button name="cell" value="'.$r.','.$c.'">&nbsp;</button></td>';
                    } else if($value == 10){
                        if($this->lights->isChecking() && $sol[$r][$c] != 10){
                            $html.= '<td class="light wrong">';
                        }
                        else{
                            $html .= '<td class="light">';
                        }
                        $html.= '<button name="cell" value="'.$r.','.$c.'"><img src="img/light.png" alt="light" width="23.850" height="41.6"></button></td>';
                    } else if($value == 11){
                        if($this->lights->isChecking() && $sol[$r][$c] == 10){
                            $html .= '<td class="unshaded wrong">';
                        }
                        else{
                            $html .= '<td class="unshaded">';
                        }
                        $html.= '<button name="cell" value="'.$r.','.$c.'">•</button></td>';
                    } else if($value > 4) {
                        $html .= '<td class="wall">&nbsp;</td>';
                    } else {
                        $html .= '<td class="wall">' . $value . '</td>';
                    }
                }

                $html .= '</tr>';
            }

            $html .= '</table>';
            $html.= '<p><input type="hidden" name="start" value="game"></p>';

            if (!$this->lights->isWinner()){
                if ($this->lights->isChecking()){
                    $html.= '<p><input type="submit" name="check" value="Uncheck"></p>';
                }
                else {
                    $html.= '<p><input type="submit" name="check" value="Check"></p>';
                }
                $html.= '<p><input type="submit" name="giveup" value="Give Up"></p>';
            }
            else{
                $html .= '<p>Solution is correct!</p>';
            }

            return $html;
    }
    private $lights; //SuperLight object
}