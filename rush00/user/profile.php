<?php
	//include_once("tools/include.php");

	include_once("../tools/const.php");
	include_once("../tools/db.php");
	include_once("../tools/init_page.php");

	initPage("../");
	
	if ($_SESSION[USER][USER_ID] === USER_ID_NOT_LOGGED)
	{
		header("Location: /user/login.php");
		exit ;
	}
	if (($serial = db_get("../Datas/users.db")) === FALSE)
	{
		header("Location: /error/500.html");
		exit ;
	}
?>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../style/style.css">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<title>My Profile</title>
	</head>

	<body>

<div id="header">
	<a href="/"><div id="main_title">Welcome to lego pieces store !</div></a>
<?php

if ($_SESSION[USER][USER_ID] !== USER_ID_NOT_LOGGED)
{
	echo '<a href="/user/profile.php"><div id="see_profile">Profile</div></a>' . "\n";
	echo '<a href="/user/logout.php"><div id="logout">Logout</div></a>' . "\n";
}
else
{
	echo '<a href="/user/login.php"><div id="login">Login</div></a>' . "\n";
	echo '<a href="/user/register.php"><div id="register">Register</div></a>' . "\n";
}

?>	
</div>

<div id="invisible"></div>

	<div class="profile_container">

		<?php 
			echo "<h1>Welcome, ".$_SESSION[USER][USER_FNAME]."</h1>".PHP_EOL;
			echo '<h3>Here are your personnal datas</h3>'.PHP_EOL;
			echo '<p>Login :      <input class="basic_input" type="text" value="'.$_SESSION[USER][USER_LOGIN].'" disabled/></p>'.PHP_EOL;
			echo '<p>First Name : <input class="basic_input" type="text" value="'.$_SESSION[USER][USER_FNAME].'" disabled/></p>'.PHP_EOL;
			echo '<p>Last Name :  <input class="basic_input" type="text" value="'.$_SESSION[USER][USER_LNAME].'" disabled/></p>'.PHP_EOL;
			echo '<p>Email address : <input class="basic_input" type="mail" value="'.$_SESSION[USER][USER_MAIL].'" disabled/></p>'.PHP_EOL;
			echo '<a href="/user/modify_infos.php"><button class="basic_input basic_button">Modify Informations</button></a><br>';
			echo '<a href="/user/modify_password.php"><button class="basic_input basic_button">Modify Password</button></a><br>';
			if ($_SESSION[USER][USER_TYPE] !== USER_TYPE_CLIENT)
				echo '<a href="/admin/panel.php"><button class="basic_input basic_button">Administration Panel</button></a><br>';
			echo '<a href="/user/delete.php"><button class="basic_input basic_button">Delete my account</button></a>';
		?>

	</div>

	</body>
</html>
