<?php
if(   $_SESSION['admin']==1   ) {

		if(   isset($_POST['after'])   ) {
				$login = $_POST['login'];;
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
				$email = $_POST['email'];
				$admin = $_POST['admin'];
				
				$pass1 = $_POST['pass1'];
				$pass2 = $_POST['pass2'];
				
				$date = date('Y-m-d H:i:s');
				
				/* Verificamos que usuario no exista */
				$consulta = "SELECT user FROM usuarios WHERE user='".$login."' LIMIT 1";
				$query = mysqli_query($db, $consulta);
				
				if(   mysqli_num_rows($query)<=0   ) {
						/* ahora comparamos ambas contraseñas */
						if(   $pass1!='' && $pass1==$pass2   ) {
								/* INSERTAMOS **************************************** * */
								$insert = "INSERT INTO usuarios VALUES(
									NULL,
									'".$login."',
									'".md5($pass1)."',
									'".$name."',
									'".$email."',
									'".$date."',
									'".$admin."',
									0
									);";
								if(   mysqli_query($db, $insert)   ) {									
										//Extraemos el ultimo ID
										$query = mysqli_query($db, "SELECT LAST_INSERT_ID()");
										$data = mysqli_fetch_array( $query, MYSQLI_NUM);
										
										$last_id = $data[0];
										@mysqli_free_result( $query );
										?>
										<script>
										window.location.href = '?action=admin_ver_usuarios&last=<?=$last_id?>';
										</script>
										<?php
										exit;
								
								} else {
										/* ocurrio un error inesperado en el INSERT */
										echo "Error Inesperado.";
								}
						} else {
								/* ERROR - EN LAS CONTRASEÑAS */
							echo "<h2 style='background:#A00; color:white; padding:10px; margin:2px;'>";
								echo "Error. Las contraseñas no coinciden.";
							echo "</h2>";
						}
				} else {
						/* ERROR - YA EXISTE USER */
						echo "<h2 style='background:#A00; color:white; padding:10px; margin:2px;'>";
							echo "Error. Ya existe este Usuario.";
						echo "</h2>";
				}
		}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Agregar Usuario</p>
	
	<form id="form_edit_client" method="POST" action="">
			<p>(*) User Login:</p>
			<input type="text" name="login" placeholder="Ingrese nick para login..." required />
			
			<br/>
			
			<p>(*) Nombre:</p>
			<input type="text" name="name" placeholder="Ingrese nombre real del usuario..." required />
			
			<br/>
			
			<p>(*) Email:</p>
			<input type="text" name="email" placeholder="Ingrese email del usuario..." required />
			
			<br/>
			
			<p>(*) Marca como Administrador:</p>
			<label class="radio"><input type="radio" name="admin" value="0" checked />Acceso reparaciones "electronica"</label>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label class="radio"><input type="radio" name="admin" value="1" />Administrador (acceso a todo)</label>
			
			<br/><br/>
			
			<p>(*) Contraseña:<br/>
				<em style="font-size:11px;">Si no desea cambiar la contraseña, deje en blanco.</em>
			</p>
			<label>Ingrese contraseña:<br/>
			<input type="password" name="pass1" placeholder="Ingrese nueva contraseña..." required />
			</label>
				<br/>
			<label>Repita contraseña:<br/>
			<input type="password" name="pass2" placeholder="Repita la contrasela..." required />
			</label>
			
			<br/>
			
			<button name="after" value="0">Añadir Usuario</button>
	</form>
</div>

<?php
}
?>