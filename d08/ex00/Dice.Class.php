<?php

    Class Dice
    {
        public static function doc(){
            return (file_get_contents('./docs/Dice.doc.txt'));
        }

        public function launch ($d = 6){
            return rand(1, $d);
        }            
    }

?>