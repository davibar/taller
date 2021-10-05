<?php
	session_start();

	//Si la variable de sesion esta vacia lo retorna al index.php
	if($_SESSION["correo"] == ""){
		header('Location: index.php');
	}

	require_once "db/db.php";
	require_once "clases/funciones.php";
	require_once "clases/administrar.php";

	$modulo = "Restauración de datos";

	$mensaje = "";

	$archivo = "";

	$day=date("d");
	$mont=date("m");
	$year=date("Y");
	$hora=date("H-i-s");

	//Crea la fecha
	$fecha = $day.'_'.$mont.'_'.$year;

	$Tablas = administrar::tablas();

	//Si la direccion existe
	if(is_dir(BACKUP_PATH)){
		//Abre el directorio, y toma los nombres del archivo dentro de la variable
		$gestor = opendir(BACKUP_PATH);
	}

	//Cuando el formulario se envie
	if(isset($_POST['restaurar'])){

		//Definicion de variables
		if(isset($_POST['archivo'])) $archivo = trim($_POST['archivo']);

		//Funcion que limpia la cadena de caracteres
		$restaurar = funciones::limpiarCadena($archivo);

		//Si la cadena viene vacia
		if($restaurar == ""){

			//Muestra el mensaje del error
			$mensaje = "Debes seleccionar un punto de restauración";

		} else {
			
			//Explode desde ;
			$consulta = explode(";",file_get_contents($restaurar));

			//Definicion de la variable de errores
			$total_errores = 0;

			//recorre los datos del archivo
			for($i = 0; $i < (count($consulta)-1); $i++){

				//Almacenamos las consulta y le concatenamos el ;
				$sql = $consulta[$i] . ";";

				//Funcion de la clase para restaurar los datos
			    if(administrar::restaurar("$consulta[$i];")){

			    } else{ 
			    	//contador de errores
			    	$total_errores ++; 
			    }
			}

			//Si el total errores es mayor a 0
			if($total_errores > 0){
				$mensaje = "Ocurrio un error inesperado, no se pudo hacer la restauración completamente";
			}else{
				$mensaje =  "Restauración completada con éxito";
				
			}
		}

	}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "meta.php"; ?>	
	<title>Restaurar</title>
	<?php include "css.php"; ?>	
</head>
<body>

	<?php include "navbar.php"; ?>


	<div class="container-fluid" style="margin-top: 60px;">

		<div class="row">
			
			<div class="col-12">

				<div class="card-sm card-center mt-3">

					<img src="img/restaurar.png" width="50">

					<p class="text-dark font-weight-bold">Restauracion de datos</p>

					<p class="text-blue font-size-2 text-left">
						Selecciona un item de la lista para comenzar a realizar la restauracion de los datos.
					</p>

					<form method="POST">

						<div class="row">

							<div class="col-12">
								<label for="archivo"></label>
								<select name="archivo" id="archivo" class="select-form">
									<option value="" disabled="" selected="">Selecciona un punto de restauración</option>
									<?php
										$ruta=BACKUP_PATH;
										if(is_dir($ruta)){
										    if($aux=opendir($ruta)){
										        while(($archivo = readdir($aux)) !== false){
										            if($archivo!="."&&$archivo!=".."){
										                $nombrearchivo = str_replace(".sql", "", $archivo);
										                $nombrearchivo = str_replace("-", ":", $nombrearchivo);
										                $ruta_completa = $ruta.$archivo;
										                if(is_dir($ruta_completa)){
										                }else{
										                    echo '<option value="'.$ruta_completa.'">'.$nombrearchivo.'</option>';
										                }
										            }
										        }
										        closedir($aux);
										    }
										}else{
										    echo $ruta." No es ruta válida";
										}
									?>
									
								</select>

							</div>

							<div class="col-12">
								<?php if(!empty($mensaje)): ?>				
									<p class="text-red"><?php echo $mensaje ?></p>
								<?php endif; ?>
							</div>

							
						</div>

						<input type="submit" class="btn-success" name="restaurar" id="restaurar" value="Restaurar datos">
					</form>
				</div>

			</div>
		</div>

		<div class="row">

			<div class="col-12">

				<!-- TABLA CON LOS USUARIOS -->
				<?php include "usuarios.php"; ?>

			</div>

		</div>
			
	</div>

	<script src="js/funciones.js"></script>

</body>
</html>