#!/usr/bin/php
<?php
	if ($argc == 1)
		return ;
	$argv[1] = trim($argv[1]);
	if (empty($argv[1]))
		return ;
	$tab = preg_split("/\s+/", $argv[1]);
	if (empty($tab))
		return ;
	foreach ($tab as $key => $value)
	{
		if ($key)
			echo " ";
		echo $value;
	}
	echo "\n";
	return ;
?>