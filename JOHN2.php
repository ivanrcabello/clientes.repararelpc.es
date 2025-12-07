<?php 
require( 'config.php' );

if(   isset($_GET['pid']) && $_GET['pid']>0   ) {
	$pid = $_GET['pid'];

	$consulta = "SELECT * FROM presupuestos WHERE PID=".$pid." LIMIT 1";
	
	$query = mysqli_query($db, $consulta);
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	} else {
			echo "no existe";
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




require 'fPDF/fpdf.php';
	
	$pdf = new FPDF();
$pdf->AddPage();
			
$pdf->Image('img/logo.jpg',10,10,90,38);

$pdf->SetFont('Arial','B',20);
$pdf->Cell(190,10,'Presupuesto',0,0,R);	

$pdf->Ln(8);
$pdf->SetXY(10,49);
$pdf->Cell(190,10,'ORDEMAT SOLUCIONES SL',0,0,L);

$pdf->Ln(8);
$pdf->SetFont('Arial','',11);
$pdf->Cell(190,5,'Nadine Gordimer 1',0,0,L);

$pdf->Ln();
$pdf->Cell(190,5,'b86744042',0,0,L);

$pdf->Ln();
$pdf->Cell(190,5,'San Fernando de Henares Madrid 28830',0,0,L);

$pdf->Ln();
$pdf->Cell(190,5,'P: ivan@repararelpc.es',0,0,L);

$pdf->Ln();
$pdf->Cell(190,5,'F: 911558505',0,0,L);


		/* fecha y presupuesto */
$pdf->Ln(12);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,"Fecha:",TRL,0,L);
$pdf->Cell(110,5,'Presupuesto:',TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,'2019-02-11',BRL,0,L);
$pdf->Cell(110,5,'999.99'.' '.chr(128),BRL,0,L);

		/* Cliente direccion */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,"Cliente:",TRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'Dirección:'),TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', 'John Magaña Navarro'),RL,0,L);
$pdf->Cell(110,5,"Guayabo #6",RL,0,L);
		
		/* Correo telefono */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', 'Teléfono:'),TRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'Correo Electrónico:'),TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', '+52 1 31414 72157'),BRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'pickira@gmail.com'),BRL,0,L);

		/* descripcion */
$pdf->Ln(12);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', "Descripción del presupuesto:"),TLR,0,C);
$pdf->SetFont('Arial','',10);
$pdf->Ln();
$pdf->MultiCell(190,5,iconv('UTF-8', 'windows-1252', 'Laptop Asus Lenovo HP chingona :v Laptop Asus Lenovo HP chingona :v '),BLR,C,0);

$pdf->Ln(20);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Firma Conforme'),0,0,R);


//$pdfdoc = $pdf->Output('', 'S');
$pdf->Output('exa1.pdf', 'I');

}