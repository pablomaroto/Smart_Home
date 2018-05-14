import os, sys, signal, time, threading
import serial

def signal_handler(signal, frame):
        print "trl+C"
        print "Cerrando programa."
        sys.exit(0)

signal.signal(signal.SIGINT, signal_handler)

arduino=serial.Serial('/dev/ttyACM0', 9600)
time.sleep(1)
dia=time.strftime("%A")
lock = threading.Lock()

def tem_hum(dia, arduino):
	if dia != time.strftime("%A"):
                dia=time.strftime("%A")
                fichero = open('temperatura.txt', 'w')
                fichero.close()
                fichero = open('humedad.txt', 'w')
                fichero.close()

	lock.acquire()
        arduino.flush()
        arduino.write('Temperatura')
        time.sleep(1)
        tem=arduino.readline()
        fichero = open('temperatura.txt', 'a')
        fichero.write(tem)
        fichero.close()

        arduino.flush()
        arduino.write('Humedad')
        time.sleep(1)
        hum=arduino.readline()
        fichero = open('humedad.txt', 'a')
        fichero.write(hum)
        fichero.close()
	threading.Timer(60, tem_hum, args=[dia, arduino]).start()
	lock.release()


tem_hum(dia, arduino)
while 1:
	ir=os.popen('cat ir.txt').read()
        ir=ir.replace("\n", '')

	lock.acquire()
	if len(ir) != 0:
        	arduino.flush()
        	arduino.write(ir)
        	time.sleep(2)
		fichero = open('ir.txt', 'w')
                fichero.close()

	linea = os.popen('tail -1 datos.txt').read()
	if linea[0]=='0':
		arduino.flush()
               	arduino.write("Apagar led 1")
		time.sleep(2)
	else:
		arduino.flush()
		arduino.write("Encender led 1")
		time.sleep(2)
	if linea[2]=='0':
               	arduino.flush()
               	arduino.write("Apagar led 2")
		time.sleep(2)
       	else:
               	arduino.flush()
       		arduino.write("Encender led 2")
		time.sleep(2)
	lock.release()
