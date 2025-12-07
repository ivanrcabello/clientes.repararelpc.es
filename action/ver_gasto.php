<?php
if(   isset($_GET['id']) && $_GET['id']>0   ) {
	$gid = $_GET['id'];

	/* Verificamos que el articulo EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM gastos WHERE GID=".$gid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM gastos WHERE UID = ".$_SESSION['ID']." AND GID=".$gid." LIMIT 1";
	}
	$query = mysqli_query($db, $consulta);
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	} else {
			/* No existe este presupuesto o no esta relacionado al ID del usuario logueado */
			?>
				NO EXISTE PRESUPUESTO
			<?php
			exit;
	}
	@mysqli_free_result($query);
	
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Ver Gasto ( #<?=$gid?> )</p>
	
	<div style="width:90%; margin:0 auto;">
		
		<br/>
				
		<br/><br/>
		
		<p style="background:#A11; color:white; font-size:16px; padding:4px 14px; border-radius:4px; margin-right:3px; line-height:normal;
				height:100%;
display: inline-block;
">
			&euro; <?=$row['precioconiva']?><br/>
			<em style="font-size:11px;">(Precio con iva)</em>
		</p>
		<p style="background:#BC8B18; color:white; font-size:16px; padding:4px 14px; border-radius:4px; margin-right:3px; line-height:normal;
				height:100%;
display: inline-block;
margin-bottom: 10px;
">
			&euro; <?=$row['preciosiniva']?><br/>
			<em style="font-size:11px;">(Precio sin iva)</em>
		</p>

		<br/>


		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Concepto:</span> 
			<span><?=$row['concepto']; ?></span>
		</p>
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Proveedor:</span> 
			<span><?=$row['nombreproveedor']; ?></span>
		</p>	
		<div style="clear:both;"></div>
	</div>
	
	<div style="width:90%; margin:0 auto;">
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:block; padding:0 10px; background:#ccc; border-radius:2px;">Descripción:</span> 
			
			<span style="display:inline-block; line-height:20px;">
				<?=$row['descripcion']?>
			</span>
		</p>
		
		<br/>
				
		<br/>
		<br/>
		
	</div>

	<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:block; padding:0 10px; background:#ccc; border-radius:2px;">Fotos o documentos:</span> 
			<?php
				if(   $row['no_fotos']>0   ) {
						for($i=1; $i<=$row['no_fotos']; $i++) {
							 $img = 'uploads/'.$row['nombre_fotos'].'_'.$i;
							 $doc = '/'.$img;
							if(   file_exists($img.'.jpg')   ) {
									echo '<img src="'.$img.'.jpg" style="max-width:200px; vertical-align:top; margin:1px 3px;"/>';
							} elseif(   file_exists($img.'.jpeg')   ) {
									echo '<img src="'.$img.'.jpeg" style="max-width:200px; vertical-align:top; margin:1px 3px;"/>';
							} elseif(   file_exists($img.'.png')   ) {
									echo '<img src="'.$img.'.png" style="max-width:200px; vertical-align:top; margin:1px 3px;"/>';
							} elseif(   file_exists($img.'.gif')   ) {
									echo '<img src="'.$img.'.gif" style="max-width:200px; vertical-align:top; margin:1px 3px;"/>';
							} elseif(   file_exists($img.'.bmp')   ) {
									echo '<img src="'.$img.'.bmp" style="max-width:200px; vertical-align:top; margin:1px 3px;"/>';
							}
							elseif(   file_exists($img.'.doc')   ) {
								echo "<a href='$doc.doc'>Descargar documento</a>";
							}
							elseif(   file_exists($img.'.docx')   ) {
								echo "<a href='$doc.docx'>Descargar documento</a>";
								}
							elseif(   file_exists($img.'.pdf')   ) {
								echo "<a href='$doc.pdf'>Descargar documento</a>";
							}
							
						}
				}
			?>
		</p>
		
		<br/>
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