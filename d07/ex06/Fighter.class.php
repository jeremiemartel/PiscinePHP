<?php

    abstract class Fighter
    {
        public $type;
        
        abstract public function fight($target);

        function __construct($name)
        {
            $this->type = $name;
        }
    }

?>