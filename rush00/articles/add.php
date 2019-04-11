<?php
	function article_add_manual($filepath, $name, $price, $preview, $description, $categorie, $sellerid)
	{
		if (($serial_tab = db_get($filepath)) === FALSE)
		{
			echo "Can't open article database for ".$name.", exiting".PHP_EOL;
			return FALSE;
		}
		foreach ($preview as $file)
		{
			if (!file_exists("./".$file))
			{
				echo "Can't find ".$name." preview image, exiting".PHP_EOL;
				return FALSE;
			}
		}
		
		$article = array();
		$article[ARTICLE_ID] = $serial_tab[count($serial_tab) - 1][ARTICLE_ID] + 1;
		$article[ARTICLE_NAME] = $name;
		$article[ARTICLE_PRICE] = $price;
		$article[ARTICLE_PREVIEW] = $preview;
		$article[ARTICLE_DESCRIPTION] = $description;
		$article[ARTICLE_CATEGORY] = $categorie;
		$article[ARTICLE_SELLERID] = $sellerid;
		$article[ARTICLE_ADDTIME] = time();
		$serial_tab[] = $article;
		if (db_save($serial_tab, $filepath) === FALSE)
		{
			echo "Can't write ".$name." in article database, exiting".PHP_EOL;
			return FALSE;
		}
		return TRUE;
	}
?>