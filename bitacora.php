<?php

	//Session start
	session_start();
	
	//Si la variable de sesion esta vacia lo retorna al index.php
	if($_SESSION["correo"] == ""){
		header('Location: index.php');
	}

	require_once "db/db.php";
	require_once "clases/validaciones.php";
	require_once "clases/bitacora.php";

	//Titulo del modulo para el nav (head) de la pagina
	$modulo = "Bitácora de usuario";

	//Llama a la funcion listar de la clase bitacora, y almacena los datos en la variable
	$bitacoras = bitacora::listar();

	$id_usuario = $_SESSION["id"]; //--> creamos el id del usuario con la variable de sesion de su propio id
	$fecha = new DateTime();
	$fecha = $fecha->format('Y-m-d H:i:s'); // 2011-01-01 15:03:01
	$folio = bitacora::obtener_folio(); //--> funcion que devuelve el folio para la bitacora
	$num_empleado = $_SESSION["id"]; //--> numero empleado desde el Id de la variable de sesion
	$nombre_empleado = $_SESSION["nombre"] . " " . $_SESSION["apellidos"]; //--> nombre completo del empleado usando variables de sesion
	$dependencia = "";
	$nombre_sistema = "";
	$descripcion_sistema = "";
	$cobertura = "";
	$ambiente_operacion = "";
	$compatibilidad = "";
	$lenguaje = "";
	$numero_empleado_responsable = "7000"; //--> datos por defectos
	$nombre_responsable = "Sergio Ibarra Solis"; //--> datos por defectos
	$categoria = "Sistemas de información"; //--> datos por defectos
	$perfil = "Desarrollador de Software"; //--> datos por defectos

	//Cuando se envie el formulario
	if(isset($_POST['guardar'])){

		//Definicion de las variables
		if(isset($_POST['fecha'])) $fecha = trim($_POST['fecha']);
		if(isset($_POST['folio'])) $folio = trim($_POST['folio']);
		if(isset($_POST['num_empleado'])) $num_empleado = trim($_POST['num_empleado']);
		if(isset($_POST['nombre_empleado'])) $nombre_empleado = trim($_POST['nombre_empleado']);
		if(isset($_POST['dependencia'])) $dependencia = trim($_POST['dependencia']);
		if(isset($_POST['nombre_sistema'])) $nombre_sistema = trim($_POST['nombre_sistema']);
		if(isset($_POST['descripcion_sistema'])) $descripcion_sistema = trim($_POST['descripcion_sistema']);
		if(isset($_POST['cobertura'])) $cobertura =  trim($_POST['cobertura']);
		if(isset($_POST['ambiente_operacion'])) $ambiente_operacion = trim($_POST['ambiente_operacion']);
		if(isset($_POST['compatibilidad'])) $compatibilidad = trim($_POST['compatibilidad']);
		if(isset($_POST['lenguaje'])) $lenguaje = trim($_POST['lenguaje']);
		if(isset($_POST['numero_empleado_responsable'])) $numero_empleado_responsable = trim($_POST['numero_empleado_responsable']);
		if(isset($_POST['nombre_responsable'])) $nombre_responsable = trim($_POST['nombre_responsable']);
		if(isset($_POST['categoria'])) $categoria = trim($_POST['categoria']);
		if(isset($_POST['perfil'])) $perfil = trim($_POST['perfil']);

		//Volvemos a consultar el folio, en caso de ser usado por otro usuario
		$folio_final = bitacora::obtener_folio();

		//Validamos que los folios sean iguales
		if($folio == $folio_final){

			//Folio es igual al folio que se asigno
			$folio = $folio;

		} else {

			//De lo contrario, folio asignado, obtiene el folio final
			$folio = $folio_final;
			
		}

		//declara un array de datos
		$datos = array();

		//Pasamos los datos al array
		$datos = array(
			"id_usuario"					=> $id_usuario,
			"fecha" 						=> $fecha,
			"folio" 						=> $folio,
			"num_empleado" 					=> $num_empleado,
			"nombre_empleado" 				=> $nombre_empleado,
			"dependencia" 					=> $dependencia,
			"nombre_sistema" 				=> $nombre_sistema,
			"descripcion_sistema" 			=> $descripcion_sistema,
			"cobertura"						=> $cobertura,
			"ambiente_operacion" 			=> $ambiente_operacion,
			"compatibilidad" 				=> $compatibilidad,
			"lenguaje" 						=> $lenguaje,
			"numero_empleado_responsable" 	=> $numero_empleado_responsable,
			"nombre_responsable" 			=> $nombre_responsable,
			"categoria" 					=> $categoria,
			"perfil" 						=> $perfil,
		);


		//Funcion de una clase para validar el formulario, recibe los datos del array como parametros
		$validacion = validaciones::validar_form_bitacora($datos);

		//Si la variable $validacion es igual diferente de vacio el formulario esta incorrecto
		if($validacion != ""){

			//Si no el mensaje que recibe la variable es el que recibio de la funcion
			$mensaje = '<i class="fa fa-exclamation-triangle text-warning"></i> <span class="text-danger">'.$validacion.'</span>';

		//Si validacion viene vacia, todos los campos cumplen con la funcion de validacion
		} else {

			//Funcion para guardar la bitacora, retorna true o false.
			$guardar = bitacora::guardar($datos);

			//Si devuelve true
			if($guardar){

				//Limpiamos las variables
				$fecha = $fecha;
				$folio = bitacora::obtener_folio();
				$num_empleado = $_SESSION["id"];
				$nombre_empleado = $_SESSION["nombre"] . " " . $_SESSION["apellidos"]; 
				$dependencia = "";
				$nombre_sistema = "";
				$descripcion_sistema ="";
				$cobertura = "";
				$ambiente_operacion = "";
				$cliente_servidor = "";
				$web = "";
				$lenguaje = "";
				$numero_empleado_responsable = "7000"; //--> datos por defectos
				$nombre_responsable = "Sergio Ibarra Solis"; //--> datos por defectos
				$categoria = "Sistemas de información"; //--> datos por defectos
				$perfil = "Desarrollador de Software"; //--> datos por defectos

				//Muestra el mensaje al usuario del registro correcto
				$mensaje = '<i class="fa fa-check text-success"></i> <span class="text-success">Bitácora guardada correctamente</span>';

			//Si no, le muestra el mensaje al usuario
			} else {

				//Muestra el mensaje al usuario del error
				$mensaje = '<i class="fa fa-times text-danger"></i> <span class="text-danger">Error al guardar la bitácora</span>';

			}
		}

	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "meta.php" ?>
	<title>Bitácora</title>
	<?php include "css.php"; ?>
</head>
<body>

	<?php include "navbar.php"; ?>

	<div class="container-fluid mb-4" style="margin-top: 60px;">

		<div class="card mx-auto" style="width:50%; min-width: 400px;">

			<form method="POST">

				<div class="card-body">

					<?php if(!empty($mensaje)): ?>
						<div class="alert alert-light text-center" role="alert">											
							<?php echo $mensaje; ?>
						</div>
					<?php endif; ?>

					<div class="form-row">

						<div class="form-group col-md-6">
							<label for="fecha"> Fecha de solicitud</label>
							<input type="text" class="form-control form-control-sm" name="fecha" id="fecha" value="<?php echo $fecha; ?>" disabled>
						</div>

						<div class="form-group col-md-6">
							<label for="folio">N° Folio</label>
							<input type="text" class="form-control form-control-sm" name="folio" id="folio" value="<?php echo $folio; ?>" disabled>
						</div>

						<div class="form-group col-md-12">
							<h5 class="text-center">Datos del responsable de la dependencia solicitante</h5>
						</div>
				
						<div class="form-group col-md-6">
							<label for="num_empleado">N° Empleado</label>
							<input type="text" class="form-control form-control-sm" name="num_empleado" id="num_empleado" value="<?php echo $num_empleado; ?>" disabled>
						</div>

						<div class="form-group col-md-6">
							<label for="nombre_empleado">Nombre</label>			
							<input type="text" class="form-control form-control-sm" name="nombre_empleado" id="nombre_empleado" value="<?php echo $nombre_empleado; ?>" disabled>
						</div>

						<div class="form-group col-md-12">
							<label for="dependencia">Dependencia</label>			
							<input type="text" class="form-control form-control-sm" name="dependencia" id="dependencia" value="<?php echo $dependencia; ?>" maxlength="100">
							<small id="passwordHelpBlock" class="form-text text-muted">* Mínimo 100 caracteres.</small>
						</div>

						<div class="form-group col-md-12">
							<h5 class="text-center">Datos del sistema de información a desarrollar</h5>
						</div>

						<div class="form-group col-md-12">
							<label for="nombre_sistema">Nombre del sistema</label>			
							<textarea class="form-control form-control-sm" name="nombre_sistema" id="nombre_sistema" rows="3" maxlength="100"><?php echo $nombre_sistema; ?></textarea>
							<small id="passwordHelpBlock" class="form-text text-muted">* Mínimo 100 caracteres.</small>
						</div>

						<div class="form-group col-md-12">
							<label for="descripcion_sistema">Descripción breve</label>			
							<textarea class="form-control form-control-sm" name="descripcion_sistema" id="descripcion_sistema" rows="3" maxlength="200"><?php echo $descripcion_sistema; ?></textarea>
							<small id="passwordHelpBlock" class="form-text text-muted">* Mínimo 200 caracteres.</small>
						</div>

						<div class="form-group col-md-12">
							<label for="cobertura">Cobertura (Ures donde será implementado)</label>			
							<textarea class="form-control form-control-sm" name="cobertura" id="cobertura" rows="3" maxlength="100"><?php echo $cobertura; ?></textarea>
							<small id="passwordHelpBlock" class="form-text text-muted">* Mínimo 100 caracteres.</small>
						</div>

						<div class="form-group col-md-12">
							<label for="ambiente_operacion">Ambiente de operacion</label>
							<select class="form-control" name="ambiente_operacion" id="ambiente_operacion">
								<option value="0">Seleccione</option>						    	
							    <option value="Cliente-Servidor">Cliente-Servidor</option>
							    <option value="Web">Web</option>
							</select>
						</div>

						<div class="form-group col-md-12">
							<label for="compatibilidad">Recursos compatibles o necesarios para la usabilidad del sistema a desarrollar</label>
							<textarea class="form-control form-control-sm" name="compatibilidad" id="compatibilidad" rows="3" maxlength="100"><?php echo $compatibilidad; ?></textarea>
							<small id="passwordHelpBlock" class="form-text text-muted">* Mínimo 100 caracteres.</small>
						</div>

						<div class="form-group col-md-12">
							<label for="lenguaje">Software a ocupar en el desarrollo del sistema (Lenguaje de programación)</label>
							<textarea class="form-control form-control-sm" name="lenguaje" id="lenguaje" rows="3" maxlength="100"><?php echo $lenguaje; ?></textarea>
							<small id="passwordHelpBlock" class="form-text text-muted">* Mínimo 100 caracteres.</small>
						</div>

						<div class="form-group col-md-12">
							<h5 class="text-center">Datos del responsable tecnológico designado para el desarrollo del sistema de información</h5>
						</div>

						<div class="form-group col-md-6">
							<label for="numero_empleado_responsable">N° Empleado</label>
							<input type="text" class="form-control form-control-sm" name="numero_empleado_responsable" id="numero_empleado_responsable" value="<?php echo $numero_empleado_responsable; ?>" disabled>
						</div>

						<div class="form-group col-md-6">
							<label for="nombre_responsable">Nombre</label>
							<input type="text" class="form-control form-control-sm" name="nombre_responsable" id="nombre_responsable" value="<?php echo $nombre_responsable; ?>" disabled>
						</div>

						<div class="form-group col-md-12">
							<label for="categoria">Categoría</label>
							<input type="text" class="form-control form-control-sm" name="categoria" id="categoria" value="<?php echo $categoria; ?>" disabled>
						</div>

						<div class="form-group col-md-12">
							<label for="perfil">Perfil / Competencia de personal</label>
							<input type="text" class="form-control form-control-sm" name="perfil" id="perfil" value="<?php echo $perfil; ?>" disabled>
						</div>

						<div class="form-group col-md-12">
							<button type="submit" name="guardar" id="guardar" class="btn btn-primary float-right">
								<i class="fa fa-save"></i> Guardar Bitácora
							</button>
						</div>

					</div>

				</div>

			</form>


		</div>

		<div class="table-responsive">

			<?php $bitacoras = false; ?>

			<?php if($bitacoras){ ?>

				<table class="table table-sm">
				  	<thead>
					    <tr>
					     	<th scope="col">Folio</th>
					      	<th scope="col">Fecha</th>
					      	<th scope="col">N° Empleado</th>
					      	<th scope="col">Nombres</th>
					      	<th scope="col">Dependencia</th>
					      	<th scope="col">Nombre Sistema</th>
					      	<th scope="col">Descripción Sistema</th>
					      	<th scope="col">Cobertura</th>
					      	<th scope="col">Ambiente Operación</th>
					      	<th scope="col">Compatibilidad</th>
					      	<th scope="col">Lenguaje Programación</th>
					      	<th scope="col">Categoría</th>
					      	<th scope="col">Perfil</th>
					    </tr>
				  	</thead>
				  	<tbody>
				  		<?php foreach($bitacoras as $bitacora){ ?>
					    <tr>
					      	<td scope="row"><?php echo $bitacora["folio"]; ?></td>
					      	<td scope="row"><?php echo date('d-m-Y', strtotime($bitacora["fecha"])); ?></td>
					      	<td scope="row"><?php echo $bitacora["num_empleado"]; ?></td>
					      	<td scope="row"><?php echo $bitacora["nombre_empleado"]; ?></td>
					      	<td scope="row"><?php echo $bitacora["dependencia"]; ?></td>
					      	<td scope="row"><?php echo $bitacora["nombre_sistema"]; ?></td>
					      	<td scope="row"><?php echo $bitacora["descripcion_sistema"]; ?></td>
					      	<td scope="row"><?php echo $bitacora["cobertura"]; ?></td>
					      	<td scope="row"><?php echo $bitacora["ambiente_operacion"]; ?></td>
					      	<td scope="row"><?php echo $bitacora["compatibilidad"]; ?></td>
					      	<td scope="row"><?php echo $bitacora["lenguaje"]; ?></td>
					      	<td scope="row"><?php echo $bitacora["categoria"]; ?></td>
					      	<td scope="row"><?php echo $bitacora["perfil"]; ?></td>
					    </tr>
					    <?php } ?>

				  	</tbody>
				</table>
			
			<?php } else { ?>

				<h5 class="text-center text-secondary">No existen bitacoras ingresadas</h5>

			<?php } ?>
		</div>
	</div>

	<script src="js/funciones.js"></script>

	<script>
		
		function responsables(){

		}

	</script>
	
</body>
</html>