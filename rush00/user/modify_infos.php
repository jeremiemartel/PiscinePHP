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
			$db_path = "../Datas/users.db";
			foreach ($db[USER] as $k => $v)
				if ($v[USER_ID] === $_SESSION[USER][USER_ID])
					$user_key = $k;
			$db[USER][$user_key][USER_FNAME] = $_POST[USER_FNAME];
			$db[USER][$user_key][USER_LNAME] = $_POST[USER_LNAME];
			$db[USER][$user_key][USER_MAIL] = $_POST[USER_MAIL];
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
		<title>Create Account</title>
	</head>
	<body>
		<div id="header">
	<a href="/"><div id="main_title">Welcome to lego pieces store !</div></a></div>
	<div id="invisible"></div>

		<h1 class="form_title">Here are your personnal informations</h1>
		<form class="basic_form" action="./modify_infos.php" method="POST" target="_self">
			
			<input class="basic_input" type="text" name="fname" placeholder="First name" 
					<?php echo 'value ="'.$_SESSION[USER][USER_FNAME].'"'; ?>
					required autofocus/>

			<input class="basic_input" type="text" name="lname" placeholder="Last name"
					<?php echo 'value ="'.$_SESSION[USER][USER_LNAME].'"'; ?>
					required/>
			<input class="basic_input" type="email" name="mail" placeholder="Email address"
					<?php echo 'value ="'.$_SESSION[USER][USER_MAIL].'"'; ?>
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
