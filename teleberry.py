import pexpect, os, sys, signal, comando
import serial, time

def signal_handler(signal, frame):
	print "trl+C"
	print "Cerrando programa."
	sys.exit(0)

signal.signal(signal.SIGINT, signal_handler)


contacto="NOMBRE_DE_CONTACTO"
telegram=pexpect.spawn('bin/telegram-cli -k tg-server.pub -W')
app="(telegram)"

while 1:
	index=telegram.expect(['Led', 'Termometro', 'Tv', pexpect.EOF, pexpect.TIMEOUT])
	linea = os.popen('tail -1 datos.txt').read()
	tem = os.popen('tail -1 temperatura.txt').read()
	hum = os.popen('tail -1 humedad.txt').read()
	if index==0:
		telegram.sendline('msg '+contacto+' (Led) -->')
		index2=telegram.expect(['H led1', 'H led2', 'L led1', 'L led2', 'Ls', pexpect.EOF, pexpect.TIMEOUT])
		if index2==0:
                	comando.comando("Encender led 1", app)

        	if index2==1:
                	comando.comando("Encender led 2", app)

        	if index2==2:
                	comando.comando("Apagar led 1", app)

        	if index2==3:
                	comando.comando("Apagar led 2", app)

		if index2==4:
                	telegram.sendline('msg '+contacto+' led1: '+linea[0])
                	telegram.sendline('msg '+contacto+' led2: '+linea[2])

		if index2==6:
			telegram.sendline('msg '+contacto+' timeout-->')
			pass

	if index==1:
		telegram.sendline('msg '+contacto+' (Termometro)-->')
		index3=telegram.expect(['C', '%', 'Grafico', pexpect.EOF, pexpect.TIMEOUT])
		if index3==0:
			telegram.sendline('msg '+contacto+' '+tem)
		if index3==1:
                        telegram.sendline('msg '+contacto+' '+hum)
		if index3==2:
                        telegram.sendline('send_photo '+contacto+' /var/www/html/img/grafico.png')
		if index3==4:
			telegram.sendline('msg '+contacto+' timeout-->')
			pass

	if index==2:
                telegram.sendline('msg '+contacto+' -->')
                index4=telegram.expect(['On', 'Off', 'Prog', 'prog', 'V', 'v',  pexpect.EOF, pexpect.TIMEOUT])
                if index4==0:
			comando.arduino("Encender television", app)
		if index4==1:
                        comando.arduino("Apagar television", app)
		if index4==2:
                        comando.arduino("Subir programa", app)
		if index4==3:
                        comando.arduino("Bajar programa", app)
		if index4==4:
                        comando.arduino("Subir volumen", app)
		if index4==5:
                        comando.arduino("Bajar volumen", app)
		if index4==7:
			telegram.sendline('msg '+contacto+' timeout-->')
			pass

	if index==5:
		pass
