#!/usr/bin/env python
import pika
import time
import pymysql
import json
import sys
from pymysql import cursors

credentials = pika.PlainCredentials('exam', 'exam')

connection = pika.BlockingConnection(pika.ConnectionParameters(
        'localhost', 5672, '/', credentials))
channel = connection.channel()

channel.queue_declare(queue='task_queue', durable=True)
print(' [*] Waiting for messages. To exit press CTRL+C')

class JobKeyException(Exception):
    pass

def callback(ch, method, properties, body):
	done = False
	dbcon = None
	
	# masukkan ke database
	try:
		print(" [x] Received %r" % body)

		job = json.loads(str(body, 'UTF-8'))
		
		try:
			users_id = job['users_id']
			key = job['key']
			library = job['library']
			code = job['code']
			key = job['key']
		except KeyError as e:
			raise JobKeyException('Key yang dibutuhkan tidak ada: '+str(e))
		
		done = job.get('done', 0)
		id_soal = job.get('id', None)
		jawaban = job.get('answers', None)
		
		if len(sys.argv) > 1:
			dbname = 'examprod'
			print('Development')
		else:
			dbname = 'exam'
		
		dbcon = pymysql.connect(host='dbserver',
							 user='exam',
							 password='exam',
							 db=dbname,
							 charset='utf8mb4',
							 cursorclass=cursors.DictCursor)
		
		with dbcon.cursor() as cursor:
			
			if users_id is None or int(users_id) <= 0:
				# Cari dulu berdasarkan key
				cursor.execute('SELECT id FROM users WHERE userkey = %s', (key, ))
				
				for row in cursor:
					users_id = row['id']		
			
			# Proses di sini
			if users_id is not None and int(users_id) > 0:
				
				if isinstance(jawaban, dict):
					for id_soal, val in jawaban.items():

						#print('soal: ', str(id_soal), ' => ', str(val))
						table = None
						
						if library == 'personal':
							table = 'personal_jawaban'
							parent_id = 'personal_questions_id'
							tipe_query = 1
						elif library == 'ist':
							table = 'ist_jawaban'
							parent_id = 'ist_questions_id'
							tipe_query = 1
						elif library == 'gti':
							table = 'gti_jawaban'
							parent_id = 'gti_questions_id'
							tipe_query = 1
						elif library == 'multiplechoice':
							table = 'multiplechoice_jawaban'
							parent_id = 'multiplechoice_question_id'
							tipe_query = 2	
						elif library == 'pauli':
							part = id_soal.lstrip('p')
							
							print('PART: '+str(part))

							benar = 0
							salah = 0
							total = 0

							# kumpulan jawaban
							# Ternyata bisa tidak konsisten, ada yg dict...
							if (isinstance(val, dict)):
								for key, arr_jawaban in val.items():

									total_jawaban = 0
									
									if (isinstance(arr_jawaban, list)):								
										# jawaban masih dalam bentuk array
										for jawaban in arr_jawaban:
											total_jawaban += int(jawaban)
									else:
										total_jawaban = int(arr_jawaban)

									if total_jawaban <= 0:
										continue
									
									if total_jawaban == 9:
										benar += 1
									else:
										salah += 1
									
									total += 1
									
							# Ada juga yg list..
							else:
								# kumpulan jawaban
								for arr_jawaban in val:
									
									total_jawaban = 0
									
									if (isinstance(arr_jawaban, list)):								
										# jawaban masih dalam bentuk array
										for jawaban in arr_jawaban:
											total_jawaban += int(jawaban)
									else:
										total_jawaban = int(arr_jawaban)

									if total_jawaban <= 0:
										continue
									
									if total_jawaban == 9:
										benar += 1
									else:
										salah += 1
									
									total += 1

							print('- Total: '+str(total))
							
							# Simpan log
							cursor.execute("""
								INSERT INTO pauli_jawaban_log (created, users_id, quiz_code, part, jawaban) 
								VALUES 
								(NOW(), %s, %s, %s, %s) ON DUPLICATE KEY UPDATE jawaban = %s
							""", (users_id, code, part, json.dumps(val), json.dumps(val)))

							# Simpan jawaban
							if total <= 0:
								total = 0
								benar = 0
								salah = 0
								
							cursor.execute("""
								INSERT INTO pauli_jawaban_statistik (created, users_id, quiz_code, part, total, benar, salah)
								VALUES (NOW(), %s, %s, %s, %s, %s, %s) ON DUPLICATE KEY UPDATE total = %s, benar = %s, salah = %s
							""", (users_id, code, part, total, benar, salah, total, benar, salah))
						
						# Simpan jawaban untuk selain pauli
						if table is not None:
							if tipe_query == 1:
								cursor.execute("INSERT INTO "+ table +
								"(`users_id`, `"+ parent_id +"""`, `jawaban`, `quiz_code`,`created`)
								VALUES
								(%s, %s, %s, %s, NOW())
								ON DUPLICATE KEY UPDATE jawaban = %s, updated = NOW()""",
								(users_id, id_soal, val, code, val,))
								
							elif tipe_query == 2:
								cursor.execute("INSERT INTO "+ table +
								"(`users_id`, `"+ parent_id +"""`, `multiplechoice_choices_id`, `jenis_soal`)
								VALUES
								(%s, %s, %s, %s)
								ON DUPLICATE KEY UPDATE multiplechoice_choices_id = %s""",
								(users_id, id_soal, val, code, val,))
				
				# Kalau done = 1
				try:
					if (isinstance(done, int) and done == 1) or (isinstance(done, str) and done == '1'):
						query_done = "UPDATE users_quiz_log SET last_update = NOW(), time_end = NOW() WHERE "
					else:
						query_done = "UPDATE users_quiz_log SET last_update = NOW() WHERE "
				except:
					query_done = "UPDATE users_quiz_log SET last_update = NOW() WHERE "
					
				# Update users_quiz_log
				cursor.execute(query_done + "quiz_code = %s AND users_id = %s", (code, users_id,))
				
				dbcon.commit()
				
				print(" [x] Done")
				done = True
			else:
				print('Tidak ditemukan users_id')
				done = True

	except JobKeyException as e:
		print('JOB KEY EXCEPTION: '+str(e))
		done = True
	except json.decoder.JSONDecodeError as e:
		print('JSON Decoder Error: ', str(e))
		print('Tidak usah diproses karena format json salah')
		done = True
	except pymysql.err.IntegrityError as e:
		print('INTEGRIRY ERROR: '+str(e))
		done = True
	except Exception as e:
		print('Error on line {}'.format(sys.exc_info()[-1].tb_lineno))
		print('UNKNOWN EXCEPTION: '+str(e))
		done = False
	finally:
		if dbcon is not None:
			dbcon.close()

	if done:
		ch.basic_ack(delivery_tag = method.delivery_tag)
	else:
		ch.basic_nack(delivery_tag = method.delivery_tag)
		
channel.basic_qos(prefetch_count=1)
channel.basic_consume(callback,
                      queue='task_queue')

channel.start_consuming()
