<?php
	function ft_split($str)
	{
		if (!(isset($str)))
			return (NULL);
		$str = trim($str);
		$tab = preg_split("/\ +/", $str);
		sort($tab);
		return ($tab);
	}
?>
