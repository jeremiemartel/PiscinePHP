<?php
	function my_hash($passwd)
	{
		return hash("whirlpool", $passwd);
	}
?>