<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if(   isset($_POST['seenvio'])   ) {
		$id = $_SESSION['ID'];
		$idcliente = $_POST['idcliente'];
		$articulo = filter_var($_POST['articulo'], FILTER_SANITIZE_STRING);
		$modelo = filter_var($_POST['modelo'], FILTER_SANITIZE_STRING);
		$modelo = (   $modelo!=''   )? $modelo : 'N/A' ;
		$marca = filter_var($_POST['marca'], FILTER_SANITIZE_STRING);
		$marca = (   $marca!=''   )? $marca : 'N/A' ;
		$serie = filter_var($_POST['serie'], FILTER_SANITIZE_STRING);
		$serie = (   $serie!=''   )? $serie : 'N/A' ;
		$presupuesto = filter_var($_POST['presupuesto'], FILTER_SANITIZE_STRING);
		$precio = (   isset($_POST['precio'])   ) ?  filter_var($_POST['precio'], FILTER_SANITIZE_STRING) : NULL;
		$imagenes = $_FILES['imagenes'];
		$funda = (   isset($_POST['funda'])   )? $_POST['funda'] : '0' ;
		$cargador = (   isset($_POST['cargador'])   )? $_POST['cargador'] : '0' ;
		$bateria = (   isset($_POST['bateria'])   )? $_POST['bateria'] : '0' ;
		$otroacc = filter_var($_POST['otroacc'], FILTER_SANITIZE_STRING);
		$otroacc = (   $otroacc!=''   )? $otroacc : 'N/A' ;
		$status = (   isset($_POST['status'])   )? $_POST['status'] : '1' ;
		$datee = (   isset($_POST['datee'])   )? $_POST['datee'] : null ;
		$dates = (   isset($_POST['dates'])   )? $_POST['dates'] : null ;
		$estimado_tiempo = (   isset($_POST['estimado_tiempo'])   )? $_POST['estimado_tiempo'] : null ;
		$folio = filter_var($_POST['folio'], FILTER_SANITIZE_STRING);
		$notas = (   isset($_POST['notas'])   )? nl2br($_POST['notas']) : '' ;
		$operacion = (   isset($_POST['operacion'])   )? nl2br($_POST['operacion']) : '' ;
		
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
						
						if(   ($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif' || $ext=='bmp') && $img_validate   ) {
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
				
				$insert = "INSERT INTO articulos VALUES(NULL,".$idcliente.",".$id.",'".$articulo."','".$modelo."','".$marca."','".$serie."','".$presupuesto."','".$precio."'
				,".$cantidad_img.",'".$name_img."',".$funda.",".$cargador.",".$bateria.",'".$otroacc."',".$status.",'".$datee."','".$dates."','".$folio."','".$notas."',0,NULL,NULL,'".$operacion."', '".$estimado_tiempo."'
);";
				mysqli_query($db, $insert);

				//echo $insert;

				$query = mysqli_query($db, "SELECT LAST_INSERT_ID()");
				$data = mysqli_fetch_array( $query, MYSQLI_NUM);
				$last_id = $data[0];
				@mysqli_free_result( $query );
		
				echo "<p style='background:#0A0; color:white; padding:14px 20px; margin:2px;'>";
					echo "Reparación agregado con éxito!";
				echo "</p>";
				
				/* redireccionamos a "ver reparaciones" con parametro aid=X */
				?>
				<script>
					window.location.href = '?action=ver_reparaciones&last=<?=$last_id?>';
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
	<p id="cabecera_action">Inicio > Agregar Nuevo Articulo/Reparación</p>
	
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
					$consulta = "SELECT * FROM clientes WHERE UID=".$id." AND CID=".$cliente." LIMIT 1";
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
							$consulta = "SELECT * FROM clientes WHERE UID=".$id." ORDER BY name";
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
				$consulta = "SELECT * FROM clientes WHERE UID=".$id." ORDER BY name";
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
			
			<p>(*) Articulo:</p>
			<input type="text" name="articulo" placeholder="Articulo..." required />
			<br/>
			
			<p>Modelo:</p>
			<input type="text" name="modelo" placeholder="Modelo del articulo..." />
			<br/>
			
			<p>Marca:</p>
			<input type="text" name="marca" placeholder="Marca del articulo..." />
			<br/>
			
			<p>Serie:</p>
			<input type="text" name="serie" placeholder="Serie del articulo..." />
			<br/>
			
			<p>(*) Presupuesto:</p>
			<input type="text" name="presupuesto" placeholder="Presupuesto por la reparación..." required />
			<br/>
			
			<p>Precio Final:</p>
			<input type="text" name="precio" placeholder="Precio Final..." value="0.00" />
			<br/>
			
			<p>FOTOS:</p>
			<input type="file" name="imagenes[]" multiple />
			<br/>
			<p style="background:#900; color:white; font-size:13px;">*FORMATOS DE IMAGEN COMPATIBLES: jpg, png, gif, bmp.</p>
			<br/>
			
			<p class="accesorios">Accesorios:</p>
			<label class="accesorio"><input type="checkbox" name="funda" value="1" /> Funda</label>
			<label class="accesorio"><input type="checkbox" name="cargador" value="1" /> Cargador</label>
			<label class="accesorio"><input type="checkbox" name="bateria" value="1" /> Bateria</label>
				<br/>
			Otro: <input class="input_accesorio" type="text" name="otroacc" placeholder="Otro accesorio..." />
			<br/>
			
			<p class="accesorios">(*) Status del articulo:</p>
				<label class="accesorio"><input type="radio" name="status" value="11" checked /> Electronica</label>
			<label class="accesorio"><input type="radio" name="status" value="0" checked /> Recibido</label>
			<label class="accesorio"><input type="radio" name="status" value="1" /> En Reparación</label>
			<label class="accesorio"><input type="radio" name="status" value="2" /> Reparación Finalizada</label>
			<label class="accesorio"><input type="radio" name="status" value="3" /> Entregado</label>
			<label class="accesorio"><input type="radio" name="status" value="4" /> En Garantía</label>
			<br/><br/>
			
			<p>(*) Fecha de Entrada:</p>
			<?php 
			    $date = date('Y-m-d');
			    $date2 = date('Y-m-d', strtotime($date . ' +2 days'));
			?>
			<input type="date" name="datee" value="<?=$date?>" />
			<br/>
			
			<p>Fecha de Salida:</p>
			<input type="date" name="dates" value="<?=$date?>"/>
			<br/>
			
			<p>Fecha de estimación de tiempo de reparación:</p>
			<input type="date" name="estimado_tiempo" value="<?=$date2?>"/>
			<br/>
			
			<p>(*) Folio de la reparación:</p>
			<input type="text" name="folio" placeholder="Folio..." required />
			<br/>

			<p>(*) Fallas / Notas:</p>
			<textarea name="notas" placeholder="Escriba las fallas o notas del articulo..." required></textarea>
			<br/>
			
			<p>Resumen Reparación Final:</p>
			<textarea name="operacion" placeholder="Escriba la operación realizada en la reparación del articulo..."></textarea>
			<br/>
			
			<button name="after" value="1">Añadir Artículo</button>
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