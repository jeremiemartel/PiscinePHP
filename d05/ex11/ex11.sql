SELECT UCASE(user_card.last_name) as NAME, user_card.first_name, subscription.price
	FROM member
		INNER JOIN subscription ON member.id_sub=subscription.id_sub 
		INNER JOIN user_card ON member.id_user_card=user_card.id_user
	WHERE subscription.price > 42
	ORDER BY user_card.last_name ASC, user_card.first_name ASC;