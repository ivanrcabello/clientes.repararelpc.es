<?php session_start();
if(   isset($_SESSION['ID']) && isset($_POST['cid'])   ) {
	$uid = $_SESSION['ID'];
	$cid = $_POST['cid'];
	require('../config.php');
	
	//Realizamos consulta y extraemos la info del cliente.
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM clientes WHERE CID=".$cid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM clientes WHERE CID=".$cid." AND UID=".$uid." LIMIT 1";
	}
	$query = mysqli_query( $db, $consulta );
	
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array( $query, MYSQLI_ASSOC );
			
			$fecha = explode(' ', $row['datei']);
				$fecha = explode('-', $fecha[0]);
				$mes = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
				$date = (   $fecha[0]>0   )? $fecha[2].' '.$mes[ ($fecha[1]-1) ].' '.$fecha[0] : 'N/A' ;
				
			$return['CID'] = $row['CID'];
			$return['name'] = $row['name'];
			$return['checker'] = (   strlen($row['id_checker'])<2   )?  '<span style="background:#a00;">ACTUALIZE ESTE PERFIL</span>'  :  $row['id_checker']  ;
			$return['nif'] = $row['nif'];
			$return['address'] = $row['address'];
			$return['phone'] = $row['phone'];
			$return['email'] = $row['email'];
			$return['date'] = $date;
			
		/* Extraemos la cantidad de Articulos */
			$consulta2 = "SELECT * FROM articulos WHERE CID=".$cid;
			$query2 = mysqli_query( $db, $consulta2 );
			
			$return['articles'] = mysqli_num_rows($query2);
			@mysqli_free_result( $query2 );

		/* Extraemos la cantidad de Presupuestos */
			$consulta3 = "SELECT * FROM presupuestos WHERE CID=".$cid;
			$query3 = mysqli_query( $db, $consulta3 );
			
			$return['presupuestos'] = mysqli_num_rows($query3);
			@mysqli_free_result( $query3 );

		/* Extraemos la cantidad de Facturas */
			$consulta4 = "SELECT * FROM facturas WHERE CID=".$cid;
			$query4 = mysqli_query( $db, $consulta4 );
			
			$return['facturas'] = mysqli_num_rows($query4);
			@mysqli_free_result( $query4 );

	} else {
		// ERROR
		$return['error'] = "No se encontro la consulta";
	}
	@mysqli_free_result( $query );
	
	echo json_encode( $return );
	exit;
} else {
	$return['wrong'] = "No se encontro la consulta";
	echo json_encode( $return );
}
?>