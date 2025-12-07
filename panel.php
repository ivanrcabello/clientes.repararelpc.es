<?php session_start();
$error =  false;

if(   isset($_POST['enviar'])   ) {
	$u = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
	$p = md5($_POST['pass']);
	
	if(   (strlen($u)*strlen($u))>0   ) {
			require( 'config.php' );
			$consulta = "SELECT * FROM usuarios WHERE user='".addslashes($u)."' AND pass='".addslashes($p)."' LIMIT 1";
			$query = mysqli_query($db, $consulta);
			if(   mysqli_num_rows($query)   ) {
					// DATOS OK, PROCEDEMOS A CREAR LA SESSION
					$data = mysqli_fetch_array( $query, MYSQLI_ASSOC);
					
					$_SESSION['ID'] = $data['ID'];
					$_SESSION['admin'] = $data['admin'];
					$_SESSION['name'] = $data['name'];
					$_SESSION['user'] = $data['user'];
			} else {
					// ERROR - NO EXISTE USUARIO
					$error = true;
			}
	}
}

if(   isset($_SESSION['user'])   ) {
	require( 'config.php' );
	require('panel_include.php');
} else {
	require('form_login.php');
}
?>