<?php
if(   isset($_GET['pid']) && $_GET['pid']>0   ) {
	$pid = $_GET['pid'];

	/* Verificamos que el articulo EXISTE y sea de este usuario */
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

	/* Extraemos datos del cliente */
	$c = "SELECT * FROM clientes WHERE CID=".$row['CID']." LIMIT 1";
	$q = mysqli_query($db, $c);
	if(   mysqli_num_rows($q)>0   ) {
			$cliente = mysqli_fetch_array($q, MYSQLI_ASSOC);
	}
	@mysqli_free_result($q);

	/* fecha */
	$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	$f = explode(' ', $row['fecha']);
		$f1 = explode('-', $f[0]);
		$h1 = explode(':', $f[1]);
	$fechae = $f1[2].' '.$meses[ ($f1[1]-1) ].' '.$f1[0].', '.$h1[0].':'.$h1[1].' Hrs';


$bar = '
<!--<link rel="stylesheet" id="style-css" href="'.$web.'style.css" type="text/css" />-->
<div id="areaprint" class="sendto">

	<div style="text-align:center;">
		<img src="'.$web.'img/repararelpc.png" style="width:100%;"/>
		<p>
			Calle marques de Berna 18 Nave 2, 28042 Madrid - 91 155 85 05 | 690 041 105
			<br/>
			Ordemat Soluciones SL B-86744042   ivan@repararelpc.es
		</p>
		
		<p class="barra">DATOS DEL CLIENTE</p>
		
			<div style="margin:10px 0;"></div>

		<div style="text-align:center; font-size:0;">
			
			<div class="c28">Fecha de Entrada:</div><div class="c70">'.$fechae.'</div>
			
				<div style="margin:10px 0;"></div>
			
			<div class="c28">Presupuesto Inicial:</div><div class="c70">&euro; '.$row['presupuesto'].'</div>
			
				<div style="margin:10px 0;"></div>
				
			<div class="c28">NOMBRE:</div><div class="c70">'.$cliente['name'].'</div>
			
			<div class="c28">Dirección:</div><div class="c70">'.$cliente['address'].'</div>
			
			<div class="c28">Telefono:</div><div class="c70">'.$cliente['phone'].'</div>
			
			<div class="c28">Correo:</div><div class="c70">'.$cliente['email'].'</div>
		</div>
		
			<div style="margin:10px 0;"></div>
		
		<p class="barra">DESCRIPCIÓN DEL PRESUPUESTO:</p><div class="c90">'.$row['notas'].'</div>
				
			<div style="margin:20px 0;"></div>

	</div>

</div>
';



$bar2 = '
<div style="color:black; border:1px solid #111;">
	<div style="text-align:center;">
		<img src="'.$web.'img/repararelpc.png" style="width:100%;"/>
		<p style="font-weight:bold;">
			Calle marques de Berna 18 Nave 2, 28042 Madrid - 91 155 85 05 | 690 041 105
			<br/>
			Ordemat Soluciones SL B-86744042   ivan@repararelpc.es
		</p>
		
		<p style="border-top:1px solid black; padding:8px 0; font-weight:bold;">DATOS DEL CLIENTE</p>
		
			<div style="margin:10px 0;"></div>

		<div style="text-align:center; font-size:0;">
			<div style="display:inline-block; width:28%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				Fecha:
			</div>
			<div style="display:inline-block; width:70%; margin-top:2px; border:1px solid black; border-left:0; font-size:18px; padding:8px 0; text-indent:5px;">
				'.$fechae.'
			</div>
			
				<div style="margin:10px 0;"></div>
			
			<div style="display:inline-block; width:28%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				Presupuesto:
			</div>
			<div style="display:inline-block; width:70%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				&euro; '.$row['presupuesto'].'
			</div>
			
				<div style="margin:10px 0;"> &nbsp; </div>
				
			<div style="display:inline-block; width:28%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				Nombre:
			</div>
			<div style="display:inline-block; width:70%; margin-top:2px; border:1px solid black; border-left:0; font-size:18px; padding:8px 0; text-indent:5px;">
				'.$cliente['name'].'
			</div>
			
			<div style="display:inline-block; width:28%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				Dirección:
			</div>
			<div style="display:inline-block; width:70%; margin-top:2px; border:1px solid black; border-left:0; font-size:18px; padding:8px 0; text-indent:5px;">
				'.$cliente['address'].'
			</div>
			
			<div style="display:inline-block; width:28%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				Telefono:
			</div>
			<div style="display:inline-block; width:70%; margin-top:2px; border:1px solid black; border-left:0; font-size:18px; padding:8px 0; text-indent:5px;">
				'.$cliente['phone'].'
			</div>
			
			<div style="display:inline-block; width:28%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				Correo:
			</div>
			<div style="display:inline-block; width:70%; margin-top:2px; border:1px solid black; border-left:0; font-size:18px; padding:8px 0; text-indent:5px;">
				'.$cliente['email'].'
			</div>
		</div>
		
			<div style="margin:10px 0;"></div>
		
		<p style="border-top:1px solid black; padding:8px 0; font-weight:bold;">
			DESCRIPCIÓN DEL PRESUPUESTO:
		</p>
		<div style="display:inline-block; width:96%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px;">
			'.$row['notas'].'
		</div>

			<div style="margin:20px 0;"></div>

	</div>

</div>
';

/* SE PULSO ENVIAR? **************************************************************************************** */
if(   isset($_POST['envio'])   ) {
/*
	require 'PHPMailer/PHPMailerAutoload.php';
	
	$asunto = $_POST['asunto'];
	$correo = $_POST['correo'];
	
	$mail = new PHPMailer;
	$mail->setFrom('ivan@repararelpc.es', 'RepararelPC.es'); // De
	$mail->addAddress( $correo ); // Para
	
	$mail->Subject = $asunto;
	//$mail->IsHTML(true);
	$mail->msgHTML( $bar2 );

	if (!$mail->send()) {
		?>
			<script> window.location.href = '?action=sendpresupuesto&pid=<?=$pid?>&error=true'; </script>
		<?php
	} else {
		?>
			<script> window.location.href = '?action=sendpresupuesto&pid=<?=$pid?>&enviado=true'; </script>
		<?php
	}
*/

require 'fPDF/fpdf.php';
	
	$pdf = new FPDF();
$pdf->AddPage();
			
$pdf->Image('img/logo.png',10,10,90,38);

$pdf->SetFont('Arial','B',20);
$pdf->Cell(190,10,'Presupuesto',0,0,R);	


$pdf->Ln(8);
$pdf->SetXY(10,49);
$pdf->Cell(190,10,'REPARELPC.ES',0,0,L);

$pdf->Ln(8);
$pdf->SetFont('Arial','',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', $config['facturacionnombres']),0,0,L);


$pdf->Ln();
$pdf->Cell(190,5,$config['facturacioncif'],0,0,L);


$pdf->Ln();
$pdf->Cell(190,5,$config['facturaciondireccion'],0,0,L);

$pdf->Ln();
$pdf->Cell(190,5,$config['facturacionemail'] ,0,0,L);


$pdf->Ln();
$pdf->Cell(190,5, $config['facturaciontelefono'],0,0,L);


		/* fecha y presupuesto */
$pdf->Ln(12);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,"Fecha:",TRL,0,L);
$pdf->Cell(110,5,'Presupuesto:',TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,$fechae,BRL,0,L);
$pdf->Cell(110,5,$row['presupuesto'].' '.chr(128),BRL,0,L);

		/* Cliente direccion */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,"Cliente:",TRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'Dirección:'),TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', $cliente['name']),RL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', $cliente['address']),RL,0,L);
		
		/* Correo telefono */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', 'Teléfono:'),TRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'Correo Electrónico:'),TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', $cliente['phone']),BRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', $cliente['email']),BRL,0,L);

		/* descripcion */
$pdf->Ln(12);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', "Descripción del presupuesto:"),TLR,0,C);
$pdf->SetFont('Arial','',10);
$pdf->Ln();
$pdf->MultiCell(190,5,iconv('UTF-8', 'windows-1252', $row['notas']),BLR,C,0);

$pdf->Ln(20);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Firma Conforme'),0,0,R);


$pdfdoc = $pdf->Output('', 'S');
//$pdf->Output('exa1.pdf', 'I');


	require 'PHPMailer/PHPMailerAutoload.php';
	
	$asunto = $_POST['asunto'];
	$correo = $_POST['correo'];
	
	$mail = new PHPMailer;
	$mail->setFrom('ivan@repararelpc.es', 'RepararelPC.es'); /* De */
	$mail->addAddress( $correo ); /* Para */
	
	$mail->Subject = iconv('UTF-8', 'windows-1252', $asunto );
	//$mail->IsHTML(true);
	$mail->msgHTML( iconv('UTF-8', 'windows-1252', 'Presupuesto adjunto en formato PDF') );
	//$mail->msgHTML( $bar );
	//$mail->addAttachment( 'img/logo.jpg' );
	$mail->addStringAttachment($pdfdoc, 'my-doc.pdf');


if (!$mail->send()) {
	?>
		<script> window.location.href = '?action=sendpresupuesto&pid=<?=$pid?>&error=true'; </script>
	<?php
	echo "ERROR";
	exit;
} else {
	?>
		<script> window.location.href = '?action=sendpresupuesto&pid=<?=$pid?>&enviado=true'; </script>
	<?php
	echo "ENVIADO";
	exit;
}


}
?>





<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Enviar Presupuesto: ( #<?=$pid?> )</p>

	<div style="width:90%; margin:0 auto;">
		<form method="post" action="">
			<a href="?action=ver_presupuesto&id=<?=$pid?>" class="print">REGRESAR</a>
				<br/>
			<button name="envio" class="send send2" style="cursor:pointer;">ENVIAR FICHA POR CORREO ELECTRONICO</button>
			
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
			<input type="text" placeholder="Asunto del Correo" name="asunto" value="Presupuesto de Reparación | RepararElPC.es" 
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