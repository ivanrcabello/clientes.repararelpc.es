<?php
if(   $_SESSION['admin']==1   ) {


if(   isset($_GET['id']) && $_GET['id']>0   ) {
	$id = $_GET['id'];

	/* Verificamos que el usuario exista */
	$consulta = "SELECT * FROM usuarios WHERE ID=".$id." LIMIT 1";
	$query = mysqli_query($db, $consulta);
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			$user = $row['user'];
			$name = $row['name'];
	} else {
			/* No existe este cliente o no esta relacionado al ID del usuario logueado */
			?>
				NO EXISTE
			<?php
			exit;
	}
@mysqli_free_result($query);

		if(   isset($_POST['after'])   ) {
				/* Procedemos a hacer delete en tabla USUARIOS */
				$delete = "DELETE FROM usuarios WHERE ID=".$id;
				mysqli_query($db, $delete);
				
				/* Procedemos a hacer delete en tabla CLIENTES */
				$delete = "DELETE FROM clientes WHERE UID=".$id;
				mysqli_query($db, $delete);
				
				/* Procedemos a hacer delete en tabla ARTICULOS */
				$delete = "DELETE FROM articulos WHERE UID=".$id;
				mysqli_query($db, $delete);
				?>
					<script>
						window.location.href = '?action=admin_ver_usuarios';
					</script>
				<?php
				exit;
		}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Eliminar Usuario (<?=$user?> - <?=$name?>)</p>
	
	<form id="form_edit_client" method="POST" action="">
			<h1>Esta seguro de eliminar al siguiente usuario?</h1>
			<h4>Nombre de Login: <?=$user?></h4>
			<h4>Contraseña: ********</h4>
			<h4>Nombre Real: <?=$name?></h4>
			<em>
				*Se eliminarán todos los clientes relacionados a este siguiente usuario.<br/>
				*Se eliminarán todos los articulos relacionados a este siguiente usuario.<br/>
				*Esta acción no se puede revertir.
			</em>
			
			<br/><br/><br/>
			
			<button name="after" value="0">Si. Eliminar Usuario</button>
	</form>
</div>

<?php
}


}
?>