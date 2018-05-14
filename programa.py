import signal, sys, os, time, comando, getpass

comandos=[]
comandos.append("Encender led 1")
comandos.append("Apagar led 1")
comandos.append("Encender led 2")
comandos.append("Apagar led 2")

arduinos=[]
arduinos.append("Encender television")
arduinos.append("Apagar television")
arduinos.append("Subir programa")
arduinos.append("Bajar programa")
arduinos.append("Subir volumen")
arduinos.append("Bajar volumen")

cmd=sys.argv[1].capitalize()

for com in comandos:
	if cmd == com:
		comando.comando(cmd, sys.argv[2])
		sys.exit()
		
for com in arduinos:
	if cmd == com:
                comando.arduino(cmd, sys.argv[2])
		sys.exit()

