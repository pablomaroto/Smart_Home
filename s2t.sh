arecord -D plughw:1,0 -f cd -c 1 -t wav -d 3 -r 16000 | \
flac - -f --best --sample-rate 16000 -o out.flac; \
wget -O - -o /dev/null --post-file out.flac --header="Content-Type: audio/x-flac; rate=16000" \
"http://www.google.com/speech-api/v2/recognize?lang=es-Es&key=API_KEY=json" | head -2 | tail -1 | cut -d "\"" -f 8 | sed 's/LED/led/g' | sed 's/ó/o/g'  > text.txt
