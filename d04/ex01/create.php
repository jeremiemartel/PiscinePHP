<?php
	function error($str = ""){echo "ERROR".$str.PHP_EOL;}
	$filename = "../htdocs/private/passwd";
	$dir_path = "../htdocs/private";
	/* Checking arguments */
	if ($_POST[submit] !== "OK" || $_POST[login] == "" || $_POST[passwd] == "")
		return error();

	/* Checking for file directory */
	if (!file_exists($dir_path))
		if (mkdir($dir_path, 0777, TRUE) == FALSE)
			return error();

	/* Opening password file database */
	if (file_exists($filename))
	{
		if (($str = file_get_contents($filename)) === FALSE)
			return error();
		if ($str === "")
			$serial_tab = [];
		else if (($serial_tab = unserialize($str)) === FALSE)
			return error();
	}
	else
		$serial_tab = [];

	/* Creating new user array */
	$new_tab[login] = $_POST[login];
	$new_tab[passwd] = hash("whirlpool", $_POST[passwd]);

	/* Checking that user do not already exist */
	foreach ($serial_tab as $user)
		if ($user[login] == $_POST[login])
			return error(": User already exist");

	/* Adding user, and saving in file */
	$serial_tab[] = $new_tab;
	$str = serialize($serial_tab);
	if (file_put_contents($filename, $str) == FALSE)
		return error();

	/* Sending answer */
	echo "OK".PHP_EOL;
?>