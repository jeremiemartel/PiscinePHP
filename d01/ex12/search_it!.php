#!/usr/bin/php
<?php
	if ($argc <= 2)
		return ;
	$tab = array();
	$i = 2;
	while ($i < $argc)
	{
		if (strstr($argv[$i], ":"))
		{
			$buff = preg_split("/:/", $argv[$i]);
			if (!strcmp($buff[0], $argv[1]))
				$res = $buff[1]."\n";
		}
		$i++;
	}
	if (!empty($res))
		echo $res;
?>