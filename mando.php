<?php
        $accion=$_POST['parametro'];
	shell_exec("sudo python /home/pi/tg/mando.py "."\"".$accion."\"");
	echo $accion;
?>

