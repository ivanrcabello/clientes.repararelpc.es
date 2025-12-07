<?php
if(   isset($_GET['fid']) && $_GET['fid']>0   ) {
	$fid = $_GET['fid'];

	/* Verificamos que el articulo EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM facturas WHERE FID=".$fid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM facturas WHERE UID = ".$_SESSION['ID']." AND FID=".$fid." LIMIT 1";
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

	/* Extraemos datos del cliente */
	$c = "SELECT * FROM clientes WHERE CID=".$row['CID']." LIMIT 1";
	$q = mysqli_query($db, $c);
	if(   mysqli_num_rows($q)>0   ) {
			$cliente = mysqli_fetch_array($q, MYSQLI_ASSOC);
	}
	@mysqli_free_result($q);


	$p = $row['total'];
	$precio100 = number_format(   ($p/121)*100, 2   );
	$precio21 = number_format($p - $precio100, 2);

	$f = explode(' ', $row['fecha']);
	$fecha = $f[0];


$bar = '
<div style="width:90%; margin:15px auto; border:1px solid black; background:white; text-align:left; padding:15px; box-sizing:border-box;">
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
							<h2 style="text-align:right;">Factura No. '.$fid.'</h2>

							<div style="clear:both;"></div>

								<br/><br/>
							<p><strong>Bill To:</strong></p>
							<p>
								<strong>Cliente:</strong> '.utf8_decode($row['nombre']).' <strong>NIF/DNI:</strong> '.$row['nif'].'
								<span style="float:right;"><strong>Fecha de Facturación:</strong> '.$fecha.'</span>
							</p>
							<p>
								<strong>Dirección:</strong> '.utf8_decode($row['direccion']).'
							</p>
							<p>
								<strong>Telefono:</strong> '.$row['telefono'].'
								<span style="float:right;"><strong>Cantidad a Pagar:</strong> '.number_format($row['total'],2).'&euro;</span>
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
										<td>Reparación articulo ('.utf8_decode($row['articulo']).')</td>
										<td>1.00</td>
										<td>'.$precio100.' &euro;</td>
										<td style="text-align:right;">'.$precio100.' &euro;</td>
									</tr>
							</table>

								<br/>

							<table style="float:right; text-align:right;">
									<tr><td>Subtotal:</td><td style="padding-left:15px;">'.$precio100.' &euro;</td></tr>
									<tr><td>IVA 21.00%</td><td style="padding-left:15px;">'.$precio21.' &euro;</td></tr>
									<tr><td>Total:</td><td style="padding-left:15px; font-weight:bold;">'.$row['total'].' &euro;</td></tr>
							</table>

								<div style="clear:both";></div>

							<p><strong>Condiciones:</strong></p>
							<p>'.utf8_decode($row['condiciones']).'</p>
</div>
';

/* SE PULSO ENVIAR? **************************************************************************************** */
if(   isset($_POST['envio'])   ) {
	require 'PHPMailer/PHPMailerAutoload.php';
	
	$asunto = utf8_decode($_POST['asunto']);
	$correo = $_POST['correo'];
	
	$mail = new PHPMailer;
	$mail->setFrom('info@repararelpc.es', 'RepararelPC.es'); /* De */
	$mail->addAddress( $correo ); /* Para */
	
	$mail->Subject = $asunto;
	//$mail->IsHTML(true);
	$mail->msgHTML( $bar );

	if (!$mail->send()) {
		?>
			<script> window.location.href = '?action=sendfactura&fid=<?=$fid?>&error=true'; </script>
		<?php
	} else {
		?>
			<script> window.location.href = '?action=sendfactura&fid=<?=$fid?>&enviado=true'; </script>
		<?php
	}
	
}
?>





<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Enviar Factura: ( #<?=$fid?> )</p>

	<div style="width:90%; margin:0 auto;">
		<form method="post" action="">
			<a href="?action=ver_factura&id=<?=$fid?>" class="print">REGRESAR</a>
				<br/>
			<button name="envio" class="send send2" style="cursor:pointer;">ENVIAR FACTURA POR CORREO ELECTRONICO</button>
			
			<?php if(   isset($_GET['enviado'])   ) { ?>
					<p style="background:#0a0; color:white; padding:8px; margin-top:3px; border-radius:4px; text-align:center; font-size:17px;">
						Correo enviado exitosamente!
					</p>
			<?php } ?>
			<?php if(   isset($_GET['error'])   ) { ?>
					<p style="background:#a00; color:white; padding:8px; margin-top:3px; border-radius:4px; text-align:center; font-size:17px;">
						Ocurrio un error al enviar el correo!
					</p>
			<?php } ?>
			
			<p style="margin-top:15px;">
			ASUNTO:<br/>
			<input type="text" placeholder="Asunto del Correo" name="asunto" value="Factura | RepararElPC.es" 
				style="width:100%; border-radius:3px; height:42px; line-height:42px; border-radius:3px; font-size:18px;
					text-indent:3px; color:black; border-bottom:6px solid #ccc; border-top:1px solid #ccc;"/>
			</p>
			<p style="margin-top:1px;">
			ENVIAR A:<br/>
			<input type="text" placeholder="Correo Destino" name="correo" value="<?=$cliente['email']?>" 
				style="width:100%; border-radius:3px; height:42px; line-height:42px; border-radius:3px; font-size:18px;
					text-indent:3px; color:black; border-bottom:6px solid #ccc; border-top:1px solid #ccc;"/>
			</p>
		</form>

	</div>
</div>

<?php
echo $bar;
}

?>