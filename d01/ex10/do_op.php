#!/usr/bin/php
<?php
	function error ()
	{
		echo "Incorrect Parameters\n";
		return ;
	}
	
	if ($argc != 4)
		return error();
	$a = trim($argv[1]);
	$op = trim($argv[2]);
	$b = trim($argv[3]);
	if ($op == "+")
		$res = $a + $b;
	else if ($op == "-")
		$res = $a - $b;
	else if ($op == "*")
		$res = $a * $b;
	else if ($op == "/" && $b != 0)
		$res = $a / $b;
	else if ($op == "%" && $b != 0)
		$res = $a % $b;
	if (isset($res))
		echo $res,"\n";
	return ;
?>