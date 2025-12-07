<?php session_start();
$return['success'] = 0;

if(   isset($_SESSION['ID']) && isset($_POST['aid'])   ) {
	require('../config.php');
	
	$aid = $_POST['aid'];
	$status_singular = $_POST['status'];
	
	/* Verificamos que el articulo EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM articulos WHERE AID=".$aid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM articulos WHERE UID = ".$_SESSION['ID']." AND AID=".$aid." LIMIT 1";
	}
	$query = mysqli_query($db, $consulta);
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	} 
	@mysqli_free_result($query);
	
	/* Extraemos datos del cliente */
	$c = "SELECT * FROM clientes WHERE CID=".$row['CID']." LIMIT 1";
	$q = mysqli_query($db, $c);
	if(   mysqli_num_rows($q)>0   ) {
			$cliente = mysqli_fetch_array($q, MYSQLI_ASSOC);
	}
	@mysqli_free_result($q);
	
	// Enviar Email con PDF y link de checar.
	
	require '../fPDF/fpdf.php';
	
	$pdf = new FPDF();
$pdf->AddPage();
			
$pdf->Image('../img/logo.png',10,10,90,38);

$pdf->SetFont('Arial','B',20);
$pdf->Cell(190,10,'Orden de',0,0,R);	
$pdf->Ln();
$pdf->Cell(190,10,iconv('UTF-8', 'windows-1252', 'Reparaci車n'),0,0,R);	
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

		/* Cliente */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,"Cliente: (ID: ".$cliente['id_checker'].")",TRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'Direcci車n:'),TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', $cliente['name']),BRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', $cliente['address']),BRL,0,L);
		
		/* Correo telefono */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', 'Tel谷fono:'),TRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'Correo Electr車nico:'),TRL,0,L);
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
if(   $row['bateria']==1   ) { $acc[] = 'Bater赤a'; }
if(   $row['cargador']==1   ) { $acc[] = 'Cargador'; }
if(   $row['funda']==1   ) { $acc[] = 'Funda'; }
if(   $row['otro']!='N/A'   ) { $acc[] = 'Otros ('.$row['otro'].')'; }
$acc2 = implode(', ', $acc);

$pdf->Cell(140,8,iconv('UTF-8', 'windows-1252', $acc2),BLR,0,L);

	/* Evaluacion */
$pdf->Ln(13);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Evaluaci車n'),0,0,C);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
	$breaks = array("<br />","<br>","<br/>"); 
$notas = str_ireplace($breaks, "\n", $row['notas']);
$pdf->Multicell(190,5,iconv('UTF-8', 'windows-1252', $notas),1,C,0); 

	/* Solucion */
$pdf->Ln(4);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Resoluci車n del problema'),0,0,C);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
	$breaks = array("<br />","<br>","<br/>"); 
$operacion = str_ireplace($breaks, "\n", $row['operacion']);
$pdf->Multicell(190,5,iconv('UTF-8', 'windows-1252', $operacion),1,C,0); 

	/* Footer */
$pdf->Ln(4);
$pdf->SetFont('Arial','',8);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Para consultar el estado de tu arculo en reparaci車n, visita: https://clientes.repararelpc.es/checker.php'),0,0,C);

$pdf->Ln(20);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Firma Conforme'),0,0,R);


$pdfdoc = $pdf->Output('', 'S');
//$pdf->Output('exa1.pdf', 'I');

	$up = -1;
	
	switch(   $status_singular   ) {
			case 'recibido':
					$status = 'Recibido';
					$box = '<span style="display:inline-block; background:#81F7F3; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
					$up = 0;
				break;
			case 'reparacion':
					$status = 'En Reparaci籀n';
					$box = '<span style="display:inline-block; background:#F3F781; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
					$up = 1;
				break;
			case 'reparado':
					$status = 'Ya Reparado';
					$box = '<span style="display:inline-block; background:#FE2E2E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
					$up = 2;
				break;
			case 'entregado':
					$status = 'Entregado al Cte';
					$box = '<span style="display:inline-block; background:#40FF00; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
					$up = 3;
				break;
			case 'garantia':
					$status = 'En garant穩a';
					$box = '<span style="display:inline-block; background:#9E9E9E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
					$up = 4;
				break;
			case 'electronica':
					$status = 'Electronica';
					$box = '<span style="display:inline-block; background:#4A3E2E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
					$up = 11;
					break;
				case 'no reparable':     $status = 'No reparable';
										$box = '<span style="display:inline-block; background:#4A1E2A; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
											$up = 12;
									break;
									case 'esperando material':     $status = 'Esperando material';
										$box = '<span style="display:inline-block; background:#400E2E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
											$up = 13;
									break;
									case 'presupuestando':     $status = 'Presupuestando';
										$box = '<span style="display:inline-block; background:#4A1A0E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
											$up = 14;
									break;
				
	}

	require '../PHPMailer/PHPMailerAutoload.php';
	
	
	$mail = new PHPMailer;
	$mail->setFrom('ivan@repararelpc.es', 'RepararelPC.es'); /* De */
	$mail->addAddress( $cliente['email'] ); /* Para */
	
	$mail->Subject = 'El estado de tu reparacion ha cambiado | RepararelPC.es' ;
	//$mail->IsHTML(true);
	$mail->msgHTML(  'El estado de la reparacion de tu PC ha cambiado a <b>"'.$status.'"</b>. Para consultar el estado de reparacion de tu PC, ingresa al siguiente link (<a href="http://clientes.repararelpc.es/checker.php">http://clientes.repararelpc.es/checker.php</a>) y consulta con los siguientes datos:<br>
	    <b>Numero de folio:</b>  '.$row['folio'].'<br>
	    <b>ID de cliente:</b> '.$cliente['id_checker']);
	//$mail->msgHTML( $bar );
	//$mail->addAttachment( 'img/logo.jpg' );
	//$mail->addStringAttachment($pdfdoc, 'my-doc.pdf');

    if (!$mail->send()) {
    $return['email'] = $mail->ErrorInfo;
} else {
    $return['email'] = 'Gracias '.$_POST['nombre'].' por contactarte con nosotros. Resolveremos tus dudas a la brevedad.';
}


	
	if(   $up>-1   ) {
				// hacemos update
				$query = "UPDATE articulos SET status=".$up." WHERE AID=".$aid." LIMIT 1";
				$update = mysqli_query($db, $query);
				
				if(   $update   ) {
						$return['span_status'] = $box.' '.$status;
						$return['success'] = 200;
				}
	}
}

echo json_encode( $return );
exit;