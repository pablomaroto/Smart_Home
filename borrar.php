<?php
	$parametro=$_POST['parametro'];
	$archivo=fopen($parametro,"w");
   	fclose($archivo);
?>
