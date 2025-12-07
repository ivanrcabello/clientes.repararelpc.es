<?php 
if(   isset($_POST['condiciones'])   ) {
		// guardamos condiciones
		$condiciones = nl2br(   filter_var($_POST['condiciones'], FILTER_SANITIZE_STRING)   );
		$facturacionnombres = nl2br(   filter_var($_POST['facturacionnombres'], FILTER_SANITIZE_STRING)   );
		$facturaciontelefono = nl2br(   filter_var($_POST['facturaciontelefono'], FILTER_SANITIZE_STRING)   );
		$facturacionemail = nl2br(   filter_var($_POST['facturacionemail'], FILTER_SANITIZE_STRING)   );
		$facturaciondireccion = nl2br(   filter_var($_POST['facturaciondireccion'], FILTER_SANITIZE_STRING)   );
		$facturacioncif = nl2br(   filter_var($_POST['facturacioncif'], FILTER_SANITIZE_STRING)   );
		
		$upx = mysqli_query($db, "UPDATE config SET config_value='".$condiciones."' WHERE config_key='condiciones'  LIMIT 1");
		$upxx = mysqli_query($db, "UPDATE config SET config_value='".$facturacionnombres."' WHERE config_key='facturacionnombres'  LIMIT 1");
		$upxxx = mysqli_query($db, "UPDATE config SET config_value='".$facturaciontelefono."' WHERE config_key='facturaciontelefono'  LIMIT 1");
		$upxxxx = mysqli_query($db, "UPDATE config SET config_value='".$facturacionemail."' WHERE config_key='facturacionemail'  LIMIT 1");
		$upxxxxx = mysqli_query($db, "UPDATE config SET config_value='".$facturaciondireccion."' WHERE config_key='facturaciondireccion'  LIMIT 1");
		$upxxxxxx = mysqli_query($db, "UPDATE config SET config_value='".$facturacioncif."' WHERE config_key='facturacioncif'  LIMIT 1");
		
		if(   $upx   ) {
				?>
					<script>
						window.location.href = '?action=admin_config&save=true';
					</script>
				<?php 
		}
}
?>
<style>
	#lista_tabla {padding:10px; background:#fff;}
	
	label {font-weight:bold; display:block;}
	textarea {width:100%; max-width:680px; padding:5px; min-height:120px; border:1px solid #ddd; background:#f6f6f6; box-sizing:border-box;}
	button {background:#2196F3; padding:15px; color:#fff;}
		button:hover {cursor:pointer; background:#1882EE;}
		
	a#reset {display:inline-block; background:#4CAF50; padding:15px; padding-bottom:11px; color:#fff; border-bottom:6px solid rgba(0,0,0,0.2);}
	
	#ok {text-align:center; padding:10px; background:#4CAF50; margin-bottom:20px; color:#fff;}
</style>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Configuración</p>

	<div id="lista_tabla">
		
		<?php 
			if(   isset($_GET['save'])   ) {
				?>
					<p id="ok">Cambios guardados con éxito.</p>
				<?php 
			}
		?>
		<?php 
			if(   isset($_GET['reset'])   ) {
				?>
					<p id="ok">Las facturas se han reseteado con éxito.</p>
				<?php 
			}
		?>
		
		<form method="post" id="form_edit_client">
			<label>Condiciones Generales:</label>
			<?php
			$nl = preg_replace('#<br\s*/?>#i', "", $config['condiciones']);
			$cif = $config['facturacioncif'];
			$df = $config['facturaciondireccion'];
			$fn = $config['facturacionnombres'];
			$fe = $config['facturacionemail'];
			$ft = $config['facturaciontelefono'];
			?>
			<textarea id="text_condiciones" name="condiciones"><?=$nl?></textarea>
			<br/>
			<label>Nombres (facturación):</label>
			<input type="text" id="facturacionnombres" name="facturacionnombres" value="<?php echo $fn; ?>">
			<br/>
			<label>CIF (facturación):</label>
			<input type="text" id="facturacioncif" name="facturacioncif" value="<?php echo $cif; ?>">
			<br/>
			<label>Dirección (facturación):</label>
			<input type="text" id="facturaciondireccion" name="facturaciondireccion" value="<?php echo $df; ?>">
			<br/>
			<label>Email (facturación):</label>
			<input type="text" id="facturacionemail" name="facturacionemail" value="<?php echo $fe; ?>">
			<br/>
			<label>Teléfono (facturación):</label>
			<input type="text" id="facturaciontelefono" name="facturaciontelefono" value="<?php echo $ft; ?>">
			<br/>
			<button type="submit">Guardar Cambios</button>
		</form>
		
		
		<div style="margin-top:30px;">
			<label>Resetear Facturas:</label>
			<a id="reset" href="?action=admin_reset">Si. Resetear facturas</a>
		</div>
		
	</div>
</div>