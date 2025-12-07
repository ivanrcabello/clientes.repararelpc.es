<?php
if(   isset($_GET['aid']) && $_GET['aid']>0   ) {
	$aid = $_GET['aid'];

	/* Verificamos que el articulo EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM garantias WHERE id=".$aid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM garantias WHERE id=".$aid." LIMIT 1";
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
						$update = "DELETE FROM garantias WHERE id=".$aid;
				} else {
						$update = "DELETE FROM garantias WHERE id=".$aid;
				}
				mysqli_query($db, $update);
				?>
					<script>
						window.location.href = '?action=ver_garantias';
					</script>
				<?php
				exit;
		}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Eliminar garantía (<?=$row['id']?>)</p>
	
	<form id="form_edit_client" method="POST" action="">
			<h1>Esta seguro de eliminar está garantía?</h1>
			<h4><?=$row['id']." - ".$row['descripcion']?></h4>
			<em>
				*Esta acción no se puede revertir.
			</em>
			
			<br/><br/><br/>
			
			<button name="after" value="0">Si. Eliminar Garantía</button>
	</form>
</div>

<?php
}
?>