#!/usr/bin/php
<?php
	function error_format(){echo "Wrong Format\n";}

	if ($argc != 2)
		return ;
	$tab = preg_split("/ /", $argv[1]);

	if (!(preg_match("/^([Ll]undi|[Mm]ardi|[Mm]ercredi|[Jj]eudi)|[Vv]endredi|[Ss]amedi|[Dd]imanche$/", $tab[0])))
		return error_format();
	if (!preg_match("/^\d\d?$/", $tab[1]))
		return error_format();
	if (!preg_match("/^([Jj]anvier|[Ff][eé]vrier|[Mm]ars|[Aa]vril|[Mm]ai|[Jj]uin|[Jj]uillet|[Aa]o[uû]t|[Ss]eptembre|[Oo]ctobre|[Nn]ovembre|[Dd][ée]cembre)$/", $tab[2]))
		return error_format();
	if (!preg_match("/^\d\d\d\d$/", $tab[3]))
		return error_format();
	if (!preg_match("/^\d\d:\d\d:\d\d$/", $tab[4]))
		return error_format();

	$months = array("janvier" => "1", "fevrier" => "2", "mars" => "3", "avril" => "4", "mai" => "5", "juin" => "6", "juillet" => "7", "aout" => "8", "septembre" => "9", "octobre" => "10", "novembre" => "11", "decembre" => "12");
	$tab[2] = strtolower($tab[2]);
	foreach ($months as $key => $value)
	{
		if ($tab[2] == $key)
			$m = $value;
	}

	date_default_timezone_set("Europe/Paris");
	$str = $tab[1]."-".$m."-".$tab[3]." ".$tab[4];
	echo strtotime($str, time()),"\n";
?>