<?php
if(   isset($_GET['id']) && $_GET['id']>0   ) {
	$fid = $_GET['id'];

	/* Verificamos que el cliente que vamos a editar EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM facturas WHERE FID=".$fid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM facturas WHERE UID = ".$_SESSION['ID']." AND FID=".$fid." LIMIT 1";
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
				/* Procedemos a hacer delete en tabla CLIENTES */
				if(   $_SESSION['admin']==1   ) {
						//$update = "DELETE FROM facturas WHERE FID=".$fid;
						$update = "UPDATE facturas SET version=0 WHERE FID=".$fid;
				} else {
						//$update = "DELETE FROM facturas WHERE UID=".$_SESSION['ID']." AND FID=".$fid;
						$update = "UPDATE facturas SET version=0 WHERE UID=".$_SESSION['ID']." AND FID=".$fid;
				}
				mysqli_query($db, $update);
				?>
					<script>
						window.location.href = '?action=ver_facturas';
					</script>
				<?php
				exit;
		}
?>
<div id="cuerpo_action">
<!--
	<p id="cabecera_action">Inicio > Eliminar Factura ( #<?=$fid?> )</p>
	-->
	<p id="cabecera_action">Inicio > Cancelar Factura ( #<?=$fid?> )</p>
	
	<form id="form_edit_client" method="POST" action="">
	<!--
			<h1>Esta seguro de eliminar esta Factura?</h1>
			-->
			<h1>Esta seguro de cancelar esta Factura?</h1>
			<em>
				*Esta acción no se puede revertir.
			</em>
			
			<br/><br/><br/>
			<!--
			<button name="after" value="0">Si. Eliminar Factura</button>
			-->
			<button name="after" value="0">Si. Cancelar Factura</button>
	</form>
</div>

<?php
}
?>