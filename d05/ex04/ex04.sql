UPDATE ft_table
	SET creation_date = creation_date + DATE('0020-00-00')
	WHERE id > 5;