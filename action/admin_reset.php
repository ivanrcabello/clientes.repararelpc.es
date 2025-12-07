<?php 
if(   isset($_POST['resetear'])   ) {
	
		$upx = mysqli_query($db, "UPDATE config SET config_value='".(intval($config['version_factura'])+1)."' WHERE config_key='version_factura' LIMIT 1");
		$upx2 = mysqli_query($db, "UPDATE config SET config_value='1' WHERE config_key='reset_facturas' LIMIT 1");
		if(   $upx && $upx2   ) {
				?>
					<script>
						window.location.href = '?action=admin_config&reset=true';
					</script>
				<?php 
		}
}
?>
<style>
	#lista_tabla {padding:10px; background:#fff;}
	
	label {font-weight:bold; display:block;}
	button, a#reset {display:inline-block; background:#2196F3; padding:15px 22px; color:#fff; vertical-align:top; font-size:14px;}
		button:hover {cursor:pointer; background:#1882EE;}
	a#reset {background:#f44336;}
</style>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Resetear facturas</p>

	<div id="lista_tabla">
		
		<form method="post">
			<label>¿Esta seguro de resetear?</label>
			<input type="hidden" name="resetear" value="1" />
			
			<button type="submit">Sí</button>
			<a id="reset" href="?action=admin_config">No</a>
		</form>
		
	</div>
</div>