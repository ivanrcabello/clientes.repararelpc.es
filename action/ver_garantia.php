<?php

if(   isset($_GET['aid']) && $_GET['aid']>0   ) {
	$aid = $_GET['aid'];

	/* Verificamos que el articulo EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM garantias WHERE id=".$aid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM garantias WHERE status = 0 AND id=".$aid." LIMIT 1";
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
	<p id="cabecera_action">Inicio > Ver Garantía: <?=$row['descripcion']?> (<?=$aid?>)</p>
	
	<div style="width:90%; margin:0 auto;">
		
		<br/>
		
		<h2 style="margin-bottom:0.8rem">Ficha</h2>
		
		<p style="background:#fff; line-height:32px; padding:2px 1px;margin-bottom: 0.2rem;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;"># Solicitud de garantía:</span> 
			<span><?=$row['id']?></span>
		</p>
		
		<p style="background:#fff; line-height:32px; padding:2px 1px;margin-bottom: 0.2rem;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;"># de órden:</span> 
			<span><?=$row['AID']?></span>
		</p>
		
		<p style="background:#fff; line-height:32px; padding:2px 1px;margin-bottom: 0.2rem;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Descripción de la solicitud:</span> 
			<span><?=$row['descripcion']?></span>
		</p>
		
		<p style="background:#fff; line-height:32px; padding:2px 1px;margin-bottom: 0.2rem;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Status:</span> 
			<?php
				switch(   $row['status']   ) {
				    case 0:
						$status = '<span style="display:inline-block; background:#4A3E2E; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Solicitado';
							break;
					case 1:
						$status = '<span style="display:inline-block; background:#81F7F3; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> En reparación';
							break;
					case 2:
						$status = '<span style="display:inline-block; background:#F3F781; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Ya reparado';
							break;
					case 3:
						$status = '<span style="display:inline-block; background:#FE2E2E; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Entregado';
							break;
					case 4:
						$status = '<span style="display:inline-block; background:#40FF00; vertical-align:middle; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> No apto para garantía';
							break;
				}
				
				echo $status;
			?>
		</p>
		
		<p style="background:#fff; line-height:32px; padding:2px 1px;margin-bottom: 0.2rem;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Fecha:</span> 
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
	
	
</div> <!-- end #cuerpo_action -->

<?php
}
/* *************************************** AREA PARA IMPRIMIR ********************************* */
?>
