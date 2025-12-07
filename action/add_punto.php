<?php
if(   isset($_POST['seenvio'])   ) {
		$id = $_SESSION['ID'];
		
		$nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
		$direccion = filter_var($_POST['direccion'], FILTER_SANITIZE_STRING);
		
		$insert = "INSERT INTO puntos VALUES(null,".$id.",'".$nombre."','".$direccion."');";
		mysqli_query($db, $insert);
		$query = mysqli_query($db, "SELECT LAST_INSERT_ID()");
		$data = mysqli_fetch_array( $query, MYSQLI_NUM);
		$last_id = $data[0];
		@mysqli_free_result( $query );
		echo "<p style='background:#0A0; color:white; padding:14px 20px; margin:2px;'>";
			echo "Punto agregado con éxito!";
		echo "</p>";
				
		/* redireccionamos a "ver reparaciones" con parametro aid=X */
		?>
		<script>
			window.location.href = '?action=ver_puntos&last=<?=$last_id?>';
		</script>
		<?php
		
}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Crear Punto</p>
	
	<form id="form_edit_client" method="POST" action="" enctype="multipart/form-data">
		<input type="hidden" value="uno" id="cualfuncion" />
		<input type="hidden" name="seenvio" value="1" />

			<p>(*) Nombre del punto de recogida:</p>
			<input type="text" name="nombre" placeholder="Escriba el nombre del punto..." required>
			<br/>

			<p>(*) Dirección del punto de recogida:</p>
			<textarea name="direccion" placeholder="Escriba la direccion del punto..." required></textarea>
			<br/>

			<button name="after" value="1">Crear Punto</button>
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

</script>

<?php
