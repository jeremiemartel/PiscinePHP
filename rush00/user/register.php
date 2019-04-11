<?php
	include_once ("../tools/const.php");
	include_once ("../tools/hash.php");
	include_once ("../tools/db.php");
	include_once ("../tools/init_page.php");
	include_once ("../tools/auth.php");
	initPage("../");

	if ($_SESSION[USER][USER_ID] !== USER_ID_NOT_LOGGED)
	{
		header("Location: /");
		exit ;
	}

	/*
		register:
			FALSE: Internal Error
			1: Login already registered
			TRUE: Successfull registration
	*/
	function register()
	{
		$passwd_file = "../Datas/users.db";

		/* Checking arguments */
		if ($_POST['login'] === "" || $_POST['passwd'] === "")
			return FALSE;

		if (($serial_tab = db_get($passwd_file)) === FALSE)
			return FALSE;

		foreach($serial_tab as $user)
			if ($user['login'] === $_POST['login'])
				return (1);

		$new_user = array();
		$new_user[USER_ID] = $serial_tab[count($serial_tab ) - 1][user_id] + 1;
		$new_user[USER_LOGIN] = $_POST[USER_LOGIN];
		$new_user[USER_FNAME] = $_POST[USER_FNAME];
		$new_user[USER_LNAME] = $_POST[USER_LNAME];
		$new_user[USER_PASSWORD] = my_hash($_POST[USER_PASSWORD]);
		$new_user[USER_MAIL] = $_POST[USER_MAIL];
		$new_user[USER_TYPE] = USER_TYPE_CLIENT;

		if (db_add($new_user, $passwd_file) === FALSE)
			return FALSE;
		return ($new_user);
	}

	function register_logIn($passwd_file, $new_user)
	{
		if ($new_user[USER_LOGIN] === "" || $new_user[USER_PASSWORD] === "")
			return FALSE;

		if (($user = auth($new_user[USER_LOGIN], $new_user[USER_PASSWORD], $passwd_file)) === FALSE)
			return (1);
		else
		{
			$basket = $_SESSION[USER][BASKET];
			$_SESSION[USER] = array();
			foreach ($new_user as $key => $value)
					$_SESSION[USER][$key] = $value;
			$_SESSION[USER][BASKET] = $basket;
			return (2);
		}
	}
?>

<?php
	function check_input()
	{
		if (safe_password($_POST["passwd"]) === FALSE)
		{
			echo '<div class="error_msg">Invalid form</div>'.PHP_EOL;
			return FALSE;
		}
		if (safe_login($_POST[USER_LOGIN]) === FALSE)
		{
			echo '<div class="error_msg">Invalid login</div>'.PHP_EOL;
			return FALSE;
		}
		if (safe_name($_POST[USER_FNAME]) === FALSE)
		{
			echo '<div class="error_msg">Invalid First Name</div>'.PHP_EOL;
			return FALSE;
		}
		if (safe_name($_POST[USER_LNAME]) === FALSE)
		{
			echo '<div class="error_msg">Invalid Last Name</div>'.PHP_EOL;
			return FALSE;
		}
		if (safe_mail($_POST[USER_MAIL]) === FALSE)
		{
			echo '<div class="error_msg">Invalid email address</div>'.PHP_EOL;
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
			$passwd_file = "../Datas/users.db";
			$res = register();
			if ($res === FALSE)
			{
				header("Location: /error/500.html");
				exit ;
			}
			else if ($res === 1)
				echo '<div class="error_msg">Username already taken</div>'.PHP_EOL;
			else
			{
				$res[USER_PASSWORD] = $_POST[USER_PASSWORD];
				if (register_logIn($passwd_file, $res) === 2)
				{
					header("Location: /");
					exit ;
				}
				header("Location: /error/500.html");
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
		<h1 class="form_title">Welcome, please register</h1>
		<form class="basic_form" action="./register.php" method="POST" target="_self">
			<input class="basic_input" type="text" name="login" placeholder="login" autofocus required/>
			<input class="basic_input" type="password" name="passwd" placeholder="password" required/>
			<br>
			<input class="basic_input" type="text" name="fname" placeholder="First name" 
					<?php if (!empty($_POST[USER_FNAME])) echo 'value ="'.$_POST[USER_FNAME].'"'; ?>
					required/>
			<input class="basic_input" type="text" name="lname" placeholder="Last name"
					<?php if (!empty($_POST[USER_LNAME])) echo 'value ="'.$_POST[USER_LNAME].'"'; ?>	required/>
			<input class="basic_input" type="email" name="mail" placeholder="Email address"
				<?php if (!empty($_POST[USER_MAIL])) echo 'value ="'.$_POST[USER_MAIL].'"'; ?>
				required/>
			<input class="basic_input basic_button" type="submit" name="submit" value="OK" />
		</form>
	</body>
	<script>
		setTimeout(function(){
			document.getElementsByClassName("error_msg")[0].style.opacity = "0";
		}, 2000);
	</script>
</html>
