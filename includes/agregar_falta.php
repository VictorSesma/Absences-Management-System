<?php session_start(); ?>
	
	//Ahora comprobamos si soy fake_cod_profesor para que el administrador pueda editar cualquier profesor:

	if(isset($_SESSION["fake_cod_profesor"])) {
		$session_cod_profesor = $_SESSION["fake_cod_profesor"];
	}else {
		$session_cod_profesor = $_SESSION["cod_profesor"];
		
	}
	//A partir de este momento usaré siempre este session_cod_profesor.	
	

	//Nos conectamos (creamos el objeto) a guardias:
	$dbConnection_guardias = conectarBD(guardias);
	//Ahora nos conectamos (creamos el objeto) a actividades extraescolares:
	$dbConnection_actividades_profesores = conectarBD(actividades_extraescolares);
	
	//Compruebo si hay observaciones ya en la base de datos y en tal caso lo recupero y lo envío:
	$consulta = $dbConnection_guardias->prepare('SELECT observaciones FROM ausencias_profesores WHERE cod_profesor = :cod_profesor AND fecha = :fecha AND cod_hora = :cod_hora AND observaciones IS NOT NULL');
	$consulta  -> bindParam(':cod_profesor',$session_cod_profesor);
	$consulta  -> bindParam(':fecha',$_POST["fecha_calendario"]);
	$consulta  -> bindParam(':cod_hora',$_POST["cod_hora"]);
	$consulta  -> execute();
	
	//Creo el array:
	$observaciones = array();
	//Si tengo un resultado, paso las observaciones, si no lo paso vacío.
		