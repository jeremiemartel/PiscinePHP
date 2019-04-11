<?php
	function auth($login, $passwd)
	{
		$filename = "../htdocs/private/passwd";
		$dir_path = "../htdocs/private";

		/* Opening password file database */
		if (($str = file_get_contents($filename)) === FALSE)
			return FALSE;
		if (($serial_tab = unserialize($str)) === FALSE)
			return FALSE;

		/* Looking for current user*/
		foreach ($serial_tab as $key => $value)
		{
			if ($value[login] === $login)
			{
					if (hash("whirlpool", $passwd) === $value[passwd])
						return TRUE;
					return FALSE;
			}
		}
		return FALSE;
	}
?>