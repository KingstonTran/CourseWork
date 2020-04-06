<?php
/**
 * Created by PhpStorm.
 * User: Kingston Tran
 * Date: 2/22/2019
 * Time: 10:00 PM
 */

namespace Game;


class Board
{
    public function __construct() {
        $this->R0Node = new Node("2,3",null, count(Game::PLAYERS),true,false,"R0");
        $this->R1Node = new Node("4,11",null, count(Game::PLAYERS),true,false,"R1");
        $this->R2Node = new Node("3,21",null, count(Game::PLAYERS),true,false,"R2");
        $this->R3Node = new Node("12,3",null, count(Game::PLAYERS),true,false,"R3");
        $this->R4Node = new Node("10,21",null, count(Game::PLAYERS),true,false,"R4");
        $this->R5Node = new Node("16,20",null, count(Game::PLAYERS),true,false,"R5");
        $this->R6Node = new Node("21,3",null, count(Game::PLAYERS),true,false,"R6");
        $this->R7Node = new Node("21,11",null, count(Game::PLAYERS),true,false,"R7");
        $this->R8Node = new Node("23,21",null, count(Game::PLAYERS),true,false,"R8");
        $this->MiNode = new Node("13,12",null, count(Game::PLAYERS),true,false,"M");
        $this->generateGrid();
        $this->connectRooms();
    }

    public function generateGrid(){
        // Create grid with all nodes only have position right now
        $this->grid = array();
        for($row=0;$row<GameView::ROWS;$row++) {
            array_push($this->grid, array());
            for ($column = 0; $column < GameView::COLUMNS; $column++) {
                if (in_array($this->toIndex($row, $column), $this->cellsR0)) {
                    array_push($this->grid[$row], $this->R0Node);
                } elseif (in_array($this->toIndex($row, $column), $this->cellsR1)) {
                    array_push($this->grid[$row], $this->R1Node);
                } elseif (in_array($this->toIndex($row, $column), $this->cellsR2)) {
                    array_push($this->grid[$row], $this->R2Node);
                } elseif (in_array($this->toIndex($row, $column), $this->cellsR3)) {
                    array_push($this->grid[$row], $this->R3Node);
                } elseif (in_array($this->toIndex($row, $column), $this->cellsR4)) {
                    array_push($this->grid[$row], $this->R4Node);
                } elseif (in_array($this->toIndex($row, $column), $this->cellsR5)) {
                    array_push($this->grid[$row], $this->R5Node);
                } elseif (in_array($this->toIndex($row, $column), $this->cellsR6)) {
                    array_push($this->grid[$row], $this->R6Node);
                } elseif (in_array($this->toIndex($row, $column), $this->cellsR7)) {
                    array_push($this->grid[$row], $this->R7Node);
                } elseif (in_array($this->toIndex($row, $column), $this->cellsR8)) {
                    array_push($this->grid[$row], $this->R8Node);
                } elseif (in_array($this->toIndex($row, $column), $this->cellsMi)) {
                    array_push($this->grid[$row], $this->MiNode);
                } else {
                    array_push($this->grid[$row], new Node("$row,$column", null));
                }
            }
        }
    }

    public function connectRooms()
    {
        $this->R0Node->setNeighbors([$this->getNodeIndex(172),$this->R8Node]);
        $this->R1Node->setNeighbors([$this->getNodeIndex(127),$this->getNodeIndex(136),
            $this->getNodeIndex(201),$this->getNodeIndex(206)]);
        $this->R2Node->setNeighbors([$this->getNodeIndex(162),$this->R6Node]);
        $this->R3Node->setNeighbors([$this->getNodeIndex(296),$this->getNodeIndex(390)]);
        $this->R4Node->setNeighbors([$this->getNodeIndex(233),$this->getNodeIndex(334)]);
        $this->R5Node->setNeighbors([$this->getNodeIndex(400),$this->getNodeIndex(332)]);
        $this->R6Node->setNeighbors([$this->getNodeIndex(438),$this->R2Node]);
        $this->R7Node->setNeighbors([$this->getNodeIndex(418),$this->getNodeIndex(420)]);
        $this->R8Node->setNeighbors([$this->getNodeIndex(497),$this->R0Node]);

        $rows = GameView::ROWS;
        $columns = GameView::COLUMNS;
        for($index=0;$index<($rows*$columns);$index++){
            $node = $this->getNodeIndex($index);
            if (in_array($index, $this->cellsC1)){
                $node->addTo($this->getNodeIndex($index-1)); // left neighbor
                $node->addTo($this->getNodeIndex($index+1)); // right neighbor
                $node->addTo($this->getNodeIndex($index-$columns)); // top neighbor
                $node->addTo($this->getNodeIndex($index+$columns)); // bottom neighbor
            }
            elseif (in_array($index, $this->cellsC2)){
                $node->addTo($this->getNodeIndex($index+1)); // right neighbor
                $node->addTo($this->getNodeIndex($index-$columns)); // top neighbor
                $node->addTo($this->getNodeIndex($index+$columns)); // bottom neighbor
            }
            elseif (in_array($index, $this->cellsC3)){
                $node->addTo($this->getNodeIndex($index-1)); // left neighbor
                $node->addTo($this->getNodeIndex($index+1)); // right neighbor
                $node->addTo($this->getNodeIndex($index-$columns)); // top neighbor
            }
            elseif (in_array($index, $this->cellsC4)){
                $node->addTo($this->getNodeIndex($index-1)); // left neighbor
                $node->addTo($this->getNodeIndex($index-$columns)); // top neighbor
                $node->addTo($this->getNodeIndex($index+$columns)); // bottom neighbor
            }
            elseif (in_array($index, $this->cellsC5)){
                $node->addTo($this->getNodeIndex($index-1)); // left neighbor
                $node->addTo($this->getNodeIndex($index+1)); // right neighbor
                $node->addTo($this->getNodeIndex($index+$columns)); // bottom neighbor
            }
            elseif (in_array($index, $this->cellsC6)){
                $node->addTo($this->getNodeIndex($index-1)); // left neighbor
                $node->addTo($this->getNodeIndex($index+1)); // right neighbor
            }
            elseif (in_array($index, $this->cellsC8)){
                $node->addTo($this->getNodeIndex($index+1)); // right neighbor
                $node->addTo($this->getNodeIndex($index-$columns)); // top neighbor
            }
            elseif (in_array($index, $this->cellsC9)){
                $node->addTo($this->getNodeIndex($index+1)); // right neighbor
                $node->addTo($this->getNodeIndex($index+$columns)); // bottom neighbor
            }
            elseif (in_array($index, $this->cellsC10)){
                $node->addTo($this->getNodeIndex($index-1)); // left neighbor
                $node->addTo($this->getNodeIndex($index+$columns)); // bottom neighbor
            }
            elseif (in_array($index, $this->cellsC11)){
                $node->addTo($this->getNodeIndex($index-1)); // left neighbor
                $node->addTo($this->getNodeIndex($index-$columns)); // top neighbor
            }
            elseif (in_array($index, $this->cellsC12)){
                $node->addTo($this->getNodeIndex($index-$columns)); // top neighbor
            }
            elseif (in_array($index, $this->cellsC13)){
                $node->addTo($this->getNodeIndex($index+1)); // right neighbor
            }
            elseif (in_array($index, $this->cellsC14)){
                $node->addTo($this->getNodeIndex($index+$columns)); // bottom neighbor
            }
            elseif (in_array($index, $this->cellsC15)){
                $node->addTo($this->getNodeIndex($index-1)); // left neighbor
            }
        }

    }

    /**
     * @return array
     */
    public function getGrid(){
        return $this->grid;
    }

    /**
     * @return Node
     */
    public function getNodeIndex($index)
    {
        $exp_array = explode(',',$this->toCoords($index));
        return $this->grid[$exp_array[0]][$exp_array[1]];
    }

    /**
     * @return Node
     */
    public function getNodeCoords($row, $column)
    {
        return $this->grid[$row][$column];
    }

    public function getNodeCoordsStr($coords)
    {
        $exp_array = explode(',',$coords);
        return $this->grid[$exp_array[0]][$exp_array[1]];
    }

    public function toIndex($row, $column)
    {
        return $row*GameView::COLUMNS+$column;
    }

    public function toCoords($index){
        $row = (int)($index/GameView::COLUMNS);
        $column = $index%GameView::COLUMNS;
        return "$row,$column";
    }


    public function getReachableIndices(){
        $reachables = [];
        for($i=0; $i<(GameView::ROWS*GameView::COLUMNS);$i++){
            $node = $this->getNodeIndex($i);
            if (!in_array($node->getPosIndex(),$reachables) && $node->isReachable()){
                $reachables[] = $node->getPosIndex();
            }
        }
        return $reachables;
    }



    public function resetReachables(){
        for($row=0;$row<GameView::ROWS;$row++) {
            for ($column = 0; $column < GameView::COLUMNS; $column++) {
                $node = $this->getNodeCoords($row,$column);
                $node->setReachable(false);
                $node->setOnPath(false);
            }
        }
    }


    private $grid;

    // node classification
    private $cellsC1 = [127, 136, 161, 162, 172, 174, 185, 197, 198, 199, 201, 206, 208, 224, 225, 231, 232, 233, 256, 280, 296, 304, 328, 329, 352, 390, 392, 400, 410, 411, 412, 413, 414, 415, 416, 423, 438, 439, 448, 472, 473, 496, 497]; // class 1 cells have neighbors left, right, top and bottom
    private $cellsC2 = [64, 78, 88, 102, 112, 126, 150, 160, 184, 248, 255, 272, 279, 303, 320, 327, 344, 351, 368, 375, 399, 409, 447, 463, 471, 487, 495, 511, 519, 535, 543]; // class 2 cells have neighbors right, top and bottom
    private $cellsC3 = [194, 195, 196, 186, 187, 188, 189, 222, 223, 226, 227, 228, 229, 230, 417, 434, 435, 436, 437, 498, 499, 500, 501];
    private $cellsC4 = [55, 79, 89, 103, 113, 137, 151, 175, 209, 249, 257, 273, 281, 297, 305, 321, 345, 369, 376, 393, 424, 440, 464, 488, 512, 520, 536, 544, 568];
    private $cellsC5 = [163, 164, 165, 169, 170, 171, 173, 200, 202, 203, 204, 205, 207, 332, 386, 387, 388, 389, 391, 419, 420, 474, 475, 476, 477];
    private $cellsC6 = [32, 39, 330, 331, 333, 418, 421, 422];

    private $cellsC8 = [193, 221, 433, 567, 559];
    private $cellsC9 = [31, 54, 385];
    private $cellsC10 = [40, 65, 166, 449, 478];
    private $cellsC11 = [190, 334, 353, 502, 560];

    private $cellsC12 = [583, 592];
    private $cellsC13 = [408, 38, 168];
    private $cellsC14 = [9, 14];
    private $cellsC15 = [479, 191, 33];

    // classifying nodes within a room
    private $cellsR0 = [24, 25, 26, 27, 28, 29, 48, 49, 50, 51, 52, 53, 72, 73, 74, 75, 76, 77, 96, 97, 98, 99, 100, 101, 120, 121, 122, 123, 124, 125, 145, 146, 147, 148, 149];
    private $cellsR1 = [34, 35, 36, 37, 56, 57, 58, 59, 60, 61, 62, 63, 80, 81, 82, 83, 84, 85, 86, 87, 104, 105, 106, 107, 108, 109, 110, 111, 128, 129, 130, 131, 132, 133, 134, 135, 152, 153, 154, 155, 156, 157, 158, 159, 176, 177, 178, 179, 180, 181, 182, 183];
    private $cellsR2 = [42, 43, 44, 45, 46, 47, 66, 67, 68, 69, 70, 71, 90, 91, 92, 93, 94, 95, 114, 115, 116, 117, 118, 119, 138, 139, 140, 141, 142];
    private $cellsR3 = [216, 217, 218, 219, 220, 240, 241, 242, 243, 244, 245, 246, 247, 264, 265, 266, 267, 268, 269, 270, 271, 288, 289, 290, 291, 292, 293, 294, 295, 312, 313, 314, 315, 316, 317, 318, 319, 336, 337, 338, 339, 340, 341, 342, 343, 360, 361, 362, 363, 364, 365, 366, 367];
    private $cellsR4 = [210, 211, 212, 213, 214, 215, 234, 235, 236, 237, 238, 239, 258, 259, 260, 261, 262, 263, 282, 283, 284, 285, 286, 287, 306, 307, 308, 309, 310, 311];
    private $cellsR5 = [354, 355, 356, 357, 358, 377, 378, 379, 380, 381, 382, 383, 401, 402, 403, 404, 405, 406, 407, 425, 426, 427, 428, 429, 430, 431, 450, 451, 452, 453, 454];
    private $cellsR6 = [456, 457, 458, 459, 460, 461, 462, 480, 481, 482, 483, 484, 485, 486, 504, 505, 506, 507, 508, 509, 510, 528, 529, 530, 531, 532, 533, 534, 552, 553, 554, 555, 556, 557, 558, 576, 577, 578, 579, 580, 581];
    private $cellsR7 = [441, 442, 443, 444, 445, 446, 465, 466, 467, 468, 469, 470, 489, 490, 491, 492, 493, 494, 513, 514, 515, 516, 517, 518, 537, 538, 539, 540, 541, 542, 561, 562, 563, 564, 565, 566, 585, 586, 587, 588, 589, 590];
    private $cellsR8 = [521, 522, 523, 524, 525, 526, 527, 545, 546, 547, 548, 549, 550, 551, 569, 570, 571, 572, 573, 574, 575, 594, 595, 596, 597, 598, 599];
    private $cellsMi = [250, 251, 252, 253, 254, 274, 275, 276, 277, 278, 298, 299, 300, 301, 302, 322, 323, 324, 325, 326, 346, 347, 348, 349, 350, 370, 371, 372, 373, 374, 394, 395, 396, 397, 398];

    private $R0Node;
    private $R1Node;
    private $R2Node;
    private $R3Node;
    private $R4Node;
    private $R5Node;
    private $R6Node;
    private $R7Node;
    private $R8Node;
    private $MiNode;
}