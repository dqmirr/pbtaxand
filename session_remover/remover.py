import os
from datetime import datetime

from mysql.connector import connect


INACTIVE_SESSION_QUERY= ("select session_name from users_sessions where "
			"session_name <> '' and users_id in (select users_id "
			"from users_quiz_log  group by users_id having "
			"MAX(last_update) < (NOW() - INTERVAL 5 MINUTE))")

ALL_SESSION_QUERY = ("select session_name from users_sessions where session_name <> ''")

SESSIONS_FOLDER_PATH = "/var/lib/php/sessions/"

UPDATE_SESSIONS_QUERY = ("UPDATE users_sessions SET session_name='' WHERE "
			"session_name <> '' and users_id in (select users_id "
			"from users_quiz_log  group by users_id having "
			"MAX(last_update) < (NOW() - INTERVAL 5 MINUTE))")
DELETE_SESSIONS_QUERY = ("DELETE FROM users_sessions WHERE "
			"session_name <> '' and users_id in (select users_id "
			"from users_quiz_log  group by users_id having "
			"MAX(last_update) < (NOW() - INTERVAL 10 MINUTE))")

def data_getter(cursor, query):
	cursor.execute(query)
	raw_data = cursor.fetchall()
	data = [item[0] for item in raw_data]

	return data

def unknown_sessions_remover(known_sessions):
	files = []
	for r, d, f in os.walk(SESSIONS_FOLDER_PATH):
		for file in f:
			if file.strip('ci_session') not in known_sessions:
				os.remove(os.path.join(r, file))

def old_sessions_remover(cursor):
	cursor.execute(UPDATE_SESSIONS_QUERY)	
		
def main():
	conn = connect(user='exam',
					host='dbserversave',
					db='exam',
					passwd='exam')
	cursor = conn.cursor()	

	old_sessions_remover(cursor)
	conn.commit()
	
	# print("Get old sessions")
	data = data_getter(cursor, ALL_SESSION_QUERY)
	unknown_sessions_remover(data)

			
	conn.close()


if __name__ == '__main__':
	main()
