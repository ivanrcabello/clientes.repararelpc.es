<?php
if(   isset($_GET['id']) && $_GET['id']>0   ) {
?>
<div id="cuerpo_action">
<p id="cabecera_action">Inicio > Ver Factura ( #<?=$_GET['id']?> )</p>

<?php
		$id = $_SESSION['ID']; // User ID
		$fid = $_GET['id'];

		if(   $_SESSION['admin']==1   ) {
				// Extraemos datos del articulo/reparacion
				$consulta = "SELECT * FROM facturas WHERE FID=".$fid." LIMIT 1";
		} else {
				// Extraemos datos del articulo/reparacion, y que pertenezca a dicho usuario
				$consulta = "SELECT * FROM facturas WHERE FID=".$fid." AND UID=".$id." LIMIT 1";
		}

		$query =  mysqli_query($db, $consulta);

		if(   mysqli_num_rows($query)>0   ) {
				$row = mysqli_fetch_array($query);

				$folio = $row['FOLIO'];
				
				$cid = $row['CID'];
				$articulo = $row['articulo'];
				$precio = floatval($row['total']);
				$condiciones = $row['condiciones'];

				$x = explode(' ', $row['fecha']);
				$fecha2 = $x[0];
							
				$precio100 = number_format(   ($precio/121)*100,2,'.',''   );
				$precio21 =  number_format(   ($precio100/100)*21,2,'.',''   );
				$preciototal = number_format(   ($precio100+$precio21),2,'.',''   );

				//Extraemos datos del cliente
				$consulta2 = "SELECT * FROM clientes WHERE CID=".$cid." LIMIT 1";
				$query2 = mysqli_query($db, $consulta2);

				if(   mysqli_num_rows($query2)>0   ) {
							$row2 = mysqli_fetch_array($query2);
							
							$nombre = $row2['name'];
							$direccion = $row2['address'];
							$telefono = $row2['phone'];
							$nif = $row2['nif'];							
	?>

						<div style="width:90%; margin:0 auto; padding:12px 0;">
									<button class="print">IMPRIMIR FICHA</button>
									<a href="?action=sendfactura&fid=<?=$fid?>" class="send">ENVIAR FICHA POR CORREO</a>
						</div>


						<div id="facturaprint" style="border:1px solid; width:90%; margin:0 auto; background:#fff; padding:20px 12px;">
							<p style="max-width:60%; float:left;">
								<img src="img/logo.jpg" style="width:300px;" />
									<br/>
								<span style="font-size:30px; font-weight:bold;">REPARARELPC.ES</span>
									<br/>
								<span>
								<?php echo $config['facturacionnombres']; ?> <br/>
								<?php echo $config['facturacioncif']; ?> <br/>
								<?php echo $config['facturaciondireccion']; ?> <br/>
								<?php echo $config['facturacionemail']; ?><br/>
								<?php echo $config['facturaciontelefono']; ?>
								</span>
							</p>
							<h2 style="text-align:right;">Factura No. <?=$folio?></h2>

							<div style="clear:both;"></div>

								<br/><br/>
							<p><strong>Cobrar a:</strong></p>
							<p>
								<strong>Cliente:</strong> <?=$nombre?> <strong>NIF/DNI:</strong> <?=$nif?>
								<span style="float:right;"><strong>Fecha de Facturación:</strong> <?=$fecha2?></span>
							</p>
							<p>
								<strong>Dirección:</strong> <?=$direccion?>
								<!--<span style="float:right;"><strong>Fecha de Vencimiento:</strong> </span>-->
							</p>
							<p>
								<strong>Telefono:</strong> <?=$telefono?>
								<span style="float:right;"><strong>Cantidad a Pagar:</strong> <?=number_format($preciototal,2,'.',',')?>&euro;</span>
							</p>

								<br/>

							<table style="width:100%;">
									<tr><td colspan="5"><p style="border-bottom:1px solid #aaa;"></p></td></tr>

									<tr style="font-weight:bold;">
										<td>Elemento</td>
										<td>Descripción</td>
										<td>Cantidad</td>
										<td>Precio</td>
										<td style="text-align:right;">Total</td>
									</tr>

									<tr><td colspan="5"><p style="border-bottom:1px solid #aaa;"></p></td></tr>

									<tr>
										<td>1</td>
										<td>Reparación articulo (<?=$articulo?>)</td>
										<td>1.00</td>
										<td><?=number_format($precio100,2,'.',',')?> &euro;</td>
										<td style="text-align:right;"><?=number_format($precio100,2,'.',',')?> &euro;</td>
									</tr>
							</table>

								<br/>

							<table style="float:right; text-align:right;">
									<tr><td>Subtotal:</td><td style="padding-left:15px;"><?=number_format($precio100,2,'.',',')?> &euro;</td></tr>
									<tr><td>IVA 21.00%</td><td style="padding-left:15px;"><?=number_format($precio21,2,'.',',')?> &euro;</td></tr>
									<tr><td>Total:</td><td style="padding-left:15px; font-weight:bold;"><?=number_format($preciototal,2,'.',',')?> &euro;</td></tr>
									<!--<tr><td style="text-align:right;">Pagado:</td><td style="padding-left:15px;">XXX</td></tr>-->
									<!--<tr><td style="text-align:right;">Balance</td><td style="padding-left:15px;">XXX</td></tr>-->
							</table>

								<div style="clear:both";></div>

							<p><strong>Detalles de la reparación:</strong></p>
							<p><?=$condiciones?></p>
							
							<div style="margin-top:20px; font-size:13px; color:#555; text-align:center;">
								<p><?=$config['condiciones']?></p>
							</div>

						</div>

					<div style="width:90%; margin:0 auto; padding:12px 0;">
								<button class="print">IMPRIMIR FICHA</button>
								<a href="?action=sendfactura&fid=<?=$fid?>" class="send">ENVIAR FICHA POR CORREO</a>
					</div>
	<?php
/* ***** TERMINA EL DIV DE LA FACTURA *** */

				} else {
						/* ERROR, NO EXISTE ESTE CID */
						echo "<h1> ERROR, NO SE PUDO GENERAR FACTURA </h1>";
						echo "<em> Detalle: Está reparación no esta relacionada a ningun cliente, Porfavor modifique esta reparación.</em>";
						echo "<br/><a href='?action=edit_reparacion&aid=".$aid."'>Click Aqui</a>";
				}
				@mysqli_free_result( $query2 );
		} else {
				/* ERROR, NO EXISTE ESTE AID, O NO PERTENECE A TI COMO USUARIO */
				echo "<h1> ERROR, NO SE PUDO GENERAR FACTURA </h1>";
				echo "<em> Detalle: Está reparación no ha sido asignada por tu usuario.</em>";
		}

		@mysqli_free_result( $query );
}
?>

</div>








<div id="areaprint" class="facturaprint">
<p style="max-width:60%; float:left;">
								<img src="img/logo.jpg" style="width:300px;" />
									<br/>
								<span style="font-size:30px; font-weight:bold;">REPARARELPC.ES</span>
									<br/>
								<span>
								<?php echo $config['facturacionnombres']; ?> <br/>
								<?php echo $config['facturacioncif']; ?> <br/>
								<?php echo $config['facturaciondireccion']; ?> <br/>
								<?php echo $config['facturacionemail']; ?><br/>
								<?php echo $config['facturaciontelefono']; ?>	
								</span>
							</p>
							<h2 style="text-align:right;">Factura No. <?=$folio?></h2>

							<div style="clear:both;"></div>

								<br/><br/>
							<p><strong>Cobrar a To:</strong></p>
							<p>
								<strong>Cliente:</strong> <?=$nombre?> <strong>NIF/DNI:</strong> <?=$nif?>
								<span style="float:right;"><strong>Fecha de Facturación:</strong> <?=$fecha2?></span>
							</p>
							<p>
								<strong>Dirección:</strong> <?=$direccion?>
								<!--<span style="float:right;"><strong>Fecha de Vencimiento:</strong> </span>-->
							</p>
							<p>
								<strong>Telefono:</strong> <?=$telefono?>
								<span style="float:right;"><strong>Cantidad a Pagar:</strong> <?=number_format($preciototal,2,'.',',')?>&euro;</span>
							</p>

								<br/>

							<table style="width:100%;">
									<tr><td colspan="5"><p style="border-bottom:1px solid #aaa;"></p></td></tr>

									<tr style="font-weight:bold;">
										<td>Elemento</td>
										<td>Descripción</td>
										<td>Cantidad</td>
										<td>Precio</td>
										<td style="text-align:right;">Total</td>
									</tr>

									<tr><td colspan="5"><p style="border-bottom:1px solid #aaa;"></p></td></tr>

									<tr>
										<td>1</td>
										<td>Reparación articulo (<?=$articulo?>)</td>
										<td>1.00</td>
										<td><?=number_format($precio100,2,'.',',')?> &euro;</td>
										<td style="text-align:right;"><?=number_format($precio100,2,'.',',')?> &euro;</td>
									</tr>
							</table>

								<br/>

							<table style="float:right; text-align:right;">
									<tr><td>Subtotal:</td><td style="padding-left:15px;"><?=number_format($precio100,2,'.',',')?> &euro;</td></tr>
									<tr><td>IVA 21.00%</td><td style="padding-left:15px;"><?=number_format($precio21,2,'.',',')?> &euro;</td></tr>
									<tr><td>Total:</td><td style="padding-left:15px; font-weight:bold;"><?=number_format($preciototal,2,'.',',')?> &euro;</td></tr>
									<!--<tr><td style="text-align:right;">Pagado:</td><td style="padding-left:15px;">XXX</td></tr>-->
									<!--<tr><td style="text-align:right;">Balance</td><td style="padding-left:15px;">XXX</td></tr>-->
							</table>

								<div style="clear:both";></div>

							<p><strong>Detalles de la reparación:</strong></p>
							<p><?=$condiciones?></p>
							
							<div style="margin-top:20px; font-size:13px; color:#555;">
								<p><center><?=$config['condiciones']?></center></p>
							</div>
</div>

<script>
	$(".print").click( function() {
			window.print();
			
			return false;
	});
</script>