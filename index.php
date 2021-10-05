<?php

	session_start();
	require_once "db/db.php";
	require_once "clases/login.php";

	//Variable para mostrar el error al usuario
	$mensaje = "";

	$rut = "";
	$contrasena = "";

	//Submit
	if(isset($_POST['login'])){

		//Definicion de variables
		if(isset($_POST['rut'])) $rut = trim($_POST['rut']);
		if(isset($_POST['contrasena'])) $contrasena = trim($_POST['contrasena']);

		//Si el rut y la contraseña estan vacios
		if($rut == "" && $contrasena == ""){

			$mensaje = "Tienes que ingresar el Rut y la contraseña";

		} else {

			//Si rut esta vacio
			if($rut == ""){

				$mensaje = "Debes ingresar tu Rut";

			//Si la contraseña esta vacia
			} else if($contrasena == "") {

				$mensaje = "Debes ingresar tu contraseña";

			//De lo contrario sigue con la funcion
			} else {

				//Ejecuta la funcion de la clase y retorna true o false, si es false
				if(login::ingresar($rut, $contrasena) == false){
					
					//Muestra el mensaje al usuario
					$mensaje = "Rut o contraseña incorrecto";
				} else {
					header('Location: home.php');
				}

			}

		}

	}

	#$rut = "193kKm";
	#$rut = preg_replace('/[^k0-9]/i', '', $rut);
	#echo $rut;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>LOGIN</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>

	<div class="content">

		<div class="card-sm card-center">

			<img src="img/login.png" width="50">

			<h4 class="text-black font-weight-300">INGRESO DE USUARIOS</h4>

			<form method="POST" class="_form-login">

				<div class="row">

					<div class="col-12">
						<input type="text" class="input-form" name="rut" id="rut" placeholder="Rut" onkeyup="formato_rut(this)" value="<?php echo $rut; ?>">
					</div>
					<div class="col-12">
						<input type="password" class="input-form" name="contrasena" id="contrasena" placeholder="Contraseña" value="<?php echo $contrasena; ?>">
					</div>
					<div class="col-12">
						<a href="registrarme.php" class="btn-link btn-registrarse">registrarme</a>
					</div>
					<div class="col-12">
						<input type="submit" class="btn" name="login" id="login" value="Ingresar">				
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