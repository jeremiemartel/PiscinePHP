#!/usr/bin/php
<?php
	function param_error()  {echo "Incorrect Parameters\n";}
	function syntax_error() {echo "Syntax Error\n";}

	if ($argc != 2)
		return param_error();
	$argv[1] = trim($argv[1]);

	if (!(preg_match("/^\d+\s*[+-\/\*\%]\s*\d+$/", $argv[1], $tab)))
		return syntax_error();
	$val = preg_split("/\s*[+-\/\*\%]\s*/", $argv[1]);
	preg_match("/[+-\/\*\%]/", $argv[1], $op);

	$a = $val[0];
	$b = $val[1];
	$op = $op[0];

	if ($op == "+")
		$res = $a + $b;
	else if ($op == "-")
		$res = $a - $b;
	else if ($op == "*")
		$res = $a * $b;
	else
	{
		if ($b == 0)
			return syntax_error();
		if ($op == "/")
			$res = $a / $b;
		else if ($op == "%")
			$res = $a % $b;
	}
	echo $res,"\n";
?>