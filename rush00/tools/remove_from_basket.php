<?php
session_start();

include_once("./const.php");

if (!isset($_SESSION[USER][USER_ID]))
	header("Location: /");
if (isset($_POST['origin']) && isset($_POST['id']))
{
	foreach($_SESSION[USER][BASKET] as $k => $e)
	{
		if (intval($e[ARTICLE_ID]) === intval($_POST['id']))
		{
			$_SESSION[USER][BASKET][$k][BASKET_QUANTITY] -= 1;
			if (intval($_SESSION[USER][BASKET][$k][BASKET_QUANTITY]) === 0)
				$_SESSION[USER][BASKET] = \array_diff_key($_SESSION[USER][BASKET], [$k => ""]);
			header("Location: /" . $_POST['origin']);
		}
	}
}

?>