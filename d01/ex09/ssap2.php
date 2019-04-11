#!/usr/bin/php
<?php
	function ssap_sorting($a, $b)
	{
		$a = strtolower($a);
		$b = strtolower($b);
		$i = 0;
		while ($a[$i] == $b[$i] && $a[$i] && $b[$i])
			$i++;

		if ($a[$i] >= 'a' && $a[$i] <= 'z')
			$wa = 0 + ord($a[$i]);
		else if ($a[$i] >= '0' && $a[$i] <= '9')
			$wa = 300 + ord($a[$i]);
		else
			$wa = 600 + ord($a[$i]);

		if ($b[$i] >= 'a' && $b[$i] <= 'z')
			$wb = 0 + ord($b[$i]);
		else if ($b[$i] >= '0' && $b[$i] <= '9')
			$wb = 300 + ord($b[$i]);
		else
			$wb = 600 + ord($b[$i]);
		return ($wa - $wb);
	}

	if ($argc == 1)
		return ;

	// Trimming and splitting every words in the tab array
	$tab = array();
	$i = 1;
	while ($i < $argc)
	{
		$argv[$i] = trim($argv[$i]);
		$tab = array_merge($tab, preg_split("/ +/", $argv[$i]));
		$i++;
	}

	if (empty($tab[0]))
		return ;

	usort($tab, 'ssap_sorting');

	foreach ($tab as $str)
		echo $str,"\n";
?>