<?php
	$linea = shell_exec('tail -1 /home/pi/tg/datos.txt | cut -f 1,2 -d ":"');
       	echo $linea;
?>
