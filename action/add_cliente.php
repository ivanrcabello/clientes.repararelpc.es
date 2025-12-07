<?php
if(   isset($_POST['after'])   ) {
		$id = $_SESSION['ID'];
		$name = filter_var($_POST['cname'], FILTER_SANITIZE_STRING);
		//$name = mysqli_real_escape_string($db, $_POST['cname']);
		$nif = $_POST['cnif'];
		$address = filter_var($_POST['caddress'], FILTER_SANITIZE_STRING);
		$phone = filter_var($_POST['cphone'], FILTER_SANITIZE_STRING);
		$email = filter_var($_POST['cemail'], FILTER_SANITIZE_STRING);
		
		$date = date('Y-m-d H:i:s');
		
		$id_checker = rand(100000,999999);

		// Revisamos que no exista checker
		$aux = 0;
		while(   $aux==0   ) {
				$queryx = mysqli_query($db, "SELECT CID FROM clientes WHERE id_checker = '".$id_checker."' LIMIT 1");
				if(   mysqli_num_rows($queryx)>0   ) {
						/* si, existe, intentamos con un nuevo id_checker */
						$id_checker = rand(100000,999999);
				} else {
						/* NO EXISTE, ASI QUE VAMOS BIEN */
						$aux=1;
				}
				@mysqli_free_result($queryx);
		}

		/* Procedemos a insertar */
		$insert = "INSERT INTO clientes VALUES(
			null,
			".$id.",
			'".$name."',
			'".$nif."',
			'".$id_checker."',
			'".$address."',
			'".$phone."',
			'".$email."',
			'".$date."'
		)";
		
		mysqli_query($db, $insert);
		$query = mysqli_query($db, "SELECT LAST_INSERT_ID()");
		$data = mysqli_fetch_array( $query, MYSQLI_NUM);
		
		$last_id = $data[0];
		
		@mysqli_free_result( $query );
		
		if(   $_POST['after']==0   ) {
		?>
			<script> window.location.href = '?action=ver_clientes&last=<?=$last_id?>'; </script>
		<?php
		} else {
		?>
			<script> window.location.href = '?action=add_reparacion&cliente=<?=$last_id?>'; </script>
		<?php
		}
		exit;
}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Agregar Nuevo Cliente</p>
	
	<form id="form_edit_client" method="POST" action="">
			<p>(*) Nombre:</p>
			<input type="text" name="cname" value="" placeholder="Ingrese nombre del cliente..." required />
			
			<br/>
			
			<p>(*) DNI / NIF:</p>
			<input type="text" name="cnif" value="" placeholder="Ingrese DNI / NIF" required />
			
			<br/>

			<p>(*) Dirección:</p>
			<input type="text" name="caddress" value="" placeholder="Ingrese dirección del cliente..." required />
			
			<br/>
			
			<p>(*) Teléfono:</p>
			<input type="text" name="cphone" value="" placeholder="Ingrese teléfono del cliente..." required />
			
			<br/>
			
			<p>Email:</p>
			<input type="text" name="cemail" value="" placeholder="Ingrese correo electronico del cliente..." />
			
			<br/>
			
			<button name="after" value="0">Añadir Cliente</button>
			<button name="after" value="1">Añadir Cliente y Añadir Reparación</button>
	</form>
</div>