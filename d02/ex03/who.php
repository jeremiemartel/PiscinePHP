#!/usr/bin/php
<?php
	$filename = "/var/run/utmpx";
	$fd = fopen($filename, "r");
	$str = fread($fd, 1256);
	
	date_default_timezone_set("Europe/Paris");
	$res = array();
	while ($str = fread($fd, 628))
		$res[] = unpack("a256user/a4id/a32line/ipid/itype/I2time/a256host/i16pad", $str);
	
	$user_max = 0;
	$line_max = 0;

	foreach($res as $key => $value)
	{
		$value[user] = trim($value[user], "\0");
		$value[line] = trim($value[line], "\0");
		if ($user_max < strlen($value[user]))
			$user_max = strlen($value[user]);
		if ($line_max < strlen($value[line]))
			$line_max = strlen($value[line]);
	}
	function comp($a, $b)
	{
		return ($a[line] > $b[line]);
	}
	usort($res, 'comp');
	foreach($res as $key => $value)
	{
		if ($value[type] != 8)
		{
			$format = "%user_max"."s  ";
			printf("%".$user_max."s  ", trim($value[user]));
			printf("%".$line_max."s  ", trim($value[line]));
			echo date("M d H:i", $value[time1])." \n";
		}
	}
	echo $str;
?>