<?php
if(   isset($_GET['tid']) && $_GET['tid']>0   ) {
	$tid = $_GET['tid'];


		$consulta = "SELECT * FROM ticket WHERE TID=".$tid." LIMIT 1";

	$query = mysqli_query($db, $consulta);
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	} else {
			/* No existe este cliente o no esta relacionado al ID del usuario logueado */
			?>
				NO EXISTE
			<?php
			exit;
	}
	@mysqli_free_result($query);

if(   isset($_POST['seenvio'])   ) {
		$id = $_SESSION['ID'];
		

		$status = (   isset($_POST['status'])   )? $_POST['status'] : '1' ;
		$fecha = (   isset($_POST['fecha'])   )? $_POST['fecha'] : '0000-00-00 00:00:00' ;
	
		$nombres = filter_var($_POST['nombres'], FILTER_SANITIZE_STRING);
		$direccion = filter_var($_POST['direccion'], FILTER_SANITIZE_STRING);
		$dni = filter_var($_POST['dni'], FILTER_SANITIZE_STRING);
		$telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
		$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
		$notas = (   isset($_POST['notas'])   )? nl2br($_POST['notas']) : '' ;
		$respuesta = (   isset($_POST['respuesta'])   )? nl2br($_POST['respuesta']) : '' ;
	
				
				
						$update = "UPDATE ticket SET nombres=".$nombres.",
							direccion='".$direccion."',
							telefono='".$telefono."',
							email='".$email."',
							dni='".$dni."',
							status=".$status.",
							fecha='".$fecha."',
							notas='".$notas."',
							respuesta='".$respuesta."' 
							 WHERE TID=".$tid;

					mysqli_query($db, $update);
		
				echo "<p style='background:#0A0; color:white; padding:14px 20px; margin:2px;'>";
					echo "Ticket editado con éxito!";
				echo "</p>";
				
				/* redireccionamos a "ver reparaciones" con parametro aid=X */
				?>
				<script>
					window.location.href = '?action=ver_tickets&last=<?=$tid?>';
				</script>
				<?php
		
}
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Editar Ticket (<?=$row['TID']?>)</p>
	
	<form id="form_edit_client" method="POST" action="" enctype="multipart/form-data">
		<input type="hidden" value="uno" id="cualfuncion" />
		<input type="hidden" name="seenvio" value="1" />
		
		<p>Nombres del cliente</p>
			<input name="nombres" type="text" value="<?=$row['nombres']?>" id="nombres"  />
			<br/>
			
			<p>DNI del cliente</p>
			<input name="dni" type="text" value="<?=$row['dni']?>" id="dni"  />
			<br/>

			<p>Dirección del cliente:</p>
			<input name="direccion" type="text" value="<?=$row['direccion']?>" id="direccion"  />
			<br/>
			
			<p>Telefono del cliente:</p>
			<input name="telefono" type="text" value="<?=$row['telefono']?>" id="telefono"  />
			<br/>
			
			<p>Email del cliente:</p>
			<input name="email" type="text" value="<?=$row['email']?>" id="email"  />
			<br/>

			<p class="accesorios">(*) Status del ticket:</p>
	
			<label class="accesorio"><input type="radio" name="status" value="1" <?php if($row['status']==1){ echo "checked";} ?> /> No resuelto</label>
			<label class="accesorio"><input type="radio" name="status" value="2" <?php if($row['status']==2){ echo "checked";} ?> /> Revisando caso</label>
			<label class="accesorio"><input type="radio" name="status" value="3" <?php if($row['status']==3){ echo "checked";} ?> /> Resuelto</label>
		
			<br/><br/>
			
			<p>(*) Fecha:</p>
			<?php
				if(   strtotime($row['fecha'])>0   ) {
					$date = date('Y-m-d', strtotime($row['fecha']));
				} else {
					$date = '';
				}
			?>
			<input type="date" name="fecha" value="<?=$date?>" />
			<br/>
			
			<p>(*)  Notas:</p>
			<?php
				$nl = preg_replace('#<br\s*/?>#i', "", $row['notas']);
			?>
			<textarea name="notas" placeholder="Escriba las notao..." required><?=$nl?></textarea>
			<br/>
			
			<p>Respuesta Final:</p>
			<?php
				$nl = preg_replace('#<br\s*/?>#i', "", $row['respuesta']);
			?>
			<textarea name="respuesta" placeholder="Escriba una respuesta final..."><?=$nl?></textarea>
			<br/>
			
			<button name="after" value="1">Guardar Cambios</button>
	</form>
</div>


<?php
}
?>