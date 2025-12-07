<?php
session_start();
require( '../config.php' );
if (
    (isset($_POST['nombres']) && isset($_POST['dni']) && (isset($_POST['punto']) || isset($_POST['direccion'])) && isset($_POST['telefono']) && isset($_POST['email'])
&& isset($_POST['modelo']) && isset($_POST['marca']) && isset($_POST['tipoordenador']) && isset($_POST['notas']))
|| (isset($_POST['register']) && $_POST['register'] == 0 && isset($_POST['modelo']) && isset($_POST['marca']) && isset($_POST['tipoordenador']) && isset($_POST['notas']))  ) {
		$nombres = $_POST['nombres'];
        $dni = $_POST['dni'];
        $modelo = $_POST['modelo'];
        $marca = $_POST['marca'];
        $tipoordenador = $_POST['tipoordenador'];
        $direccion = $_POST['direccion'];
        $punto = $_POST['punto'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $notas = $_POST['notas'];
        $certificado = $_POST['certificado'] === 'on' ? 1 : 0;
        $password = $_POST['password'];
        $register = $_POST['register'];
        $date = date('Y-m-d H:i:s');
        $date2 = date('Y-m-d', strtotime($date . ' +2 days'));
		$id_checker = rand(100000,999999);
		$folio = rand(100000,999999);
		$pass = "pass".rand(1000000,9999999);

        if ($register != 0) {
		    $res = mysqli_query($db, "SELECT * FROM clientes WHERE nif='".$dni."'");
        }
        else if (isset($_SESSION['user'])) {
            $res = mysqli_query($db, "SELECT * FROM clientes WHERE CID='".$_SESSION['user']."'");
        }
		if (mysqli_num_rows($res) === 0) {
		    $insert = "INSERT INTO clientes VALUES(
			NULL,
			'1',
			'".$nombres."',
			'".$dni."',
			'".$id_checker."',
			'".$direccion."',
			'".$telefono."',
			'".$email."',
			'".$date."'
		    )";
		    $res = mysqli_query($db, $insert);
		    $query = mysqli_query($db, "SELECT LAST_INSERT_ID()");
    		$data = mysqli_fetch_array( $query, MYSQLI_NUM);
            $id_cliente = $data[0];
            @mysqli_free_result( $res );
		}
		else {
    		$data = mysqli_fetch_array( $res, MYSQLI_NUM);
            $id_cliente = $data[0];
            @mysqli_free_result( $res );
		}
        
        if ($register != 0) {
            $newUser = "INSERT INTO usuarios VALUES (NULL,'".$id_cliente."','".md5($pass)."','".$nombres."','".$email."','".$date."','0','0');";
            mysqli_query($db, $newUser);
        }
    
        // Insertar orden
        $insert = "INSERT INTO articulos VALUES (NULL,".$id_cliente.",'1','".$tipoordenador."','".$modelo."','".$marca."','N/A','0.00','0.00'
        ,'0','','0','0','0','N/A',10,'".$date."','".$date."','".$folio."','".$notas."',$certificado,'".$password."',$punto,'N/A', '".$date2."');";
        mysqli_query($db, $insert);

        $query = mysqli_query($db, "SELECT LAST_INSERT_ID()");
        $data = mysqli_fetch_array( $query, MYSQLI_NUM);
        $last_id = $data[0];
        @mysqli_free_result( $query );
        

	// Enviar Email con PDF y link de checar.
	
	require '../fPDF/fpdf.php';
	
	$pdf = new FPDF();
$pdf->AddPage();
			
$pdf->Image('../img/logo.png',10,10,90,38);

$pdf->SetFont('Arial','B',20);
$pdf->Cell(190,10,'Orden de',0,0,R);	
$pdf->Ln();
$pdf->Cell(190,10,iconv('UTF-8', 'windows-1252', 'Reparación'),0,0,R);	
$pdf->Ln();
$pdf->SetFont('Arial','',16);
$pdf->Cell(190,10,'Folio No. '.$folio,0,0,R);	

$pdf->Ln(8);
$pdf->SetXY(10,49);
$pdf->Cell(190,10,'REPARARELPC.ES',0,0,L);

$pdf->Ln(8);
$pdf->SetFont('Arial','B',14);

$pdf->Cell(190,10,'Equipo aun no recepcionado',0,0,L);

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
$pdf->Cell(80,5,"Cliente: (ID: ".$id_checker.")",TRL,0,L);
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

		/* Articulo */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,"Articulo:",LR,0,L);
$pdf->SetFont('Arial','',10);
$pdf->Ln();
$pdf->MultiCell(190,5,iconv('UTF-8', 'windows-1252', $tipoordenador),BLR,L,0);

		/* Modelo Serie */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,"Marca:",BRL,0,L);
$pdf->Cell(110,5,"Modelo:",BRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', $marca), BLR,0,C);

$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', $modelo), BLR,0,C);

	/* Notas */
$pdf->Ln(13);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Notas'),0,0,C);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
	$breaks = array("<br />","<br>","<br/>"); 
$notas = str_ireplace($breaks, "\n", $notas);
$pdf->Multicell(190,5,iconv('UTF-8', 'windows-1252', $notas),1,C,0); 


	/* Footer */
$pdf->Ln(4);
$pdf->SetFont('Arial','',8);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Para consultar el estado de tu arculo en reparación, visita: https://clientes.repararelpc.es/checker.php '),0,0,C);

$pdf->Ln(20);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Firma Conforme'),0,0,R);


$pdfdoc = $pdf->Output('', 'S');
//$pdf->Output('exa1.pdf', 'I');



	require '../PHPMailer/PHPMailerAutoload.php';
	
	
	$mail = new PHPMailer;
	$mail->setFrom('ivan@repararelpc.es', 'RepararelPC.es'); /* De */
	$mail->addAddress( $email ); /* Para */
	
	$mail->Subject = 'Orden de reparacion creada | RepararelPC.es' ;
	//$mail->IsHTML(true);
	$mail->msgHTML(  '<b>La orden de reparacion se ha creado correctamente</b>. Para consultar el estado de reparacion de tu PC, ingresa al siguiente link para iniciar sesión (<a href="http://clientes.repararelpc.es/panel-cliente.php">http://clientes.repararelpc.es/panel-cliente.php</a>) y consulta con los siguientes datos:<br>
	    <b>Numero de folio:</b>  '.$folio.'<br>
	    <b>ID de cliente:</b> '.$id_checker.'<br>
	    <b>Usuario:</b> '.$id_cliente.'<br>
	    <b>Contraseña: </b>'.$pass);
	$mail->addStringAttachment($pdfdoc, 'my-doc.pdf');

    if (!$mail->send()) {
    
} else {

}
             
				
                    if($query) {
                        $return = array(
                            'folio' => $folio,
                            'cliente' => $id_checker,
                            'orden' => $last_id,
                            'user' => $id_cliente,
                            'pass' => $pass,
                            );
                    }

} else {
		$return['error'] = 'Formulario no ha sido enviado';
}
echo json_encode($return);
?>