<?php
	include_once("tools/const.php");
	include_once("tools/db.php");
	include_once("tools/init_page.php");

	initPage("");
	echo "<h1>Users DataBase</h1>";
	foreach($db[USER] as $user)
		echo "<p>id : ".$user[USER_ID].", login : ".$user[USER_LOGIN]."  permissions : ".$user[USER_TYPE]."</p>";

	echo "<h1>Articles DataBase</h1>";
	foreach($db[ARTICLE] as $user)
		{
			echo "<p>".$user[ARTICLE_ID]." : ".$user[ARTICLE_NAME].'  <img src="'.$user[ARTICLE_PREVIEW][0].'" alt="preview" style="width:20px;height=20px"/>';
			foreach ($user[ARTICLE_CATEGORY] as $value)
				echo $value.'   ';
			echo "</p>";
		}
?>