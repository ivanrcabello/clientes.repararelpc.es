<?php
if(   isset($_GET['aid']) && $_GET['aid']>0   ) {
	$aid = $_GET['aid'];

	/* Verificamos que el articulo EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM articulos WHERE AID=".$aid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM articulos WHERE UID = ".$_SESSION['ID']." AND AID=".$aid." LIMIT 1";
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
	
	
	$mes = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');

	/* Extraemos datos del cliente */
	$c = "SELECT * FROM clientes WHERE CID=".$row['CID']." LIMIT 1";
	$q = mysqli_query($db, $c);
	if(   mysqli_num_rows($q)>0   ) {
			$cliente = mysqli_fetch_array($q, MYSQLI_ASSOC);
	}
	@mysqli_free_result($q);



	$f = explode(" ",$row['fecha_entrada']);
	$f = explode("-",$f[0]);
	
	if(   ($f[0]+0)>0   ) {
			$fechae =  $f[2]." ".$mes[   ($f[1]-1)   ]." ".$f[0];
	} else {
			$fechae =  "N/A";
	}

	$f = explode(" ",$row['fecha_salida']);
	$f = explode("-",$f[0]);
	
	if(   ($f[0]+0)>0   ) {
			$fechas =  $f[2]." ".$mes[   ($f[1]-1)   ]." ".$f[0];
	} else {
			$fechas =  "N/A";
	}


$funda = ( $row['funda']==1 )? 'X' : '&nbsp;' ;
$cargador = ( $row['cargador']==1 )? 'X' : '&nbsp;' ;
$bateria = ( $row['bateria']==1 )? 'X' : '&nbsp;' ;

$bar = '
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
			<div class="c20">Fecha de Entrada:</div>
			<div class="c29">'.$fechae.'</div>
			<div class="c20">Fecha de Salida:</div>
			<div class="c29">'.$fechas.'</div>
			
			<div class="c20">Presupuesto:</div>
			<div class="c29">&euro; '.$row['presupuesto'].'</div>
			<div class="c20">Precio Final:</div>
			<div class="c29">&euro; '.$row['precio'].'</div>

			<div class="c20">ID Cliente:</div>
			<div class="c29">'.$cliente['id_checker'].'</div>
			<div class="c20">No. de Folio:</div>
			<div class="c29">'.$row['folio'].'</div>
			
				<div style="margin:10px 0;"></div>
				
			<div class="c28">Nombre:</div>
			<div class="c70">'.$cliente['name'].'</div>
			
			<div class="c28">Dirección:</div>
			<div class="c70">'.$cliente['address'].'</div>
			
			<div class="c20">Telefono:</div>
			<div class="c28">'.$cliente['phone'].'</div>
			
			<div class="c20">Correo:</div>
			<div class="c28">'.$cliente['email'].'</div>
			
				<div style="margin:10px 0;"></div>
				
			<div class="c20">Funda:</div>
			<div class="c10">'.$funda.'</div>
			<div class="c20">Cargador:</div>
			<div class="c10">'.$cargador.'</div>
			<div class="c20">Bateria:</div>
			<div class="c10">'.$bateria.'</div>
			<div class="c28">Otro Accesorio:</div>
			<div class="c70">'.$row['otro'].'</div>
		</div>
		
			<div style="margin:10px 0;"></div>
		
		<p class="barra">EVALUACION DEL PROBLEMA</p>
		<div class="c90">
			'.$row['notas'].'
		</div>
			<div style="margin:20px 0;"></div>
		<p class="barra">RESOLUCION DEL PROBLEMA</p>
		<div class="c90">
			'.$row['operacion'].'
		</div>

		<p>Para consultar el estado de tu articulo en reparación, visita: <a href="http://app.goseo.es/"><u>http://app.goseo.es/</u></a></p>
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
			<div style="display:inline-block; width:29%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				Fecha de Entrada:
			</div>
			<div style="display:inline-block; width:20%; margin-top:2px; border:1px solid black; border-left:0; font-size:18px; padding:8px 0; text-indent:5px;">
				'.$fechae.'
			</div>
			<div style="display:inline-block; width:29%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				Fecha de Salida:
			</div>
			<div style="display:inline-block; width:20%; margin-top:2px; border:1px solid black; border-left:0; font-size:18px; padding:8px 0; text-indent:5px;">
				'.$fechas.'
			</div>
			
			<div style="display:inline-block; width:29%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				Presupuesto Inicial:
			</div>
			<div style="display:inline-block; width:20%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				&euro; '.$row['presupuesto'].'
			</div>
			<div style="display:inline-block; width:29%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				Precio Final:
			</div>
			<div style="display:inline-block; width:20%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				&euro; '.$row['precio'].'
			</div>

			<div style="display:inline-block; width:29%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				ID Cliente:
			</div>
			<div style="display:inline-block; width:20%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				&euro; '.$cliente['id_checker'].'
			</div>
			<div style="display:inline-block; width:29%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				No. Folio:
			</div>
			<div style="display:inline-block; width:20%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				'.$row['folio'].'
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
			
				<div style="margin:10px 0;"></div>
				
			<div style="display:inline-block; width:20%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				Funda:
			</div>
			<div style="display:inline-block; width:10%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				'.$funda.'
			</div>
			<div style="display:inline-block; width:20%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				Cargador:
			</div>
			<div style="display:inline-block; width:10%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				'.$cargador.'
			</div>
			<div style="display:inline-block; width:20%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				Bateria:
			</div>
			<div style="display:inline-block; width:10%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				'.$bateria.'
			</div>
			<div style="display:inline-block; width:28%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px 0; text-indent:5px;">
				Otro Accesorio:
			</div>
			<div style="display:inline-block; width:70%; margin-top:2px; border:1px solid black; border-left:0; font-size:18px; padding:8px 0; text-indent:5px;">
				'.$row['otro'].'
			</div>
		</div>
		
			<div style="margin:10px 0;"></div>
		
		<p style="border-top:1px solid black; padding:8px 0; font-weight:bold;">
			EVALUACION DEL PROBLEMA
		</p>
		<div style="display:inline-block; width:96%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px;">
			'.$row['notas'].'
		</div>
			
			<div style="margin:20px 0;"></div>
			
		<p style="border-top:1px solid black; padding:8px 0; font-weight:bold;">
			RESOLUCION DEL PROBLEMA
		</p>
		<div style="display:inline-block; width:96%; margin-top:2px; border:1px solid black; font-size:18px; padding:8px;">
			'.$row['operacion'].'
		</div>

		<p>Para consultar el estado de tu articulo en reparación, visita: <a href="http://app.goseo.es/"><u>http://app.goseo.es/</u></a></p>

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
			<script> window.location.href = '?action=send&aid=<?=$aid?>&error=true'; </script>
		<?php
	} else {
		?>
			<script> window.location.href = '?action=send&aid=<?=$aid?>&enviado=true'; </script>
		<?php
	}
*/	

function orden($row){
    $orden = "";
    foreach($row as $key => $value) {
        $orden.= $key. ": " . $value . "\n"; 
    }
    return $orden;
}

$opts = array(
  'http'=>array(
    'method'=>"GET"
  )
);

$context = stream_context_create($opts);

$a = "https://chart.googleapis.com/chart?chs=230x230&cht=qr&chl=Repararelpc.es\n" . "Folio".$row['folio'];
file_put_contents("/home/reparare/clientes.repararelpc.es/action/qrs/". $row['folio']. ".jpg", file_get_contents($a, false, $context));


require 'fPDF/fpdf.php';
	
	$pdf = new FPDF();
$pdf->AddPage();
			
$pdf->Image('img/logo.png',10,10,90,38);

$pdf->SetFont('Arial','B',20);
$pdf->Cell(190,10,'Orden de',0,0,R);	
$pdf->Ln();
$pdf->Cell(190,10,iconv('UTF-8', 'windows-1252', 'Reparación'),0,0,R);	
$pdf->Ln();
$pdf->SetFont('Arial','',16);
$pdf->Cell(190,10,'Folio No. '.$row['folio'],0,0,R);	

$pdf->Ln(8);
$pdf->SetXY(10,49);
$pdf->Cell(190,10,'REPARARELPC.ES',0,0,L);

$pdf->Ln(8);
$pdf->SetFont('Arial','',11);
$pdf->Cell(190,5, iconv('UTF-8', 'windows-1252', $config['facturacionnombres']),0,0,L);

$pdf->Ln();
$pdf->Cell(190,5,$config['facturacioncif'],0,0,L);

$pdf->Ln();
$pdf->Cell(190,5,$config['facturaciondireccion'],0,0,L);

$pdf->Ln();
$pdf->Cell(190,5,$config['facturacionemail'],0,0,L);

$pdf->Ln();
$pdf->Cell(190,5,$config['facturaciontelefono'],0,0,L);

		/* Fechas */
$pdf->Ln(12);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(90,5,"Fecha de entrada:",0,0,L);
$pdf->Cell(100,5,"Fecha de Salida:",0,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(90,5,$fechae,0,0,L);
$pdf->Cell(100,5,$fechas,0,0,L);

		/* presupuesto precio */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,"Presupuesto:",TRL,0,L);
$pdf->Cell(110,5,'Precio Final:',TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,number_format($row['presupuesto'],2,'.',',').' '.chr(128),BRL,0,L);
$pdf->Cell(110,5,number_format($row['precio'],2,'.',',').' '.chr(128),BRL,0,L);

		/* Cliente */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,"Cliente: (ID: ".$cliente['id_checker'].")",TRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'Dirección:'),TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', $cliente['name']),BRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', $cliente['address']),BRL,0,L);
		
		/* Correo telefono */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', 'Teléfono:'),TRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'Correo Electrónico:'),TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', $cliente['phone']),BRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', $cliente['email']),BRL,0,L);

		/* Articulo */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,"Articulo:",LR,0,L);
$pdf->SetFont('Arial','',10);
$pdf->Ln();
$pdf->MultiCell(190,5,iconv('UTF-8', 'windows-1252', $row['articulo']),BLR,L,0);

		/* Modelo Serie */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,5,"Marca:",LR,0,C);
$pdf->Cell(64,5,"Modelo:",LR,0,C);
$pdf->Cell(63,5,"Serie:",LR,0,C);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(63,5,iconv('UTF-8', 'windows-1252', $row['marca']),BLR,0,C);
$pdf->Cell(64,5,iconv('UTF-8', 'windows-1252', $row['modelo']),BLR,0,C);
$pdf->Cell(63,5,iconv('UTF-8', 'windows-1252', $row['serie']),BLR,0,C);

		/* Accesorios */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(50,8,'Accesorios',BLR,0,C);
$pdf->SetFont('Arial','',10);
$acc = array();
if(   $row['bateria']==1   ) { $acc[] = 'Batería'; }
if(   $row['cargador']==1   ) { $acc[] = 'Cargador'; }
if(   $row['funda']==1   ) { $acc[] = 'Funda'; }
if(   $row['otro']!='N/A'   ) { $acc[] = 'Otros ('.$row['otro'].')'; }
$acc2 = implode(', ', $acc);

$pdf->Cell(140,8,iconv('UTF-8', 'windows-1252', $acc2),BLR,0,L);

	/* Evaluacion */
$pdf->Ln(13);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Evaluación'),0,0,C);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
	$breaks = array("<br />","<br>","<br/>"); 
$notas = str_ireplace($breaks, "\n", $row['notas']);
$pdf->Multicell(190,5,iconv('UTF-8', 'windows-1252', $notas),1,C,0); 

	/* Solucion */
$pdf->Ln(4);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Resolución del problema'),0,0,C);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
	$breaks = array("<br />","<br>","<br/>"); 
$operacion = str_ireplace($breaks, "\n", $row['operacion']);
$pdf->Multicell(190,5,iconv('UTF-8', 'windows-1252', $operacion),1,C,0); 

	/* Footer */
$pdf->Ln(4);
$pdf->SetFont('Arial','',8);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Para consultar el estado de tu arculo en reparación, visita: https://clientes.repararelpc.es/checker.php'),0,0,C);

$pdf->Ln(20);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Firma Conforme'),0,0,R);

//$pdf->Image('img/logo.png',50,220,90,38);
//$pdf->Image("<img src='/qrs/". $row['folio'] .".jpg'/>",50,220,90,38);

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
	$mail->msgHTML( iconv('UTF-8', 'windows-1252', 'Orden de reparación adjunta en formato PDF') );
	//$mail->msgHTML( $bar );
	//$mail->addAttachment( 'img/logo.jpg' );
	$mail->addStringAttachment($pdfdoc, 'my-doc.pdf');


if (!$mail->send()) {
	?>
		<script> window.location.href = '?action=send&aid=<?=$aid?>&error=true'; </script>
	<?php
	echo "ERROR";
	exit;
} else {
	?>
		<script> window.location.href = '?action=send&aid=<?=$aid?>&enviado=true'; </script>
	<?php
	echo "ENVIADO";
	exit;
}
	
}
?>





<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Enviar Orden de Reparacion: <?=$row['articulo']?> (<?=$aid?>)</p>

	<div style="width:90%; margin:0 auto;">
		<form method="post" action="">
			<a href="?action=ver_reparacion&aid=<?=$aid?>" class="print">REGRESAR</a>
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
			<input type="text" placeholder="Asunto del Correo" name="asunto" value="Orden de Reparación | RepararElPC.es" 
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