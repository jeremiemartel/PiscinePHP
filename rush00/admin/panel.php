<?php
	include_once("../tools/const.php");
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

<html>
	<head>
		<title>Administration Panel</title>
	</head>
	<body>
		<h1>Welcome <?php echo $_SESSION[USER][USER_FNAME]; ?></h1>

			<a href="/"><button>Go back to website</button></a>


			<form action="./panel-back.php" method="POST">
				<input type="hidden" name="action" value="add">
				<input type="hidden" name="db" value="user">
				<h2>User Database <input type="submit" name="submit" value="Add User"/></h2>
			</form>

			<?php
				foreach($db[USER] as $user)
				{
					echo '<form action="./panel-back.php" method="POST">'.PHP_EOL;
					echo '<input type="hidden" name="action" value="del"/>';
					echo '<input type="hidden" name="db" value="user"/>';
					echo '<input type="hidden" name="id" value="'.$user[USER_ID].'"/>';
					echo '<p>'.$user[USER_ID].": ".$user[USER_LOGIN];
					if ($user[USER_TYPE] !== USER_TYPE_ADMIN)
						echo '   <input type="submit" name="del_user" value="Delete User"></p>'.PHP_EOL;
					echo '<p>=>       '.$user[USER_FNAME].' '.$user[USER_LNAME].'</p>';
					echo '<p>=>       '.$user[USER_MAIL].'</p>';
					echo '<br/>';
					echo '</form>'.PHP_EOL;
				}
			?>

			<form action="./panel-back.php" method="POST">
				<input type="hidden" name="action" value="add">
				<input type="hidden" name="db" value="article">
				<h2>Articles Database <input type="submit" name="submit" value="Add Article"/></h2>
			</form>

			<?php
				foreach($db[ARTICLE] as $article)
				{
					echo '<form action="./panel-back.php" method="POST">'.PHP_EOL;
					echo '<input type="hidden" name="action" value="del"/>';
					echo '<input type="hidden" name="db" value="article"/>';
					echo '<input type="hidden" name="id" value="'.$article[ARTICLE_ID].'"/>';
					echo '<p>';
					echo '<img src="'.$article[ARTICLE_PREVIEW][0].'" alt="preview" style="width:20px;height=20px"/>';
					echo $article[ARTICLE_ID].": ".$article[ARTICLE_NAME].", ".$article[ARTICLE_PRICE]."$";
					if ($article[ARTICLE_ID] !== 0)
						echo '  <input type="submit" name="del_article" value="Delete Article">'.PHP_EOL;
					echo '</form>'.PHP_EOL;

					echo '<form action="./panel-back.php" method="POST">'.PHP_EOL;
					echo '<input type="hidden" name="action" value="mod"/>';
					echo '<input type="hidden" name="db" value="article"/>';
					echo '<input type="hidden" name="id" value="'.$article[ARTICLE_ID].'"/>';
					if ($article[ARTICLE_ID] !== 0)
						echo '  <input type="submit" name="mod_article" value="Modify Article"></p>'.PHP_EOL;
					echo '</form>'.PHP_EOL;
				}
			?>

			<form action="./panel-back.php" method="POST">
				<input type="hidden" name="action" value="add">
				<input type="hidden" name="db" value="category">
				<h2>Category Database <input type="submit" name="submit" value="Add Category"/></h2>
			</form>

			<?php
				foreach($db[CATEGORY] as $category)
				{
					echo '<form action="./panel-back.php" method="POST">'.PHP_EOL;
					echo '<input type="hidden" name="action" value="del"/>';
					echo '<input type="hidden" name="db" value="category"/>';
					echo '<input type="hidden" name="id" value="'.$category[CATEGORY_ID].'"/>';
					echo '<p>';
					echo $category[CATEGORY_ID].": ".$category[CATEGORY_NAME];
					if ($category[CATEGORY_ID] !== 0)
						echo '  <input type="submit" name="del_category" value="Delete Category">'.PHP_EOL;
					echo '</form>'.PHP_EOL;
					echo '</p>';
				}
			?>

			<form action="./panel-back.php" method="POST">
				<h2>Orders Database</h2>
			</form>

			<?php
				foreach($db[ORDER] as $order)
				{
					if ($order[ORDER_ID] !== 0)
					{
						echo '<form action="./panel-back.php" method="POST">'.PHP_EOL;
						echo '<input type="hidden" name="action" value="del"/>';
						echo '<input type="hidden" name="db" value="orders"/>';
						echo '<input type="hidden" name="id" value="'.$order[ORDER_ID].'"/>';
						echo '<p>';
						echo $order[ORDER_ID]."  ";
						echo '  <input type="submit" name="del_order" value="Delete Order"></p>'.PHP_EOL;
					}
					echo '</form>'.PHP_EOL;
				}
			?>

			<a href="/admin/orders.php"><button>See all orders</button></a>

		</form>
	</body>
</html>