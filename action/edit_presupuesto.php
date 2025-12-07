<?php
if(   isset($_GET['id']) && $_GET['id']>0   ) {
	$pid = $_GET['id'];

	/* Verificamos que el presupuesto EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM presupuestos WHERE PID=".$pid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM presupuestos WHERE UID = ".$_SESSION['ID']." AND PID=".$pid." LIMIT 1";
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
		
		$idcliente = $_POST['idcliente'];
		$presupuesto = filter_var($_POST['presupuesto'], FILTER_SANITIZE_STRING);
		$notas = (   isset($_POST['notas'])   )? nl2br($_POST['notas']) : '' ;
	
				
				if(   $_SESSION['admin']==1   ) {
						$update = "UPDATE presupuestos SET 
							CID=".$idcliente.",
							presupuesto='".$presupuesto."',
							notas='".$notas."'
							 WHERE PID=".$pid;

				} else {
						$update = "UPDATE presupuestos SET 
							CID=".$idcliente.",
							presupuesto='".$presupuesto."',
							notas='".$notas."'
							 WHERE PID=".$pid." AND UID=".$id;
				}
					
					mysqli_query($db, $update);
		
				echo "<p style='background:#0A0; color:white; padding:14px 20px; margin:2px;'>";
					echo "Presupuesto actualizado!";
				echo "</p>";
				
				/* redireccionamos a "ver reparaciones" con parametro aid=X */
				if(   $_GET['action'] == 'admin_edit_presupuesto'   ) {
		?>
						<script>
							window.location.href = '?action=admin_ver_presupuestos&last=<?=$pid?>';
						</script>
		<?php
				} else {
		?>
						<script>
							window.location.href = '?action=ver_presupuestos&last=<?=$pid?>';
						</script>
		<?php
				}
}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Editar Presupuesto</p>
	
	<form id="form_edit_client" method="POST" action="" enctype="multipart/form-data">
		<input type="hidden" value="uno" id="cualfuncion" />
		<input type="hidden" name="seenvio" value="1" />
			<?php
				$default = false;
				$nombre_default = '';
				$address_default = '';
				$id_default = '';
				
				$cliente = $row['CID'];
				$id = $_SESSION['ID'];
				
				if( $cliente > 0 ) {
					/* Extraemos el cliente unico */
					if(   $_SESSION['admin']==1   ) {
						$consulta = "SELECT * FROM clientes WHERE CID=".$cliente." LIMIT 1";
					} else {
						$consulta = "SELECT * FROM clientes WHERE UID=".$id." AND CID=".$cliente." LIMIT 1";
					}
					$query = mysqli_query($db, $consulta);
					
					if(   mysqli_num_rows($query)>0   ) {
							$rowc = mysqli_fetch_array($query, MYSQLI_ASSOC);
							/* variable auxiliar para poner el nombre y id como definidos en el campo del cliente */
							$default = true;
							$nombre_default = $rowc['name'];
							$address_default = $rowc['address'];
							$id_default = $rowc['CID'];
					}
					@mysqli_free_result($query);
					
				}
			?>
			<p>(*) Cliente:</p>
			<input type="text" name="namecliente" placeholder="Ingrese nombre del cliente..." <?php if( $default ){echo "value='".$nombre_default."'";} ?> />
			<input type="text" name="idcliente" <?php if( $default ){echo "value='".$id_default."'";} ?> readonly required />
			<br/>
			<div class="rclientes">
			<?php
				/* Extraemos todos los clientes relacionados */
				if(   $_SESSION['admin']==1   ) {
					$consulta = "SELECT * FROM clientes ORDER BY name";
				} else {
					$consulta = "SELECT * FROM clientes WHERE UID=".$id." ORDER BY name";
				}
				$query = mysqli_query($db, $consulta);
				
				
				if(   mysqli_num_rows($query)>0 ) {
						while( $rowx = mysqli_fetch_array($query, MYSQLI_ASSOC) ) {
			?>
							<p cid="<?=$rowx['CID']?>" dataname="<?=$rowx['name']?>" dataaddress="<?=$rowx['address']?>"><?=$rowx['name']?> (<?=$rowx['address']?>)</p>
			<?php
						} // end while
				} else {
			?>
					<a class="error-add-cliente" href="?action=add_cliente">Porfavor, Primero registra un cliente.</a>
			<?php
				}
				@mysqli_free_result($query);
			?>
			</div> <!-- end .rclientes -->
			<br/>
			
			<!--
			<p>Dirección del cliente: (No se puede modificar)</p>
			<input type="text" value="<?=$address_default?>" id="address" readonly />
			<br/>
			-->
			<p>(*) Presupuesto ( &euro; ) :</p>
			<input type="text" name="presupuesto" value="<?=$row['presupuesto']?>" placeholder="Presupuesto por la reparación..." required />
			<br/>

			<p>(*) Detalles del presupuesto:</p>
			<?php
				$nl = preg_replace('#<br\s*/?>#i', "", $row['notas']);
			?>
			<textarea name="notas" placeholder="Escriba detalles del presupuesto..." required><?=$nl?></textarea>
			<br/>
			
			<button name="after" value="1">Guardar Cambios</button>
	</form>
</div>

<script>
function enviar_form_1() {
		var val = $('input[name="idcliente"]').val();
		var valido = false;
		
		if(   val == ''   ) {
				/* No ha seleccionado ID del cliente */
				alert( "Error, Seleccione un cliente Porfavor. \n Recuerde dar clic sobre el cliente que desea seleccionar." );
				
				return false;
		} else {
				var suc = false;
				/* verificamos via AJAX que sea un numero de cliente valido */
					$.ajax({
						url:'ajax/verificar_id_cliente.php',
						type:'POST',
						dataType:'json',
						data:{cid:val},
						beforeSend: function() {
							console.log( "ID CLIENTE A VERIFICAR?: " + val );
						},
						success: function(e) {
							if( e.success ) {
								suc = true;
							} else {
								alert( "Ocurrio un error, al seleccionar el cliente, Porfavor seleccione un cliente válido" );
							}
						},
						error: function(i,o,u) {
							console.log( i );
							console.log( o );
							console.log( u );
						}
					}).done( function() {
							if(   suc   ) {
									/* una vez que la validacion esta correcta, cambiamos el valor de este campo hidden, y llamamos el evento SUBMIT
										para que el formulario se envie, y no vuelva a validar, si no, que YA se envie directo y se guarde */
									$("#cualfuncion").attr('value','dos');
									$('#form_edit_client').submit();
							} else {
									/* ERROR, Mostramos en alerta que el IDCliente no es compatible con el usuario */
									alert( "Error. Seleccione un cliente valido. Recuerde dar click sobre el cliente que desea." );
							}
					});
					
					return false;
		}
} // end function enviar_form_1()

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
</script>

<?php
}
?>