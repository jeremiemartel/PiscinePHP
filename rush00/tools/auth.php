<?php

	function auth($login, $passwd, $passwd_file)
	{
		/* Opening password file database */
		if (($str = file_get_contents($passwd_file)) === FALSE)
			return FALSE;
		if (($serial_tab = unserialize($str)) === FALSE)
			return FALSE;

		/* Looking for current user*/
		foreach ($serial_tab as $key => $value)
		{
			if ($value[USER_LOGIN] === $login)
			{
					if (my_hash($passwd) === $value[USER_PASSWORD])
						return $value;
					return FALSE;
			}
		}
		return FALSE;
	}
?>
