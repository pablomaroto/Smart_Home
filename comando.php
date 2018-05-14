<?php
	$parametro=$_POST['parametro'];
	$linea=shell_exec("tail -1 /home/pi/tg/datos.txt");
        $datos=explode(" ", $linea);
	if(strcmp($parametro, "Encender led 1")==0)
        	$datos[0]="1";
	if(strcmp($parametro, "Apagar led 1")==0)
                $datos[0]="0";
        if(strcmp($parametro, "Encender led 2")==0)
                $datos[1]="1";
        if(strcmp($parametro, "Apagar led 2")==0)
                $datos[1]="0";

	$linea="";
        for($i=0; $i<count($datos); $i++)
        {
		$linea.=$datos[$i];
		if($i<count($datos)-1)
			$linea.=" ";
        }
	$fichero = fopen("/home/pi/tg/datos.txt", "w");
	$flag=fwrite($fichero, $linea);
	fclose($fichero);

	date_default_timezone_set('Europe/Madrid');
	$parametro="(web) ".$parametro." -- ".date("D M j G:i:s")."\n";
	$fichero2 = fopen("/home/pi/tg/registro.txt", "a");
        $flag=fwrite($fichero2, $parametro);
        fclose($fichero2);

	echo $parametro;
?>
