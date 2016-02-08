<?php session_start(); ?>
	//Nos conectamos (creamos el objeto) a guardias:
	$dbConnection_guardias = conectar(guardias);
	//Ahora nos conectamos (creamos el objeto) a actividades extraescolares:
	$dbConnection_actividades_profesores = conectar(actividades_extraescolares);
	
	//Compruebo si hay observaciones ya en la base de datos y en tal caso lo recupero y lo envío:
	$consulta = $dbConnection_guardias->prepare('SELECT observaciones FROM ausencias_profesores WHERE cod_profesor = :cod_profesor AND fecha = :fecha AND cod_hora = :cod_hora AND observaciones IS NOT NULL');
	$consulta  -> bindParam(':cod_profesor',$_SESSION["cod_profesor"]);
	$consulta  -> bindParam(':fecha',$_POST["fecha_calendario"]);
	$consulta  -> bindParam(':cod_hora',$_POST["cod_hora"]);
	$consulta  -> execute();
	
	//Si tengo un resultado, paso las observaciones, si no lo paso vacío.