<?php 

	//Si la variable de sesion esta vacia lo retorna al index.php
	if($_SESSION["correo"] == ""){
		header('Location: index.php');
	}

	require_once "db/db.php";
	require_once "clases/usuarios.php";

	//Llama a la funcion listar de la clase usuarios, y almacena los datos en la variable
	$usuarios = usuarios::listar();

?>

<div class="card mt-3">

	<h4 class="text-blue">Lista de usuarios</h4>

	<?php if($usuarios){ ?>
	<table>
		<thead>	
			<tr>
				<th class="text-center">Nombre</th>
				<th class="text-center">Apellidos</th>
				<th class="text-center">Rut</th>
				<th class="text-center">Correo</th>
				<th class="text-center">Contrasena</th>
				<th class="text-center">Fecha</th>
			</tr>
		</thead>
		<tbody>	
			<?php foreach($usuarios as $usuario){ ?>
			<tr>
				<td><?php echo $usuario['nombre']; ?></td>
				<td><?php echo $usuario['apellidos']; ?></td>
				<td><?php echo $usuario['rut']; ?></td>
				<td><?php echo $usuario['correo']; ?></td>
				<td><?php echo $usuario['contrasena']; ?></td>
				<td><?php echo $usuario['fecha']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table> 
	<?php } else { ?>
		<h5 class="text-gray">No hay registros</h5>
	<?php } ?>
</div>