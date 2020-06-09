<?php
	include_once ("../tools/const.php");
	include_once ("../tools/hash.php");
	include_once ("../tools/auth.php");
	include_once ("../tools/db.php");
	include_once ("../tools/init_page.php");
	initPage("../");

	if ($_SESSION[USER][USER_ID] !== USER_ID_NOT_LOGGED)
	{
		header("Location: /");
		exit ;
	}
	if ($_GET["error"] === "order")
		echo '<div class="error_msg">You need to log in to validate an order</div>'.PHP_EOL;
?>

<?php
	/*
	Return Value:
		FALSE => internal Error
		1 => Invalid couple login / passwd
		2 => Authentification successfull
	*/
	function logIn($passwd_file)
	{
		if ($_POST[USER_LOGIN] === "" || $_POST[USER_PASSWORD] === "")
			return FALSE;

		if (($user = auth($_POST[USER_LOGIN], $_POST[USER_PASSWORD], $passwd_file)) === FALSE)
			return (1);
		else
		{
			$basket = $_SESSION[USER][BASKET];
			$_SESSION[USER] = array();
			foreach ($user as $key => $value)
					$_SESSION[USER][$key] = $value;
			$_SESSION[USER][BASKET] = $basket;
			return (2);
		}
	}
?>

<?php
	function check_input()
	{
		if (safe_login($_POST[USER_LOGIN]) === FALSE)
		{
			echo '<div class="error_msg">Invalid characters in Login</div>'.PHP_EOL;
			return FALSE;
		}
		if (safe_password($_POST["passwd"]) === FALSE)
		{
			echo '<div class="error_msg">Invalid form</div>'.PHP_EOL;
			return FALSE;
		}
		return TRUE;
	}
?>

<?php
	if ($_POST["submit"] === "OK")
	{
		if (check_input() === TRUE)
		{
			$res = logIn("../Datas/users.db");
			if ($res === 1)
				echo '<div class="error_msg">Invalid Password</div>'.PHP_EOL;
			else if ($res === 2)
			{
				header("Location: /");
				exit ;
			}
			else
			{
				header("Location: /error/500.html");
				exit();
			}
		}
	}
?>

<html>
	<head>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" href="../style/style.css">
		<title>Create Account</title>
	</head>
	<body>
		<div id="header">
	<a href="/"><div id="main_title">Welcome to lego pieces store !</div></a></div>
	<div id="invisible"></div>
		<h1 class="form_title">Welcome, please login</h1>
		<form action="./login.php" method="POST" target="_self" class="basic_form">
			<input class="basic_input" type="text" name="login" placeholder="login" <?php if (empty($_POST["login"])) echo "autofocus"; else echo 'value="'.$_POST["login"].'"'; ?> required/>
			<input class="basic_input" type="password" name="passwd" <?php if (!empty($_POST["login"])) echo "autofocus"; ?> placeholder="password" required/>
			<input class="basic_input basic_button" type="submit" name="submit" value="OK" />
		</form>
	</body>
	<script>
		setTimeout(function(){
			document.getElementsByClassName("error_msg")[0].style.opacity = "0";
		}, 2000);
	</script>
</html>
