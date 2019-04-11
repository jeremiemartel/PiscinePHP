INSERT INTO ft_table
	SELECT 0, last_name as login, 'other', DATE(birthdate) as creation_date
	FROM user_card WHERE (last_name LIKE "%a%" AND CHAR_LENGTH(last_name) < 9)
	ORDER BY last_name ASC 
	LIMIT 10;