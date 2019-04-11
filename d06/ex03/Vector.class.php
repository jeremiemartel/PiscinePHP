<?php
    error_reporting(E_ALL);
    require_once 'Vertex.class.php';

    Class Vector
    {
        private $_x;
        private $_y;
        private $_z;
        private $_w;
        public static $verbose = FALSE;

        public static function doc(){
            return (file_get_contents('Vector.doc.txt'));
        }

        public function __construct(array $args)
        {
            $dest = $args['dest'];

            if (array_key_exists('orig', $args))
                $orig = $args['orig'];
            else
                $orig = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0, 'w' => 1));

            $this->_x = $dest->get_x() - $orig->get_x();
            $this->_y = $dest->get_y() - $orig->get_y();
            $this->_z = $dest->get_z() - $orig->get_z();
            $this->_w = 0.0;
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
            $str =  sprintf("Vector( x:%0.2f, y:%0.2f, z:%0.2f, w:%0.2f", $this->_x, $this->_y, $this->_z, $this->_w);
            $str .= " )";
            return $str;
        }

        function __get($var){
            return ($this->$var);
        }

        function magnitude(){
            return (sqrt($this->_x ** 2 + $this->_y ** 2 + $this->_z ** 2 ));
        }

        function normalize(){
            $norme = $this->magnitude();
            return new Vector (array ( 'dest' => new Vertex( array(
                'x' => $this->_x / $norme,
                'y' => $this->_y / $norme,
                'z' => $this->_z / $norme
            ))));
        }

        function add(Vector $rhs){
            return new Vector (array ( 'dest' => new Vertex( array(
                'x' => $this->_x + $rhs->_x,
                'y' => $this->_y + $rhs->_y,
                'z' => $this->_z + $rhs->_z
            ))));
        }

        function sub(Vector $rhs){
            return new Vector(array( 'dest' => new Vertex( array(
                'x' => $this->_x - $rhs->_x,
                'y' => $this->_y - $rhs->_y,
                'z' => $this->_z - $rhs->_z
            ))));
        }

        function opposite(){
            return new Vector(array( 'dest' => new Vertex( array(
                'x' => -1 * $this->_x,
                'y' => -1 * $this->_y,
                'z' => -1 * $this->_z,
            ))));
        }

        function scalarProduct($k){
            return new Vector(array( 'dest' => new Vertex( array(
                'x' => $k * $this->_x,
                'y' => $k * $this->_y,
                'z' => $k * $this->_z,
            ))));
        }

        function dotProduct(Vector $rhs){
            return $this->_x * $rhs->_x + $this->_y * $rhs->_y + $this->_z * $rhs->_z;
        }

        function cos(Vector $rhs){
            return $this->dotProduct($rhs) / ($this->magnitude() * $rhs->magnitude());
        }

        function crossProduct(Vector $rhs){
            return new Vector(array( 'dest' => new Vertex( array(
                'x' => $this->_y * $rhs->_z - $this->_z * $rhs->_y,
                'y' => $this->_z * $rhs->_x - $this->_x * $rhs->_z,
                'z' => $this->_x * $rhs->_y - $this->_y * $rhs->_x
            ))));
        }
    }
?>