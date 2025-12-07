<?php
if(   isset($_GET['id']) && $_GET['id']>0 && $_SESSION['admin']==1   ) {
	$fid = $_GET['id'];

	/* Verificamos que el cliente que vamos a editar EXISTE */
		$consulta = "SELECT * FROM facturas WHERE FID=".$fid." LIMIT 1";
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
				/* Procedemos a hacer delete en tabla CLIENTES */
						$update = "DELETE FROM facturas WHERE FID=".$fid;
				mysqli_query($db, $update);
				?>
					<script>
						window.location.href = '?action=admin_ver_facturas';
					</script>
				<?php
				exit;
		}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Eliminar Factura ( #<?=$fid?> )</p>
	
	<form id="form_edit_client" method="POST" action="">
			<h1>Esta seguro de eliminar esta Factura?</h1>
			<em>
				*Esta acción no se puede revertir.
			</em>
			
			<br/><br/><br/>
			
			<button name="after" value="0">Si. Eliminar Factura</button>
	</form>
</div>

<?php
}
?>