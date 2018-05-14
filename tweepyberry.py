import tweepy, signal, sys, os, time, comando

def signal_handler(signal, frame):
        print "trl+C"
        print "Cerrando programa."
        sys.exit(0)

signal.signal(signal.SIGINT, signal_handler)
 
CONSUMER_KEY = 'CONSUMER_KEY' 
CONSUMER_SECRET = 'CONSUMER_SECRET'
ACCESS_KEY = 'ACCESS_KEY'
ACCESS_SECRET = 'ACCESS_SECRET'
 
auth = tweepy.OAuthHandler(CONSUMER_KEY, CONSUMER_SECRET)
auth.set_access_token(ACCESS_KEY, ACCESS_SECRET)
 
x = tweepy.API(auth)

for tweets in x.user_timeline():
	x.destroy_status(tweets.id)

fecha=""
app="(twitter)"
while(1):
	linea = os.popen('tail -1 datos.txt').read()
	tem = os.popen('tail -1 temperatura.txt').read()
        hum = os.popen('tail -1 humedad.txt').read()
	contador=0
	try:
		for tweets in x.user_timeline():
			contador+=1
			if contador>1:
				x.destroy_status(tweets.id)

			else:
				if fecha!=tweets.created_at:
					fecha=tweets.created_at
					text=tweets.text

					if text=="Encender led 1" or text=="Encender led 2" or text=="Apagar led 1" or text=="Apagar led 2":
						comando.comando(text, app)
					if text=="Encender television" or text=="Apagar television" or text=="Subir programa" or text=="Bajar programa" or text=="Subir volumen" or text=="Bajar volumen":
						comando.arduino(text, app)
					if text=="Grafico":
						photo_path = '/var/www/html/img/grafico.png'
						x.update_with_media(photo_path)
					if text=="Leds":
						mensaje="Led 1: "+linea[0]+"\n"+"Led 2: "+linea[2]
						x.update_status(mensaje)
					if text=="Temperatura":
						x.update_status(tem)
					if text=="Humedad":
                                                x.update_status(hum)

		time.sleep(10)

	except tweepy.TweepError:
		time.sleep(60*15)
		continue
