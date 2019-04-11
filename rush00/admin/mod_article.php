<?php
	include_once("../tools/const.php");
	include_once("../tools/hash.php");
	include_once("../tools/db.php");
	include_once("../tools/init_page.php");

	initPage("../");

	if ($_SESSION[USER][USER_ID] === USER_ID_NOT_LOGGED)
	{
		header("Location: /user/login.php");
		exit ;
	}
	if ($_SESSION[USER][USER_TYPE] !== USER_TYPE_ADMIN)
	{
		header("Location: /");
		exit ;
	}
?>

<?php
	function mod_article()
	{
		if (($serial_tab = db_get("../Datas/articles.db")) === FALSE)
		{
			header("/error/500.html");
			exit ;
		}
		foreach($serial_tab as $k => $a)
		{
			if ($a[ARTICLE_ID] == $_GET["id"])
			{
				$serial_tab[$k][ARTICLE_NAME] = $_POST[ARTICLE_NAME];
				$serial_tab[$k][ARTICLE_PRICE] = $_POST[ARTICLE_PRICE];
				$serial_tab[$k][ARTICLE_DESCRIPTION] = $_POST[ARTICLE_DESCRIPTION];
				$serial_tab[$k][ARTICLE_PREVIEW] = array($_POST[ARTICLE_PREVIEW]);
				$serial_tab[$k][ARTICLE_CATEGORY] = get_categories();
			}
		}
		if (db_save($serial_tab, "../Datas/articles.db") === FALSE)
		{
			header("Location: /error/500.html");
			exit ;
		}
		header("Location: /admin/panel.php");
		exit ;
	}
?>

<?php
	function get_categories()
	{
		global $db;
		$res = array();
		foreach($_POST as $key => $value)
		{
			if (strstr($key, "category_") !== FALSE)
			{
				$buf = substr($key, 9);
				foreach($db[CATEGORY] as $cat)
				{
					if ($buf === $cat[CATEGORY_NAME])
					{
						$res[] = $buf;
						break ;
					}
				}
			}
		}
		return $res;
	}
?>

<?php
	function check_input()
	{
		if (safe_article_name($_POST[ARTICLE_NAME]) === FALSE)
		{
			echo '<div class="error_msg">Invalid characters in Name</div>'.PHP_EOL;
			return FALSE;
		}
		if (safe_article_description($_POST[ARTICLE_DESCRIPTION]) === FALSE)
		{
			echo '<div class="error_msg">Invalid characters in Description</div>'.PHP_EOL;
			return FALSE;
		}
		if (safe_article_price($_POST[ARTICLE_PRICE]) === FALSE)
		{
			echo '<div class="error_msg">Invalid price : please only use 0.00 numbers</div>'.PHP_EOL;
			return FALSE;
		}
		if (safe_article_category($_POST[ARTICLE_CATEGORY]) === FALSE)
		{
			echo '<div class="error_msg">Invalid category</div>'.PHP_EOL;
			return FALSE;
		}
		return TRUE;
	}
?>

<?php
	if ($_POST["submit"] === "OK")
	{
		if (check_input() === TRUE)
		{
			if (check_input() === TRUE)
				mod_article();
		}
	}
?>

<?php
	if (($serial_tab = db_get("../Datas/articles.db")) === FALSE)
	{
		header("Location: /error/500.html");
		exit ;
	};
	foreach ($serial_tab as $a)
	{
		if (($a[ARTICLE_ID]) == ($_GET["id"]))
			$current_article = $a;
	}
?>

<html>
	<head>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" href="../style/style.css">
		<title>Add Article</title>
	</head>
	<body>
	<div id="header">
	<a href="/"><div id="main_title">Welcome to lego pieces store !</div></a></div>
	<div id="invisible"></div>
	
	<h1 class="form_title">Please fill article informations:</h1>
		<form class="basic_form" action="./mod_article.php?id=<?php echo $_GET["id"]?>" method="POST" target="_self">

			<input class="basic_input" type="text" name="name" placeholder="Name" autofocus required
				<?php echo 'value ="'.$current_article[ARTICLE_NAME].'"';?>
			/>
			<input class="basic_input" type="number" min="0" max="999" step="0.01" name="price" placeholder="Price (USD)" required
				<?php echo 'value ="'.$current_article[ARTICLE_PRICE].'"';?>
			/>
			<input class="basic_input" type="text" name="preview" placeholder="Preview URL" 
				<?php echo 'value ="'.$current_article[ARTICLE_PREVIEW][0].'"';?>
			required/>
			<input class="basic_input" type="text" name="description" placeholder="Description"
				<?php echo 'value ="'.$current_article[ARTICLE_DESCRIPTION].'"';?>
			required/>
					
			<?php
				foreach($db[CATEGORY] as $key => $value)
					echo '<input type="checkbox" class="basic_input basic_checkbox" value="'.$value[CATEGORY_ID].'" name="category_'.$value[CATEGORY_NAME].'"/>'.$value[CATEGORY_NAME];
			?>

			<input class="basic_button" type="submit" name="submit" value="OK" />
		</form>
	</body>

	<script>
		setTimeout(function(){
			document.getElementsByClassName("error_msg")[0].style.opacity = "0";
		}, 2000);
	</script>

</html>