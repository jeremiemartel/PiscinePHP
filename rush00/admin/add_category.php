<?php
	include_once("../tools/const.php");
	include_once("../tools/hash.php");
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

	function create_user()
	{
		if (($serial_tab = db_get("../Datas/category.db")) === FALSE)
		{
			header("Location: /error/500.html");
			exit ;
		}
		$new_user = array();
		$new_user[CATEGORY_ID] = $serial_tab[count($serial_tab ) - 1][CATEGORY_ID] + 1;
		$new_user[CATEGORY_NAME] = $_POST[CATEGORY_NAME];
		$serial_tab[] = $new_user;
		if (db_save($serial_tab, "../Datas/category.db") === FALSE)
		{
			header("Location: /error/500.html");
			exit ;
		}
		header("Location: /admin/panel.php");
		exit ;
	}

	function check_input()
	{
		if (safe_name($_POST[CATEGORY_NAME]) === FALSE)
		{
			echo '<div class="error_msg">Invalid characters in name</div>'.PHP_EOL;
			return FALSE;
		}
		return TRUE;
	}

	if ($_POST["submit"] === "OK")
	{
		if (check_input() === TRUE)
		{
			if (db_get_elem("../Datas/category.db", CATEGORY_NAME, $_POST[CATEGORY_NAME]) !== FALSE)
				echo '<div class="error_msg">Name already taken</div>'.PHP_EOL;
			else
				create_user();
		}
	}
?>

<html>
	<head>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" href="../style/style.css">
		<title>Add Category</title>
	</head>
	<body>
	<div id="header">
	<a href="/"><div id="main_title">Welcome to lego pieces store !</div></a></div>
	<div id="invisible"></div>
	
	<h1 class="form_title">Please fill new Category informations:</h1>
		<form class="basic_form" action="./add_category.php" method="POST" target="_self">
			<input class="basic_input" type="text" name="category_name" placeholder="Name" autofocus required/>
			<input class="basic_input basic_button" type="submit" name="submit" value="OK" />
		</form>
	</body>

	<script>
		setTimeout(function(){
			document.getElementsByClassName("error_msg")[0].style.opacity = "0";
		}, 2000);
	</script>

</html>