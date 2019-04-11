<?php
	function ft_is_sort($tab)
	{
		$sorted = array_values($tab);
		sort($sorted);
		if (!array_diff_assoc($tab, $sorted))
			return (TRUE);
		return (FALSE);
	}
?>