<?php
	include_once("../tools/const.php");
	include_once("../tools/db.php");
	include_once("../tools/init_page.php");

	initPage("../");

	if ($_SESSION[USER][USER_ID] === USER_ID_NOT_LOGGED)
	{
		header("Location: /user/login.php");
		exit ;
	}
	if ($_SESSION[USER][USER_TYPE] !== USER_TYPE_ADMIN)
	{
		header("Location: /");
		exit ;
	}

	if ($_POST["db"] === "user")
	{
		$db_path = "../Datas/users.db";
		$id = USER_ID;
	}
	else if ($_POST["db"] === "article")
	{
		$db_path = "../Datas/articles.db";
		$id = ARTICLE_ID;
	}
	else if ($_POST["db"] === "category")
	{
		$db_path = "../Datas/category.db";
		$id = CATEGORY_ID;
	}
	else if ($_POST["db"] === "orders")
	{
		$db_path = "../Datas/orders.db";
		$id = ORDER_ID;
	}
	else
	{
		header("Location: /error/500.html");
		exit ;
	}

	if ($_POST["action"] === "add")
	{
		header("Location: ./add_".$_POST["db"].'.php');
		exit ;
	}
	else if ($_POST["action"] === "del")
	{
		if (db_del_elem($db_path, $id, $_POST["id"]) === FALSE)
		{
			header("Location: /error/550.html");
			exit ;
		}
	}
	else if ($_POST["action"] === "mod" && ($_POST["db"] === "article"))
	{
		header("Location: ./mod_".$_POST["db"].'.php?id='.$_POST["id"]);
		exit ;
	}
	header("Location: /admin/panel.php");
?>