<?php
	$hora=$_POST['hora'];
	$comando="\"".$_POST['programa']."\"";
	$dia=$_POST['dia'];
	$app="\"(programa)\"";
	$linea="#!/bin/bash"."\n"."date=`date +\"%H:%M\"`"."\n"."day=`date +\"%a\"`"."\n"."if [ \$date = ".$hora." ] && ([ $dia = \$day ] || [ $dia = All ])"."\n"."then python /home/pi/tg/programa.py ".$comando." ".$app."\n"."fi"."\n";
	$fichero = fopen("/home/pi/tg/cron.sh", "w");
       	$flag=fwrite($fichero, $linea);
       	fclose($fichero);
?>
