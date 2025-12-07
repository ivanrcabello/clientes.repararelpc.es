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
</style>
<?php
/* PAGINADOR */
$slug = '?action=ver_tickets';
$current = (   isset($_GET['page'])   )? $_GET['page'] : 1 ;
	$current = (   $current>0   )? $current : 1 ;
$post_per_page = 50;

		//Total de resultados
		if($_SESSION['admin']==1) {
		if(   $filtro>=0 && $filtro<3   ) {
			$t_consulta = "SELECT * FROM ticket WHERE UID = ".$_SESSION['ID']." AND status=".$filtro;
		} else {
			$t_consulta = "SELECT * FROM ticket WHERE UID = ".$_SESSION['ID'];
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
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Ver tickets</p>
	
	<?php
			/* Extraemos los articulos */
			if($_SESSION['admin']==1) {
		    if(   $filtro>=0 && $filtro<=3   ) {
				$consulta = "SELECT * FROM ticket WHERE status=".$filtro." ORDER BY TID DESC LIMIT ".$apartir_limit.",".$post_per_page;
			} else {
				$consulta = "SELECT * FROM ticket ORDER BY TID DESC LIMIT ".$apartir_limit.",".$post_per_page;
			}
		
		} 
			$query = mysqli_query($db, $consulta);
	?>
	<?php
			/* Extraemos totales de los filtros */

			if($_SESSION['admin']==1) {
						$consulta1 = mysqli_query($db, "SELECT COUNT(*) FROM ticket WHERE UID = ".$_SESSION['ID']." AND status=1");
			$consulta2 = mysqli_query($db, "SELECT COUNT(*) FROM ticket WHERE UID = ".$_SESSION['ID']." AND status=2");
			$consulta3 = mysqli_query($db, "SELECT COUNT(*) FROM ticket WHERE UID = ".$_SESSION['ID']." AND status=3");
			$consulta5 = mysqli_query($db, "SELECT COUNT(*) FROM ticket WHERE UID = ".$_SESSION['ID']);
			}


			$t1 = mysqli_fetch_row($consulta1);
			$t2 = mysqli_fetch_row($consulta2);
			$t3 = mysqli_fetch_row($consulta3);
			$t5 = mysqli_fetch_row($consulta5);

			@mysqli_free_result($consulta1);
			@mysqli_free_result($consulta2);
			@mysqli_free_result($consulta3);
			@mysqli_free_result($consulta5);

	?>
	<div class="filtros">
		<strong>Filtros:</strong> 
<?php if($_SESSION['admin']==1) { ?>
		    <a href="<?=$slug?>&filtro=1" <?php if($filtro==1){echo 'class="activate"';} ?> >No resuelto (<?=$t1[0]?>)</a>
			<a href="<?=$slug?>&filtro=2" <?php if($filtro==2){echo 'class="activate"';} ?> > Revisando caso (<?=$t2[0]?>)</a>
			<a href="<?=$slug?>&filtro=3" <?php if($filtro==3){echo 'class="activate"';} ?> >Resuelto (<?=$t3[0]?>)</a>
			
			<a href="<?=$slug?>&nofilter=true" <?php if($filtro<0){echo 'class="activate"';} ?> >Todos (<?=$t5[0]?>)</a>
			<?php } ?>
	</div>

	<div id="lista_tabla">
		<div class="lista_row cabecera">
			<span class="cname">Nombres cliente</span>
			<span class="cdir">Telefono</span>
			<span class="cphone">Status</span>
			<span class="cemail">Fecha</span>
			<span class="actions">Acciones</span>
		</div>
	<?php
		if(   mysqli_num_rows($query)>0   ) {
				//$mes = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
				
				$aux = 1;
				while(   $row =  mysqli_fetch_array($query, MYSQLI_ASSOC)   ) {
						switch(   $row['status']   ) {
								case 1:     $status = 'No resuelto';
										$box = '<span style="display:inline-block; background:#81F7F3; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
									break;
								case 2:     $status = 'Revisando caso';
										$box = '<span style="display:inline-block; background:#F3F781; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
									break;
								case 3:     $status = 'Resuelto';
										$box = '<span style="display:inline-block; background:#FE2E2E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
									break;
	
								default:    $status = 'N/A';
										$box = '';
									break;
						}
						
									
						$fecha = explode(' ', $row['fecha']);
							$fecha = explode('-', $fecha[0]);
							$datee = (   $fecha[0]>0   )? $fecha[2].'-'.$fecha[1].'-'.substr($fecha[0],2,2) : '---' ;
					
							
			?>
				<div id="article-id-<?=$row['TID']?>" class="lista_row <?php if($aux%2==1){echo 'par';}else{echo 'inpar';} ?>">
					<!-- <span class="cname"><?=$row['nombres']?></span> -->
					<span class="cname"><?=$row['nombres']?></span>
					<span class="cdir"><?=$row['telefono']?></span>
				
					  	<span class="cphone i_status" id="i_status_<?=$row['TID']?>" data-tid="<?=$row['TID']?>"><?=$box.''.$status?></span>  
					  
					    
				
					<span class="cemail"><?=$datee?></span>
					<span class="actions">
						<a href="?action=ver_ticket&tid=<?=$row['TID']?>" title="Ver Ficha"><img src="img/view.png" /></a>
						<a href="?action=edit_ticket&tid=<?=$row['TID']?>" title="Editar"><img src="img/edit.png" /></a>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="?action=delete_ticket&tid=<?=$row['TID']?>" title="Eliminar"><img src="img/trash.png" /></a>
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
	</div> 


	
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