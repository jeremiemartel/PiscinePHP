<?php
	include_once ("../tools/const.php");
	include_once ("../tools/hash.php");
	include_once ("../tools/auth.php");
	include_once ("../tools/db.php");
	include_once ("../tools/init_page.php");
	initPage("../");

	if ($_SESSION[USER][USER_ID] === USER_ID_NOT_LOGGED)
	{
		header("Location: /user/login.php");
		exit ;
	}
?>


<?php
	function check_input()
	{
		if (safe_password($_POST["oldpw"]) === FALSE || safe_password($_POST["newpw"]) === FALSE || safe_password($_POST["conf_newpw"]) === FALSE)
		{
			echo '<div class="error_msg">Invalid form, contact administrators</div>'.PHP_EOL;
			return FALSE;
		}
		$path = "../Datas/users.db";
		$hashed_old = my_hash($_POST["oldpw"]);
		if (($serial_tab = db_get($path)) === FALSE)
		{
			header("Location: /error/500.html");
			exit ;
		}
		$user = FALSE;
		foreach($serial_tab as $u)
			if ($u[USER_ID] === $_SESSION[USER][USER_ID])
				$user = $u;
		if ($user === FALSE)
		{
			header("Location: /error/500.html");
			exit ;
		}
		if ($hashed_old !== $user[USER_PASSWORD])
		{
			echo '<div class="error_msg">Your password is wrong</div>'.PHP_EOL;
			return FALSE;
		}
		if ($_POST["conf_newpw"] !== $_POST["newpw"])
		{
			echo '<div class="error_msg">Passwords are not the same</div>'.PHP_EOL;
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
			$db_path = "../Datas/users.db";
			foreach ($db[USER] as $k => $v)
				if ($v[USER_ID] === $_SESSION[USER][USER_ID])
					$user_key = $k;
			$db[USER][$user_key][USER_PASSWORD] = my_hash($_POST["newpw"]);
			if (db_save($db[USER], $db_path) === FALSE)
			{
				header("Location: /error/500.html");
				exit ;
			}
			header ("Location: /user/profile.php");
			exit ;
		}
	}
?>


<html>
	<head>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" href="../style/style.css">
		<title>Change your password</title>
	</head>
	<body>
		<div id="header">
	<a href="/"><div id="main_title">Welcome to lego pieces store !</div></a></div>
	<div id="invisible"></div>

		<h1 class="form_title">Please set your password </h1>
		<form class="basic_form" action="./modify_password.php" method="POST" target="_self">
			
			<input class="basic_input" type="password" name="oldpw" placeholder="Old Password"required autofocus/>
			<input class="basic_input" type="password" name="newpw" placeholder="New Password"required/>
			<input class="basic_input" type="password" name="conf_newpw" placeholder="Please Confirm"required/>

			<input class="basic_input basic_button" type="submit" name="submit" value="OK" />
		</form>
	</body>

	<script>
		setTimeout(function(){
			document.getElementsByClassName("error_msg")[0].style.opacity = "0";
		}, 2000);
	</script>
</html>