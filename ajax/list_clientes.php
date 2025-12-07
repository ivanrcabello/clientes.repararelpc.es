<?php session_start();
if(   isset($_SESSION['ID']) && isset($_POST['cliente'])   ) {
	$uid = $_SESSION['ID'];
	$cliente = $_POST['cliente'];
	require('../config.php');
	
	/* Extraemos todos los clientes relacionados */
	$id = $_SESSION['ID'];
	
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM clientes WHERE name LIKE '%".$cliente."%' OR address LIKE '%".$cliente."%' ORDER BY name";
	} else {
		$consulta = "SELECT * FROM clientes WHERE UID=".$id." AND (name LIKE '%".$cliente."%' OR address LIKE '%".$cliente."%') ORDER BY name";
	}
	$query = mysqli_query($db, $consulta);
	
	$array = array();
	
	if(   mysqli_num_rows($query)>0 ) {
			while( $row = mysqli_fetch_array($query, MYSQLI_ASSOC) ) {
				$array[] = array(
						'id' => $row['CID'],
						'name' => $row['name'],
						'address' => $row['address'],
						'phone' => $row['phone'],
						'nif' => $row['nif'],
						'email' => $row['email']
					);
			} // end while
			$return['clientes'] = $array;
	} else {
			$return['error'] = 'No hay coincidencias.';
	}
	@mysqli_free_result($query);
	
	//$return['test'] = $cliente;
	echo json_encode( $return );
	exit;
} else {
	$return['wrong'] = "No se encontro la consulta";
	echo json_encode( $return );
}
?>