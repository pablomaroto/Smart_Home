import signal, os, comando
import RPi.GPIO as GPIO

def signal_handler(signal, frame):
        print "trl+C"
        print "Cerrando programa."
        sys.exit(0)

signal.signal(signal.SIGINT, signal_handler)

GPIO.setmode(GPIO.BCM)

GPIO.setup(23, GPIO.IN, pull_up_down=GPIO.PUD_UP)

app="(voz)"
while 1:
	GPIO.wait_for_edge(23, GPIO.FALLING)
	os.system('./s2t.sh')

	speech=os.popen('cat text.txt').read()
	speech=speech.replace("\n", '')
	if speech == "temperatura":
		os.system("tail -1 temperatura.txt | sed 's/C/ºC/g' | espeak -ves 2> /dev/null")
	elif speech == "humedad":
		os.system('tail -1 humedad.txt | espeak -ves 2> /dev/null')
	else:
		speech=speech.capitalize()
		if speech=="Encender led 1" or speech=="Encender led 2" or speech=="Apagar led 1" or speech=="Apagar led 2":
			comando.comando(speech, app)
		if speech=="Encender television" or speech=="Apagar television" or speech=="Subir programa" or speech=="Bajar programa" or speech=="Subir volumen" or speech=="Bajar volumen":
			comando.arduino(speech, app)
