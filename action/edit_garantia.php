<?php
if(   isset($_GET['aid']) && $_GET['aid']>0   ) {
	$aid = $_GET['aid'];

	/* Verificamos que el articulo EXISTE y sea de este usuario */
	/*
	if(   $_SESSION['admin']==1   ) {
	*/
		$consulta = "SELECT * FROM garantias WHERE id=".$aid." LIMIT 1";
		
	/*	
	} 
	else {
		$consulta = "SELECT * FROM articulos WHERE UID = ".$_SESSION['ID']." AND AID=".$aid." LIMIT 1";
	}
	*/
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
		$orden = (   isset($_POST['orden'])   )? $_POST['status'] : '' ;
		$status = (   isset($_POST['status'])   )? $_POST['status'] : '1' ;
		$datee = (   isset($_POST['fecha'])   )? $_POST['fecha'] : '0000-00-00 00:00:00' ;
		$notas = (   isset($_POST['descripcion'])   )? nl2br($_POST['descripcion']) : '' ;

				if ($_SESSION['admin']==1) {
						$update = "UPDATE garantias SET 
						    AID=$orden,
							descripcion='".$notas."',
							status=$status,
							fecha='".$datee."'
							 WHERE id=".$aid;

				} else {
						$update = "UPDATE garantias SET 
						    AID=$orden,
							descripcion='".$notas."',
							status=$status,
							fecha='".$datee."'
							 WHERE id=".$aid;
				}
					
				mysqli_query($db, $update);
		
				echo "<p style='background:#0A0; color:white; padding:14px 20px; margin:2px;'>";
					echo "Garantía agregado con éxito!";
				echo "</p>";
				
				/* redireccionamos a "ver reparaciones" con parametro aid=X */
				?>
				
				<script>
					window.location.href = '?action=ver_garantias&last=<?=$aid?>';
				</script>
				<?php
		
}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Editar Garantía (<?=$row['descripcion']?>)</p>
	
	<form id="form_edit_client" method="POST" action="" enctype="multipart/form-data">
		<input type="hidden" value="uno" id="cualfuncion" />
		<input type="hidden" name="seenvio" value="1" />
		<div class="cliente-solo-admin"  style="<?= $_SESSION['admin']==1 ?   'display: block' : 'display: none' ?>">
			<?php
				$default = false;
				$nombre_default = '';
				$address_default = '';
				$id_default = '';
				$id = $_SESSION['ID'];
				
			?>
		</div>

			<p>Descripción de solicitud:</p>
			<?php
				$nl = preg_replace('#<br\s*/?>#i', "", $row['descripcion']);
			?>
			<textarea name="descripcion" placeholder="Escriba las fallas o notas del articulo..." required><?=$nl?></textarea>
			<br/>
			
			<p class="accesorios">(*) Status de la garantía:</p>
			<label class="accesorio"><input type="radio" name="status" value="0" <?php if($row['status']==0){ echo "checked";} ?> /> Solicitado</label>
			<label class="accesorio"><input type="radio" name="status" value="1" <?php if($row['status']==1){ echo "checked";} ?> /> En Reparación</label>
			<label class="accesorio"><input type="radio" name="status" value="2" <?php if($row['status']==2){ echo "checked";} ?> /> Reparación Finalizada</label>
			<label class="accesorio"><input type="radio" name="status" value="3" <?php if($row['status']==3){ echo "checked";} ?> /> Entregado</label>
			<label class="accesorio"><input type="radio" name="status" value="4" <?php if($row['status']==4){ echo "checked";} ?> /> No apto para garantía</label>
			<br/><br/>
			
			<p>(*) Fecha de solicitud:</p>
			<?php
				if(   strtotime($row['fecha'])>0   ) {
					$date = date('Y-m-d', strtotime($row['fecha']));
				} else {
					$date = '';
				}
			?>
			<input type="date" name="fecha" value="<?=$date?>" />
			<input type="hidden" name="orden" value="<?=$row['AID']?>" />
			<br/>
			
			<button name="after" value="1">Guardar Cambios</button>
	</form>
</div>

<script>
function enviar_form_1() {
	$('#form_edit_client').submit();
} 

$('#form_edit_client').submit( function() {
		var cualf = $("#cualfuncion").val();
		
		if( cualf == "uno" ) {
			return enviar_form_1();
		}
});

$('input[name="namecliente"]').keyup( function(e) {
		//e.keyCode
		$('input[name="idcliente"]').val( '' );
		var cliente = $(this).val();
		
		$.ajax({
			type:'POST',
			dataType:'JSON',
			url:'ajax/list_clientes.php',
			data:{cliente:cliente},
			beforeSend: function() {
				console.log( 'BEFORE: '+ cliente );
			},
			success: function(i) {
				$('.rclientes').html('');
				
				if(   i.clientes   ) {
					if(   i.clientes.length > 0   ) {
						var l = i.clientes.length;
						for( var z=0; z<l; z++ ) {
								$('.rclientes').append('<p cid="'+i.clientes[z].id+'" dataname="'+i.clientes[z].name+'" dataaddress="'+i.clientes[z].address+'">'+i.clientes[z].name+' ('+i.clientes[z].address+')</p>');
						} // end for
					}
				}
			},
			error: function(a,o,u) {
			
			}
		});
});

$('body').on('click', '.rclientes p', function() {
		var name =  $(this).attr('dataname');
		var address =  $(this).attr('dataaddress');
		var id = $(this).attr('cid');
		
		$('input[name="namecliente"]').val( name );
		$('input#address').val( address );
		$('input[name="idcliente"]').val( id );
});



/* ************************************ *********************************** ELIMINAR IMAGENES */
$(".img_delete").click( function() {
		var resp = window.confirm( "Esta seguro de eliminar esta imagen? \n *Esto no se puede revertir." );
		var nombre = $(this).attr('name');
		var id = $(this).attr('id');
		var aid = '<?=$aid?>';
		
		if(   resp   ) {
				$.ajax({
					type:'POST',
					dataType:'json',
					url:'ajax/delete_imagen.php',
					data:{nombre:nombre, id:id, aid:aid},
					beforeSend: function() {
							//alert( "articulo: " + aid + "\n nombre: " +nombre + "\n numero: "+id );
					},
					success: function(e) {
							window.location.reload();
							/*
							var imagenes = $('.img_delete');
							var cant = imagenes.length;
							
							for(var i=0; i<cant; i++) {
									var idx = $( imagenes[i] ).attr('id');
									
									if(  idx>id ) {
										$( imagenes[i] ).attr('id', (idx-1));
									}
							}
							
							
							console.log( e );
							*/
					}
				});
				$(this).fadeOut(200);
		}
		return false;
});
</script>

<?php
}
?>