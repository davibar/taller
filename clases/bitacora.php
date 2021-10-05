<?php 

	class bitacora {

		public static function obtener_folio(){

			//Llama a la conexion
			$conexion = conexion();

			//Tipo de datos utf-8
			//mysqli_set_charset($conexion,"utf8");
			
			//query para insertar un usuario
			$consulta = "SELECT folio FROM bitacora ORDER BY folio DESC LIMIT 1";
			$resultado = mysqli_query($conexion, $consulta);

			//si el numero de filas es igual a 0, creamos el folio 1
			if(mysqli_num_rows($resultado) == 0){

				$folio = 1;

			//si no obtiene el ultimo folio y le suma 1
			} else {

				//Devuelve el resultado de la fila
				$folio = mysqli_fetch_row($resultado);
				//Obtiene el valor, convertido en entero y se le suma 1
				$folio =  intval($folio[0]) + 1;
			}

			//Cierra la conexion
			mysqli_close($conexion);

			//retorna la respuesta
			return $folio;
		}


		//Funcion para guardar la bitacora de usuarios
		public static function guardar($datos){

			//Llama a la conexion
			$conexion = conexion();

			//Tipo de datos utf-8
			//mysqli_set_charset($conexion,"utf8");

			$fecha = new DateTime();
			$fecha = $fecha->format('Y-m-d H:i:s'); // 2011-01-01 15:03:01
			
			//query para insertar un usuario
			$consulta = "INSERT INTO bitacora(
							    id_usuario,
							    fecha, 
							    folio, 
							    num_empleado, 
							    nombre_empleado,
							    dependencia,
							    nombre_sistema,
							    descripcion_sistema,
							    cobertura,
							    ambiente_operacion,
							    compatibilidad,
							    lenguaje,
							    categoria,
							    perfil
							) VALUES (
								".$datos["id_usuario"].",
								'".$datos["fecha"]."',
								'".$datos["folio"]."',
								'".$datos["num_empleado"]."',
								'".$datos["nombre_empleado"]."',
								'".$datos["dependencia"]."',
								'".$datos["nombre_sistema"]."',
								'".$datos["descripcion_sistema"]."',
								'".$datos["cobertura"]."',
								'".$datos["ambiente_operacion"]."',
								'".$datos["compatibilidad"]."',
								'".$datos["lenguaje"]."',
								'".$datos["categoria"]."',
								'".$datos["perfil"]."'
						)";


			$resultado = mysqli_query($conexion, $consulta);

			//Definimos la respuesta como false
			$respuesta = false;

			//Si retorna true, los datos fueron insertados correctamente
			if($resultado){
				$respuesta = true;
			} else {
				$respuesta = false;
			}

			//Cierra la conexion
			mysqli_close($conexion);

			//retorna la respuesta
			return $respuesta;

		}


		//Funcion para listar las bitacoras
		public static function listar(){

			//Llama a la conexion
			$conexion = conexion();

			//Tipo de datos utf-8
			mysqli_set_charset($conexion,"utf8");
			
			//query para insertar un usuario
			$consulta = "SELECT * FROM bitacora ORDER BY folio DESC ";
			$resultado = mysqli_query($conexion, $consulta);

			//Cierra la conexion
			mysqli_close($conexion);

			//retorna la respuesta
			return $resultado;


		}

	}


?>