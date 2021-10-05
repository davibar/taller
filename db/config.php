<?php

	$URL = "localhost";

	//Si la conexion es local
	if($URL == "localhost"){

		//Definicion de variables con parametros de conexion a la base de datos
		define("SERVER","127.0.0.1:3307");
		define("USER","root");
		define("PASSWORD","");
		define("DATABASE","taller");

	} else {

		//Definicion de variables con parametros de conexion a la base de datos
		define("SERVER","127.0.0.1:3306");
		define("USER","root");
		define("PASSWORD","di4100");
		define("DATABASE","taller");

	}

	//Carpeta donde se almacenaran las copias de seguridad
	define("BACKUP_PATH", "backup/");
	
?>