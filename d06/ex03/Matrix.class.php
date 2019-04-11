<?php
    class Matrix
    {
		const IDENTITY = 1;
		const SCALE = 2;
		const RX = 3;
		const RY = 4;
		const RZ = 5;
		const TRANSLATION = 6;
		const PROJECTION = 7;
		const MYPRESET = 8;
		private $_matrix;
		static $verbose = FALSE;

		public static function doc(){
			return (file_get_contents('Matrix.doc.txt'));
		}

		public function __get($var){
			if ($var === "_matrix")
				return $this->_matrix;
		}

		function __destruct()
		{
			if (self::$verbose)
				echo "Matrix instance destructed".PHP_EOL;
		}

		function __toString()
		{
			$m = $this->_matrix;
			$str =  sprintf("M | vtcX | vtcY | vtcZ | vtxO".PHP_EOL);
			$str .= sprintf("-----------------------------".PHP_EOL);
			$str .= sprintf("x | %.2f | %.2f | %.2f | %.2f".PHP_EOL, $m[0][0], $m[0][1], $m[0][2], $m[0][3]);
			$str .= sprintf("y | %.2f | %.2f | %.2f | %.2f".PHP_EOL, $m[1][0], $m[1][1], $m[1][2], $m[1][3]);
			$str .= sprintf("z | %.2f | %.2f | %.2f | %.2f".PHP_EOL, $m[2][0], $m[2][1], $m[2][2], $m[2][3]);
			$str .= sprintf("w | %.2f | %.2f | %.2f | %.2f", $m[3][0], $m[3][1], $m[3][2], $m[3][3]);
			return $str;
		}

		public function __construct(array $args)
		{
			$type = $args['preset'];
			switch ($type)
			{
				case self::IDENTITY:
				{
					$this->_matrix = array(
						array(1.0, 0.0, 0.0, 0.0),
						array(0.0, 1.0, 0.0, 0.0),
						array(0.0, 0.0, 1.0, 0.0),
						array(0.0, 0.0, 0.0, 1.0));
					if (self::$verbose)
						echo "Matrix IDENTITY instance constructed".PHP_EOL;
					break ;
				}
				case self::SCALE:
				{
					$f = floatval($args['scale']);
					$this->_matrix = array(
						array($f , 0.0, 0.0, 0.0),
						array(0.0, $f , 0.0, 0.0),
						array(0.0, 0.0, $f , 0.0),
						array(0.0, 0.0, 0.0, 1.0));
					if (self::$verbose)
						echo "Matrix SCALE preset instance constructed".PHP_EOL;
					break ;
				}
				case self::RX:
				{
					$angle = floatval($args['angle']);
					$this->_matrix = array(
						array(1.0, 0.0, 0.0, 0.0),
						array(0.0, cos($angle), -1 *sin($angle), 0.0),
						array(0.0, sin($angle), cos($angle), 0.0),
						array(0.0, 0.0, 0.0, 1.0));
					if (self::$verbose)
						echo "Matrix Ox ROTATION preset instance constructed".PHP_EOL;
					break ;
				}
				case self::RY:
				{
					$angle = floatval($args['angle']);
					$this->_matrix = array(
						array(cos($angle), 0.0, sin($angle), 0.0),
						array(0.0, 1.0, 0.0, 0.0),
						array(-1 * sin($angle), 0.0, cos($angle), 0.0),
						array(0.0, 0.0, 0.0, 1.0));
					if (self::$verbose)
						echo "Matrix Oy ROTATION preset instance constructed".PHP_EOL;
					break ;
				}
				case self::RZ:
				{
					$angle = floatval($args['angle']);
					$this->_matrix = array(
						array(cos($angle), -1 * sin($angle), 0.0, 0.0),
						array(sin($angle), cos($angle), 0.0, 0.0),
						array(0.0, 0.0, 1.0, 0.0),
						array(0.0, 0.0, 0.0, 1.0));
					if (self::$verbose)
						echo "Matrix Oz ROTATION preset instance constructed".PHP_EOL;
					break ;
				}
				case self::TRANSLATION:
				{
					$t = $args['vtc'];
					$this->_matrix = array(
						array(1.0, 0.0, 0.0, $t->_x),
						array(0.0, 1.0, 0.0, $t->_y),
						array(0.0, 0.0, 1.0, $t->_z),
						array(0.0, 0.0, 0.0, 1.0));
					if (self::$verbose)
						echo "Matrix TRANSLATION preset instance constructed".PHP_EOL;
					break ;
				}
				case self::PROJECTION:
				{
					$a = deg2rad(floatval($args['fov']));
					$ar = floatval($args['ratio']);
					$near = floatval($args['near']);
					$far = floatval($args['far']);
					$this->_matrix = array(
						array(1.0 / ($ar * tan($a / 2)), 0.0, 0.0, 0.0),
						array(0.0, 1 / tan($a / 2), 0.0, 0.0),
						array(0.0, 0.0, ( -1 * $near - $far) / ($far - $near), (2 * $far * $near) / ($near - $far)),
						array(0.0, 0.0, -1.0, 0.0));
					if (self::$verbose)
						echo "Matrix PROJECTION preset instance constructed".PHP_EOL;
					break ;
				}
				case self::MYPRESET:
				{
					$this->_matrix = $args['matrix'];
				}
			}
		}

		function mult (Matrix $mult)
		{
			$a = $this->_matrix;
			$b = $mult->_matrix;
			$nm = array(array(0.0, 0.0, 0.0, 0.0),array(0.0, 0.0, 0.0, 0.0),array(0.0, 0.0, 0.0, 0.0),array(0.0, 0.0, 0.0, 0.0));
			foreach ($nm as $lk => $l)
				foreach ($l as $ck => $c)
					for ($k = 0; $k < 4; $k++)
						$nm[$lk][$ck] += $a[$lk][$k] * $b[$k][$ck];
			return new Matrix (array('preset' => self::MYPRESET, 'matrix' => $nm));
		}

		function transformVertex(Vertex $vtx)
		{
			$m = $this->_matrix;
			$x = $vtx->get_x();
			$y = $vtx->get_y();
			$z = $vtx->get_z();
			$w = $vtx->get_w();
			return new Vertex( array(
				'x' => ($x * $m[0][0] + $y * $m[0][1] + $z * $m[0][2] + $w * $m[0][3]),
				'y' => ($x * $m[1][0] + $y * $m[1][1] + $z * $m[1][2] + $w * $m[1][3]),
				'z' => ($x * $m[2][0] + $y * $m[2][1] + $z * $m[2][2] + $w * $m[2][3]),
				'w' => ($x * $m[3][0] + $y * $m[3][1] + $z * $m[3][2] + $w * $m[3][3]),
				));
		}
	}
?>