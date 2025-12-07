<?php session_start();
if(   isset($_SESSION['ID']) && isset($_POST['aid'])   ) {
	$uid = $_SESSION['ID'];
	$aid = $_POST['aid'];
	$nombre = $_POST['nombre'];
	$id_a_eliminar = $_POST['id'];
	require('../config.php');
	
	//Realizamos consulta y extraemos la cantidad de imagenes del articulo
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT no_fotos FROM articulos WHERE AID=".$aid." LIMIT 1";
	} else {
		$consulta = "SELECT no_fotos FROM articulos WHERE AID=".$aid." AND UID=".$uid." LIMIT 1";
	}
	$query = mysqli_query( $db, $consulta );
	
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array( $query, MYSQLI_ASSOC );

			$cantidad = $row['no_fotos'];
			
			/* eliminamos la foto */
			$file = "../uploads/".$nombre."_".$id_a_eliminar;
			if(   file_exists($file.".jpg")   ) { unlink( $file.".jpg"); }
			elseif(   file_exists($file.".jpeg")   ) { unlink( $file.".jpeg"); }
			elseif(   file_exists($file.".png")   ) { unlink( $file.".png"); }
			elseif(   file_exists($file.".gif")   ) { unlink( $file.".gif"); }
			elseif(   file_exists($file.".bmp")   ) { unlink( $file.".bmp"); }
			
			/* reordenamos los archivos */
			for($i=1; $i<=$cantidad; $i++){
					$file = "../uploads/".$nombre;
					
					/* Comparamos, si es MAYOR la resta, entonces modificamos su numero con "-1" */
					if(   ($i-$id_a_eliminar)>0   ) {
							$ext = '';
							if(   file_exists($file."_".$i.".jpg")   ) { $ext = ".jpg"; }
							elseif(   file_exists($file."_".$i.".jpeg")   ) { $ext = ".jpeg"; }
							elseif(   file_exists($file."_".$i.".png")   ) { $ext = ".png"; }
							elseif(   file_exists($file."_".$i.".gif")   ) { $ext = ".gif"; }
							elseif(   file_exists($file."_".$i.".bmp")   ) { $ext = ".bmp"; }
							
							$original = $file."_".$i.$ext;
							$nuevo = $file."_".($i-1).$ext;
							
							rename($original, $nuevo);
							
							$return['ext'][$i] = $ext;
							$return['original'][$i] = $file."_".$i.$ext;
							$return['nuevo_nombre'][$i] = $file."_".($i-1).$ext;
					}
			} // end for
			
			/* hacemos update en el campo "no_fotos" */
			if(   $_SESSION['admin']==1   ) {
				$update = "UPDATE articulos SET no_fotos=".($cantidad-1)." WHERE AID=".$aid;
			} else {
				$update = "UPDATE articulos SET no_fotos=".($cantidad-1)." WHERE AID=".$aid." AND UID=".$uid;
			}
			mysqli_query($db, $update);
			
			$return['cantidad_fotos'] = $cantidad;
			$return['nombre'] = $file;
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