<?php

require_once "config.php";

//Funcion para conectar a la base de datos
function conexion(){

	//Conexion a la base de datos
	$conexion = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);

	//Verifica si la conexion es correcta, true o false
	if(!$conexion){
		//Imprime el error
		echo 'Error al conectar a la base de datos';
	} else {
		//Imprime la conexion correcta
		#echo 'Conectado correctamente';

	}

	return $conexion;
}

?>