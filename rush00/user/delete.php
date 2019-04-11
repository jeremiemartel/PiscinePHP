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
	if ($_GET[submit] === "OK")
	{
		db_del_elem("../Datas/users.db", USER_ID, $_SESSION[USER][USER_ID]); // Protection ??
		session_unset();
		header("Location: /index.php");
		exit ;
	}
	else if ($_GET[submit] == "NO")
		header("Location: /user/profile.php");
?>
<html>
	<head>
		<title>Delete User</title>
	</head>
	<body>
		<h1>Delete Profile</h1>
		<h2>You are about to Delete your profile, and all datas stored on our Website<br/>
			Are you sure ?
		</h2>
		<form action="delete.php" method="get">
			<input type="submit" name="submit" value="OK"/>
			<input type="submit" name="submit" value="NO" autofocus/>
		</form>
	</body>
</html>