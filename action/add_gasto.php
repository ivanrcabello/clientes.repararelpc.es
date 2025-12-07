<?php
if(   isset($_POST['seenvio'])   ) {
		$id = $_SESSION['ID'];
		
		$concepto = filter_var($_POST['concepto'], FILTER_SANITIZE_STRING);
		$proveedor = filter_var($_POST['nombreproveedor'], FILTER_SANITIZE_STRING);
		$descripcion = filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING);
		$precioconiva = filter_var($_POST['precioconiva'], FILTER_SANITIZE_STRING);
		$preciosiniva = filter_var($_POST['preciosiniva'], FILTER_SANITIZE_STRING);
		$imagenes = $_FILES['imagenes'];

		// Generamos nombre aleatorio de las imagenes 
		$name_img = date('Ymd_His')."_".rand(111111,999999);
		$cantidad_img = (   isset($imagenes['name']) && $imagenes['name'][0] != ''   )? count( $imagenes['name'] ) : 0 ;
				
		/* validamos las imagenes */
		$img_validate = true;
		if(   $cantidad_img>0   ) {
				//Recorremos el array de imagenes y revisamos EXT
				foreach(   $imagenes['name'] as $img   ) {
						$ext = strtolower(   end(   explode('.', $img)   )   );
						//echo $ext;
						
						if(   ($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif' || $ext=='bmp' || $ext=='doc' || $ext=='pdf' || $ext=='docx') && $img_validate   ) {
								// Si es valida
								//echo " - SI ES VALIDA<br/>";
						} else {
								// No es ninguna de esas EXTs
								$img_validate = false;
								//echo " - NOO ES VALIDA<br/>";
						}
				}
		
		}
		
		if(   $img_validate   ) {
				/* la validacion de imagenes esta OK, ahora veemos si son mas de 0, las movemos y las subimos */
				if(   $cantidad_img>0   ) {
						$auxm = 1;
						$aux = 0;
						foreach(   $imagenes['tmp_name'] as $img   ) {
								echo $img;
								echo "<hr/>";
								$ext = strtolower(   end(   explode('.', $imagenes['name'][$aux])   )   );
								//Movemos la imagen temporal
								move_uploaded_file($img, 'uploads/'.$name_img.'_'.$auxm.'.'.$ext);
								
								$auxm++;
								$aux++;
						} // end foreach
				}
				$insert = "INSERT INTO gastos VALUES(null,".$id.",'".$concepto."','".$descripcion."',".$preciosiniva.",".$precioconiva.",'".$proveedor."','".$name_img."','".$cantidad_img."');";
		
				mysqli_query($db, $insert);

				$query = mysqli_query($db, "SELECT LAST_INSERT_ID()");
				$data = mysqli_fetch_array( $query, MYSQLI_NUM);
				$last_id = $data[0];
				@mysqli_free_result( $query );
		
				echo "<p style='background:#0A0; color:white; padding:14px 20px; margin:2px;'>";
					echo "Gasto agregado con éxito!";
				echo "</p>";
				
				/* redireccionamos a "ver reparaciones" con parametro aid=X */
				?>
				<script>
					window.location.href = '?action=ver_gastos&last=<?=$last_id?>';
				</script>
				<?php
		} else {
				echo "<h2 style='background:#A00; color:white; padding:10px; margin:2px;'>";
					echo "Error. Está intentando subir una imagen invalida.";
				echo "</h2>";
		}
		
}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Crear Gasto</p>
	
	<form id="form_edit_client" method="POST" action="" enctype="multipart/form-data">
		<input type="hidden" value="uno" id="cualfuncion" />
		<input type="hidden" name="seenvio" value="1" />

			<p>(*) Proveedor:</p>
			<input type="text" name="nombreproveedor" placeholder="Escriba el proveedor del gasto..." required>
			<br/>

			<p>(*) Concepto:</p>
			<textarea name="concepto" placeholder="Escriba el concepto del gasto..." required></textarea>
			<br/>

			<p>(*) Descripción:</p>
			<textarea name="descripcion" placeholder="Escriba la descripción del gasto..." required></textarea>
			<br/>

			<p>FOTOS:</p>
			<input type="file" name="imagenes[]" multiple />
			<br/>
			<p style="background:#900; color:white; font-size:13px;">*FORMATOS DE IMAGEN COMPATIBLES: jpg, png, gif, bmp, doc, docx, pdf.</p>
			<br/>
			
			<p>(*) Precio sin IVA ( &euro; ) :</p>
			<input type="text" name="preciosiniva" value="" placeholder="Precio sin iva &euro;" required />
			<br/>
			<p>(*) Precio con IVA ( &euro; ) :</p>
			<input type="text" name="precioconiva" value="" placeholder="Precio con iva &euro;" required />
			<br/>
			
			<button name="after" value="1">Crear Gasto</button>
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
