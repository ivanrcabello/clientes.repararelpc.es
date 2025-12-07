<?php
if(   isset($_GET['id']) && $_GET['id']>0   ) {
	$gid = $_GET['id'];

	/* Verificamos que el articulo EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM puntos WHERE GID=".$gid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM puntos WHERE UID = ".$_SESSION['ID']." AND GID=".$gid." LIMIT 1";
	}
	$query = mysqli_query($db, $consulta);
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	} else {
			/* No existe este presupuesto o no esta relacionado al ID del usuario logueado */
			?>
				NO EXISTE PUNTO
			<?php
			exit;
	}
	@mysqli_free_result($query);
	
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Ver Punto ( #<?=$gid?> )</p>
	
	<div style="width:90%; margin:0 auto;">
		
		<br/>

		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Nombre del punto:</span> 
			<span><?=$row['nombre']; ?></span>
		</p>
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Direccion:</span> 
			<span><?=$row['direccion']; ?></span>
		</p>	
		<div style="clear:both;"></div>
	</div>


</div> <!-- end #cuerpo_action -->



<?php
}
/* *************************************** AREA PARA IMPRIMIR ********************************* */
?>


<script>
	$(".print").click( function() {
			window.print();
			
			return false;
	});
</script>