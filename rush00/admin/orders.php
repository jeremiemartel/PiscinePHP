<?php

include_once("../tools/const.php");
include_once("../tools/db.php");
include_once("../tools/init_page.php");
include_once("../articles/get_article_element.php");
include_once("../tools/index_helper.php");
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
<html>

<head>
	<title>Lego Piece Store</title>
	<link rel="stylesheet" href="../style/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>

<div id="basket"><div id="basket_logo"><div id="article_count">
<?php
echo getTotalItems() . "\n";
?>
</div></div></div>

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

function getArticlebyId($id)
{
	global $db;
	foreach ($db[ARTICLE] as $e)
		if (intval($e[ARTICLE_ID]) === $id)
			return $e;
		return FALSE;
}

function getUsernameById($id)
{
	global $db;
	foreach ($db[USER] as $e)
		if (intval($e[USER_ID]) === intval($id))
			return $e[USER_LOGIN];
}

date_default_timezone_set("Europe/Paris");

foreach($db[ORDER] as $x => $o)
{
	if (intval($o[ORDER_USER_ID]) !== -2)
	{
		$totalPrice = 0;
		echo '<div class="separator">';
		echo 'Ordered by ' . getUsernameById($o[ORDER_USER_ID]) . ' on ' . date("F jS Y H:i", intval($o[ORDER_TIME])) . '</div>';
		echo '<div class="basket_showcase">';
		foreach ($o[BASKET] as $k => $e)
		{
			echo getBasketElement(getArticleById(intval($e[ARTICLE_ID])), "", intval($e[BASKET_QUANTITY]), 'basket.php', FALSE);
			$totalPrice += floatval(getArticleById(intval($e[ARTICLE_ID]))[ARTICLE_PRICE]) * intval($e[BASKET_QUANTITY]);
			echo '<form action="remove_from_order.php" method="post">';
			echo '<input style="display: none" name="id" value="'.$x.'">';
			echo '<input style="display: none" name="article_id" value="'.$e[ARTICLE_ID].'">';
			echo '<input type="submit" class="remove_basket" name="submit" value="X">';
			echo '</form>';
		}
		echo '</div>';
		echo '<div class="total_price article_price">Total :' . $totalPrice . '$</div>';
	}
}

?>


</body></html>