<?php
	/* User database keys and values*/
	define('USER', "user");
	define('USER_ID', "user_id");
		define('USER_ID_NOT_LOGGED', -1);
	define('USER_LOGIN', "login");
	define('USER_PASSWORD', "passwd");
	define('USER_FNAME', "fname");
	define('USER_LNAME', "lname");
	define('USER_MAIL', "mail");
	define('USER_TYPE', "type");
		define('USER_TYPE_ADMIN', 0);
		define('USER_TYPE_SELLER', 1);
		define('USER_TYPE_CLIENT', 2);
	
	/* Articles database keys and values */
	define('ARTICLE', "article");
	define('ARTICLE_ID', "article_id");
	define('ARTICLE_NAME', "name");
	define('ARTICLE_PRICE', "price");
	define('ARTICLE_PREVIEW', "preview");
	define('ARTICLE_DESCRIPTION', "description");
	define('ARTICLE_CATEGORIE', "categorie");
	define('ARTICLE_CATEGORY', "categorie");
		define('ARTICLE_CATEGORY_BRICK', 0);
		define('ARTICLE_CATEGORY_CHARACTER', 1);
	define('ARTICLE_COLOR', "color");
		define('ARTICLE_COLOR_RED', "red");
		define('ARTICLE_COLOR_BLUE', "blue");
		define('ARTICLE_COLOR_GREEN', "green");
		define('ARTICLE_COLOR_BLACK', "black");
		define('ARTICLE_COLOR_WHITE', "white");
	define('ARTICLE_SELLER', "seller");
	define('ARTICLE_ADDTIME', "addtime");
	define('BASKET', "basket");
	define('BASKET_QUANTITY', "basket_quantity");

	define('CATEGORY', "category");
	define('CATEGORY_ID', "category_id");
	define('CATEGORY_NAME', "category_name");
	define('CATEGORIE', "category");
	define('CATEGORIE_ID', "category_id");
	define('CATEGORIE_NAME', "category_name");

	define('ORDER', "order");
	define('ORDER_ID', "order_id");
	define('ORDER_USER_ID', "order_user_id");
	define('ORDER_TIME', "order_time");
?>
