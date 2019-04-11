<?php
	include_once("auth.php");
	function error($str = ""){echo "ERROR".$str.PHP_EOL;}

	if ($_GET[login] == "" || $_GET[passwd] == "")
		return error();

	if (session_start() == FALSE)
		return error();

	if (auth($_GET[login], $_GET[passwd]) == TRUE)
	{
		$_SESSION[loggued_on_user] = $_GET[login];
		echo "OK".PHP_EOL;
		return ;
	}
	else
	{
		$_SESSION[loggued_on_user] = "";
		return error();
	}
?>