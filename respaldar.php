<?php 

	session_start();

	//Si la variable de sesion esta vacia lo retorna al index.php
	if($_SESSION["correo"] == ""){
		header('Location: index.php');
	}

	require_once "db/db.php";
	require_once "clases/administrar.php";

	$modulo = "Respaldo de datos";

	//Variable para el mensaje
	$mensaje = "";

	$day=date("d");
	$mont=date("m");
	$year=date("Y");
	$hora=date("H-i-s");

	//Crea la fecha
	$fecha=$day.'_'.$mont.'_'.$year;

	$Tablas = administrar::tablas();

	//Si la direccion existe
	if(is_dir(BACKUP_PATH)){
		//Abre el directorio, y toma los nombres del archivo dentro de la variable
		$gestor = opendir(BACKUP_PATH);
	}

	//Cuando se envie el formulario
	if(isset($_POST['respaldar'])){

		//Si devuelve false, no existen tablas en la base de datos
		if($Tablas == false) {

			//Muestra el mensaje al usuario
			$mensaje = "No se encontraron tablas en la base de datos";

		//Entonces continua con el proceso de respaldo
		} else {

			//Definicion de variables
			if(isset($_POST['tabla'])) $tabla = trim($_POST['tabla']);

			//Funcion para crear el respaldo, pasa como parametro el nombre de la tabla seleccionada
			$Registros = administrar::respaldar($tabla);

			//Si devuelve true
			if($Registros){

				//nombre del archivo
				$path_name = $tabla ."_". $fecha . ".sql";

				//Recibe el nombre de la ruta y el tipo de escritura del archivo
				chmod(BACKUP_PATH, 0777);
		        #$sql='SET FOREIGN_KEY_CHECKS=1;';

		        //Recibe la ruta y el nombre del archivo
		        $handle=fopen(BACKUP_PATH.$path_name,'w+');

		        //se le pasa como parametro el directorio con el nombre del archivo y los datos que contendra el archivo creado
		        if(fwrite($handle, $Registros)){
		        	//cierra el archivo
		            fclose($handle);
		            //retorna la respuesta
		            echo 'Copia de seguridad realizada';
		        }else{
		        	// si existe un error
		            echo 'Ocurrio un error';
		        }
			
			} else {
				//retorna el mensaje
				$mensaje = $Registros;
			}
		}

	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "meta.php"; ?>	
	<title>Respaldo de datos</title>
	<?php include "css.php"; ?>	
</head>
<body>

	<?php include "navbar.php"; ?>


	<div class="container-fluid" style="margin-top: 60px;">

		<div class="row align-center">

			<div class="col-4">

				<div class="card-sm card-center mt-3">

					<img src="img/backup.png" width="50">

					<p class="text-dark font-weight-bold">Crea un respaldo de seguridad de tu base de datos</p>

					<p class="text-blue font-size-2 text-left">
						Tienes que seleccionar una tabla de la cual quieres realizar el respaldo
					</p>

					<form method="POST">

						<div class="row">

							<div class="col-12">
								<label for="tabla"></label>
								<select name="tabla" id="tabla" class="select-form">
									<?php if($Tablas){
										foreach($Tablas as $Tabla){
									?>
									<option value="0">Seleccione una tabla</option>
									<option value="<?php echo $Tabla ?>"><?php echo $Tabla ?></option>
									<?php } } else { ?>
									<option value="">No hay tablas</option>
									<?php } ?>
								</select>
							</div>
							
						</div>

						<input type="submit" class="btn-success" name="respaldar" id="respaldar" value="Crear un respaldo"/>
					</form>
				</div>

			</div>

			<div class="col-4">

				<div class="card-sm card-center mt-3">

					<img src="img/download.png" width="50">

					<p class="text-dark font-weight-bold">Descarga de respaldos</p>

					<p class="text-blue font-size-2 text-left">
						Puedes descargar los respaldos realizados anteriormente, seleccionando uno de los archivos de la lista
					</p>

					<form method="POST">

						<div class="row">

							<div class="col-12">
								<label for="archivo"></label>
								<select name="archivo" id="archivo" class="select-form">
									<?php 
										while (($archivo = readdir($gestor)) !== false)  {
											$ruta_completa = BACKUP_PATH . $archivo;

												if ($archivo != "." && $archivo != "..") {

													$file = explode("usuarios_", $archivo);
									                // Si es un directorio se recorre recursivamente
									                if (is_dir($ruta_completa)) {
									?>
									<option value="<?php echo $archivo ?>"><?php echo $archivo ?></option>
									<?php
									                    #obtener_estructura_directorios($ruta_completa);
									                } else {
									?>
									<option value="<?php echo $archivo ?>"><?php echo $file[1] ?></option>
									<?php
									                }
									            }
									        }
									?>		
								</select>

							</div>

							
						</div>

						<a class="btn-success" name="download" id="download" onclick="descargar_respaldo()">
							Descargar respaldo
						</a>
					</form>
				</div>

			</div>

		</div>

	</div>

	<script src="js/funciones.js"></script>


</body>
</html>