<?php 

	class login {

		//Funcion para ingresar a la aplicacion
		public static function ingresar($rut, $contrasena){

			//Llama a la conexion
			$conexion = conexion();

			//Tipo de datos utf-8
			//mysqli_set_charset($conexion,"utf8");
			
			//Consulta
			$consulta = "SELECT * FROM usuarios WHERE rut = '".$rut."' AND contrasena = '".$contrasena."' ";
			$resultado = mysqli_query($conexion, $consulta);

			//
			$count = 0;

			//Crea el ciclo para obtener los datos con desde un array asociativo
			while($row = mysqli_fetch_assoc($resultado)){
				$count++;
				//Crea la variable de sesion 
				$_SESSION["id"] = $row["id"];
				$_SESSION["nombre"] = $row["nombre"];
				$_SESSION["apellidos"] = $row["apellidos"];
				$_SESSION["correo"] = $row["correo"];
				$_SESSION["rut"] = $row["rut"];
			}	 	

			//Retornamos el valor con un true o false
			if($count == 1){ return true; } else {	return false; } 	

			//Cierra la conexion
			mysqli_close($conexion);


		}

	}

?>