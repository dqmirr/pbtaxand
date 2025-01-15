INSERT INTO users_quiz (users_id, quiz_id, active)
SELECT
	id,
	(SELECT id FROM quiz WHERE code = 'gti') as quiz_id,
	1
FROM
	users;
