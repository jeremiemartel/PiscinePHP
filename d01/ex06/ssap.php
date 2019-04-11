#!/usr/bin/php
<?php
	if ($argc == 1)
		return ;
	
	function split_word($str)
	{
		$str = trim($str);
		$tab = preg_split("/\ +/", $str);
		return $tab;
	}
	$i = 1;
	$res = array();
	while ($i < $argc)
	{
		$res = array_merge($res, split_word($argv[$i]));
		$i++;
	}
	sort($res);
	foreach ($res as $str)
	{
		if (!empty($str))
			echo $str,"\n";
	}
?>