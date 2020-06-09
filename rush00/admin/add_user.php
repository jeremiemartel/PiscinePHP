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
		if (($serial_tab = db_get("../Datas/users.db")) === FALSE)
		{
			header("/error/500.html");
			exit ;
		}
		$new_user = array();
		$new_user[USER_ID] = $serial_tab[count($serial_tab ) - 1][USER_ID] + 1;
		$new_user[USER_LOGIN] = $_POST[USER_LOGIN];
		$new_user[USER_FNAME] = $_POST[USER_FNAME];
		$new_user[USER_LNAME] = $_POST[USER_LNAME];
		$new_user[USER_PASSWORD] = my_hash($_POST[USER_PASSWORD]);
		$new_user[USER_MAIL] = $_POST[USER_MAIL];
		$new_user[USER_TYPE] = $_POST[USER_TYPE];
		$serial_tab[] = $new_user;
		if (db_save($serial_tab, "../Datas/users.db") === FALSE)
		{
			header("Location: /error/500.html");
			exit ;
		}
		header("Location: /admin/panel.php");
		exit ;
	}

	function check_input()
	{
		if (safe_user_type($_POST[USER_TYPE]) === FALSE)
		{
			echo '<div class="error_msg">Invalid user permissions</div>'.PHP_EOL;
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

	if ($_POST["submit"] === "OK")
	{
		if (check_input() === TRUE)
		{
			if (db_get_elem("../Datas/users.db", USER_LOGIN, $_POST[USER_LOGIN]) !== FALSE)
				echo '<div class="error_msg">Username already taken</div>'.PHP_EOL;
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
		<title>Add User</title>
	</head>
	<body>
	<div id="header">
	<a href="/"><div id="main_title">Welcome to lego pieces store !</div></a></div>
	<div id="invisible"></div>
	
	<h1 class="form_title">Please fill new user informations:</h1>
		<form class="basic_form" action="./add_user.php" method="POST" target="_self">
			<select class="basic_input basic_button" name="type">
		    		<option value="<?php echo USER_TYPE_CLIENT;?>"> Client</option>
    				<option value="<?php echo USER_TYPE_SELLER;?>"> Seller</option>
            	</select>
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