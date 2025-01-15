import time

import schedule

from remover import main

def job():
	print("It's the best day ever!!!")


while True:
	main()
	job()
	time.sleep(300)
