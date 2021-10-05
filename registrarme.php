<?php

	require_once "db/db.php";
	require_once "clases/validaciones.php";
	require_once "clases/usuarios.php";

	//Variable para mostrar el error al usuario
	$mensaje = "";

	//Variables
	$nombre = "";
	$apellidos = "";
	$rut = "";
	$correo = "";
	$contrasena = "";

	//Envio del formulario
	if(isset($_POST['registrarme'])){

		//Definicion de variables
		if(isset($_POST['nombre'])) $nombre 		= trim($_POST['nombre']);
		if(isset($_POST['apellidos'])) $apellidos 	= trim($_POST['apellidos']);
		if(isset($_POST['rut'])) $rut 				= trim($_POST['rut']);
		if(isset($_POST['correo'])) $correo 		= trim($_POST['correo']);
		if(isset($_POST['contrasena'])) $contrasena = trim($_POST['contrasena']);

		//declara un array de datos
		$datos = array();

		//Pasamos los datos al array
		$datos = array(
			"nombre" 		=> $nombre,
			"apellidos" 	=> $apellidos,
			"rut" 			=> $rut,
			"correo" 		=> $correo,
			"contrasena" 	=> $contrasena
		);

		//Funcion de una clase para validar el formulario, recibe los datos del array como parametros
		$validacion = validaciones::validar_form_registro($datos);

		//Si la variable $validacion es igual diferente de vacio el formulario esta incorrecto
		if($validacion != ""){

			//Si no el mensaje que recibe la variable es el que recibio de la funcion
			$mensaje = $validacion;

		} else {

			//Funcion para $verificar si el usuarios existe
			$existe = count(usuarios::verificar($rut));

			//Si el usuario existe
			if($existe){

				//Mandamos el valor a la variable para el usuario
				$mensaje = "Ya existe un usuario con este Rut";

			} else {

				//Funcion para registrar al usuario e insertarlo en la base de datos
				$registrar = usuarios::registrar($datos);

				//Si $registrar es true, el registro fue completado
				if($registrar){

					//vaciamos las variables
					$nombre = "";
					$apellidos = "";
					$rut = "";
					$correo = "";
					$contrasena = "";

					//Muestra el mensaje al usuario del registro correcto
					$mensaje = "Registro completado correctamente";

				} else {

					//Muestra el mensaje al usuario del error
					$mensaje = "Error al crear el registro";

				}

			}

		
		}

	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registro de usuarios</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>

	<div class="content">

		<div class="card-sm card-center">

			<img src="img/registro.png" width="50">

			<h4 class="text-black font-weight-300">REGISTRO DE USUARIOS</h4>

			<form method="POST">

				<div class="row">

					<div class="col-12">
						<input type="text" class="input-form" name="nombre" id="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre">
					</div>
					<div class="col-12">
						<input type="text" class="input-form" name="apellidos" id="apellidos" value="<?php echo $apellidos; ?>" placeholder="Apellidos">
					</div>
					<div class="col-12">
						<input type="text" class="input-form" name="rut" id="rut" value="<?php echo $rut; ?>" placeholder="Rut" onkeyup="formato_rut(this)">
					</div>
					<div class="col-12">
						<input type="text" class="input-form" name="correo" id="correo" value="<?php echo $correo; ?>" placeholder="Correo">
					</div>
					<div class="col-12">
						<input type="password" class="input-form" name="contrasena" id="contrasena" value="<?php echo $contrasena; ?>" placeholder="Contraseña">
					</div>
					<div class="col-12">
						<input type="submit" class="btn" name="registrarme" id="registrarme" value="Registrarme">
					</div>
					<div class="col-12">
						<a href="index.php" class="btn-link">volver</a>
					</div>
					<div class="col-12">
						<?php if(!empty($mensaje)): ?>				
							<p class="text-red"><?php echo $mensaje ?></p>
						<?php endif; ?>
					</div>
					
				</div>
				
			
			</form>

		</div>

	</div>

	<script src="js/funciones.js"></script>
	
</body>
</html>