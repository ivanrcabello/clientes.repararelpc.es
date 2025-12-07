<?php
if(   isset($_GET['aid']) && $_GET['aid']>0 && $_SESSION['admin']==1   ) {
	$aid = $_GET['aid'];

	/* Verificamos que el articulo EXISTE */
	$consulta = "SELECT * FROM articulos WHERE AID=".$aid." LIMIT 1";
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
		$articulo = filter_var($_POST['articulo'], FILTER_SANITIZE_STRING);
		$modelo = filter_var($_POST['modelo'], FILTER_SANITIZE_STRING);
				$modelo = (   $modelo!=''   )? $modelo : 'N/A' ;
		$marca = filter_var($_POST['marca'], FILTER_SANITIZE_STRING);
				$marca = (   $marca!=''   )? $marca : 'N/A' ;
		$serie = filter_var($_POST['serie'], FILTER_SANITIZE_STRING);
				$serie = (   $serie!=''   )? $serie : 'N/A' ;
		$presupuesto = filter_var($_POST['presupuesto'], FILTER_SANITIZE_STRING);
		$precio = filter_var($_POST['precio'], FILTER_SANITIZE_STRING);
		$imagenes = $_FILES['imagenes'];
		$funda = (   isset($_POST['funda'])   )? $_POST['funda'] : '0' ;
		$cargador = (   isset($_POST['cargador'])   )? $_POST['cargador'] : '0' ;
		$bateria = (   isset($_POST['bateria'])   )? $_POST['bateria'] : '0' ;
		$otroacc = filter_var($_POST['otroacc'], FILTER_SANITIZE_STRING);
				$otroacc = (   $otroacc!=''   )? $otroacc : 'N/A' ;
		$status = (   isset($_POST['status'])   )? $_POST['status'] : '1' ;
		$datee = (   isset($_POST['datee'])   )? $_POST['datee'] : '0000-00-00 00:00:00' ;
		$dates = (   isset($_POST['dates'])   )? $_POST['dates'] : '0000-00-00 00:00:00' ;
		$folio = filter_var($_POST['folio'], FILTER_SANITIZE_STRING);
		$notas = (   isset($_POST['notas'])   )? nl2br($_POST['notas']) : '' ;
		$operacion = (   isset($_POST['operacion'])   )? nl2br($_POST['operacion']) : '' ;
		
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

						$update = "UPDATE articulos SET 
							CID=".$idcliente.",
							articulo='".$articulo."',
							modelo='".$modelo."',
							marca='".$marca."',
							serie='".$serie."',
							presupuesto='".$presupuesto."',
							precio='".$precio."',
							no_fotos=".$cantidad_img.",
							funda=".$funda.",
							cargador=".$cargador.",
							bateria=".$bateria.",
							otro='".$otroacc."',
							status=".$status.",
							fecha_entrada='".$datee."',
							fecha_salida='".$dates."',
							folio='".$folio."',
							notas='".$notas."',
							operacion='".$operacion."' 
							 WHERE AID=".$aid;
					
					mysqli_query($db, $update);
		
				echo "<p style='background:#0A0; color:white; padding:14px 20px; margin:2px;'>";
					echo "Reparación agregado con éxito!";
				echo "</p>";
				
				/* redireccionamos a "ver reparaciones" con parametro aid=X */
				?>
				<script>
					window.location.href = '?action=admin_ver_reparaciones&last=<?=$aid?>';
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
	<p id="cabecera_action">Inicio > Editar Articulo/Reparación (<?=$row['articulo']?>)</p>
	
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
			
			<p>Dirección del cliente: (No se puede modificar)</p>
			<input type="text" value="<?=$address_default?>" id="address" readonly />
			<br/>
			
			<p>(*) Articulo:</p>
			<input type="text" name="articulo" value="<?=$row['articulo']?>" placeholder="Articulo..." required />
			<br/>
			
			<p>Modelo:</p>
			<input type="text" name="modelo" value="<?=$row['modelo']?>" placeholder="Modelo del articulo..." />
			<br/>
			
			<p>Marca:</p>
			<input type="text" name="marca" value="<?=$row['marca']?>" placeholder="Marca del articulo..." />
			<br/>
			
			<p>Serie:</p>
			<input type="text" name="serie" value="<?=$row['serie']?>" placeholder="Serie del articulo..." />
			<br/>
			
			<p>(*) Presupuesto:</p>
			<input type="text" name="presupuesto" value="<?=$row['presupuesto']?>" placeholder="Presupuesto por la reparación..." required />
			<br/>
			
			<p>Precio Final:</p>
			<input type="text" name="precio" value="<?=$row['precio']?>" placeholder="Precio Final..." />
			<br/>
			
			<p>FOTOS:</p>
			<div id="carga_fotos">
			<?php
				if(   $row['no_fotos']>0   ) {
						for($i=1; $i<=$row['no_fotos']; $i++) {
							$img = 'uploads/'.$row['nombre_fotos'].'_'.$i;
							
							if(   file_exists($img.'.jpg')   ) {
									$img .= '.jpg';
							} elseif(   file_exists($img.'.jpeg')   ) {
									$img .= '.jpeg';
							} elseif(   file_exists($img.'.png')   ) {
									$img .= '.png';
							} elseif(   file_exists($img.'.gif')   ) {
									$img .= '.gif';
							} elseif(   file_exists($img.'.bmp')   ) {
									$img .= '.bmp';
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
			<p style="background:#900; color:white; font-size:13px;">*FORMATOS DE IMAGEN COMPATIBLES: jpg, png, gif, bmp.</p>
			<br/>
			
			<p class="accesorios">Accesorios:</p>
			<label class="accesorio"><input type="checkbox" name="funda" value="1" <?php if($row['funda']==1){ echo "checked";} ?> /> Funda</label>
			<label class="accesorio"><input type="checkbox" name="cargador" value="1" <?php if($row['cargador']==1){ echo "checked";} ?> /> Cargador</label>
			<label class="accesorio"><input type="checkbox" name="bateria" value="1" <?php if($row['bateria']==1){ echo "checked";} ?> /> Bateria</label>
				<br/>
			Otro: <input class="input_accesorio" type="text" name="otroacc" value="<?=$row['otro']?>" placeholder="Otro accesorio..." />
			<br/>
			
			<p class="accesorios">(*) Status del articulo:</p>
			<label class="accesorio"><input type="radio" name="status" value="0" <?php if($row['status']==0){ echo "checked";} ?> /> Recibido</label>
			<label class="accesorio"><input type="radio" name="status" value="1" <?php if($row['status']==1){ echo "checked";} ?> /> En Reparación</label>
			<label class="accesorio"><input type="radio" name="status" value="2" <?php if($row['status']==2){ echo "checked";} ?> /> Reparación Finalizada</label>
			<label class="accesorio"><input type="radio" name="status" value="3" <?php if($row['status']==3){ echo "checked";} ?> /> Entregado</label>
			<br/><br/>
			
			<p>(*) Fecha de Entrada:</p>
			<?php
				if(   strtotime($row['fecha_entrada'])>0   ) {
					$date = date('Y-m-d', strtotime($row['fecha_entrada']));
				} else {
					$date = '';
				}
			?>
			<input type="date" name="datee" value="<?=$date?>" />
			<br/>
			
			<p>Fecha de Salida:</p>
			<?php
				if(   strtotime($row['fecha_salida'])>0   ) {
					$date = date('Y-m-d', strtotime($row['fecha_salida']));
				} else {
					$date = '';
				}
			?>
			<input type="date" name="dates" value="<?=$date?>" />
			<br/>
			
			<p>(*) Folio de la reparación:</p>
			<input type="text" name="folio" value="<?=$row['folio']?>" placeholder="Folio..." required />
			<br/>

			<p>(*) Fallas / Notas:</p>
			<?php
				$nl = preg_replace('#<br\s*/?>#i', "", $row['notas']);
			?>
			<textarea name="notas" placeholder="Escriba las fallas o notas del articulo..." required><?=$nl?></textarea>
			<br/>
			
			<p>Resumen Reparación Final:</p>
			<?php
				$nl = preg_replace('#<br\s*/?>#i', "", $row['operacion']);
			?>
			<textarea name="operacion" placeholder="Escriba la operación realizada en la reparación del articulo..."><?=$nl?></textarea>
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