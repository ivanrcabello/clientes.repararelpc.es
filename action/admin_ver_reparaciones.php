<?php
if(   $_SESSION['admin']==1   ) {
	$last = (   isset($_GET['last'])   )? $_GET['last'] : 0 ;
	$filtro = (   isset($_GET['filtro'])   )? $_GET['filtro'] : -1 ;
?>
<style>
#article-id-<?=$last?> {
    box-shadow: 0 0 3px 1px red;
    position: relative;
    z-index: 999;
}
</style>
<?php
/* PAGINADOR */
$slug = '?action=admin_ver_reparaciones';
$current = (   isset($_GET['page'])   )? $_GET['page'] : 1 ;
	$current = (   $current>0   )? $current : 1 ;
$post_per_page = 50;

		//Total de resultados
		if(   $filtro>=0 && $filtro<=4   ) {
			$t_consulta = "SELECT * FROM articulos WHERE status=".$filtro;
		} else {
			$t_consulta = "SELECT * FROM articulos";
		}
		$t_query = mysqli_query($db, $t_consulta);
$total = mysqli_num_rows( $t_query );
		@mysqli_free_result( $t_query );
$total_pages = ceil($total / $post_per_page);
	$total_pages = (   $total_pages>0   )? $total_pages : 1 ;
$apartir = ( ($current-3)>1 )? $current-3 : 1 ;
$hasta =  ( ($current+3)<$total_pages )? $current+3 : $total_pages ;

$apartir_limit = ($current*$post_per_page)-$post_per_page;
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Ver Todas las Reparaciones</p>
	
	<?php
			/* Extraemos los articulos */
			if(   $filtro>=0 && $filtro<=4   ) {
				$consulta = "SELECT * FROM articulos WHERE status=".$filtro." ORDER BY AID DESC LIMIT ".$apartir_limit.",".$post_per_page;
			} else {
				$consulta = "SELECT * FROM articulos ORDER BY AID DESC LIMIT ".$apartir_limit.",".$post_per_page;
			}
			$query = mysqli_query($db, $consulta);
	?>
	<?php
			/* Extraemos totales de los filtros */
			$consulta1 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE status=0");
			$consulta2 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE status=1");
			$consulta3 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE status=2");
			$consulta4 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE status=3");
			$consulta6 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE status=4");
			$consulta5 = mysqli_query($db, "SELECT COUNT(*) FROM articulos");
			
			$t1 = mysqli_fetch_row($consulta1);
			$t2 = mysqli_fetch_row($consulta2);
			$t3 = mysqli_fetch_row($consulta3);
			$t4 = mysqli_fetch_row($consulta4);
			$t6 = mysqli_fetch_row($consulta6);
			$t5 = mysqli_fetch_row($consulta5);
			
			@mysqli_free_result($consulta1);
			@mysqli_free_result($consulta2);
			@mysqli_free_result($consulta3);
			@mysqli_free_result($consulta4);
			@mysqli_free_result($consulta6);
			@mysqli_free_result($consulta5);
	?>
	<div class="filtros">
		<strong>Filtros:</strong> 
			<a href="<?=$slug?>&filtro=0" <?php if($filtro==0){echo 'class="activate"';} ?> >Recibidos (<?=$t1[0]?>)</a>
			<a href="<?=$slug?>&filtro=1" <?php if($filtro==1){echo 'class="activate"';} ?> >En Reparación (<?=$t2[0]?>)</a>
			<a href="<?=$slug?>&filtro=2" <?php if($filtro==2){echo 'class="activate"';} ?> >Reparados (<?=$t3[0]?>)</a>
			<a href="<?=$slug?>&filtro=3" <?php if($filtro==3){echo 'class="activate"';} ?> >Entregados (<?=$t4[0]?>)</a>
			<a href="<?=$slug?>&filtro=4" <?php if($filtro==4){echo 'class="activate"';} ?> >En garantía (<?=$t6[0]?>)</a>
			<a href="<?=$slug?>&nofilter=true" <?php if($filtro<0){echo 'class="activate"';} ?> >Todos (<?=$t5[0]?>)</a>
	</div>

	<div id="lista_tabla">
		<div class="lista_row cabecera">
			<span class="cname">Cliente</span>
			<span class="cdir">Dirección</span>
			<span class="cphone">Status</span>
			<span class="cemail">Fecha Ent/Sal</span>
			<span class="actions">Acciones</span>
		</div>
	<?php
		if(   mysqli_num_rows($query)>0   ) {
				$aux = 1;
				while(   $row =  mysqli_fetch_array($query, MYSQLI_ASSOC)   ) {
						//$mes = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
						
						switch(   $row['status']   ) {
								case 0:     $status = 'Recibido';
										$box = '<span style="display:inline-block; background:#81F7F3; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
									break;
								case 1:     $status = 'En Reparación';
										$box = '<span style="display:inline-block; background:#F3F781; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
									break;
								case 2:     $status = 'Ya Reparado';
										$box = '<span style="display:inline-block; background:#FE2E2E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
									break;
								case 3:     $status = 'Entregado al Cte';
										$box = '<span style="display:inline-block; background:#40FF00; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
									break;
								case 4:     $status = 'En Garantía';
										$box = '<span style="display:inline-block; background:#9E9E9E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
									break;
								default:    $status = 'N/A';
										$box = '';
									break;
						}
						
									
						$fecha = explode(' ', $row['fecha_entrada']);
							$fecha = explode('-', $fecha[0]);
							$datee = (   $fecha[0]>0   )? $fecha[2].'-'.$fecha[1].'-'.substr($fecha[0],2,2) : '---' ;
						$fecha = explode(' ', $row['fecha_salida']);
							$fecha = explode('-', $fecha[0]);
							$dates = (   $fecha[0]>0   )? $fecha[2].'-'.$fecha[1].'-'.substr($fecha[0],2,2) : '---' ;
							
						/* Extraemos Cliente */
						$c = "SELECT name, address FROM clientes WHERE CID=".$row['CID']." LIMIT 1";
						$q = mysqli_query($db, $c);
						if(   mysqli_num_rows($q)>0   ) {
								$r = mysqli_fetch_array($q, MYSQLI_ASSOC);
								$cliente = $r['name'];
								$direccion = $r['address'];
						} else {
								$cliente = '?';
								$direccion = 'N/A';
						}
						@mysqli_free_result($q);
					?>
				<div id="article-id-<?=$row['AID']?>" class="lista_row <?php if($aux%2==1){echo 'par';}else{echo 'inpar';} ?>">
					<span class="cname"><?=$cliente?></span>
					<span class="cdir"><?=$direccion?></span>
					<span class="cphone e_status" id="e_status_<?=$row['AID']?>" data-aid="<?=$row['AID']?>"><?=$box.''.$status?></span>
					<span class="cemail"><?=$datee?> / <?=$dates?></span>
					<span class="actions">
						<a href="?action=ver_reparacion&aid=<?=$row['AID']?>" title="Ver Ficha"><img src="img/view.png" /></a>
						<a href="?action=admin_edit_reparacion&aid=<?=$row['AID']?>" title="Editar"><img src="img/edit.png" /></a>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="?action=delete_reparacion&aid=<?=$row['AID']?>" title="Eliminar"><img src="img/trash.png" /></a>
					</span>
				</div>
			<?php
				$aux++;
				} // end while
		} else { // end IF mysqli_num_rows
				?>
					<p>No hay Resultados.</p>
				<?php
		}
		@mysqli_free_result( $query );
	?>
	</div> <!-- end #lista_tabla -->
<!-- EXPORTAS ******************************************************************************************* -->
	<p style="width:90%; margin:10px auto; padding:10px; background:#ddd;">
		Exportar: <br/>
		<a href="download_status.php?status=-9" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#000; color:#fff;">Todo</a>
		<a href="download_status.php?status=0" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#111; color:#fff;">Recibidos</a>
		<a href="download_status.php?status=1" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#222; color:#fff;">En Reparación</a>
		<a href="download_status.php?status=2" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#333; color:#fff;">Ya Reparados</a>
		<a href="download_status.php?status=3" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#444; color:#fff;">Entregados</a>
	</p>
	
	<p style="width:90%; margin:5px auto 0 auto; color:#444;">
		<span style="display:inline-block; background:#81F7F3; vertical-align:top; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> El cliente a dejado el articulo en la empresa.<br/>
		<span style="display:inline-block; background:#F3F781; vertical-align:top; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Actualmente está siendo reparado.<br/>
		<span style="display:inline-block; background:#FE2E2E; vertical-align:top; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> El articulo ya está reparado, pero aun no ha sido entregado al cliente.<br/>
		<span style="display:inline-block; background:#40FF00; vertical-align:top; width:15px; height:15px; border-radius:3px; border:1px solid #ccc;"></span> Articulo entregado al cliente.
	</p>
	
	<?php
		$slug = (   $filtro>=0 && $filtro<=3   )?   $slug .= '&filtro='.$filtro : $slug ;
	?>
	<ul id="paginador">
		<li><a href="<?=$slug?>&page=1" class="item-pag">Primero</a></li>
		<?php
			for($i=$apartir; $i<=$hasta; $i++) {
					if( $i == $current ) {
							?>
							<li><span class="item-pag current"><?=$i?></span></li>
							<?php
					} else {
							?>
							<li><a href="<?=$slug?>&page=<?=$i?>" class="item-pag"><?=$i?></a></li>
							<?php
					}
			}
		?>
		<li><a href="<?=$slug?>&page=<?=$total_pages?>" class="item-pag">Ultimo</a></li>
	</ul>
</div>
<?php
}
?>