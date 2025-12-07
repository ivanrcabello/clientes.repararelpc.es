<?php

if(   isset($_GET['aid']) && $_GET['aid']>0   ) {
	$aid = $_GET['aid'];

	/* Verificamos que el articulo EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT *, puntos.direccion as dire FROM articulos LEFT JOIN puntos ON articulos.punto = puntos.GID WHERE AID=".$aid." LIMIT 1";
	} else {
		$consulta = "SELECT *, puntos.direccion as dire FROM articulos LEFT JOIN puntos ON articulos.punto = puntos.GID WHERE status = 11 AND AID=".$aid." LIMIT 1";
	}
	$query = mysqli_query($db, $consulta);
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
            
	} else {
			/* No existe este cliente o no esta relacionado al ID del usuario logueado */
			?>
				No tienes permisos
			<?php
			exit;
	}
	@mysqli_free_result($query);
	
	/* Extraemos datos del cliente */
	$c = "SELECT * FROM clientes WHERE CID=".$row['CID']." LIMIT 1";
	$q = mysqli_query($db, $c);
	if(   mysqli_num_rows($q)>0   ) {
			$cliente = mysqli_fetch_array($q, MYSQLI_ASSOC);
	}
	@mysqli_free_result($q);
	
	
	$mes = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Ver Reparacion: <?=$row['articulo']?> (<?=$aid?>)</p>
	
	<div style="width:90%; margin:0 auto;">
		
		<br/>
		<?php //echo json_encode($row); ?>
		<button class="print">IMPRIMIR FICHA</button>
		<a href='/action/print/ticket.php?row=<?php echo json_encode(array_merge($row, $cliente)); ?>' class="send ticket">IMPRIMIR TICKET DE LA FICHA</button>
		<a href="?action=send&aid=<?=$aid?>" class="send">ENVIAR FICHA POR CORREO</a>
		<a href="?action=add_factura&aid=<?=$aid?>" class="send" style="background:#ffda22; border-color:#d4b310; color:#222;">GENERAR FACTURA</a>
		<a target="_blank" href="https://api.whatsapp.com/send/?phone=+34<?=$cliente['phone']; ?>&text=Hola&type=phone_number&app_absent=0" class="send" style="background:#e7f075; border-color:#d4b310; color:#222;">ENVIAR MENSAJE DE WHATSAPP</a>
		
		<br/><br/>

		<h2 style="line-height:42px; margin:1px 0 4px 0;">
			<?=$row['articulo']?>
			<?php 
			if(   $_SESSION['admin']==1   ) {
			    ?>
			<span style="float:right; background:#A11; color:white; font-size:16px; padding:4px 14px; border-radius:4px; line-height:normal;">
				&euro; <?=$row['precio']?><br/>
				<em style="font-size:11px;">(Precio Final)</em>
			</span>
			<span style="float:right; background:#A11; color:white; font-size:16px; padding:4px 14px; border-radius:4px; margin-right:3px; line-height:normal;">
				&euro; <?=$row['presupuesto']?><br/>
				<em style="font-size:11px;">(Presupuesto)</em>
			</span>
			<?php } ?>
			<span style="float:right; background:#5AF; color:white; font-size:16px; padding:4px 14px; border-radius:4px; margin-right:3px; line-height:normal;">
				<?=$row['folio']?>
				<br/>
				<em style="font-size:11px;">( No. de Folio)</em>
			</span>
		</h2>
		
		<hr/>
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">CLIENTE:</span> 
			<span><?=$cliente['name']; ?></span>
		</p>
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">ID de CLIENTE:</span> 
			<span><?=$cliente['id_checker']; ?></span>
		</p>
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">DIRECCIÓN del cliente:</span> 
			<span><?=$cliente['address']; ?></span>
		</p>	
		<hr/><br/>
		
			<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">DIRECCIÓN de recogida:</span> 
			<span><?=$row['dire']; ?></span>
		</p>	
		<hr/><br/>
		
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Modelo:</span> 
			<span><?=$row['modelo']?></span>
		</p>
		
		<p style="background:#eee; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Marca:</span> 
			<span><?=$row['marca']?></span>
		</p>
		
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Serie:</span> 
			<span><?=$row['serie']?></span>
		</p>
		
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Cuenta con certificados:</span> 
			<span><?=$row['certificado'] == 1 ? 'Si' : 'No' ?></span>
		</p>
		
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Contraseña del ordenador:</span> 
			<span><?=$row['password']?></span>
		</p>
		
		<p style="background:#eee; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Accesorios:</span> 
			<span>
				<?php
					$acc = '';
					if(   $row['bateria']==1   ) { $acc .= "Bateria"; }
					if(   $row['funda']==1   ) { if(   $acc!=''   ) { $acc .= ", "; } $acc .= "Funda"; }
					if(   $row['cargador']==1   ) { if(   $acc!=''   ) { $acc .= ", "; } $acc .= "Cargador"; }
					if(   $acc!=''   ) { $acc .= ", "; }
					$acc .= $row['otro'];
					
					echo $acc;
				?>
			</span>
		</p>
		
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Status:</span> 
			<?php
				switch(   $row['status']   ) {
				    	case 11:
						$status = '<span style="display:inline-block; background:#4A3E2E; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Electronica';
							break;
					case 0:
						$status = '<span style="display:inline-block; background:#81F7F3; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Recibido';
							break;
					case 1:
						$status = '<span style="display:inline-block; background:#F3F781; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> En Reparación';
							break;
					case 2:
						$status = '<span style="display:inline-block; background:#FE2E2E; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Reparación Finalizada';
							break;
					case 3:
						$status = '<span style="display:inline-block; background:#40FF00; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Entregado';
							break;
					case 4:
								$status = '<span style="display:inline-block; background:#9E9E9E; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> En garantia';
							break;
					case 10:
								$status = '<span style="display:inline-block; background:#4E9E4E; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Sin recepcionar';
						break;
						case 12:
								$status = '<span style="display:inline-block; background:#4E9E4E; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> No reparable';
						break;
						case 13:
								$status = '<span style="display:inline-block; background:#4E9E4E; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Esperando material';
						break;
						case 14:
								$status = '<span style="display:inline-block; background:#4E9E4E; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Presupuestando';
						break;
					
				}
				
				echo $status;
			?>
		</p>
		
		<p style="background:#eee; line-height:32px; padding:2px 1px; width:49%; float:left;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Fecha Entrada:</span> 
			<?php
				$f = explode(" ",$row['fecha_entrada']);
				$f = explode("-",$f[0]);
				
				if(   ($f[0]+0)>0   ) {
						$fechae =  $f[2]." ".$mes[   ($f[1]-1)   ]." ".$f[0];
				} else {
						$fechae =  "N/A";
				}
				echo $fechae;
			?>
		</p>
		<p style="background:#eee; line-height:32px; padding:2px 1px; width:49%; float:right;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Fecha Salida:</span> 
			<?php
				$f = explode(" ",$row['fecha_salida']);
				$f = explode("-",$f[0]);
				
				if(   ($f[0]+0)>0   ) {
						$fechas =  $f[2]." ".$mes[   ($f[1]-1)   ]." ".$f[0];
				} else {
						$fechas =  "N/A";
				}
				echo $fechas;
			?>
		</p>
		
		<div style="clear:both;"></div>
	</div>
	
	<p style="width:90%; margin:5px auto 0 auto; color:#444;">
		<span style="display:inline-block; background:#81F7F3; vertical-align:top; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> El cliente a dejado el articulo en la empresa.<br/>
		<span style="display:inline-block; background:#F3F781; vertical-align:top; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Actualmente está siendo reparado.<br/>
		<span style="display:inline-block; background:#FE2E2E; vertical-align:top; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> El articulo ya está reparado, pero aun no ha sido entregado al cliente.<br/>
		<span style="display:inline-block; background:#40FF00; vertical-align:top; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Articulo entregado al cliente.
	</p>
	
	<div style="width:90%; margin:0 auto;">
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:block; padding:0 10px; background:#ccc; border-radius:2px;">Notas:</span> 
			
			<span style="display:inline-block; line-height:20px;">
				<?=$row['notas']?>
			</span>
		</p>
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:block; padding:0 10px; background:#ccc; border-radius:2px;">Operación Final de la Reparación:</span> 
			
			<span style="display:inline-block; line-height:20px;">
				<?=$row['operacion']?>
			</span>
		</p>
		
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:block; padding:0 10px; background:#ccc; border-radius:2px;">Fotos:</span> 
			<?php
				if(   $row['no_fotos']>0   ) {
						for($i=1; $i<=$row['no_fotos']; $i++) {
							$img = 'uploads/'.$row['nombre_fotos'].'_'.$i;
							
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
						}
				}
			?>
		</p>
		
		<br/>
		
		<button class="print">IMPRIMIR FICHA</button>
		<a href="?action=send&aid=<?=$aid?>" class="send">ENVIAR FICHA POR CORREO</a>
		<a href="?action=add_factura&aid=<?=$aid?>" class="send" style="background:#ffda22; border-color:#d4b310; color:#222;">GENERAR FACTURA</a>
		
		<br/>
		<br/>
		
	</div>
</div> <!-- end #cuerpo_action -->

<?php
}
/* *************************************** AREA PARA IMPRIMIR ********************************* */
?>
<div id="areaprint">

	<div style="text-align:center;">
		<img src="img/repararelpc.png" style="width:100%;"/>
		<p>
			Calle marques de Berna 18 Nave 2, 28042 Madrid - 91 155 85 05 | 690 041 105
			<br/>
			Ordemat Soluciones SL B-86744042   info@repararelpc.es
		</p>
		
		<p class="barra">DATOS DEL CLIENTE</p>
		
			<div style="margin:10px 0;"></div>
		
		<div style="text-align:left; font-size:0;">
			<div class="c29">Fecha de Entrada:</div>
			<div class="c20"><?=$fechae?></div>
			<div class="c29">Fecha de Salida:</div>
			<div class="c20"><?=$fechas?></div>
			
			<div class="c29">Presupuesto:</div>
			<div class="c20">&euro; <?=$row['presupuesto']?></div>
			<div class="c29">Precio Final:</div>
			<div class="c20">&euro; <?=$row['precio']?></div>
			
			<div class="c29">ID Cliente:</div>
			<div class="c20"><?=$cliente['id_checker']?></div>
			<div class="c29">No. Folio:</div>
			<div class="c20"><?=$row['folio']?></div>

					<div style="margin:10px 0;"></div>

			<div class="c28">Nombre:</div>
			<div class="c70"><?=$cliente['name']; ?></div>
			
			<div class="c28">Dirección:</div>
			<div class="c70"><?=$cliente['address']; ?></div>
			
			<div class="c20">Telefono:</div>
			<div class="c29"><?php if( $cliente['phone'] != '' ) { echo $cliente['phone']; } else { echo '-'; } ?></div>
			
			<div class="c20">Correo:</div>
			<div class="c29"><?php if( $cliente['email'] != '' ) { echo $cliente['email']; } else { echo '-'; } ?></div>
			
				<div style="margin:10px 0;"></div>
				
			<div class="c20">Funda:</div>
			<div class="c10"><?php if( $row['funda']==1 ) {echo "X";}else{echo '&nbsp;';} ?></div>
			<div class="c20">Cargador:</div>
			<div class="c10"><?php if( $row['cargador']==1 ) {echo "X";}else{echo '&nbsp;';} ?></div>
			<div class="c20">Bateria:</div>
			<div class="c10"><?php if( $row['bateria']==1 ) {echo "X";}else{echo '&nbsp;';} ?></div>
			<div class="c28">Otro Accesorio:</div>
			<div class="c70"><?=$row['otro']?></div>
		</div>
		
			<div style="margin:10px 0;"></div>
		
		<p class="barra">EVALUACION DEL PROBLEMA</p>
		<div class="c90">
			<?=$row['notas']?>
		</div>
			<div style="margin:5px 0;"></div>
		<p class="barra">RESOLUCION DEL PROBLEMA</p>
		<div class="c90">
			<?=$row['operacion']?>
		</div>
			<div style="margin:10px 0;"></div>
			
		<p>Para consultar el estado de tu articulo en reparación, visita: <u>http://app.goseo.es/</u></p>
		<div class="firma">Firma Conforme</div>
	</div>

</div> <!-- // TERMINA AREA PARA IMPRIMIR -->


<script>
	$(".print").click( function() {
			window.print();
			
			return false;
	});
</script>