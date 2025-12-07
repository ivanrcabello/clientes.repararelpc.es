<?php session_start();
$return['success'] = 0;

if(   isset($_SESSION['ID']) && isset($_POST['tid'])   ) {
	require('../config.php');
	
	$tid = $_POST['tid'];
	$status_singular = $_POST['status'];
	
	/* Verificamos que el articulo EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM ticket WHERE TID=".$tid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM ticket WHERE UID = ".$_SESSION['ID']." AND TID=".$tid." LIMIT 1";
	}
	$query = mysqli_query($db, $consulta);
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	} 
	@mysqli_free_result($query);
	
	
	// Enviar Email con PDF y link de checar.
	
	require '../fPDF/fpdf.php';
	
	$pdf = new FPDF();
$pdf->AddPage();
			
$pdf->Image('../img/logo.png',10,10,90,38);

$pdf->SetFont('Arial','B',20);
$pdf->Cell(190,10,'Ticket',0,0,R);	
$pdf->Ln();
$pdf->Cell(190,10,iconv('UTF-8', 'windows-1252', ''),0,0,R);	
$pdf->Ln();
$pdf->SetFont('Arial','',16);
$pdf->Cell(190,10,'No. '.$row['TID'],0,0,R);	

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
$pdf->Cell(80,5,"Cliente:",TRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'Dirección:'),TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', $row['nombres']),BRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', $row['direccion']),BRL,0,L);
		
		/* Correo telefono */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', 'Teléfono:'),TRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'Correo Electrónico:'),TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', $row['telefono']),BRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', $row['email']),BRL,0,L);

	/* Evaluacion */
$pdf->Ln(13);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Problema'),0,0,C);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
	$breaks = array("<br />","<br>","<br/>"); 
$notas = str_ireplace($breaks, "\n", $row['notas']);
$pdf->Multicell(190,5,iconv('UTF-8', 'windows-1252', $notas),1,C,0); 

	/* Solucion */
$pdf->Ln(4);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Respuesta de RepararelPC.es'),0,0,C);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
	$breaks = array("<br />","<br>","<br/>"); 
$operacion = str_ireplace($breaks, "\n", $row['respuesta']);
$pdf->Multicell(190,5,iconv('UTF-8', 'windows-1252', $operacion),1,C,0); 


$pdf->Ln(20);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Firma Conforme'),0,0,R);


$pdfdoc = $pdf->Output('', 'S');
//$pdf->Output('exa1.pdf', 'I');

	$up = -1;
	
	switch(   $status_singular   ) {
			case 'no resuelto':
					$status = 'No resuelto';
					$box = '<span style="display:inline-block; background:#81F7F3; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
					$up = 1;
				break;
			case 'revisando caso':
					$status = 'Revisando caso';
					$box = '<span style="display:inline-block; background:#F3F781; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
					$up = 2;
				break;
			case 'resuelto':
					$status = 'Resuelto';
					$box = '<span style="display:inline-block; background:#FE2E2E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
					$up = 3;
				break;
		
	}

	require '../PHPMailer/PHPMailerAutoload.php';
	
	
	$mail = new PHPMailer;
	$mail->setFrom('ivan@repararelpc.es', 'RepararelPC.es'); /* De */
	$mail->addAddress( $row['email'] ); /* Para */
	
	$mail->Subject = 'El estado de tu ticket ha cambiado | RepararelPC.es' ;
	//$mail->IsHTML(true);
	$mail->msgHTML(  'El estado de tu ticket ha cambiado a <b>"'.$status.'"</b>. <br>
	    <b>Respuesta de RepararElPC.es:</b>  '.$row['respuesta'].'<br>');
	//$mail->msgHTML( $bar );
	//$mail->addAttachment( 'img/logo.jpg' );
	//$mail->addStringAttachment($pdfdoc, 'my-doc.pdf');

    if (!$mail->send()) {
    $return['email'] = $mail->ErrorInfo;
} else {
    $return['email'] = 'Gracias por contactarte con nosotros. Resolveremos tus dudas a la brevedad.';
}


	
	if(   $up>-1   ) {
				// hacemos update
				$query = "UPDATE ticket SET status=".$up." WHERE TID=".$tid." LIMIT 1";
				$update = mysqli_query($db, $query);
				
				if(   $update   ) {
						$return['span_status'] = $box.' '.$status;
						$return['success'] = 200;
				}
	}
}

echo json_encode( $return );
exit;