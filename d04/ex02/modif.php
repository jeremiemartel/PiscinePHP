<?php
	function error($str = ""){echo "ERROR".$str.PHP_EOL;}
	function look_user($serial_tab, $user){
		foreach ($serial_tab as $key => $value)
			if ($value[login] === $user[login])
				return ($key);
		return (FALSE);
	}

	$filename = "../htdocs/private/passwd";
	$dir_path = "../htdocs/private";

	/* Checking arguments */
	if ($_POST[submit] !== "OK" || $_POST[login] == "" || $_POST[oldpw] == "" || $_POST[newpw] == "")
		return error();
	
	/* Opening password file database */
	if (($str = file_get_contents($filename)) === FALSE)
		return error();
	if (($serial_tab = unserialize($str)) === FALSE)
		return error();

	/* Creating new user array */
	$new_tab[login] = $_POST[login];
	$new_tab[passwd] = hash("whirlpool", $_POST[oldpw]);

	/* Looking for current user*/
	if (($user_key = look_user($serial_tab, $new_tab)) === FALSE)
		return error();

	/* Modifying password if old one is good */
	if ($serial_tab[$user_key][passwd] !== $new_tab[passwd])
		return error();
	$serial_tab[$user_key][passwd] = hash("whirlpool", $_POST[newpw]);

	/* Saving new value in file */
	$str = serialize($serial_tab);
	if (file_put_contents($filename, $str) == FALSE)
		return error();

	/* Sending answer */
	echo "OK".PHP_EOL;
?>