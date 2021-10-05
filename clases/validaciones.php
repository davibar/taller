<?php

class validaciones {

	/**
	 *	Función de validación de un rut basado en el algoritmo chileno
	 *	el formato de entrada es ########-# en donde deben ser sólo
	 *	números en la parte izquierda al guión y número o k en el
	 *	dígito verificador
	 */
	public static function validar_rut ($rutCompleto) {
	if ( !preg_match("/^[0-9]+-[0-9kK]{1}/",$rutCompleto)) return false;
		$rut = explode('-', $rutCompleto);
		return strtolower($rut[1]) == validaciones::dv($rut[0]);
	}
	
	public static function dv ( $T ) {
		$M=0;$S=1;
		for(;$T;$T=floor($T/10))
			$S=($S+$T%10*(9-$M++%6))%11;
		return $S?$S-1:'k';
	}

	//Valida valores ingresados en el formulario
	public static function validar_form_registro($datos){

		//Almacena los datos del array en la variable
		$nombre = trim($datos["nombre"]);
		$apellidos = trim($datos["apellidos"]);
		$rut = trim($datos["rut"]);
		$correo = trim($datos["correo"]);
		$contrasena = trim($datos["contrasena"]);

		//Variable para el mensaje que se le entregara al usuario
		$mensaje = "";

		//Si todos los campos del formularios estan vacios
		if($nombre == "" && $apellidos == "" && $rut == "" && $correo == "" && $contrasena == ""){

			//Retorna el mensaje al usuario
			$mensaje = "Tienes que completar todos los campos del formulario"; 
			return $mensaje;

		} else {

			//Si en nombre esta vacio
			if($nombre == ""){

				$mensaje = "Debes ingresar tu Nombre";
				return $mensaje;

			//El los apellidos estan vacios
			} else if($apellidos == ""){

				$mensaje = "Debes ingresar tus Apellidos";
				return $mensaje;

			//Si el rut esta vacio
			} else if($rut == ""){

				$mensaje = "Debes ingresar tu Rut";
				return $mensaje;

			//Si el rut no es valido
			} else if(validaciones::validar_rut($rut) == false) {

				$mensaje = "El Rut ingresado no es valido";
				return $mensaje;

			//Si el correo esta vacio
			} else if($correo == ""){

				$mensaje = "Debes ingresar tu Correo";
				return $mensaje;

			//Valida que el correo ingresado sea un correo valido
			} else if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){

				$mensaje = "Debes ingresar un Correo valido";
				return $mensaje;

			//Si la contraseña esta vacia
			} else if($contrasena == ""){

				$mensaje = "Debes ingresar tu contraseña";
				return $mensaje;

			//Minimo de largo de la contraseña
			} else if(strlen($contrasena) < 8){

				$mensaje = "La contraseña debe tener como minimo 8 caracteres";
				return $mensaje;

			}

		}

		//retorna el valor que contiene la variable
		return $mensaje;

	}

	//Valida valores ingresados en el formulario de bitacoras
	public static function validar_form_bitacora($datos){

		//recibe los datos en una variable
		$fecha = trim($datos["fecha"]);
		$folio = trim($datos["folio"]);
		$num_empleado = trim($datos["num_empleado"]);
		$nombre_empleado = trim($datos["nombre_empleado"]);
		$dependencia = trim($datos["dependencia"]);
		$nombre_sistema = trim($datos["nombre_sistema"]);
		$descripcion_sistema = trim($datos["descripcion_sistema"]);
		$cobertura = trim($datos["cobertura"]);
		$ambiente_operacion = trim($datos["ambiente_operacion"]);
		$compatibilidad = trim($datos["compatibilidad"]);
		$lenguaje = trim($datos["lenguaje"]);
		$numero_empleado_responsable = trim($datos["numero_empleado_responsable"]);
		$nombre_responsable = trim($datos["nombre_responsable"]);
		$categoria = trim($datos["categoria"]);
		$perfil = trim($datos["perfil"]);

		//Variable para el mensaje que se le entregara al usuario
		$mensaje = "";

		//Si todas las variables vienen vacias
		if(
			$fecha == "" && 
			$folio == "" && 
			$num_empleado == "" && 
			$nombre_empleado == "" && 
			$dependencia == "" && 
			$nombre_sistema == "" && 
			$descripcion_sistema == "" && 
			$cobertura == "" && 
			$ambiente_operacion == "" && 
			$compatibilidad == "" && 
			$lenguaje == "" && 
			$numero_empleado_responsable == "" && 
			$nombre_responsable == "" && 
			$categoria == "" && 
			$perfil == ""
		) {

			//Variable para el mensaje que se le entregara al usuario
			$mensaje = "Debes completar todos los campos del formulario";
			return $mensaje;

		} else {

			//Si la fecha de la solicitud viene vacia
			if($fecha == ""){

				//Mensaje
				$mensaje = "Debes ingresar la fecha de la solicitud";
				return $mensaje;

			//Si el folio viene vacio
			} else if($folio == ""){

				//Mensaje
				$mensaje = "Debes ingresar el numero de folio";
				return $mensaje;

			//Si los carateres son mayor a 100
			} else if(strlen($folio) > 100){

				//Mensaje
				$mensaje = "El folio debe tener minimo 100 caracteres";
				return $mensaje;

			//Si el numero empleado viene vacio
			} else if($num_empleado == ""){

				//Mensaje
				$mensaje = "Debes ingresar el numero de empleado";
				return $mensaje;

			//Si los carateres son mayor a 100
			} else if(strlen($num_empleado) > 100){

				//Mensaje
				$mensaje = "El Numero del empleado debe tener minimo 100 caracteres";
				return $mensaje;

			//Si el nombre del empleado esta vacio
			} else if($nombre_empleado == ""){

				//Mensaje
				$mensaje = "Debes ingresar el nombre del empleado";
				return $mensaje;

			//Si los carateres son mayor a 100
			} else if(strlen($nombre_empleado) > 100){

				//Mensaje
				$mensaje = "El nombre del empleado debe tener minimo 100 caracteres";
				return $mensaje;

			//Si la dependencia viene vacia
			} else if($dependencia == ""){

				//Mensaje
				$mensaje = "Debes ingresar la dependencia";
				return $mensaje;

			//Si los carateres son mayor a 100
			} else if(strlen($dependencia) > 100){

				//Mensaje
				$mensaje = "La dependencia debe tener minimo 100 caracteres";
				return $mensaje;

			//Si nombre del sistema viene vacia
			} else if($nombre_sistema == ""){

				//Mensaje
				$mensaje = "Debes ingresar el nombre del sistema";
				return $mensaje;

			//Si los carateres son mayor a 100
			} else if(strlen($nombre_sistema) > 100){

				//Mensaje
				$mensaje = "El nombre del sistema debe tener minimo 100 caracteres";
				return $mensaje;

			//Si la descripcion del sistema viene vacia
			} else if($descripcion_sistema == ""){

				//Mensaje
				$mensaje = "Debes ingresar el nombre del sistema";
				return $mensaje;

			//Si los carateres son mayor a 200
			} else if(strlen($descripcion_sistema) > 200){

				//Mensaje
				$mensaje = "la descripcion del sistema debe tener minimo 200 caracteres";
				return $mensaje;

			//Si cobertura viene vacio
			} else if($cobertura == ""){

				//Mensaje
				$mensaje = "Debes ingresar la cobertura";
				return $mensaje;

			//Si los carateres son mayor a 100
			} else if(strlen($cobertura) > 100){

				//Mensaje
				$mensaje = "La cobertura debe tener minimo 100 caracteres";
				return $mensaje;

			//Si el ambiente de operación viene vacio
			} else if($ambiente_operacion == "0"){

				//Mensaje
				$mensaje = "Debes seleccionar un ambiente de operación";
				return $mensaje;

			//Si los carateres son mayor a 100
			} else if(strlen($ambiente_operacion) > 100){

				//Mensaje
				$mensaje = "El ambiente de operacion debe tener minimo 100 caracteres";
				return $mensaje;


			//Si compatibilidad viene vacio
			} else if($compatibilidad == ""){

				//Mensaje
				$mensaje = "Debes ingresar la compatibilidad";
				return $mensaje;


			//Si los carateres son mayor a 100
			} else if(strlen($compatibilidad) > 100){

				//Mensaje
				$mensaje = "La compatibilidad debe tener minimo 100 caracteres";
				return $mensaje;

			//Si lenguaje del programación viene vacio
			} else if($lenguaje == ""){

				//Mensaje
				$mensaje = "Debes el lenguaje de programación";
				return $mensaje;

			//Si los carateres son mayor a 100
			} else if(strlen($lenguaje) > 100){

				//Mensaje
				$mensaje = "El lenguaje de programación debe tener minimo 100 caracteres";
				return $mensaje;


			//Si categoria viene vacia
			} else if($categoria == ""){

				//Mensaje
				$mensaje = "Debes ingresar la categoria";
				return $mensaje;

			//Si los carateres son mayor a 100
			} else if(strlen($categoria) > 100){

				//Mensaje
				$mensaje = "La categoria debe tener minimo 100 caracteres";
				return $mensaje;

			//Si perfil viene vacio
			} else if($perfil == ""){

				//Mensaje
				$mensaje = "Debes ingresar el perfil";
				return $mensaje;

			//Si los carateres son mayor a 100
			} else if(strlen($perfil) > 100){

				//Mensaje
				$mensaje = "El perfil debe tener minimo 100 caracteres";
				return $mensaje;

			} else {

				//retorna la variable vacia
				return $mensaje;
			}

		}

	}
}

?>