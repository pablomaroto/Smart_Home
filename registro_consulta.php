<?php
	$fecha=" ";
	if ($fecha != shell_exec('ls -l /home/pi/tg/registro.txt | cut -f 6-8 -d " " > /dev/null'))
	{
        	$fecha = shell_exec('ls -l registro.txt | cut -f 6-8 -d " " > /dev/null');
		$linea = shell_exec('cat /home/pi/tg/registro.txt | cut -f 1,2 -d ":"');
        	echo $linea;
	}
?>
