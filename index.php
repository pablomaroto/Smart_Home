<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<script type="text/javascript">
    function led_data() {
		var resul = $.ajax({
 
            url: 'consulta.php',
                dataType: 'text',
                async: false
        }).responseText;

	var reg = $.ajax({

            url: 'registro_consulta.php',
                dataType: 'text',
                async: false
        }).responseText;

	document.getElementById("Registro").innerHTML = reg;
	actualizar_img(resul);
    }

    setInterval(led_data,1000);

	function tem_hum_AJAX() {
		var temp = $.ajax({

            url: 'temperatura.php',
                dataType: 'text',
                async: false
        }).responseText;

		var hum = $.ajax({

            url: 'humedad.php',
                dataType: 'text',
                async: false
        }).responseText;

	document.getElementById("Temp").innerHTML = temp;
        document.getElementById("Hum").innerHTML = hum;
	}
	setInterval(tem_hum_AJAX,10000);

	function actualizar_img(x)
	{
		if(x[0]==1)
		{
			document.getElementById("led1").src="img/led_diode_yellow.png";
		}
		else
		{
			document.getElementById("led1").src="img/led_diode_black.png";
		}
		if(x[2]==1)
                {
                        document.getElementById("led2").src="img/led_diode_yellow.png";
                }
                else
                {
                        document.getElementById("led2").src="img/led_diode_black.png";
                }

	}

	function comando(x)
	{
		 var cmd = $.ajax({
            url: 'comando.php',
                type: "POST",
		dataType: 'text',
                data:{parametro: x},
		async: false
        }).responseText;
	}
	function borrar(x)
        {
		if (x == "/home/pi/tg/cron.sh"){
                document.getElementById("nota_programa").innerHTML = "programa borrado!";}

                 var x = $.ajax({
            url: 'borrar.php',
		type: "POST",
                dataType: 'text',
		data:{parametro: x},
                async: false
        }).responseText;


        }
	function aceptar()
        {
		var i 
   		for (i=0;i<document.formulario.prog.length;i++){ 
      		if (document.formulario.prog[i].checked) 
         	break; 
   		} 
   		var a = document.formulario.prog[i].value
		programa(a)
        }
	function programa(a)
        {
                 var x = $.ajax({
            url: 'programa.php',
		 type: "POST",
                dataType: 'text',
		data:{programa: a, hora: document.getElementById("hora").value, dia: document.getElementById("dia").value},
                async: false
        }).responseText;
	document.getElementById("nota_programa").innerHTML = "programa establecido!";
        }

	function mando(x)
        {
                 var man = $.ajax({
            url: 'mando.php',
                type: "POST",
                dataType: 'text',
                data:{parametro: x},
                async: false
        }).responseText;
	document.getElementById("Mando").innerHTML = man;
        }

</script>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Panel de control</title>

	<style type="text/css"> ${demo.css}</style>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximun-scale=1.0, minimun-scale=1.0">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!--<link rel="stylesheet" href="css/estilos.css">-->
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>

</head>
<body>
	<header class="bg-primary">
		<br>
	</header>
	<section class="main row">
		<br>
		<div class="container">
                        <div class="col-xm-4 col-sm-3">
                                <img src="img/logo.png" width="100%">
                        </div>
                        <div class="col-xm-8 col-sm-9">
                                <h2 class="text-primary" style="text-align: center;">Panel de control</h2>
                        </div>
		</div>
		<br>
		<div class="container">
			<div class="col-xm-12 col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">Luces - leds</div>
					<div class="panel-body">
						<div style="float: left; margin: 5px;"><img id="led1" src="img/led_diode_black.png"height="50px">
						<div class="btn-group">
							<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Led 1  <span class="caret"></span></button>
							<ul class="dropdown-menu" role="menu">
								<li onclick="comando('Encender led 1')"><a href="#">Encender</a></li>
								<li onclick="comando('Apagar led 1')"><a href="#">Apagar</a></li>
							</ul>
						</div></div>
						<div style="float: left; margin: 5px;"><img id="led2" src="img/led_diode_black.png"height="50px">
                                                <div class="btn-group">
                                                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Led 2  <span class="caret"></span></button>
                                                        <ul class="dropdown-menu" role="menu">
                                                                <li onclick="comando('Encender led 2')"><a href="#">Encender</a></li>
                                                                <li onclick="comando('Apagar led 2')"><a href="#">Apagar</a></li>
                                                        </ul>
                                                </div></div>

					</div>
				</div>
			</div>
			<div class="col-xm-12 col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">Temperatura - Humedad (AM2302)</div>
					<div class="panel-body">
						<div style="float: left; clear: both;"><div style="float: left;"><img id="thermometer" src="img/thermometer.png"height="60px"></div>
						<div id='Temp' style="font-size: 20px; float: left;" width="50px">Midiendo...</div></div>
						<div style="float: left; clear: both;"><div style="float: left;"><img id="hummidity" src="img/hummidity.png"height="60px"></div>
                                                <div id='Hum' style="font-size: 20px; float: left;" width="50px">Midiendo...</div></div>
					</div>
				</div>
			</div>
			<div class="col-xm-12 col-sm-12">
                                <div class="panel panel-default">
                                        <div class="panel-heading">Temperatura - Humedad (GRÁFICO)</div>
                                        <div class="panel-body">
						<div><img id="grafico" src="img/grafico.png" width="100%" height="auto"></div>
                                        </div>
                                </div>
                        </div>
			<div class="col-xm-12 col-sm-6">
                                <div class="panel panel-default">
                                        <div class="panel-heading">Registro de eventos</div>
                                        <div class="panel-body" style="min-height: 250px;">
                                                <pre class="pre-scrollable" style="min-height: 200px; max-height: 200px;"><div id="Registro">---- REGISTRO ----</div></pre>
						<button type="button" class="btn btn-warning" onclick="borrar('/home/pi/tg/registro.txt')">Borrar</button>
                                        </div>
                                </div>
                        </div>
			<div class="col-xm-12 col-sm-6">
                                <div class="panel panel-default">
                                        <div class="panel-heading">Mando IR</div>
                                        <div class="panel-body">
                                                <div><button type="button" class="btn btn-danger btn-lg" onclick="mando('Encender television')"><i class="glyphicon glyphicon-off"></i></button></div>
						<br>
						<div><button type="button" class="btn btn-success btn-lg" onclick="mando('Subir programa')"><i class="glyphicon glyphicon-triangle-top"></i></button>
						<button type="button" class="btn btn-success btn-lg" onclick="mando('Bajar programa')"><i class="glyphicon glyphicon-triangle-bottom"></i></button>
						<button type="button" class="btn btn-success btn-lg" onclick="mando('Subir volumen')"><i class="glyphicon glyphicon-volume-up"></i></button>
						<button type="button" class="btn btn-success btn-lg" onclick="mando('Bajar volumen')"><i class="glyphicon glyphicon-volume-down"></i></button></div>
                                        </div>
                                </div>
                        </div>
			<div class="col-xm-12 col-sm-12">
                                <div class="panel panel-default">
                                        <div class="panel-heading">Programa</div>
                                        <div class="panel-body">
                                                <form class="form-inline" name="formulario">
                                                        <div class="form-group">
                                                                <label for="email">Tarea:</label>
                                                                <input type="radio"  name="prog" value="Encender led 1" checked="checked"> Encender led 1&nbsp;&nbsp;
                                                                <input type="radio"  name="prog" value="Apagar led 1"> Apagar led 1&nbsp;&nbsp;
                                                                <input type="radio" name="prog" value="Encender led 2"> Encender led 2&nbsp;&nbsp;
                                                                <input type="radio" name="prog" value="Apagar led 2"> Apagar led 2&nbsp;&nbsp;
								<br>
								<input type="radio"  name="prog" value="Encender television"> Encender televisión&nbsp;&nbsp;
								<input type="radio"  name="prog" value="Apagar television"> Apagar televisión&nbsp;&nbsp;
                                                                <input type="radio"  name="prog" value="Subir programa"> Subir programa&nbsp;&nbsp;
                                                                <input type="radio" name="prog" value="Bajar programa"> Bajar programa&nbsp;&nbsp;
                                                                <input type="radio" name="prog" value="Subir volumen"> Subir volumen&nbsp;&nbsp;
								<input type="radio" name="prog" value="Bajar volumen"> Bajar volumen&nbsp;&nbsp;
								<br>
                                                        </div>
                                                        <div class="form-group">
								<br>
                                                                <label for="pwd">Hora:</label>
								<input type="time" id="hora" name="time" step="300" value="12:00"/>
                                                                <!--<input type="number" class="form-control" id="hora" min="0" max="23" value="12" style="width: 100px;">&nbsp;&nbsp;
                                                                <label for="pwd">Minuto(s):</label>
                                                                <input type="number" class="form-control" id="minutos" min="0" max="55" step="5" value="0" style="width: 100px;">&nbsp;&nbsp;-->
                                                                <label for="pwd">Día(s):</label>
                                                                <select class="form-control" id="dia">
                                                                        <option value="All">Todos</option>
                                                                        <option value="Mon">Lunes</option>
                                                                        <option value="Tue">Martes</option>
                                                                        <option value="Wed">Miércoles</option>
                                                                        <option value="Thu">Jueves</option>
                                                                        <option value="Fri">Viernes</option>
                                                                        <option value="Sat">Sábado</option>
                                                                        <option value="Sun">Domingo</option>
                                                                </select>
                                                        </div>
							<br><br>
                                                        <button type="button" class="btn btn-default" onclick="aceptar()">Aceptar</button>
                                                        <button type="button" class="btn btn-warning" onclick="borrar('/home/pi/tg/cron.sh')">Borrar</button>
                                                </form>
						<p id="nota_programa">-</p>
                                        </div>
                                </div>
			</div>
		</div>
	</section>
	<footer class="bg-primary">
		<div class="container">
			<blockquote class="blockquote-reverse">
				<h4 class="text-right">Universidad de Alcalá</h4>
			</blockquote>
		</div>
	</footer>
</body>
</html>
