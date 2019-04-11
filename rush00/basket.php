<?php

include_once("tools/const.php");
include_once("tools/db.php");
include_once("tools/init_page.php");
include_once("articles/get_article_element.php");
include_once("tools/index_helper.php");
initPage("");
?>
<html>

<head>
	<title>Lego Piece Store</title>
	<link rel="stylesheet" href="style/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>

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
</div></div></div>

<div id="header">
	<a href="/"><div id="main_title">Welcome to lego pieces store !</div></a>
<?php

if ($_SESSION[USER][USER_ID] !== USER_ID_NOT_LOGGED)
{
	echo "<div id='welcome'>Welcome " . $_SESSION[USER][USER_LOGIN] . " !</div>\n";
	echo '<a href="user/profile.php"><div id="see_profile">Profile</div></a>' . "\n";
	echo '<a href="user/logout.php"><div id="logout">Logout</div></a>' . "\n";
}
else
{
	echo '<a href="user/login.php"><div id="login">Login</div></a>' . "\n";
	echo '<a href="user/register.php"><div id="register">Register</div></a>' . "\n";
}

?>	
</div>

<div id="invisible"></div>

<div class="basket_showcase">

<?php

$totalPrice = 0;
foreach ($_SESSION[USER][BASKET] as $e)
{
	echo getBasketElement(getArticleById(intval($e[ARTICLE_ID])), "", intval($e[BASKET_QUANTITY]), 'basket.php');
	$totalPrice += floatval(getArticleById(intval($e[ARTICLE_ID]))[ARTICLE_PRICE]) * intval($e[BASKET_QUANTITY]);
}

?>

</div>

<div class="total_price article_price">Total :
<?php
echo $totalPrice . '$</div>';
if ($totalPrice > 0)
	echo '<div class="confirm_order article_price"><a href="/tools/confirm_order.php">Confirm Order</a></div>';
?>


</body></html>