<?php
session_start();

include_once("./const.php");
include_once("./db.php");

if (!isset($_SESSION[USER][USER_ID]) || count($_SESSION[USER][BASKET]) < 1)
	header("Location: /");
else if ($_SESSION[USER][USER_ID] === USER_ID_NOT_LOGGED)
	header("Location: /user/login.php?error=order");
else
{
	$order = array();
	$order[ORDER_ID] = count($db[ORDER]);
	$order[ORDER_USER_ID] = $_SESSION[USER][USER_ID];
	$order[BASKET] = $_SESSION[USER][BASKET];
	$order[ORDER_TIME] = time();
	
	$_SESSION[USER][BASKET] = array();
	db_add($order, "../Datas/orders.db");
	header("Location: /");
}

?>