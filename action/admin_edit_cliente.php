<?php
if(   isset($_GET['id']) && $_GET['id']>0 && $_SESSION['admin']==1   ) {
	$cid = $_GET['id'];

		$consulta = "SELECT * FROM clientes WHERE CID=".$cid." LIMIT 1";

	$query = mysqli_query($db, $consulta);
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			$name = $row['name'];
			$nif = $row['nif'];
			$id_checker = $row['id_checker'];
			$address = $row['address'];
			$phone = $row['phone'];
			$email = $row['email'];
	} else {
			/* No existe este cliente o no esta relacionado al ID del usuario logueado */
			?>
				NO EXISTE
			<?php
			exit;
	}
@mysqli_free_result($query);

		if(   isset($_POST['after'])   ) {
				$name = filter_var($_POST['cname'], FILTER_SANITIZE_STRING);
				$nif = filter_var($_POST['cnif'], FILTER_SANITIZE_STRING);
				$address = filter_var($_POST['caddress'], FILTER_SANITIZE_STRING);
				$phone = filter_var($_POST['cphone'], FILTER_SANITIZE_STRING);
				$email = filter_var($_POST['cemail'], FILTER_SANITIZE_STRING);

				/* Si el ID checker Extraido en la linea 16 esta vacio, entonces generamos uno */
				if(   $id_checker == '' || strlen($id_checker)<2   ) {
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
				} else {
					/* Si NO ESTA VACIO, Qiere decir que ya existia */
					$id_checker = $_POST['id_checker'];
				}
				
				/* Procedemos a hacer update */
						$update = "UPDATE clientes SET
							name='".$name."',
							nif='".$nif."',
							id_checker='".$id_checker."',
							address='".$address."',
							phone='".$phone."',
							email='".$email."'
							WHERE CID=".$cid;
				
				mysqli_query($db, $update);
				?>
					<script>
						window.location.href = '?action=admin_ver_clientes&last=<?=$cid?>';
					</script>
				<?php
				exit;
		}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Editar Cliente (<?=$name?>)</p>
	
	<form id="form_edit_client" method="POST" action="">
			<p>(*) Nombre:</p>
			<input type="text" name="cname" value="<?=$name?>" placeholder="Ingrese nombre del cliente..." required />
			
			<br/>

			<p>(*) DNI / NIF:</p>
			<input type="text" name="cnif" value="<?=$nif?>" placeholder="Ingrese DNI / NIF" required />
			
			<br/>

			<p>(*) ID_CHECKER:</p>
	<?php
		if(   $id_checker == '' || strlen($id_checker)<2   ) {
				$class_checker = 'style="background:#a00;"';
				$id_checker = "SOLO DE CLICK EN 'Guadar Cambios', Y SE GENERARA EL 'ID CHECKER'";
		} else {
				$class_checker = '';
		}
	?>
			<input type="text" name="id_checker" <?=$class_checker?> value="<?=$id_checker?>" readonly />
			
			<br/>
			
			<p>(*) Dirección:</p>
			<input type="text" name="caddress" value="<?=$address?>" placeholder="Ingrese dirección del cliente..." required />
			
			<br/>
			
			<p>(*) Teléfono:</p>
			<input type="text" name="cphone" value="<?=$phone?>" placeholder="Ingrese teléfono del cliente..." required />
			
			<br/>
			
			<p>Email:</p>
			<input type="text" name="cemail" value="<?=$email?>" placeholder="Ingrese correo electronico del cliente..." />
			
			<br/>
			
			<button name="after" value="0">Guardar Cambios</button>
	</form>
</div>

<?php
}
?>