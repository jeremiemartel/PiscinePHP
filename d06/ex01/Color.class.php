<?php
    Class Color
    {
        public $red;
        public $green;
        public $blue;
        public static $verbose = FALSE;

        public static function doc()
        {
            return (file_get_contents('Color.doc.txt'));
        }

        function __construct(array $args)
        {
            if (array_key_exists('rgb', $args))
            {
                $this->red = (intval($args['rgb']) & 0xff0000) >> 16;
                $this->green = (intval($args['rgb']) & 0x00ff00) >> 8;
                $this->blue = (intval($args['rgb']) & 0x0000ff);
            }
            else
            {
                $this->red = intval($args['red']);
                $this->green = intval($args['green']);
                $this->blue = intval($args['blue']);
            }
            if (self::$verbose)
                echo $this." constructed.".PHP_EOL;
        }

        function __destruct()
        {
            if (self::$verbose)
                echo $this." destructed.".PHP_EOL;
        }

        function __toString()
        {
            return sprintf("Color( red: %3d, green: %3d, blue: %3d )", $this->red, $this->green, $this->blue);
        }

        public function add(Color $rhs)
        {
            return new self (array("red" => ($this->red + $rhs->red), "green" => ($this->green + $rhs->green), "blue" => ($this->blue + $rhs->blue)));
        }

        public function sub(Color $rhs)
        {
            return new self (array("red" => ($this->red - $rhs->red), "green" => ($this->green - $rhs->green), "blue" => ($this->blue - $rhs->blue)));
        }
        public function mult($f)
        {
            return (new self (array("red" => $this->red * $f, "green" => $this->green * $f, "blue" => $this->blue  * $f)));
        }
    }


?>