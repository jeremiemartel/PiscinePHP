<?php

include_once("../tools/const.php");
include_once("../tools/db.php");
include_once("../tools/init_page.php");
include_once("./get_article_element.php");
include_once("../tools/index_helper.php");
initPage("../");
?>
<html>

<head>
	<title>Lego Piece Store</title>
	<link rel="stylesheet" href="../style/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<a href="/basket.php">
<div id="basket"><div id="basket_logo"><div id="article_count">
<?php
function getArticlebyId($id)
{
	global $db;
	foreach ($db[ARTICLE] as $e)
		if (intval($e[ARTICLE_ID]) === $id)
			return $e;
		return FALSE;
}

$totalPrice = 0;
foreach ($_SESSION[USER][BASKET] as $e)
	$totalPrice += floatval(getArticleById(intval($e[ARTICLE_ID]))[ARTICLE_PRICE]) * intval($e[BASKET_QUANTITY]);
echo '<div class="basket_cost">' . $totalPrice . '$</div>';
echo getTotalItems() . "\n";
?>
</div></div></div></a>

<div id="header">
	<a href="/"><div id="main_title">Welcome to lego pieces store !</div></a>
<?php

if ($_SESSION[USER][USER_ID] !== USER_ID_NOT_LOGGED)
{
	echo "<div id='welcome'>Welcome " . $_SESSION[USER][USER_LOGIN] . " !</div>\n";
	echo '<a href="/user/profile.php"><div id="see_profile">Profile</div></a>' . "\n";
	echo '<a href="/user/logout.php"><div id="logout">Logout</div></a>' . "\n";
}
else
{
	echo '<a href="/user/login.php"><div id="login">Login</div></a>' . "\n";
	echo '<a href="/user/register.php"><div id="register">Register</div></a>' . "\n";
}

?>
</div>

<div id="invisible"></div>

<?php

function getCategoryName($i)
{
	global $db;
	foreach ($db[CATEGORY] as $e)
	{
		if (intval($e[CATEGORY_ID]) === intval($i))
			return ($e[CATEGORY_NAME]);
	}
	return FALSE;
	
}

function date_sort($a, $b)
{
	if ($a[ARTICLE_ADDTIME] > $b[ARTICLE_ADDTIME])
		return 1;
	else if ($a[ARTICLE_ADDTIME] < $b[ARTICLE_ADDTIME])
		return -1;
	return 0;
}

function getUsernameById($id)
{
	global $db;
	foreach ($db[USER] as $e)
		if (intval($e[USER_ID]) === intval($id))
			return $e[USER_LOGIN];
}

$hasFound = FALSE;

if (isset($_GET['id']))
{
	date_default_timezone_set("Europe/Paris");
	foreach($db[ARTICLE] as $e)
	{
		if (intval($e[ARTICLE_ID]) === intval($_GET['id']))
		{
			echo getArticleElement($e, "../", $_SERVER['REQUEST_URI']);
			echo '<div class="description">' . $e[ARTICLE_DESCRIPTION] . '</div>';
			echo '<div class="added_date">Added by ' . getUsernameById($e[ARTICLE_SELLER]) . ' on ' . date("F jS Y H:i", intval($e[ARTICLE_ADDTIME])) . '</div>';
		}
	}
}
else if (isset($_GET['sort']))
{
	if ($_GET['sort'] === "category")
	{
		foreach($db[CATEGORY] as $e)
		{
			echo '<div class="separator blue">'.$e[CATEGORY_NAME].'</div>';
			echo '<div class="showcase">';
			foreach($db[ARTICLE] as $a)
			{
				foreach($a[ARTICLE_CATEGORY] as $c)
				{
					if ($c === $e[CATEGORY_NAME])
						echo getArticleElement($a, "../", $_SERVER['REQUEST_URI']);
				}
			}
			echo '</div>';
		}
	}
	else if ($_GET['sort'] === "date")
	{
		echo '<div class="separator blue">All Articles sort by date</div>';
		echo '<div class="showcase">';
		usort($db[ARTICLE], "date_sort");
		foreach($db[ARTICLE] as $e)
			echo getArticleElement($e, "../", $_SERVER['REQUEST_URI']);
		echo '</div>';
	}
}
else if (isset($_GET['category']))
{
	$name = getCategoryName($_GET['category']);
	foreach($db[ARTICLE] as $e)
	{
		foreach($e[ARTICLE_CATEGORY] as $cat)
		{
			if ($cat === $name)
			{
				if (!$hasFound)
				{
					echo '<div class="separator">Results for category "';
					echo $name;
					echo '":</div>';
					echo '<div class="showcase">';
					$hasFound = TRUE;
				}	
				echo getArticleElement($e, "../", $_SERVER['REQUEST_URI']);
			}
		}
	}
}
if ($hasFound)
	echo '</div>';

?>

</html></body>

