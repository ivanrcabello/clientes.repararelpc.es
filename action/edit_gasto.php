<?php
if(   isset($_GET['id']) && $_GET['id']>0   ) {
	$gid = $_GET['id'];

	/* Verificamos que el presupuesto EXISTE y sea de este usuario */
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

if(   isset($_POST['seenvio'])   ) {
		$id = $_SESSION['ID'];
		
		$concepto = filter_var($_POST['concepto'], FILTER_SANITIZE_STRING);
		$proveedor = filter_var($_POST['nombreproveedor'], FILTER_SANITIZE_STRING);
		$descripcion = filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING);
		$precioconiva = filter_var($_POST['precioconiva'], FILTER_SANITIZE_STRING);
		$preciosiniva = filter_var($_POST['preciosiniva'], FILTER_SANITIZE_STRING);
		$imagenes = $_FILES['imagenes'];

					
	// Generamos nombre aleatorio de las imagenes 
	$name_img = $row['nombre_fotos'];
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
									// comenzará a partir de la cantidad de fotos que ya existen.
					$auxm = $row['no_fotos']+1; // auxiliar para poner un ID a cada foto, ejemplo foto_1, foto_2, foto_3, etc ...
					$aux = 0; // auxiliar para recorrer el array FILES
					foreach(   $imagenes['tmp_name'] as $img   ) {
							$ext = strtolower(   end(   explode('.', $imagenes['name'][$aux])   )   );
							//Movemos la imagen temporal
							move_uploaded_file($img, 'uploads/'.$name_img.'_'.$auxm.'.'.$ext);
							
							$auxm++;
							$aux++;
					} // end foreach
			}
			
			/* LE SUMAMOS A LA CANTIDAD DE FOTOS + LA CANTIDAD QUE YA EXISTIAN */
			$cantidad_img = $cantidad_img + $row['no_fotos'];

			if(   $_SESSION['admin']==1   ) {
				$update = "UPDATE gastos SET 
					concepto='".$concepto."',
					descripcion='".$descripcion."',
					nombreproveedor='".$proveedor."',
					precioconiva=".$precioconiva.",
					no_fotos=".$cantidad_img.",
					preciosiniva=".$preciosiniva."
					 WHERE GID=".$gid;

		} else {
				$update = "UPDATE gastos SET 
					concepto='".$concepto."',
					descripcion='".$descripcion."',
					nombreproveedor='".$proveedor."',
					no_fotos=".$cantidad_img.",
					precioconiva=".$precioconiva.",
					preciosiniva=".$preciosiniva."
					 WHERE GID=".$gid." AND UID=".$id;
		}
				
				mysqli_query($db, $update);
	
			echo "<p style='background:#0A0; color:white; padding:14px 20px; margin:2px;'>";
				echo "Gasto editado con éxito!";
			echo "</p>";
			
			/* redireccionamos a "ver reparaciones" con parametro aid=X */
			?>
			<script>
				window.location.href = '?action=admin_ver_gastos&last=<?=$aid?>';
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
	<p id="cabecera_action">Inicio > Editar Gasto</p>
	
	<form id="form_edit_client" method="POST" action="" enctype="multipart/form-data">
		<input type="hidden" value="uno" id="cualfuncion" />
		<input type="hidden" name="seenvio" value="1" />

		<p>(*) Proveedor:</p>
			<input type="text" name="nombreproveedor" placeholder="Escriba el proveedor del gasto..." value="<?= $row['nombreproveedor']; ?>" required>
			<br/>

			<p>(*) Concepto:</p>
			<textarea name="concepto" placeholder="Escriba el concepto del gasto..." required><?= $row['concepto']?></textarea>
			<br/>

			<p>(*) Descripción:</p>
			<textarea name="descripcion" placeholder="Escriba la descripción del gasto..." required><?= $row['descripcion']?></textarea>
			<br/>

			<p>FOTOS:</p>
			<div id="carga_fotos">
			<?php
				if(   $row['no_fotos']>0   ) {
						for($i=1; $i<=$row['no_fotos']; $i++) {
							$img = 'uploads/'.$row['nombre_fotos'].'_'.$i;
							$doc = '/'.$img;
							if(   file_exists($img.'.jpg')   ) {
									echo '<img src="'.$img.'.jpg" style="max-width:200px; vertical-align:top; margin:1px 3px;"/>';
							} elseif(   file_exists($img.'.jpeg')   ) {
									echo '<img src="'.$img.'.jpeg" style="max-width:200px; vertical-align:top; margin:1px 3px;"/>';
							} elseif(   file_exists($img.'.png')   ) {
									echo '<img src="'.$img.'.png" style="max-width:200px; vertical-align:top; margin:1px 3px;"/>';
							} elseif(   file_exists($img.'.gif')   ) {
									echo '<img src="'.$img.'.gif" style="max-width:200px; vertical-align:top; margin:1px 3px;"/>';
							} elseif(   file_exists($img.'.bmp')   ) {
									echo '<img src="'.$img.'.bmp" style="max-width:200px; vertical-align:top; margin:1px 3px;"/>';
							}
							elseif(   file_exists($img.'.doc')   ) {
								echo "<a href='$doc.doc'>Descargar documento</a>";
							}
							elseif(   file_exists($img.'.docx')   ) {
								echo "<a href='$doc.docx'>Descargar documento</a>";
								}
							elseif(   file_exists($img.'.pdf')   ) {
								echo "<a href='$doc.pdf'>Descargar documento</a>";
							}
							
							echo "<div class='img_delete' name='".$row['nombre_fotos']."' id='".$i."' style='display:inline-block; position:relative; cursor:pointer;'>";
								echo '<img src="'.$img.'" style="max-width:100px; vertical-align:top; margin:1px 3px;"/>';
								
								echo "<div style='display:none; background:rgba(0,0,0,0.5); width:100%; height:100%; position:absolute; top:0; left:0; color:white; text-align:center;'>";
								echo "ELIMINAR</div>";
								
								echo "<span style='display:inline-block; width:25px; height:24px; border-radius:3px; text-align:center; line-height:24px;
									position:absolute; top:1px; right:3px; background:#A00; color:white; border:2px solid #C00;'>x</span>";
							echo "</div>";
									
						} // end for
				} else {
					echo "No hay fotos";
				}
			?>
			</div>
			
			<p>Añadir Nuevas Imagenes:</p>
			<input type="file" name="imagenes[]" multiple />
			<br/>
			<p style="background:#900; color:white; font-size:13px;">*FORMATOS DE IMAGEN COMPATIBLES: jpg, png, gif, bmp, doc, docx, pdf.</p>
			<br/>
			
			<p>(*) Precio sin IVA ( &euro; ) :</p>
			<input type="text" name="preciosiniva" value="<?= $row['preciosiniva']?>" placeholder="Precio sin iva &euro;" required />
			<br/>
			<p>(*) Precio con IVA ( &euro; ) :</p>
			<input type="text" name="precioconiva" value="<?= $row['precioconiva']?>" placeholder="Precio con iva &euro;" required />
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