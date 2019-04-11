<?php

include_once("../tools/const.php");
include_once("../tools/db.php");
include_once("../tools/init_page.php");
include_once("./get_article_element.php");
include_once("../tools/index_helper.php");
initPage("../");

if (!isset($_SESSION[USER][USER_ID]))
	header("Location: /");

if (isset($_POST['id']) && isset($_POST['article_id']))
{
	foreach($db[ORDER][$_POST['id']][BASKET] as $x => $e)
	{
		echo $e[ARTICLE_ID] . " : " . $_POST['id'] . "\n";
		if (intval($e[ARTICLE_ID]) === intval($_POST['article_id']))
		{
			print_r($db[ORDER][$_POST['id']][BASKET]);
			$db[ORDER][$_POST['id']][BASKET] = \array_diff_key($db[ORDER][$_POST['id']][BASKET], [$x => ""]);
			echo "\n";
			print_r($db[ORDER][$_POST['id']][BASKET]);
			if (count($db[ORDER][$_POST['id']][BASKET]) === 0)
			{
				$db[ORDER] = \array_diff_key($db[ORDER], [$_POST['id'] => ""]);
			}
			db_save($db[ORDER], "../Datas/orders.db");
			header("Location: /admin/orders.php");
			exit;
		}
	}
}

?>