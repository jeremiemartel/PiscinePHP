SELECT ABS(DATEDIFF(max(date), min(date))) as 'uptime'
	FROM member_history;
