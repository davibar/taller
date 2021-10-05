<?php

	session_start();

	//Si la variable de sesion esta vacia lo retorna al index.php
	if($_SESSION["correo"] == ""){
		header('Location: index.php');
	}

	require_once "db/db.php";
	require_once "clases/validaciones.php";
	require_once "clases/usuarios.php";

	$modulo = "Modificar";

	//Variable para mostrar el error al usuario
	$mensaje = "";

	$nombre = "";
	$apellidos = "";
	$rut = "";
	$correo = "";
	$contrasena = "";

	//Inicia la funcion de la clase para obtener los datos del usuario, desde el rut de la variable de sesion
	$datos = usuarios::obtener(trim($_SESSION["rut"]));

	//Si el resultado es igual a 0 retornamos un error
	if(count($datos) == 0){

		//Mostramos el error al usuario
		$mensaje = "Error al obtener los datos del usuario";

	} else {

		//Completamos las variables, con los datos devueltos de la funcions
		$nombre = $datos["nombre"];
		$apellidos = $datos["apellidos"];
		$rut = $datos["rut"];
		$correo = $datos["correo"];
		$contrasena = $datos["contrasena"];

	}

	//Envio del formulario
	if(isset($_POST['modificar'])){

		//Definicion de variables
		if(isset($_POST['nombre'])) $nombre 		= trim($_POST['nombre']);
		if(isset($_POST['apellidos'])) $apellidos	= trim($_POST['apellidos']);
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

			//Ejecuta la funcion de la clase, si retorna true los datos son modificados
			$modificar = usuarios::modificar($datos);

			//Si $modificar es true, los datos del usuarios fueron modificados
			if($modificar){

				//Actualizamos las variables de sesion
				$_SESSION["nombre"] = $nombre;
				$_SESSION["correo"] = $correo;
				$_SESSION["rut"] = $rut;

				//Muestra el mensaje al usuario del registro correcto
				$mensaje = "Datos modificados correctamente";
			
			} else {

				//Muestra el mensaje al usuario del error
				$mensaje = "Error al modificar los datos";

			}

		}

	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "meta.php"; ?>	
	<title>Modificar</title>
	<?php include "css.php"; ?>	
</head>
<body>

	<?php include "navbar.php"; ?>

	<div class="container-fluid" style="margin-top: 60px;">

		<div class="card mx-auto" style="width: 30%;">

			<center>
				<img src="img/editar.png" width="50">
			</center>

			<h5 class="text-center">MODIFICAR MIS DATOS</h5>

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
						<input type="submit" class="btn" name="modificar" id="modificar" value="Modificar">
					</div>
					<div class="col-12">
						<a href="home.php" class="btn-link">volver</a>
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