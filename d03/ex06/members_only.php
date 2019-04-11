<?php
	if (!strcmp($_SERVER["PHP_AUTH_USER"], "zaz") && !strcmp($_SERVER["PHP_AUTH_PW"], "jaimelespetitsponeys"))
		{
			header("Content-type: text/html");
			$string = file_get_contents("../img/42.png");
			$string = base64_encode($string);
			echo "<html><title>Welcome</title><body><h1>Bonjour Zaz<h1><br />";
			echo "<img src='data:image/png;base64,".$string."'>";
			echo "</body></html>";
			exit ;
		}
		header("Content-type: text/html;charset=utf-8");
?>
<html><body>Cette zone est accessible uniquement aux membres du site</body></html>
