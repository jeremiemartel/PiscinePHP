#!/usr/bin/php
<?php
	function error_format(){echo "Wrong Format\n";}

	if ($argc != 2)
		return ;
	
	if (!($str = file_get_contents($argv[1])))
		return ;

	preg_match_all("/[^\\\]<a.*[^\\\]>.*<\/a>/", $str, $links);
	foreach ($links[0] as $links)
	{
		preg_match_all('/[^\\\]>.*?[^\\\]</', $links, $original);
		foreach($original[0] as $original)
			$str = str_replace($original, $original[0].strtoupper(strchr($original, '>')), $str);
		preg_match_all('/title=".*?[^\\\]"/', $links, $original);
		foreach($original[0] as $original)
		{
			$buff = substr($original, 0, 5).strtoupper(strchr($original, "="));
			$str = str_replace($original, $buff, $str);
		}
	}
	echo $str;
?>