#!/usr/bin/php
<?php
	if ($argc != 2)
		return ;
	$str = trim($argv[1]);
	$tab = preg_split("/\ +/", $str);
	
	if (empty($tab) || empty($tab[0]))
		return ;
	foreach($tab as $key => $value)
	{
		if ($key != 0)
			echo " ";
		echo $value;
	}
	echo "\n";
?>