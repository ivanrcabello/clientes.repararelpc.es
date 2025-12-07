<?php
if(   isset($_POST['seenvio'])   ) {
		$id = $_SESSION['ID'];
		
		$idcliente = $_POST['idcliente'];
		$presupuesto = filter_var($_POST['presupuesto'], FILTER_SANITIZE_STRING);
		$notas = (   isset($_POST['notas'])   )? nl2br($_POST['notas']) : '' ;
		$fecha = date('Y-m-d H:i:s');
				
		$insert = "INSERT INTO presupuestos VALUES(null,".$idcliente.",".$id.",'".$presupuesto."','".$notas."','".$fecha."');";
		mysqli_query($db, $insert);

		$query = mysqli_query($db, "SELECT LAST_INSERT_ID()");
		$data = mysqli_fetch_array( $query, MYSQLI_NUM);
		$last_id = $data[0];
		@mysqli_free_result( $query );

		echo "<p style='background:#0A0; color:white; padding:14px 20px; margin:2px;'>";
			echo "Presupuesto creado con éxito!";
		echo "</p>";
		
		/* redireccionamos a "ver presupuestos" con parametro aid=X */
	?>
				<script>
					window.location.href = '?action=ver_presupuestos&last=<?=$last_id?>';
				</script>
	<?php
		
}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Crear Presupuesto</p>
	
	<form id="form_edit_client" method="POST" action="" enctype="multipart/form-data">
		<input type="hidden" value="uno" id="cualfuncion" />
		<input type="hidden" name="seenvio" value="1" />
			<?php
				$default = false;
				$nombre_default = '';
				$id_default = '';
				
				$cliente = (   isset($_GET['cliente'])   )? $_GET['cliente'] : 0 ;
					$cliente = (   $cliente>0   )? $cliente : 0 ;
				$id = $_SESSION['ID'];
				
				if( $cliente > 0 ) {
					/* Extraemos el cliente unico */
					if(   isset($_SESSION['admin'])   ) {
								/* es del lado del ADMIN */
								$consulta = "SELECT * FROM clientes WHERE CID=".$cliente." LIMIT 1";
					} else {
								/* lado de usuario normal */
							$consulta = "SELECT * FROM clientes WHERE UID=".$id." AND CID=".$cliente." LIMIT 1";
					}
					$query = mysqli_query($db, $consulta);
					
					if(   mysqli_num_rows($query)>0   ) {
							$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
							/* variable auxiliar para poner el nombre y id como definidos en el campo del cliente */
							$default = true;
							$nombre_default = $row['name'];
							$id_default = $row['CID'];
					} else {
							@mysqli_free_result($query);
							/* No existe, asi que extraemos Todos */
							if(   isset($_SESSION['admin'])   ) {
										/* es del lado del ADMIN */
									$consulta = "SELECT * FROM clientes ORDER BY name";
							} else {
										/* lado de usuario normal */
									$consulta = "SELECT * FROM clientes WHERE UID=".$id." ORDER BY name";
							}
							$query = mysqli_query($db, $consulta);
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
				if(   isset($_SESSION['admin'])   ) {
							/* es del lado del ADMIN */
						$consulta = "SELECT * FROM clientes ORDER BY name";
				} else {
							/* lado de usuario normal */
						$consulta = "SELECT * FROM clientes WHERE UID=".$id." ORDER BY name";
				}
				$query = mysqli_query($db, $consulta);
				
				
				if(   mysqli_num_rows($query)>0 ) {
						while( $row = mysqli_fetch_array($query, MYSQLI_ASSOC) ) {
			?>
							<p cid="<?=$row['CID']?>" ><?=$row['name']?></p>
			<?php
						} // end while
				} else {
			?>
					<a class="error-add-cliente" href="?action=add_cliente">Porfavor, Primero registra un cliente.</a>
			<?php
				}
				@mysqli_free_result($query);
			?>
			</div>
			<br/>
			
			<p>(*) Presupuesto ( &euro; ) :</p>
			<input type="text" name="presupuesto" value="" placeholder="Presupuesto &euro;" required />
			<br/>

			<p>(*) Detalles del presupuesto:</p>
			<textarea name="notas" placeholder="Escriba detalles del presupuesto..." required></textarea>
			<br/>
			
			<button name="after" value="1">Crear Presupuesto</button>
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
							}
						},
						error: function(i,o,u) {
							console.log( i );
							console.log( o );
							console.log( u );
						}
					}).done( function() {
							if(   suc   ) {
									/* ID CORRECTO --- mostramos un BOX FLOTANTE diciendo si esta seguro de agregar la reparacion a "CLIENTE APELLIDO" */
									//--- MOSTRAR DIV KUROSAKI
									// SE OMITIRA ESTO
									
									/* ahora creamos una funcion cuando se le de click al OK del BOX y en dicha funcion ponemos las dos lineas de abajo
									despues por obvio se enviara el form de nuevo */
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
								$('.rclientes').append('<p cid="'+i.clientes[z].id+'">'+i.clientes[z].name+'</p>');
						} // end for
					}
				}
			},
			error: function(a,o,u) {
			
			}
		});
});

$('body').on('click', '.rclientes p', function() {
		var name =  $(this).html();
		var id = $(this).attr('cid');
		
		$('input[name="namecliente"]').val( name );
		$('input[name="idcliente"]').val( id );
});
</script>