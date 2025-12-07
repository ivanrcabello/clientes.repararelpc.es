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
			$folio = $row['FOLIO'];
	} else {
			/* No existe esta factura o no esta relacionado al ID del usuario logueado */
			?>
				NO EXISTE
			<?php
			exit;
	}
@mysqli_free_result($query);

		if(   isset($_POST['after'])   ) {
				$folio = filter_var($_POST['FOLIO'], FILTER_SANITIZE_STRING);
				
				/* Procedemos a hacer update */
				if(   $_SESSION['admin']==1   ) {
						$update = "UPDATE facturas SET
							FOLIO='".$folio."'
							WHERE FID=".$fid;
				
				} else {
						$update = "UPDATE facturas SET
							FOLIO='".$folio."'
							WHERE UID=".$_SESSION['ID']." AND FID=".$fid;
				}
				mysqli_query($db, $update);
				?>
					<script>
						window.location.href = '?action=ver_facturas&last=<?=$fid?>';
					</script>
				<?php
				exit;
		}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Editar Factura</p>
	
	<form id="form_edit_client" method="POST" action="">

			
			<p>FOLIO:</p>
			<input type="text" name="FOLIO" value="<?=$folio?>" placeholder="Ingrese nuevo folio..." />
			
			<br/>
			
			<button name="after" value="0">Guardar Cambios</button>
	</form>
</div>

<?php
}
?>