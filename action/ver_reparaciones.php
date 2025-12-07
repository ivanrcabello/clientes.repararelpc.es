<?php
	$last = (   isset($_GET['last'])   )? $_GET['last'] : 0 ;
	$filtro = (   isset($_GET['filtro'])   )? $_GET['filtro'] : -1 ;
?>
<style>
#article-id-<?=$last?> {
    box-shadow: 0 0 3px 1px red;
    position: relative;
    z-index: 999;
}
.search {
  margin-top: 0.6rem;
  display: flex;
  justify-content: start;
  align-items: center;
  gap: 0.4rem;
}
.search input {
  height: 1.6rem;
  width: 12rem;
  border-radius: 4px;
  padding: 0rem 0.4rem 0rem 0.4rem;
}
.button.norden {
  background: black;
  color: white;
  padding: 0.4rem 2rem 0.4rem 2rem;
  font-size: 0.8rem;
  border-radius: 4px;
}
</style>
<?php
/* PAGINADOR */
$slug = '?action=ver_reparaciones';
$current = (   isset($_GET['page'])   )? $_GET['page'] : 1 ;
	$current = (   $current>0   )? $current : 1 ;
$post_per_page = 50;

		//Total de resultados
		if($_SESSION['admin']==1) {
		if(   isset($_GET['orden'])   ) {
		    $t_consulta = "SELECT * FROM articulos  WHERE UID = ".$_SESSION['ID']." AND AID=".$_GET['orden'];
		}
		else if(   $filtro>=0 && $filtro<14   ) {
			$t_consulta = "SELECT * FROM articulos  WHERE UID = ".$_SESSION['ID']." AND status=".$filtro;
		} else {
			$t_consulta = "SELECT * FROM articulos WHERE UID = ".$_SESSION['ID'];
		}
		} else if($_SESSION['admin']==0) {

			$t_consulta = "SELECT * FROM articulos WHERE status = 11";
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
	<p id="cabecera_action">Inicio > Ver Reparaciones</p>
	
	<?php
			/* Extraemos los articulos */
			if($_SESSION['admin']==1) {
			if(   isset($_GET['orden'])   ) {
		        $consulta = "SELECT * FROM articulos  WHERE UID = ".$_SESSION['ID']." AND AID=".$_GET['orden'];
		    }
		    else if(   $filtro>=0 && $filtro<=14   ) {
				$consulta = "SELECT * FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=".$filtro." ORDER BY AID DESC LIMIT ".$apartir_limit.",".$post_per_page;
			} else {
				$consulta = "SELECT * FROM articulos WHERE UID = ".$_SESSION['ID']." ORDER BY AID DESC LIMIT ".$apartir_limit.",".$post_per_page;
			}
			
			
		
		} else if($_SESSION['admin']==0) {
		   

				$consulta = "SELECT * FROM articulos WHERE status=11 ORDER BY AID DESC LIMIT ".$apartir_limit.",".$post_per_page;

			
		}
			$query = mysqli_query($db, $consulta);
	?>
	
	<?php
			/* Extraemos totales de los filtros */
			$consulta1 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=0");
			$consulta2 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=1");
			$consulta3 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=2");
			$consulta4 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=3");
			$consulta6 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=4");
			$consulta5 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']);
			$consulta10 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=10");
			if($_SESSION['admin']==1) {
			$consulta11 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=11");
			$consulta12 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=12");
			$consulta13 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=13");
			$consulta14 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=14");
			}
			else {
			    $consulta11 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE status=11");
			}

			$t1 = mysqli_fetch_row($consulta1);
			$t2 = mysqli_fetch_row($consulta2);
			$t3 = mysqli_fetch_row($consulta3);
			$t4 = mysqli_fetch_row($consulta4);
			$t6 = mysqli_fetch_row($consulta6);
			$t5 = mysqli_fetch_row($consulta5);
			$t10 = mysqli_fetch_row($consulta10);
			$t11 = mysqli_fetch_row($consulta11);
			$t12 = mysqli_fetch_row($consulta12);
			$t13 = mysqli_fetch_row($consulta13);
			$t14 = mysqli_fetch_row($consulta14);
			
			@mysqli_free_result($consulta1);
			@mysqli_free_result($consulta2);
			@mysqli_free_result($consulta3);
			@mysqli_free_result($consulta4);
			@mysqli_free_result($consulta6);
			@mysqli_free_result($consulta5);
	?>
	<div class="filtros">
		<strong>Filtros:</strong> 
		    <?php if($_SESSION['admin']==0){ ?>
		    <a href="<?=$slug?>&filtro=11" <?php if($filtro==11){echo 'class="activate"';} ?> >Electrónica (<?=$t11[0]?>)</a>
		    <?php } else if($_SESSION['admin']==1) { ?>
		    <a href="<?=$slug?>&filtro=11" <?php if($filtro==11){echo 'class="activate"';} ?> >Electrónica (<?=$t11[0]?>)</a>
			<a href="<?=$slug?>&filtro=10" <?php if($filtro==10){echo 'class="activate"';} ?> >Sin recepcionar (<?=$t10[0]?>)</a>
			<a href="<?=$slug?>&filtro=0" <?php if($filtro==0){echo 'class="activate"';} ?> >Recibidos (<?=$t1[0]?>)</a>
			<a href="<?=$slug?>&filtro=1" <?php if($filtro==1){echo 'class="activate"';} ?> >En Reparación (<?=$t2[0]?>)</a>
			<a href="<?=$slug?>&filtro=2" <?php if($filtro==2){echo 'class="activate"';} ?> >Reparados (<?=$t3[0]?>)</a>
			<a href="<?=$slug?>&filtro=3" <?php if($filtro==3){echo 'class="activate"';} ?> >Entregados (<?=$t4[0]?>)</a>
			<a href="<?=$slug?>&filtro=4" <?php if($filtro==4){echo 'class="activate"';} ?> >En Garantía (<?=$t6[0]?>)</a>
			<a href="<?=$slug?>&filtro=12" <?php if($filtro==12){echo 'class="activate"';} ?> >No reparable (<?=$t12[0]?>)</a>
			<a href="<?=$slug?>&filtro=13" <?php if($filtro==13){echo 'class="activate"';} ?> >Esperando material (<?=$t13[0]?>)</a>
			<a href="<?=$slug?>&filtro=14" <?php if($filtro==14){echo 'class="activate"';} ?> >Presupuestando (<?=$t14[0]?>)</a>
			
			<a href="<?=$slug?>&nofilter=true" <?php if($filtro<0){echo 'class="activate"';} ?> >Todos (<?=$t5[0]?>)</a>
			<?php } ?>
		<div class="search"><strong>Buscar por número de orden:</strong><input type="text" name="orden" class="orden" id="orden" placeholder="12345" oninput="buscar(event);"><a class="button norden" href="">Buscar</a></div>
	</div>

	<div id="lista_tabla">
		<div class="lista_row cabecera">
		    <span class="id">ID</span>
			<span class="cname">Cliente</span>
			<span class="cdir">Dirección</span>
			<span class="cphone">Status</span>
			<span class="cemail">Fecha Ent/Sal</span>
			<span class="actions">Acciones</span>
		</div>
	<?php
		if(   mysqli_num_rows($query)>0   ) {
				//$mes = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
				
				$aux = 1;
				while(   $row =  mysqli_fetch_array($query, MYSQLI_ASSOC)   ) {
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
								case 4:     $status = 'En garantía';
										$box = '<span style="display:inline-block; background:#9E9E9E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
									break;
								case 10:     $status = 'Sin recepcionar';
										$box = '<span style="display:inline-block; background:#4E9E4E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
									break;
								case 11:     $status = 'Electrónica';
										$box = '<span style="display:inline-block; background:#4A3E2E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
									break;
									case 12:     $status = 'No reparable';
										$box = '<span style="display:inline-block; background:#4A1E2A; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
									break;
									case 13:     $status = 'Esperando material';
										$box = '<span style="display:inline-block; background:#400E2E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
									break;
									case 14:     $status = 'Presupuestando';
										$box = '<span style="display:inline-block; background:#4A1A0E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
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
					<!-- <span class="cname"><?=$row['articulo']?></span> -->
					<span class="id"><?=$row['AID']?></span>
					<span class="cname"><?=$cliente?></span>
					<span class="cdir"><?=$direccion?></span>
					<span class="cphone e_status" id="e_status_<?=$row['AID']?>" data-aid="<?=$row['AID']?>"><?=$box.''.$status?></span>  
					<span class="cemail"><?=$datee?> / <?=$dates?></span>
					<span class="actions">
						<a href="?action=ver_reparacion&aid=<?=$row['AID']?>" title="Ver Ficha"><img src="img/view.png" /></a>
						<a href="?action=edit_reparacion&aid=<?=$row['AID']?>" title="Editar"><img src="img/edit.png" /></a>
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
		 <?php if($_SESSION['admin']==1){ ?>
		<a href="download_status.php?status=-9" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#000; color:#fff;">Todo</a>
		<a href="download_status.php?status=11" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#4A3E2E; color:#fff;">Electrónica</a>
		<a href="download_status.php?status=10" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#111; color:#fff;">Sin recepcionar</a>
		<a href="download_status.php?status=0" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#111; color:#fff;">Recibidos</a>
		<a href="download_status.php?status=1" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#222; color:#fff;">En Reparación</a>
		<a href="download_status.php?status=2" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#333; color:#fff;">Ya Reparados</a>
		<a href="download_status.php?status=3" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#444; color:#fff;">Entregados</a>
		<a href="download_status.php?status=3" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#555; color:#fff;">No reparable</a>
		<a href="download_status.php?status=12" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#666; color:#fff;">Esperando material</a>
		<a href="download_status.php?status=3" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#777; color:#fff;">Presupuestando</a>
		<?php } else if($_SESSION['admin']==0) { ?>
		<a href="download_status.php?status=11" style="display:inline-block; height:46px; line-height:46px; padding:0 12px; background:#4A3E2E; color:#fff;">Electrónica</a>
		<?php } ?>
		
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
<script>
    function buscar(event) {
        document.querySelector(".button.norden").href = "https://clientes.repararelpc.es/panel.php?action=ver_reparaciones&orden=" + event.currentTarget.value;
    }
</script>