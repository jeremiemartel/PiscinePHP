<?php

session_start();

$db = [];

// Mettre a jour les infos du user dans la session

function verifyLogin()
{
	global $db;
	foreach($db[USER] as $e)
	{
		if (intval($e[USER_ID]) === intval($_SESSION[USER][USER_ID]))
		{
			if ($e[USER_LOGIN] === $_SESSION[USER][USER_LOGIN])
				return TRUE;
			else
				return FALSE;
		}
	}
	return FALSE;
}

function getCurrentUser()
{
	global $db;
	foreach($db[USER] as $e)
	{
		if (intval($e[USER_ID]) === intval($_SESSION[USER][USER_ID]))
			return $e;
	}
}

function initPage($path = "")
{
	if (!isset($_SESSION[USER]))
	{
		$_SESSION[USER] = array();
		$_SESSION[USER][USER_ID] = USER_ID_NOT_LOGGED;
		$_SESSION[USER][USER_LOGIN] = "no_login";
		$_SESSION[USER][USER_FNAME] = "";
		$_SESSION[USER][USER_LNAME] = "";
		$_SESSION[USER][USER_MAIL] = "";
		$_SESSION[USER][USER_TYPE] = USER_TYPE_CLIENT;
		$_SESSION[USER][BASKET] = array();
	}

	// Verif DB
	global $db;

	$db[ARTICLE] = db_get($path . "Datas/articles.db");
	$db[USER] = db_get($path . "Datas/users.db");
	$db[CATEGORY] = db_get($path . "Datas/category.db");
	$db[ORDER] = db_get($path . "Datas/orders.db");	

	if ($db[ARTICLE] === FALSE || $db[USER] === FALSE || $db[CATEGORY] === FALSE || $db[ORDER] === FALSE)
		header("Location: /error/500.html");

	// Check if current user still exists
	if (!verifyLogin() && $_SESSION[USER][USER_ID] !== USER_ID_NOT_LOGGED)
	{
		$_SESSION = [];
		header("Location: /");
	}
	else
	{
		$usr = getCurrentUser();
		$_SESSION[USER][USER_FNAME] = $usr[USER_FNAME];
		$_SESSION[USER][USER_LNAME] = $usr[USER_LNAME];
		$_SESSION[USER][USER_MAIL] = $usr[USER_MAIL];
	}
}

function safe_name($str)
{
	if (!isset($str) || empty($str))
		return FALSE;
	if (preg_match("/^[a-zA-Z]+$/", $str) === 1)
		return TRUE;
	return FALSE;
}

function safe_login($str)
{
	if (!isset($str) || empty($str))
		return FALSE;
	if (preg_match("/^\w+$/", $str) === 1)
		return TRUE;
	return FALSE;
}

function safe_user_type($type)
{
	print_r($type);
	if (intval($type) === intval(USER_TYPE_CLIENT))
		return TRUE;
	if (intval($type) === intval(USER_TYPE_SELLER))
		return TRUE;
	if (intval($type) === intval(USER_TYPE_ADMIN))
		return FALSE;
	return FALSE;
}

function safe_mail($str)
{
	if (!isset($str) || empty($str))
		return FALSE;
	if (preg_match("/^[\w.-]+\@[\w.]+.\w+$/", $str) === 1)
		return TRUE;
	return FALSE;
}

function safe_article_name($str)
{
	if (!isset($str) || empty($str))
		return FALSE;
	if (preg_match("/^[\w\s-]+$/", $str) === 1)
		return TRUE;
	return (FALSE);
}

function safe_article_price($str)
{
	if (!isset($str) || empty($str))
		return FALSE;
	if (preg_match("/^[\d]{1,3}(\.\d\d)?$/", $str) === 1)
		return TRUE;
	return FALSE;
}

function safe_article_description($str)
{
	if (!isset($str) || empty($str))
		return FALSE;
	if (preg_match("/^[\w\s]+$/", $str) === 1)
		return TRUE;
	return (FALSE);
}

function safe_article_category($str)
{
	return TRUE;
}

function safe_id($str, $db_name, $key_looked)
{
	global $db;

	if (!isset($str) || empty($str))
		return FALSE;
	foreach ($db[$db_name][$key_looked] as $value)
	{
		if ($str === $value)
			return (TRUE);
	}
	return FALSE;
}

function safe_password($string)
{
	if (!isset($string))
		return FALSE;
	if (empty($string))
		return FALSE;
}

?>
