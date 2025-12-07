<div id="cuerpo_action">
<p id="cabecera_action">Inicio > Generar Factura</p>

<?php
if(   isset($_GET['aid']) && $_GET['aid']>0   ) {
		$id = $_SESSION['ID']; // User ID
		$aid = $_GET['aid'];

		if(   $_SESSION['admin']==1   ) {
				// Extraemos datos del articulo/reparacion
				$consulta = "SELECT * FROM articulos WHERE AID=".$aid." LIMIT 1";
		} else {
				// Extraemos datos del articulo/reparacion, y que pertenezca a dicho usuario
				$consulta = "SELECT * FROM articulos WHERE AID=".$aid." AND UID=".$id." LIMIT 1";
		}

		$query =  mysqli_query($db, $consulta);

		if(   mysqli_num_rows($query)>0   ) {
				$row = mysqli_fetch_array($query);

				$cid = $row['CID'];
				$articulo = $row['articulo'];
				$precio = floatval($row['precio']);


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

/* *** PROCEDEMOS A CREAR LA FACTURA ********************************************************************************************* */
							$fecha = date('Y-m-d H:i:s');
							$fecha2 = date('Y-m-d');
	?>
<?php
/* ** SE ENVIO EL FORM? ** */
if(   isset($_POST['condiciones'])   ) {
		$condiciones = nl2br(   filter_var($_POST['condiciones'], FILTER_SANITIZE_STRING)   );

		// extraemos ultimo FOLIO 
		$selectx = mysqli_query($db, "SELECT FOLIO FROM facturas ORDER BY FID DESC LIMIT 1");
		if(   $selectx   ) {
			if(   mysqli_num_rows($selectx)>0   ) {
					$row = mysqli_fetch_array($selectx, MYSQLI_ASSOC);
					$ULTIMO_FOLIO = $row['FOLIO'];
					
					$FOLIO = (intval($ULTIMO_FOLIO)+1);
					
					// SI se acaban de resetear, entonces FOLIO debe ser 1 y reset_factura lo cambiamos a 0
					if(   $config['reset_facturas']==1   ) {
						$FOLIO = 1;
						$upx = mysqli_query($db, "UPDATE config SET config_value='0' WHERE config_key='reset_facturas' LIMIT 1");
					}
					
					/* Insertamos la factura */
					$insert = "INSERT INTO facturas VALUES(null,".$FOLIO.",".$config['version_factura'].",".$cid.",".$aid.",".$id.",'".$nombre."','".$direccion."','".$telefono."','".$nif."','".$fecha."','".$preciototal."','".$articulo."','".$condiciones."')";

					if(   mysqli_query($db, $insert)   ) {
							$queryx = mysqli_query($db, "SELECT LAST_INSERT_ID()");
							$data = mysqli_fetch_array( $queryx, MYSQLI_NUM);
							
							$last_id = $data[0];
							
							@mysqli_free_result( $queryx );
				?>
						<script>
								window.location.href = '?action=ver_facturas&last=<?=$last_id?>';
						</script>
				<?php
					}
			}
		}
		@mysqli_free_result($selectx);
}
?>
				<div id="facturaprint" style="width:90%; margin:0 auto;">
						<a href="?action=ver_reparacion&aid=<?=$aid?>" class="print">REGRESAR</a>
				</div>

						<div id="facturaprint" style="border:1px solid; width:90%; margin:0 auto; background:#fff; padding:20px 12px;">
							<p style="max-width:60%; float:left;">
								<img src="img/logo.jpg" style="width:300px;" />
									<br/>
								<span style="font-size:30px; font-weight:bold;">ORDEMAT SOLUCIONES SL</span>
									<br/>
								<span>
								Nadine Gordimer 1 <br/>
								b86744042 <br/>
								San Fernando de Henares Madrid 28830 <br/>
								P:ivan@repararelpc.es <br/>
								F:911558505
								</span>
							</p>
							<h2 style="text-align:right;">Factura No. 0000</h2>

							<div style="clear:both;"></div>

								<br/><br/>
							<p><strong>Bill To:</strong></p>
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
<!-- EL FORM -->
							<form method="post" action="">
								<p><strong>Detalles de la reparación:</strong></p>
								<textarea style="padding:10px 10px; color:#000; width:100%; box-sizing:border-box; font-size:17px; min-height:80px; border:1px solid #ccc;" name="condiciones" placeholder="Escriba los detalles de la reparación..." required></textarea>

								<br/>
								<button style="height:58px; line-height:58px; padding:0 26px; font-size:16px; cursor:pointer; background:#2288ff; border-bottom:6px solid #2070cc; color:#fff;">LISTO, CREAR FACTURA</button>
							</form>
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