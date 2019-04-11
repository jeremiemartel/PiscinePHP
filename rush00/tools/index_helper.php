<?php

function getTotalItems()
{
	$res = 0;
	foreach ($_SESSION[USER][BASKET] as $e)
		$res += $e[BASKET_QUANTITY];
	return ($res);
}

?>
