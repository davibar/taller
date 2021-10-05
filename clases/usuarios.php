<?php 
 
	class usuarios {

		//Verifica si el usuario existe
		public static function verificar($rut){

			//Llama a la conexion
			$conexion = conexion();
			
			//query para insertar un usuario
			$consulta = "SELECT * FROM usuarios WHERE rut = '".$rut."' ";
			$resultado = mysqli_query($conexion, $consulta);

			$datos = array();

			//Crea el ciclo para obtener los datos con desde un array asociativo
			while($row = mysqli_fetch_assoc($resultado)){

				//Llena el arreglo con los datos obtenidos
				$datos = $row;
			}

			//Cierra la conexion
			mysqli_close($conexion);

			//retorna la respuesta
			return $datos;

		}

		//Funcion para crear un nuevo registro de usuario
		public static function registrar($datos){

			//Llama a la conexion
			$conexion = conexion();

			//Tipo de datos utf-8
			//mysqli_set_charset($conexion,"utf8");

			$fecha = new DateTime();
			$fecha = $fecha->format('Y-m-d H:i:s'); // 2011-01-01 15:03:01
			
			//query para insertar un usuario
			$consulta = "INSERT INTO usuarios(
								nombre, 
								apellidos,
								rut,
								correo,
								contrasena,
								fecha
							) VALUES (
								'".$datos["nombre"]."',
								'".$datos["apellidos"]."',
								'".$datos["rut"]."',
								'".$datos["correo"]."',
								'".$datos["contrasena"]."',
								'".$fecha."'
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

		//Funcion para obtener los datos de un registro
		public static function obtener($rut){

			//Llama a la conexion
			$conexion = conexion();

			//Tipo de datos utf-8
			//mysqli_set_charset($conexion,"utf8");
			
			//query para insertar un usuario
			$consulta = "SELECT * FROM usuarios WHERE rut = '".$rut."' ";
			$resultado = mysqli_query($conexion, $consulta);

			$datos = array();

			//Crea el ciclo para obtener los datos con desde un array asociativo
			while($row = mysqli_fetch_assoc($resultado)){

				//Llena el arreglo con los datos obtenidos
				$datos = array(
					"nombre" => $row["nombre"],
					"apellidos" => $row["apellidos"],
					"rut" => $row["rut"],
					"correo" => $row["correo"],
					"contrasena" => $row["contrasena"],
				);
			}

			//Cierra la conexion
			mysqli_close($conexion);

			//retorna la respuesta
			return $datos;


		}

		//Funcion para modificar un registro
		public static function modificar($datos){

			//Llama a la conexion
			$conexion = conexion();
			
			//query para modificar los datos del usuario
			$consulta = "UPDATE usuarios SET
								nombre = '".$datos["nombre"]."', 
								apellidos = '".$datos["apellidos"]."',
								rut = '".$datos["rut"]."',
								correo = '".$datos["correo"]."',
								contrasena = '".$datos["contrasena"]."' 
							WHERE rut = '".$datos["rut"]."' ";

			$resultado = mysqli_query($conexion, $consulta);

			//Definimos la respuesta como false
			$respuesta = false;

			//Si retorna true, los datos fueron modificados correctamente
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

		//Funcion para eliminar un registro
		public static function eliminar($rut){

			//Llama a la conexion
			$conexion = conexion();
			
			//query para insertar un usuario
			$consulta = "DELETE FROM usuarios WHERE rut = '".$rut."' ";
			$resultado = mysqli_query($conexion, $consulta);

			//Definimos la respuesta como false
			$respuesta = false;

			//Si retorna true, el registro se elimino correctamente
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

		//Funcion para listar los usuarios
		public static function listar(){

			//Llama a la conexion
			$conexion = conexion();

			//Tipo de datos utf-8
			mysqli_set_charset($conexion,"utf8");
			
			//query para insertar un usuario
			$consulta = "SELECT * FROM usuarios ORDER BY Nombre ASC ";
			$resultado = mysqli_query($conexion, $consulta);

			//Cierra la conexion
			mysqli_close($conexion);

			//retorna la respuesta
			return $resultado;


		}

	}

?>