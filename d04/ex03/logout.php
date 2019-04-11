<?php
	if (session_start() == FALSE)
		return ;
	$_SESSION[loggued_on_user] = "";
?>