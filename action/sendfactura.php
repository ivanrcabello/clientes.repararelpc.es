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


	$p = number_format($row['total'], 2);
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
							<h2 style="text-align:right;">Factura No. '.$row['FOLIO'].'</h2>

							<div style="clear:both;"></div>

								<br/><br/>
							<p><strong>Bill To:</strong></p>
							<p>
								<strong>Cliente:</strong> '.$row['nombre'].' <strong>NIF/DNI:</strong> '.$row['nif'].'
								<span style="float:right;"><strong>Fecha de Facturación:</strong> '.$fecha.'</span>
							</p>
							<p>
								<strong>Dirección:</strong> '.$row['direccion'].'
							</p>
							<p>
								<strong>Telefono:</strong> '.$row['telefono'].'
								<span style="float:right;"><strong>Cantidad a Pagar:</strong> '.$p.'&euro;</span>
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
										<td>Reparación articulo ('.$row['articulo'].')</td>
										<td>1.00</td>
										<td>'.$precio100.' &euro;</td>
										<td style="text-align:right;">'.$precio100.' &euro;</td>
									</tr>
							</table>

								<br/>

							<table style="float:right; text-align:right;">
									<tr><td>Subtotal:</td><td style="padding-left:15px;">'.$precio100.' &euro;</td></tr>
									<tr><td>IVA 21.00%</td><td style="padding-left:15px;">'.$precio21.' &euro;</td></tr>
									<tr><td>Total:</td><td style="padding-left:15px; font-weight:bold;">'.$p.' &euro;</td></tr>
							</table>

								<div style="clear:both";></div>

							<p><strong>Detalles de la reparación:</strong></p>
							<p>'.$row['condiciones'].'</p>
							
							<div style="margin-top:20px; font-size:13px; color:#555; text-align:center;">
								<p>'.$config['condiciones'].'</p>
							</div>
</div>
';

/* SE PULSO ENVIAR? **************************************************************************************** */
if(   isset($_POST['envio'])   ) {
	require 'fPDF/fpdf.php';
	
	$pdf = new FPDF();
$pdf->AddPage();
			// file,              x, y, w, h
$pdf->Image('img/logo.png',10,10,90,38);
			/*	METODO "CELL"
				W en mm, la hoja mide 210 por 280
				H
				TEXTO
				BORDER		 0|1 LTRB			0 es No, 1 es si, o los lados (Left, Top, Right, Bottom)
				LN 0->hacia derecha, 1-> comienzo en la sig linea, 2->debajo
				ALIGN		LCR		left, center, right
				FILL, true o false (x defecto false)
				link = NOSE QUE PEDO XD
			*/
	$pdf->SetFont('Arial','B',20);
$pdf->Cell(190,10,'Factura No. '.$row['FOLIO'],0,0,R);	$pdf->Ln(8);
	$pdf->SetXY(10,49);
$pdf->Cell(190,10,'REPARARELPC.ES',0,0,L);	$pdf->Ln(8);
	
	$pdf->SetFont('Arial','',11);
	$pdf->Ln(8);
$pdf->SetXY(10,49);


$pdf->Ln();
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', $config['facturacionnombres']),0,0,L);	$pdf->Ln();
$pdf->Cell(190,5,$config['facturacioncif'],0,0,L);	$pdf->Ln();
$pdf->Cell(190,5,$config['facturaciondireccion'],0,0,L);	$pdf->Ln();
$pdf->Cell(190,5,$config['facturacionemail'],0,0,L);	$pdf->Ln();
$pdf->Cell(190,5,$config['facturaciontelefono'],0,0,L);

$pdf->Ln(12);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,'Bill To:',0,0,L);
	$pdf->Ln();
$pdf->Cell(25,5,'Cliente:',0,0,L);
$pdf->SetFont('Arial','',11);
$pdf->Cell(75,5, $row['nombre'],0,0,L);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(50,5,'DNI/NIF:',0,0,R);
$pdf->SetFont('Arial','',11);
$pdf->Cell(40,5, $row['nif'] ,0,0,R);
	$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(25,5,iconv('UTF-8', 'windows-1252', 'Dirección:'),0,0,L);
$pdf->SetFont('Arial','',11);
$pdf->Cell(75,5,$row['direccion'],0,0,L);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(50,5,iconv('UTF-8', 'windows-1252', 'Fecha de Facturación:'),0,0,R);
$pdf->SetFont('Arial','',11);
$pdf->Cell(40,5, $fecha ,0,0,R);
	$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(25,5,iconv('UTF-8', 'windows-1252', 'Teléfono:'),0,0,L);
$pdf->SetFont('Arial','',11);
$pdf->Cell(75,5, $row['telefono'] ,0,0,L);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(50,5,'Cantidad a Pagar:',0,0,R);
$pdf->SetFont('Arial','',11);
$pdf->Cell(40,5, $p.' '.chr(128),0,0,R);
	
	$pdf->Ln(10);
$pdf->Cell(190,5,'',B);
	$pdf->Ln(6);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(30,5,'Elemento',0,0,L);
$pdf->Cell(90,5,iconv('UTF-8', 'windows-1252', 'Descripción'),0,0,L);
$pdf->Cell(22,5,'Cantidad',0,0,L);
$pdf->Cell(24,5,'Precio',0,0,L);
$pdf->Cell(24,5,'Total',0,0,R);
	$pdf->Ln(1);
$pdf->Cell(190,5,'',B);
	$pdf->Ln(6);

$pdf->SetFont('Arial','',11);
$pdf->Cell(30,5,'1',0,0,L);
//$pdf->Cell(90,5,utf8_decode( 'Reparación articulo ('.$row['articulo'].')' ),0,0,L);
$pdf->Multicell(90,5,iconv('UTF-8', 'windows-1252', 'Reparación articulo ('.$row['articulo'].')') ); 
	
	$pdf->SetXY(131,127);
$pdf->Cell(22,5,'1.00',0,0,L);
$pdf->Cell(24,5,$precio100.' '.chr(128),0,0,L);
$pdf->Cell(24,5,$precio100.' '.chr(128),0,0,R);
	$pdf->Ln(10);
	
$pdf->Cell(160,5,'Subtotal:',0,0,R);
$pdf->Cell(30,5,$precio100.' '.chr(128),0,0,R);
	$pdf->Ln();
$pdf->Cell(160,5,'IVA 21.00%',0,0,R);
$pdf->Cell(30,5,$precio21.' '.chr(128),0,0,R);
	$pdf->Ln();
$pdf->Cell(160,5,'Total:',0,0,R);
	$pdf->SetFont('Arial','B',11);
$pdf->Cell(30,5,$p.' '.chr(128),0,0,R);

	$pdf->Ln(12);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Detalles de la reparación:'),0,0,L);

	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
$breaks = array("<br />","<br>","<br/>"); 
$condiciones = str_ireplace($breaks, "\n", $row['condiciones']);
//$pdf->Cell(190,5, utf8_decode($condiciones),0,0,L);
$pdf->Multicell(190,4,iconv('UTF-8', 'windows-1252', $condiciones)); 

	$pdf->Ln(12);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(120,120,120);
	$breaks = array("<br />","<br>","<br/>"); 
$condiciones2 = str_ireplace($breaks, "\n", $config['condiciones']);
$pdf->Multicell(190,4,iconv('UTF-8', 'windows-1252', $condiciones2),0,C,0); 

//SetMargins(float left, float top [, float right])
//SetLeftMargin(float) // Top, Right


// encode data (puts attachment in proper format)
$pdfdoc = $pdf->Output('', 'S');

//$attachment = chunk_split(base64_encode($pdfdoc));

	require 'PHPMailer/PHPMailerAutoload.php';
	
	$asunto = $_POST['asunto'];
	$correo = $_POST['correo'];
	
	$mail = new PHPMailer;
	$mail->setFrom('ivan@repararelpc.es', 'RepararelPC.es'); /* De */
	$mail->addAddress( $correo ); /* Para */
	
	$mail->Subject = iconv('UTF-8', 'windows-1252', $asunto );
	//$mail->IsHTML(true);
	$mail->msgHTML( 'Factura adjunta en formato PDF.' );
	//$mail->msgHTML( $bar );
	//$mail->addAttachment( 'img/logo.jpg' );
	$mail->addStringAttachment($pdfdoc, 'my-doc.pdf');


	if (!$mail->send()) {
		?>
			<script> window.location.href = '?action=sendfactura&fid=<?=$fid?>&error=true'; </script>
		<?php
		echo "ERROR";
		exit;
	} else {
		?>
			<script> window.location.href = '?action=sendfactura&fid=<?=$fid?>&enviado=true'; </script>
		<?php
		echo "ENVIADO";
		exit;
	}
	
} /* end if isset $post envio */
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
//echo $bar;
}

?>