<?php
    require_once 'Color.class.php';

    Class Vertex
    {
        private $_x;
        private $_y;
        private $_z;
        private $_w;
        private $_color;
        public static $verbose = FALSE;

        public static function doc(){
            return (file_get_contents('Vertex.doc.txt'));
        }

        public function __construct(array $args)
        {
            $this->_x = floatval($args['x']);
            $this->_y = floatval($args['y']);
            $this->_z = floatval($args['z']);

            if (array_key_exists(('w'), $args))
                $this->_w = floatval($args['w']);
            else
                $this->_w = 1.0;

            if (array_key_exists(('color'), $args))
                $this->_color = $args['color'];
            else
                $this->_color = new Color (array('rgb' => 0xffffff));

            if (self::$verbose)
                echo $this." constructed".PHP_EOL;
        }

        function __destruct()
        {
            if (self::$verbose)
                echo $this." destructed".PHP_EOL;
        }

        function __toString()
        {
            $str =  sprintf("Vertex( x: %0.2f, y: %0.2f, z:%0.2f, w:%0.2f", $this->_x, $this->_y, $this->_z, $this->_w);
            if (self::$verbose)
                $str .= ", " . $this->_color;
            $str .= " )";
            return $str;
        }

        public function set_x($x){
            $this->_x = floatval($x);
        }
        public function set_y($y){
            $this->_y = floatval($y);
        }
        public function set_z($z){
            $this->_z = floatval($z);
        }
        public function set_w($w){
            $this->_w = floatval($w);
        }

        public function set_color($red, $green, $blue){
            $this->_color->red = intval($red);
            $this->_color->green = intval($green);
            $this->_color->blue = intval($blue);
        }


        public function get_x(){
            return ($this->_x);
        }
        public function get_y(){
            return ($this->_y);
        }
        public function get_z(){
            return ($this->_z);
        }
        public function get_w(){
            return ($this->_w);
        }
        public function get_color(){
            return array( 'red' => $this->color->red,
                'green' => $this->color->green,
                'blue' => $this->color->blue);
        }

    }


?>