<?php
if(   isset($_GET['tid']) && $_GET['tid']>0   ) {
	$tid = $_GET['tid'];

	/* Verificamos que el articulo EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM ticket WHERE TID=".$tid." LIMIT 1";
	}
	$query = mysqli_query($db, $consulta);
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	} else {
			/* No existe este cliente o no esta relacionado al ID del usuario logueado */
			?>
				No tienes permisos
			<?php
			exit;
	}
	@mysqli_free_result($query);
	
	
	$mes = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Ver Ticket: <?=$row['TID']?> (<?=$tid?>)</p>
	
	<div style="width:90%; margin:0 auto;">
		
		
		<br/><br/>
		<hr/>
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">CLIENTE:</span> 
			<span><?=$row['nombres']; ?></span>
		</p>

		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">DIRECCIÓN:</span> 
			<span><?=$row['direccion']; ?></span>
		</p>	
		<hr/><br/>
		
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Telefono:</span> 
			<span><?=$row['telefono']?></span>
		</p>
		
		<p style="background:#eee; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Email:</span> 
			<span><?=$row['email']?></span>
		</p>

		
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Status:</span> 
			<?php
				switch(   $row['status']   ) {

					case 1:
						$status = '<span style="display:inline-block; background:#81F7F3; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> No resuelto';
							break;
					case 2:
						$status = '<span style="display:inline-block; background:#F3F781; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Revisando caso';
							break;
					case 3:
						$status = '<span style="display:inline-block; background:#FE2E2E; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Resuelto';
							break;
				
				}
				
				echo $status;
			?>
		</p>
		
		<p style="background:#eee; line-height:32px; padding:2px 1px; width:49%; float:left;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Fecha emision:</span> 
			<?php
				$f = explode(" ",$row['fecha']);
				$f = explode("-",$f[0]);
				
				if(   ($f[0]+0)>0   ) {
						$fechae =  $f[2]." ".$mes[   ($f[1]-1)   ]." ".$f[0];
				} else {
						$fechae =  "N/A";
				}
				echo $fechae;
			?>
		</p>

		
		<div style="clear:both;"></div>
	</div>
	
	
	<div style="width:90%; margin:0 auto;">
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:block; padding:0 10px; background:#ccc; border-radius:2px;">Notas:</span> 
			
			<span style="display:inline-block; line-height:20px;">
				<?=$row['notas']?>
			</span>
		</p>
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:block; padding:0 10px; background:#ccc; border-radius:2px;">Respuesta Final del ticket:</span> 
			
			<span style="display:inline-block; line-height:20px;">
				<?=$row['respuesta']?>
			</span>
		</p>
		

	
		
	</div>
</div> <!-- end #cuerpo_action -->

<?php
}
/* *************************************** AREA PARA IMPRIMIR ********************************* */
?>
