#!/usr/bin/php
<?php
	if (argc == 1 || empty($argv[1]))
		return ;
	$tab = preg_split("/\ +/", trim($argv[1]));
	$buf = array_shift($tab);
	array_push($tab, $buf);
	$res = implode(" ", $tab);
	if (!empty($res))
		echo $res,"\n";
?>