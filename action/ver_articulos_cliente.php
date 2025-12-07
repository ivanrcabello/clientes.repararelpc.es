<?php
if(   isset($_GET['cid']) && $_GET['cid']>0   ) {
$cid = $_GET['cid'];
$filtro = (   isset($_GET['filtro'])   )? $_GET['filtro'] : -1 ;

/* PAGINADOR */
$slug = '?action=ver_articulos_cliente&cid='.$cid;
$current = (   isset($_GET['page'])   )? $_GET['page'] : 1 ;
$post_per_page = 50;

		//Total de resultados
		if(   $_SESSION['admin']==1   ) {
					if(   $filtro>=0 && $filtro<=3   ) {
							$t_consulta = "SELECT * FROM articulos WHERE CID=".$cid." AND status=".$filtro;
					} else {
							$t_consulta = "SELECT * FROM articulos WHERE CID=".$cid;
					}
		} else {
					if(   $filtro>=0 && $filtro<=3   ) {
							$t_consulta = "SELECT * FROM articulos WHERE UID = ".$_SESSION['ID']." AND CID=".$cid." AND status=".$filtro;
					} else {
							$t_consulta = "SELECT * FROM articulos WHERE UID = ".$_SESSION['ID']." AND CID=".$cid;
					}
		}
		$t_query = mysqli_query($db, $t_consulta);
$total = mysqli_num_rows( $t_query );
		@mysqli_free_result( $t_query );
$total_pages = ceil($total / $post_per_page);
		$total_pages = (   $total_pages>0   )? $total_pages : 1 ;
$apartir = ( ($current-3)>1 )? $current-3 : 1 ;
$hasta =  ( ($current+3)<$total_pages )? $current+3 : $total_pages ;

$apartir_limit = ($current*$post_per_page)-$post_per_page;


/* Extraemos el NOMBRE del cliente */
if(   $_SESSION['admin']==1   ) {
	$consulta = "SELECT name FROM clientes WHERE CID=".$cid." LIMIT 1";
} else {
	$consulta = "SELECT name FROM clientes WHERE UID = ".$_SESSION['ID']." AND CID=".$cid." LIMIT 1";
}
$query = mysqli_query($db, $consulta);
if(   mysqli_num_rows($query)>0   ) {
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		$nombre = $row['name'];
} else {
		/* No existe este cliente o no esta relacionado al ID del usuario logueado */
		?>
			NO EXISTE
		<?php
		exit;
}
@mysqli_free_result($query);
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Ver Articulos del cliente: <span style="text-decoration:underline;"><?=$nombre?> (<?=$total?> articulos)</span></p>
	
	<?php
			/* Extraemos los articulos */
			if(   $_SESSION['admin']==1   ) {
					if(   $filtro>=0 && $filtro<=3   ) {
							$consulta = "SELECT * FROM articulos WHERE cid=".$cid." AND status=".$filtro." ORDER BY AID DESC LIMIT ".$apartir_limit.",".$post_per_page;
					} else {
							$consulta = "SELECT * FROM articulos WHERE cid=".$cid." ORDER BY AID DESC LIMIT ".$apartir_limit.",".$post_per_page;
					}
			} else {
					if(   $filtro>=0 && $filtro<=3   ) {
							$consulta = "SELECT * FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=".$filtro." AND cid=".$cid." ORDER BY AID DESC LIMIT ".$apartir_limit.",".$post_per_page;
					} else {
							$consulta = "SELECT * FROM articulos WHERE UID = ".$_SESSION['ID']." AND cid=".$cid." ORDER BY AID DESC LIMIT ".$apartir_limit.",".$post_per_page;
					}
			}
			$query = mysqli_query($db, $consulta);
	?>
	<?php
			/* Extraemos totales de los filtros */
			if(   $_SESSION['admin']==1   ) {
				$consulta1 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE status=0 AND cid=".$cid);
				$consulta2 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE status=1 AND cid=".$cid);
				$consulta3 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE status=2 AND cid=".$cid);
				$consulta4 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE status=3 AND cid=".$cid);
				$consulta5 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE cid=".$cid);

			} else {
				$consulta1 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=0 AND cid=".$cid);
				$consulta2 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=1 AND cid=".$cid);
				$consulta3 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=2 AND cid=".$cid);
				$consulta4 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND status=3 AND cid=".$cid);
				$consulta5 = mysqli_query($db, "SELECT COUNT(*) FROM articulos WHERE UID = ".$_SESSION['ID']." AND cid=".$cid);
			}
			$t1 = mysqli_fetch_row($consulta1);
			$t2 = mysqli_fetch_row($consulta2);
			$t3 = mysqli_fetch_row($consulta3);
			$t4 = mysqli_fetch_row($consulta4);
			$t5 = mysqli_fetch_row($consulta5);
			
			@mysqli_free_result($consulta1);
			@mysqli_free_result($consulta2);
			@mysqli_free_result($consulta3);
			@mysqli_free_result($consulta4);
			@mysqli_free_result($consulta5);
	?>
	<div class="filtros">
		<strong>Filtros:</strong> 
			<a href="<?=$slug?>&filtro=0" <?php if($filtro==0){echo 'class="activate"';} ?> >Recibidos (<?=$t1[0]?>)</a>
			<a href="<?=$slug?>&filtro=1" <?php if($filtro==1){echo 'class="activate"';} ?> >En Reparación (<?=$t2[0]?>)</a>
			<a href="<?=$slug?>&filtro=2" <?php if($filtro==2){echo 'class="activate"';} ?> >Reparados (<?=$t3[0]?>)</a>
			<a href="<?=$slug?>&filtro=3" <?php if($filtro==3){echo 'class="activate"';} ?> >Entregados (<?=$t4[0]?>)</a>
			<a href="<?=$slug?>&nofilter=true" <?php if($filtro<0){echo 'class="activate"';} ?> >Todos (<?=$t5[0]?>)</a>
	</div>

	<div id="lista_tabla">
		<div class="lista_row cabecera">
			<span class="cname">Articulo</span>
			<span class="cphone">Estado</span>
			<span class="cemail">Fechan Entrada</span>
			<span class="actions">Acciones</span>
		</div>
	<?php
		if(   mysqli_num_rows($query)>0   ) {
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
								default:    $status = 'N/A';
										$box = '';
									break;
						}
						
									
						$fecha = explode(' ', $row['fecha_entrada']);
							$fecha = explode('-', $fecha[0]);
							$mes = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
							$date = (   $fecha[0]>0   )? $fecha[2].' '.$mes[ ($fecha[1]-1) ].' '.$fecha[0] : 'N/A' ;				
			?>
				<div class="lista_row <?php if($aux%2==1){echo 'par';}else{echo 'inpar';} ?>">
					<span class="cname"><?=$row['articulo']?></span>
					<span class="cphone"><?=$box.''.$status?></span>
					<span class="cemail"><?=$date?></span>
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