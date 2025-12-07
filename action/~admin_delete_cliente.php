<?php
if(   isset($_GET['id']) && $_GET['id']>0   ) {
	$cid = $_GET['id'];

	/* Verificamos que el cliente que vamos a editar EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM clientes WHERE CID=".$cid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM clientes WHERE UID = ".$_SESSION['ID']." AND CID=".$cid." LIMIT 1";
	}
	$query = mysqli_query($db, $consulta);
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			$name = $row['name'];
			$address = $row['address'];
			$phone = $row['phone'];
			$email = $row['email'];
	} else {
			/* No existe este cliente o no esta relacionado al ID del usuario logueado */
			?>
				NO EXISTE
			<?php
			exit;
	}
@mysqli_free_result($query);

		if(   isset($_POST['after'])   ) {
				/* Procedemos a hacer delete en tabla CLIENTES */
				if(   $_SESSION['admin']==1   ) {
						$update = "DELETE FROM clientes WHERE CID=".$cid;
				} else {
						$update = "DELETE FROM clientes WHERE UID=".$_SESSION['ID']." AND CID=".$cid;
				}
				mysqli_query($db, $update);
				
				/* Procedemos a hacer delete en tabla ARTICULOS */
				if(   $_SESSION['admin']==1   ) {
						$update = "DELETE FROM articulos WHERE CID=".$cid;
				} else {
						$update = "DELETE FROM articulos WHERE UID=".$_SESSION['ID']." AND CID=".$cid;
				}
				mysqli_query($db, $update);
				?>
					<script>
						window.location.href = '?action=ver_clientes';
					</script>
				<?php
				exit;
		}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Eliminar Cliente (<?=$name?>)</p>
	
	<form id="form_edit_client" method="POST" action="">
			<h1>Esta seguro de eliminar al cliente?</h1>
			<h4><?=$name?></h4>
			<em>
				*Se eliminarán todos los articulos relacionados a este cliente.<br/>
				*Esta acción no se puede revertir.
			</em>
			
			<br/><br/><br/>
			
			<button name="after" value="0">Si. Eliminar Cliente</button>
	</form>
</div>

<?php
}
?>