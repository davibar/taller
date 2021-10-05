<?php 

	class administrar {

		//Funcion para consultar las tablas existentes dentro de la base de datos
		public static function tablas() {

			//Llama a la conexion
			$conexion = conexion();

			//Tipo de datos utf-8
			mysqli_set_charset($conexion,"utf8");
			
			//query para insertar un usuario
			$consulta = "SHOW TABLES";
			$resultados = mysqli_query($conexion, $consulta);
			$resultados = mysqli_fetch_row($resultados);

			//Cierra la conexion
			mysqli_close($conexion);

			//Retorna el resultado
			return $resultados;
		}

		//Funcion para realizar el respaldo de los datos de la tabla
		public static function respaldar($tabla){

			//Verifica que exista el nombre de la tablas
			if($tabla != ""){
				
				//Recibe el nombre de la tabla
				switch($tabla){

					case "usuarios":

						//Llama a la conexion
						$conexion = conexion();

						//Tipo de datos utf-8
						mysqli_set_charset($conexion,"utf8");
						
						//query para insertar un usuario
						$consulta = "SELECT * FROM usuarios ORDER BY Nombre ASC ";
						$resultados = mysqli_query($conexion, $consulta);

						$datos = "";

						//Si retorna TRUE
						if($resultados){
							//Crea la sentencia SQL
							foreach($resultados as $resultado){
							   $datos .= "INSERT INTO ".$tabla." (nombre, apellidos, rut, correo, contrasena, fecha) VALUES ('".$resultado['nombre']."', '".$resultado['apellidos']."', '".$resultado['rut']."', '".$resultado['correo']."', '".$resultado['contrasena']."', '".$resultado['fecha']."' );\n\n" ;
							}
						}

						//Cierra la conexion
						mysqli_close($conexion);

						//retorna los datos
						return $datos;
						break;

					default:

						echo "El nombre de la tabla no existe";	

				}

			} else {

				echo "Falta enviar el nombre de la tabla como parametro";
			}

		}

		//Funcion para realizar la restauracion de los datos
		public static function restaurar($consulta){

			//Llama a la conexion
			$conexion = conexion();

			//Tipo de datos utf-8
			mysqli_set_charset($conexion,"utf8");

			//Resultado de la consulta
            $resultados = mysqli_query($conexion, $consulta);

            //Cierra la conexion
			mysqli_close($conexion);

			//Retorna el resultado
			return $resultados;
		}

	}

 ?>