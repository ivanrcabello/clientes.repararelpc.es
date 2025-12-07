<?php session_start();
if(   isset($_SESSION['ID']) && isset($_POST['cid'])   ) {
	$uid = $_SESSION['ID'];
	$cid = $_POST['cid'];
	require('../config.php');
	
	/* validamos que el ID del cliente sea compatible con el ID del usuario */

		$consulta = "SELECT name FROM clientes WHERE CID=".$cid." LIMIT 1";

	$query = mysqli_query($db,$consulta);
	
	if(   mysqli_num_rows($query)>0   ) {
		$return['success'] = "ID de cliente válido para el usuario.";
	} else {
		$return['error'] = "Cliente Invalido, no esta asociado a este usuario.";
	}
	@mysqli_free_result($query);
	
	echo json_encode( $return );
	exit;
} else {
	$return['wrong'] = "No session iniciada o No data enviada.";
	echo json_encode( $return );
	exit;
}
?>