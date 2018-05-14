<?php   

include("/var/www/html/class/pData.class.php");
include("/var/www/html/class/pDraw.class.php");
include("/var/www/html/class/pImage.class.php");


$file_data = file_get_contents("/home/pi/tg/temperatura.txt");
$file_filtered = str_replace("Temperatura: ", "", $file_data);
$file_filtered = str_replace(" C", "", $file_filtered);
$data_array = explode("\n", $file_filtered);

$file_data2 = file_get_contents("/home/pi/tg/humedad.txt");
$file_filtered2 = str_replace("Humedad: ", "", $file_data2);
$file_filtered2 = str_replace(" %", "", $file_filtered2);
$data_array2 = explode("\n", $file_filtered2);

$datos_temperatura=array();
$datos_humedad=array();
$j=0;

$suma_temperatura=0;
$suma_humedad=0;

for($i=0; $i<count($data_array)-1; $i++)
{
	if($i == 0)
	{
		$datos_temperatura[$j]=$data_array[$i];
                $datos_humedad[$j]=$data_array2[$i];
                $hora[$j]=$j*3600;
                $j++;
	}
	else
	{
		$suma_temperatura=$suma_temperatura+$data_array[$i];
		$suma_humedad=$suma_humedad+$data_array2[$i];
		if(($i % 60) == 0)
		{
			$datos_temperatura[$j]=$suma_temperatura / 60;
			$datos_humedad[$j]=$suma_humedad / 60;
			$hora[$j]=$j*3600;
			$j++;
			$suma_temperatura=0;
        		$suma_humedad=0;

		}
	}
}


$MyData = new pData();  
$MyData->addPoints($datos_temperatura,"Temperatura");
$MyData->addPoints($datos_humedad,"Humedad");
$MyData->setSerieOnAxis("Temperatura",0);
$MyData->setSerieOnAxis("Humedad",1);

$MyData->setAxisPosition(1,AXIS_POSITION_RIGHT);

$MyData->setSerieTicks("Humedad",4);
$MyData->setAxisName(0,"Temperatura");
$MyData->setAxisUnit(0,"ºC");
$MyData->setAxisName(1,"Humedad");
$MyData->setAxisUnit(1,"%");

$MyData->addPoints($hora,"Timestamp");

$MyData->setSerieDescription("Timestamp","Sampled Dates");
$MyData->setAbscissa("Timestamp");
$MyData->setXAxisDisplay(AXIS_FORMAT_TIME);


$serieSettings=array("R"=>0,"G"=>154,"B"=>255);
$MyData->setPalette("Temperatura",$serieSettings);

$serieSettings=array("R"=>255,"G"=>0,"B"=>0);
$MyData->setPalette("Humedad",$serieSettings);


$myPicture = new pImage(1000,430,$MyData);

$myPicture->Antialias = FALSE;

$myPicture->setFontProperties(array("FontName"=>"/var/www/html/fonts/Forgotte.ttf","FontSize"=>11));
$myPicture->drawText(150,35,"Temperatura - Humedad",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

$myPicture->setFontProperties(array("FontName"=>"/var/www/html/fonts/pf_arma_five.ttf","FontSize"=>6));

$myPicture->setGraphArea(60,40,950,400);

$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
$myPicture->drawScale($scaleSettings);

$myPicture->Antialias = TRUE;

$myPicture->drawLineChart();

$myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

$myPicture->Render("/var/www/html/img/grafico.png");
?>
