<?php

	//Session start
	session_start();
	
	//Si la variable de sesion esta vacia lo retorna al index.php
	if($_SESSION["rut"] == ""){
		header('Location: index.php');
	}

	require_once "db/db.php";
	require_once "clases/usuarios.php";

	$modulo = "Home";

	//Submit
	if(isset($_POST['salir'])){
		//Destruye la sesion
		session_destroy();
		//Retorna al index.php
		header('Location: index.php');
	}

	//Submit
	if(isset($_POST['eliminar'])){

		//Ejecuta la funcion de la clase y retorna true o false, si es false
		if(usuarios::eliminar($_SESSION["rut"]) == false){
			
			//Muestra el mensaje al usuario del error
			$mensaje = "Error al eliminar el usuario";

		} else {

			//Muestra el mensaje al usuario del registro correcto
			$mensaje = "Usuario eliminado correctamente";

			//Destruye la sesion
			session_destroy();

			//Retorna al index.php
			header('Location: eliminar.php');

		}

	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "meta.php"; ?>	
	<title>HOME</title>
	<?php include "css.php"; ?>	
</head>
<body>

	<?php include "navbar.php"; ?>

	<div class="container-fluid" style="margin-top: 60px;">

		<form method="POST">

			<div class="alert alert-light text-center" role="alert">

			  	<i class="fa fa-heart text-danger"></i> Bienvenido <a href="modificar.php" class="alert-link"><?php echo $_SESSION["nombre"]; ?></a>, <button type="submit" class="btn-link text-gray" name="salir" id="salir">Salir <i class="fa fa-sign-out-alt text-secondary"></i></button>

			  	<div class="d-flex justify-content-center">			
					<button type="submit" class="btn-link btn-sm text-danger" name="eliminar" id="eliminar">
						<i class="fa fa-times-circle text-danger"></i> Eliminar mi cuenta
					</button>
				</div>

			</div>

			
		</form>


		<div class="row d-flex justify-content-around">	

			<div class="col-md-4">	

				<div class="card">

					<center>
						<img src="img/backup.png" width="50">
					</center>

					<h4>Respaldo de datos</h4>

					<p class="text-blue">Crea un respaldo de seguridad de tu base de datos</p>

					<a href="respaldar.php" class="btn">Respaldar</a>
					
				</div>		

			</div>

			<div class="col-md-4">	

				<div class="card">

					<center>
						<img src="img/restaurar.png" width="50">
					</center>					

					<h4>Restauración de datos</h4>

					<p class="text-blue">Crea un punto de restauración  de tu base de datos</p>

					<a href="restaurar.php" class="btn">Restaurar</a>
					
				</div>		

			</div>

			<div class="col-md-4">	

				<div class="card">
					<center>
						<img src="img/formulario.png" width="50">
					</center>
					

					<h4>Bitácora de usuario</h4>

					<p class="text-blue">Realizar una nueva bitácora de usuario</p>

					<a href="bitacora.php" class="btn">Bitácora</a>
					
				</div>		

			</div>
		</div>


	</div>
	
</body>
</html>