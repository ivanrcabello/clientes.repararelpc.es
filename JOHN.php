<?php 
require( 'config.php' );

if(   isset($_GET['aid']) && $_GET['aid']>0   ) {
	$aid = $_GET['aid'];

	$consulta = "SELECT * FROM articulos WHERE AID=".$aid." LIMIT 1";
	
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


$funda = ( $row['funda']==1 )? 'X' : '&nbsp;' ;
$cargador = ( $row['cargador']==1 )? 'X' : '&nbsp;' ;
$bateria = ( $row['bateria']==1 )? 'X' : '&nbsp;' ;






require 'fPDF/fpdf.php';
	
	$pdf = new FPDF();
$pdf->AddPage();
			
$pdf->Image('img/logo.jpg',10,10,90,38);

$pdf->SetFont('Arial','B',20);
$pdf->Cell(190,10,'Orden de',0,0,R);	
$pdf->Ln();
$pdf->Cell(190,10,iconv('UTF-8', 'windows-1252', 'Reparación'),0,0,R);	
$pdf->Ln();
$pdf->SetFont('Arial','',16);
$pdf->Cell(190,10,'Folio No. 3333333',0,0,R);	

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

		/* Fechas */
$pdf->Ln(12);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(90,5,"Fecha de entrada:",0,0,L);
$pdf->Cell(100,5,"Fecha de Salida:",0,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(90,5,"0000-00-00",0,0,L);
$pdf->Cell(100,5,"0000-00-00",0,0,L);

		/* presupuesto precio */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,"Presupuesto:",TRL,0,L);
$pdf->Cell(110,5,'Precio Final:',TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,'999.99'.' '.chr(128),BRL,0,L);
$pdf->Cell(110,5,'999.99'.' '.chr(128),BRL,0,L);

		/* Cliente */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,"Cliente: (ID: 2398479823)",TRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'Dirección:'),TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', 'John Magaña Navarro'),BRL,0,L);
$pdf->Cell(110,5,"Guayabo #6",BRL,0,L);
		
		/* Correo telefono */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', 'Teléfono:'),TRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'Correo Electrónico:'),TRL,0,L);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,iconv('UTF-8', 'windows-1252', '+52 1 31414 72157'),BRL,0,L);
$pdf->Cell(110,5,iconv('UTF-8', 'windows-1252', 'pickira@gmail.com'),BRL,0,L);

		/* Articulo */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,"Articulo:",LR,0,L);
$pdf->SetFont('Arial','',10);
$pdf->Ln();
$pdf->MultiCell(190,5,iconv('UTF-8', 'windows-1252', 'Laptop Asus Lenovo HP chingona :v Laptop Asus Lenovo HP chingona :v '),BLR,L,0);

		/* Modelo Serie */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,5,"Marca:",LR,0,C);
$pdf->Cell(64,5,"Modelo:",LR,0,C);
$pdf->Cell(63,5,"Serie:",LR,0,C);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(63,5,'ASUS',BLR,0,C);
$pdf->Cell(64,5,'ONE EXPLORER',BLR,0,C);
$pdf->Cell(63,5,'X441N 23H09',BLR,0,C);

		/* Accesorios */
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(50,8,'Accesorios',BLR,0,C);
$pdf->SetFont('Arial','',10);
$pdf->Cell(140,8,iconv('UTF-8', 'windows-1252', 'Batería, otra cosa, etc...'),BLR,0,L);

	/* Evaluacion */
$pdf->Ln(13);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Evaluación'),0,0,C);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$breaks = array("<br />","<br>","<br/>"); 
$condiciones = str_ireplace($breaks, "\n", 'SKLJFLK SDKF JL SKDJF LKSJD LKSDJFL LKDJFK SJDFLLKDJ FKSJD FKDJ LK DLKJ DF');
$pdf->Multicell(190,5,iconv('UTF-8', 'windows-1252', $condiciones),1,C,0); 

	/* Solucion */
$pdf->Ln(4);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Resolución del problema'),0,0,C);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$breaks = array("<br />","<br>","<br/>"); 
$condiciones = str_ireplace($breaks, "\n", 'SKLJFLK SDKF JL SKDJF LKSJD LKSDJFL LKDJFK SJDFLLKDJ FKSJD FKDJ LK DLKJ DF SKLJFLK SDKF JL SKDJF LKSJD LKSDJFL LKDJFK SJDFLLKDJ FKSJD FKDJ LK DLKJ DF SKLJFLK SDKF JL SKDJF LKSJD LKSDJFL LKDJFK SJDFLLKDJ FKSJD FKDJ LK DLKJ DF SKLJFLK SDKF JL SKDJF LKSJD LKSDJFL LKDJFK SJDFLLKDJ FKSJD FKDJ LK DLKJ DF SKLJFLK SDKF JL SKDJF LKSJD LKSDJFL LKDJFK SJDFLLKDJ FKSJD FKDJ LK DLKJ DF SKLJFLK SDKF JL SKDJF LKSJD LKSDJFL LKDJFK SJDFLLKDJ FKSJD FKDJ LK DLKJ DF SKLJFLK SDKF JL SKDJF LKSJD LKSDJFL LKDJFK SJDFLLKDJ FKSJD FKDJ LK DLKJ DF SKLJFLK SDKF JL SKDJF LKSJD LKSDJFL LKDJFK SJDFLLKDJ FKSJD FKDJ LK DLKJ DF ');
$pdf->Multicell(190,5,iconv('UTF-8', 'windows-1252', $condiciones),1,C,0); 

	/* Footer */
$pdf->Ln(4);
$pdf->SetFont('Arial','',8);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Para consultar el estado de tu arculo en reparación, visita: hp://app.goseo.es/'),0,0,C);

$pdf->Ln(20);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,5,iconv('UTF-8', 'windows-1252', 'Firma Conforme'),0,0,R);


//$pdfdoc = $pdf->Output('', 'S');
$pdf->Output('exa1.pdf', 'I');

}