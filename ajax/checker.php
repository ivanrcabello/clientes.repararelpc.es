<?php
if(   isset($_POST['folio']) && isset($_POST['checker'])   ) {
		$folio = str_replace(' ', '', $_POST['folio']);
		$checker = str_replace(' ', '', $_POST['checker']);

		require( '../config.php' );

			$query = mysqli_query($db, "SELECT * FROM articulos, clientes WHERE articulos.folio='".$folio."' AND clientes.id_checker='".$checker."' LIMIT 1");
			if(   mysqli_num_rows($query)>0   ) {
					$row = mysqli_fetch_array( $query, MYSQLI_ASSOC );
					$return['data'] = $row;
					$return['data']['operacion'] = utf8_decode($row['operacion']);
			} else {
					$return['error'] = 'No existe articulo relacionado al Folio o al ID de Cliente';
			}
			@mysqli_free_result( $query );

} else {
		$return['error'] = 'Not form submited';
}
echo json_encode($return);
?>