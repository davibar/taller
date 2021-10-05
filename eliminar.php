<?php

	//Session start
	session_start();
	
	//Si la variable de sesion esta vacia lo retorna al index.php
	if($_SESSION["correo"] == ""){
		header('Location: index.php');
	}

	require_once "db/db.php";
	require_once "clases/usuarios.php";

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

		}

	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>HOME</title>
	<link rel="stylesheet" href="css/main.css?r=123456789">
</head>
<body>

	<div class="content">

		<div class="row">	

			<div class="col-12">

				<div class="card card-center">

					<form method="POST">
				
						<p class="text-red font-weight-bold">Usuario eliminado correctamente</p>

						<div class="row">

							<div class="col-12">
								<img src="img/eliminado.png" width="100">
							</div>

							<div class="col-12">
								<input type="submit" class="btn" name="salir" id="salir" value="Cerrar">	
							</div>
							
						</div>
					
					</form>

				</div>

			</div>

		</div>

	</div>
	
</body>
</html>