<?php

	if (session_start() === FALSE)
		exit ;
	if ($_GET[submit] === "OK")
	{
		$_SESSION[login] = $_GET[login];
		$_SESSION[passwd] = $_GET[passwd];
	}
?>

<h1>Please identify</h1>
<form action="index.php" method="get" target="_self">
	<p>Login : <input		type="text"		name="login"	title="login"	placeholder="login"		value="<?php echo $_SESSION[login]?>"	autofocus/></p>
	<p>Password : <input	type="password"	name="passwd"	title="passwd"	placeholder="passwd"	value="<?php echo $_SESSION[passwd]?>"/></p>
	<p><input type="submit" value="OK" name="submit"/> </p>
</form>
