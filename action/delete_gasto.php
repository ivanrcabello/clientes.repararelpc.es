<?php
if(   isset($_GET['id']) && $_GET['id']>0   ) {
	$gid = $_GET['id'];

	/* Verificamos que el articulo EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM gastos WHERE GID=".$gid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM gastos WHERE UID = ".$_SESSION['ID']." AND GID=".$gid." LIMIT 1";
	}
	$query = mysqli_query($db, $consulta);
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	} else {
			/* No existe este cliente o no esta relacionado al ID del usuario logueado */
			?>
				NO EXISTE
			<?php
			exit;
	}
	@mysqli_free_result($query);

		if(   isset($_POST['after'])   ) {		
				/* Procedemos a hacer delete en tabla ARTICULOS */
				if(   $_SESSION['admin']==1   ) {
						$update = "DELETE FROM gastos WHERE GID=".$gid;
				} else {
						$update = "DELETE FROM gastos WHERE UID=".$_SESSION['ID']." AND GID=".$gid;
				}
				mysqli_query($db, $update);

				if(   $_GET['action'] == 'admin_delete_gasto'   ) {
		?>
						<script>
							window.location.href = '?action=admin_ver_gastos';
						</script>
		<?php
				} else {
		?>
						<script>
							window.location.href = '?action=ver_gastos';
						</script>
		<?php
				}
				exit;
		}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Eliminar Gasto</p>
	
	<form id="form_edit_client" method="POST" action="">
			<h1>Esta seguro de eliminar este gasto?</h1>
			<em>
				*Esta acción no se puede revertir.
			</em>
			
			<br/><br/><br/>
			
			<button name="after" value="0">Si. Eliminar</button>
	</form>
</div>

<?php
}
?>