<?php
	if (session_start() == FALSE)
		return error();

	if ($_SESSION[loggued_on_user] == "")
		echo "Error".PHP_EOL;
	else
		echo $_SESSION[loggued_on_user].PHP_EOL;
?>