<?php
session_start();

include_once("./const.php");

if (!isset($_SESSION[USER][USER_ID]))
	header("Location: /");
if (isset($_POST['origin']) && isset($_POST['id']))
{
	$found = FALSE;
	foreach($_SESSION[USER][BASKET] as $k => $e)
	{
		echo $e[ARTICLE_ID] . " : " . $_POST['id'] . "\n";
		if (intval($e[ARTICLE_ID]) === intval($_POST['id']))
		{
			$_SESSION[USER][BASKET][$k][BASKET_QUANTITY] += 1;
			$found = TRUE;
			header("Location: " . $_POST['origin']);
		}
	}
	if (!$found)
		$_SESSION[USER][BASKET][] = array(ARTICLE_ID => $_POST['id'], BASKET_QUANTITY => 1);
	header("Location: " . $_POST['origin']);
}

?>