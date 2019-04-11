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

<div id="hero_zone"><div class="hero_back"></div><div class="catch_phrase">Here you can find any piece you're missing</div></div>


<div class="search_container">
<div class="search_title">Search by category:</div><br>
<div class="category_select">
<?php

foreach ($db[CATEGORY] as $e)
	echo '<a href="/articles/?category='.$e[CATEGORY_ID].'"><button>'.$e[CATEGORY_NAME].'</button></a>';

?>
</div></div>


<div class="search_container">
<div class="search_title">Search all articles sort by:</div><br>
<div class="category_select">
<?php
echo '<a href="/articles/?sort=date"><button>Date</button></a>';
echo '<a href="/articles/?sort=category"><button>Category</button></a>';
?>
</div></div>


<div class="separator blue">Recent pieces</div>

<div class="showcase">

<?php

foreach ($db[ARTICLE] as $e)
	echo getArticleElement($e, "");
 
?>

</div>

</html></body>
