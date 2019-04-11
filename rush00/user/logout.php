<?php
	session_start();

	function logOut()
	{
		session_unset();
		header("Location: /");
	}
	logOut();
?>
