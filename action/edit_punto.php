<?php
if(   isset($_GET['id']) && $_GET['id']>0   ) {
	$gid = $_GET['id'];

	/* Verificamos que el presupuesto EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM puntos WHERE GID=".$gid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM puntos WHERE UID = ".$_SESSION['ID']." AND GID=".$gid." LIMIT 1";
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

if(   isset($_POST['seenvio'])   ) {
		$id = $_SESSION['ID'];
		
		$nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
		$direccion = filter_var($_POST['direccion'], FILTER_SANITIZE_STRING);
			
			if(   $_SESSION['admin']==1   ) {
				$update = "UPDATE puntos SET 
					nombre='".$nombre."',
					direccion='".$direccion."'
					 WHERE GID=".$gid;

		} else {
				$update = "UPDATE puntos SET 
					nombre='".$nombre."',
					direccion='".$direccion."'
					 WHERE GID=".$gid." AND UID=".$id;
		}
				
				mysqli_query($db, $update);
	
			echo "<p style='background:#0A0; color:white; padding:14px 20px; margin:2px;'>";
				echo "Punto editado con éxito!";
			echo "</p>";
			
			/* redireccionamos a "ver reparaciones" con parametro aid=X */
			?>
			<script>
				window.location.href = '?action=ver_puntos&last=<?=$aid?>';
			</script>
			<?php
	
}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Editar Punto</p>
	
	<form id="form_edit_client" method="POST" action="" enctype="multipart/form-data">
		<input type="hidden" value="uno" id="cualfuncion" />
		<input type="hidden" name="seenvio" value="1" />

		<p>(*) Nombre del punto de recogida:</p>
			<input type="text" name="nombre" placeholder="Escriba el nombre del punto..." value="<?= $row['nombre']; ?>" required>
			<br/>

			<p>(*) Dirección del punto de recogida:</p>
			<textarea name="direccion" placeholder="Escriba la direccion del punto..." required><?= $row['direccion']?></textarea>
			<br/>

			<button name="after" value="1">Guardar Cambios</button>
	</form>
</div>

<script>
function enviar_form_1() {
									$('#form_edit_client').submit();
						
		
} // end function enviar_form_1()

$('#form_edit_client').submit( function() {
		var cualf = $("#cualfuncion").val();
		
		if( cualf == "uno" ) {
			return enviar_form_1();
		}
});


$('body').on('click', '.rclientes p', function() {
		var name =  $(this).attr('dataname');
		var address =  $(this).attr('dataaddress');
		var id = $(this).attr('cid');
		
		$('input[name="namecliente"]').val( name );
		$('input#address').val( address );
		$('input[name="idcliente"]').val( id );
});
</script>

<?php
}
?>