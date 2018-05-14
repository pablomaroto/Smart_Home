import signal, sys, os, time, serial

def comando(com, app):

	linea = os.popen('tail -1 /home/pi/tg/datos.txt').read()

	if com=="Encender led 1":
		linea='1'+linea[1:]
		fichero = open('/home/pi/tg/datos.txt', 'w')
		fichero.write(linea)
		fichero.close()

	if com=="Encender led 2":
		linea=linea[:2]+'1'+linea[3:]
		fichero = open('/home/pi/tg/datos.txt', 'w')
		fichero.write(linea)
		fichero.close()

	if com=="Apagar led 1":
		linea='0'+linea[1:]
		fichero = open('/home/pi/tg/datos.txt', 'w')
		fichero.write(linea)
		fichero.close()

	if com=="Apagar led 2":
		linea=linea[:2]+'0'+linea[3:]
		fichero = open('/home/pi/tg/datos.txt', 'w')
		fichero.write(linea)
		fichero.close()

	fichero2 = open('/home/pi/tg/registro.txt', 'a')
	fichero2.write(app)
	fichero2.write(" ")
	fichero2.write(com)
	fichero2.write(" -- ")
	fichero2.write(time.strftime("%c"))
	fichero2.write("\n")
	fichero2.close()
	return

def arduino(com, app):
	fichero = open('/home/pi/tg/ir.txt', 'w')
        fichero.write(com)
        fichero.close()
	
	fichero2 = open('/home/pi/tg/registro.txt', 'a')
        fichero2.write(app)
        fichero2.write(" ")
        fichero2.write(com)
        fichero2.write(" -- ")
        fichero2.write(time.strftime("%c"))
        fichero2.write("\n")
        fichero2.close()
	return
