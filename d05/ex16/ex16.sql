SELECT count(id_film) as films
	FROM member_history
	WHERE (DATE(date) BETWEEN DATE('2006-10-30') AND DATE('2007-07-27')) OR DATE(date) LIKE '____-12-24';