<?php
if(   isset($_GET['status']) && ($_GET['status']>-1 || $_GET['status']==-9)   ) {
	require('config.php');

	$filtro = $_GET['status'];

	$lema = '';
	switch( $filtro ) {
			case 0: $lema = '"de articulos Recibidos"';  break;
			case 1: $lema = '"de articulos En Reparacion"';  break;
			case 2: $lema = '"de articulos Ya Reparados"';  break;
			case 3: $lema = '"de articulos Entregados al Cliente"';  break;
			default: $lema = '"todos los Articulos"';
	}



	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=exportacion ".$lema.".txt");
   /*
   // do your Db stuff here to get the content into $content
   print "This is some text...\n";
   print $content;
   */


	// all 0 1 2 3
	if(   $filtro > -1 ) {
				$consulta = "SELECT clientes.name, clientes.address, articulos.precio FROM articulos, clientes WHERE clientes.CID=articulos.CID AND articulos.status=".$filtro." ORDER BY AID DESC";
	} else {
				$consulta = "SELECT clientes.name, clientes.address, articulos.precio FROM articulos, clientes WHERE clientes.CID=articulos.CID ORDER BY AID DESC";
	}

	$query = mysqli_query($db, $consulta);

	
	echo " Exportación ".$lema;
	echo "\r\n\r\n ORDEN DE LA TABLA:";
	echo "\r\n NOMBRE  |  DIRECCION  |  PRECIO \r\n\r\n";

	echo "\r\n\r\n TOTAL DE RESULTADOS: ( ".mysqli_num_rows($query)." ) \r\n\r\n\r\n";

	if(   mysqli_num_rows($query)>0   ) {
			while(   $row = mysqli_fetch_array($query, MYSQLI_ASSOC)   ) {
					$precio = (   $row['precio']==''   )? 'N/A' : number_format($row['precio'],2).'€' ;

					echo ' '.utf8_decode($row['name']).'  |  '.$row['address'].'  |  '.$precio."\r\n";

			}
	}

	@mysqli_free_result($query);
	/* header( "refresh:5;url=panel.php" ); */
 }