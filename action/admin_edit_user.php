<?php
if(   $_SESSION['admin']==1   ) {

if(   isset($_GET['id']) && $_GET['id']>0   ) {
	$id = $_GET['id'];

	/* Verificamos que exista el usuario */
	$consulta = "SELECT * FROM usuarios WHERE ID=".$id." LIMIT 1";
	$query = mysqli_query($db, $consulta);
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			
	} else {
			/* No existe este usuario */
			?>
				NO EXISTE
			<?php
			exit;
	}
@mysqli_free_result($query);

		if(   isset($_POST['after'])   ) {
				$login = $_POST['login'];;
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
				$email = $_POST['email'];
				$admin = $_POST['admin'];
				
				$pass1 = $_POST['pass1'];
				$pass2 = $_POST['pass2'];
				
				/* Procedemos a hacer update */
				if(   $pass1==$pass2   ) {
						if( $pass1=='' ) {
								/* update sin el password */
								$update = "UPDATE usuarios SET
									user='".$login."',
									name='".$name."',
									email='".$email."',
									admin='".$admin."'
									WHERE ID=".$id;
						
						} else {
								/* update con password */
								$update = "UPDATE usuarios SET
									user='".$login."',
									name='".$name."',
									email='".$email."',
									admin='".$admin."',
									pass='".md5($pass1)."' 
									WHERE ID=".$id;
						}
						mysqli_query($db, $update);
						?>
							<script>
								window.location.href = '?action=admin_ver_usuarios&last=<?=$id?>';
							</script>
						<?php
						exit;
				} else {
						/* contraseñas no coinciden */
						echo "<h2 style='background:#A00; color:white; padding:10px; margin:2px;'>";
							echo "Error. Las contraseñas no coinciden.";
						echo "</h2>";
				}
		}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Editar Usuario (<?=$row['user']?> - <?=$row['name']?>)</p>
	
	<form id="form_edit_client" method="POST" action="">
			<p>(*) User Login:</p>
			<input type="text" name="login" value="<?=$row['user']?>" placeholder="Ingrese nick para login..." required />
			
			<br/>
			
			<p>(*) Nombre:</p>
			<input type="text" name="name" value="<?=$row['name']?>" placeholder="Ingrese nombre real del usuario..." required />
			
			<br/>
			
			<p>(*) Email:</p>
			<input type="text" name="email" value="<?=$row['email']?>" placeholder="Ingrese email del usuario..." required />
			
			<br/>
			
			<p>Marca como Administrador:</p>
			<label class="radio"><input type="radio" name="admin" value="0" <?php if($row['admin']==0){ echo "checked";} ?> />No</label>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label class="radio"><input type="radio" name="admin" value="1" <?php if($row['admin']==1){ echo "checked";} ?> />Si</label>
			
			<br/><br/>
			
			<p>Cambiar Contraseña:<br/>
				<em style="font-size:11px;">Si no desea cambiar la contraseña, deje en blanco.</em>
			</p>
			<label>Ingrese nueva contraseña:<br/>
			<input type="password" name="pass1" placeholder="Ingrese nueva contraseña..." />
			</label>
				<br/>
			<label>Repita contraseña:<br/>
			<input type="password" name="pass2" placeholder="Repita la contrasela..." />
			</label>
			
			<br/>
			
			<button name="after" value="0">Guardar Cambios</button>
	</form>
</div>

<?php
}


}
?>