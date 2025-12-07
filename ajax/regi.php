<?php
require( '../config.php' );
if(   isset($_POST['nombres']) && isset($_POST['dni']) && isset($_POST['direccion']) && isset($_POST['telefono']) && isset($_POST['email']) && isset($_POST['notas'])  ) {
		$nombres = $_POST['nombres'];
        $dni = $_POST['dni'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $notas = $_POST['notas'];
        $date = date('Y-m-d H:i:s');

        
        $insert = "INSERT INTO ticket VALUES(
			NULL,
			'1',
			'".$nombres."',
			'".$dni."',
			'".$direccion."',
			'".$telefono."',
			'".$email."',
			'".$notas."',
			'1',
			'".$date."',
			''
		)";
		
		$cl = mysqli_query($db, $insert);
		$query = mysqli_query($db, "SELECT LAST_INSERT_ID()");
		$data = mysqli_fetch_array( $query, MYSQLI_NUM);
		
        $last_id = $data[0];

        @mysqli_free_result( $query );
        
        // Insertar orden
        if($cl) {
  
        

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
$pdf->Cell(190,10,'No. '.$last_id,0,0,R);	

$pdf->Ln(8);
$pdf->SetXY(10,49);
$pdf->Cell(190,10,'REPARARELPC.ES',0,0,L);

$pdf->Ln(8);
$pdf->SetFont('Arial','B',14);

$pdf->Cell(190,10,'No resuelto',0,0,L);

$pdf->Ln(4);
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
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', $nombres),BRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', $direccion),BRL,0,L);
		
		/* Correo telefono */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', 'Teléfono:'),TRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'Correo Electrónico:'),TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', $telefono),BRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', $email),BRL,0,L);


	/* Notas */
$pdf->Ln(13);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Problema'),0,0,C);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
	$breaks = array("<br />","<br>","<br/>"); 
$notas = str_ireplace($breaks, "\n", $notas);
$pdf->Multicell(190,5,iconv('UTF-8', 'windows-1252', $notas),1,C,0); 


$pdf->Ln(20);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Firma Conforme'),0,0,R);


$pdfdoc = $pdf->Output('', 'S');
//$pdf->Output('exa1.pdf', 'I');



	require '../PHPMailer/PHPMailerAutoload.php';
	
	
	$mail = new PHPMailer;
	$mail->setFrom('ivan@repararelpc.es', 'RepararelPC.es'); /* De */
	$mail->addAddress( $email );
	$mail->addAddress('ivan@repararelpc.es' );/* Para */
	
	$mail->Subject = 'Ticket de incidencia recepcionado' ;
	//$mail->IsHTML(true);
	$mail->msgHTML(  '<b>El ticket se ha creado correctamente</b>. <br> Número de ticket:'.$last_id);
	//$mail->msgHTML( $bar );
	//$mail->addAttachment( 'img/logo.jpg' );
	$mail->addStringAttachment($pdfdoc, 'my-doc.pdf');

    if (!$mail->send()) {
    
} else {

}
             
				
                    if($query) {
                        $return = array(
                            'orden' => $last_id
                            );
                    }
        }
        else {
            $return['error'] = 'No se pudo procesar la orden.';
        }

} else {
		$return['error'] = 'Formulario no ha sido enviado';
}
echo json_encode($return);
?>