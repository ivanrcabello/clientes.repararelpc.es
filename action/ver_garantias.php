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
$slug = '?action=ver_garantias';
$current = (   isset($_GET['page'])   )? $_GET['page'] : 1 ;
	$current = (   $current>0   )? $current : 1 ;
$post_per_page = 50;

		//Total de resultados
		if($_SESSION['admin']==1) {
		if(   isset($_GET['orden'])   ) {
		    $t_consulta = "SELECT * FROM garantias AND id=".$_GET['orden'];
		}
		else if(   $filtro>=0 && $filtro<4   ) {
			$t_consulta = "SELECT * FROM garantias  WHERE AND status=".$filtro;
		} else {
			$t_consulta = "SELECT * FROM garantias";
		}
		} else if($_SESSION['admin']==0) {
			$t_consulta = "SELECT * FROM garantias WHERE status = 0";
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
	<p id="cabecera_action">Inicio > Ver Garantias</p>
	
	<?php
			/* Extraemos los articulos */
			if($_SESSION['admin']==1) {
			if(   isset($_GET['orden'])   ) {
		        $consulta = "SELECT * FROM garantias WHERE id=".$_GET['orden'];
		    }
		    else if(   $filtro>=0 && $filtro<=4   ) {
				$consulta = "SELECT * FROM garantias WHERE status=".$filtro." ORDER BY id DESC LIMIT ".$apartir_limit.",".$post_per_page;
			} else {
				$consulta = "SELECT * FROM garantias ORDER BY id DESC LIMIT ".$apartir_limit.",".$post_per_page;
			}
			
			
		
		} else if($_SESSION['admin']==0) {
		   

				$consulta = "SELECT * FROM garantias WHERE status=0 ORDER BY id DESC LIMIT ".$apartir_limit.",".$post_per_page;

			
		}
			$query = mysqli_query($db, $consulta);
	?>
	
	<?php
			if($_SESSION['admin']==1) {
    			$consulta1 = mysqli_query($db, "SELECT COUNT(*) FROM garantias WHERE status=0");
    			$consulta2 = mysqli_query($db, "SELECT COUNT(*) FROM garantias WHERE status=1");
    			$consulta3 = mysqli_query($db, "SELECT COUNT(*) FROM garantias WHERE status=2");
    			$consulta4 = mysqli_query($db, "SELECT COUNT(*) FROM garantias WHERE status=3");
    			$consulta5 = mysqli_query($db, "SELECT COUNT(*) FROM garantias WHERE status=4");
    			$consulta6 = mysqli_query($db, "SELECT COUNT(*) FROM garantias");
			}

			$t1 = mysqli_fetch_row($consulta1);
			$t2 = mysqli_fetch_row($consulta2);
			$t3 = mysqli_fetch_row($consulta3);
			$t4 = mysqli_fetch_row($consulta4);
			$t5 = mysqli_fetch_row($consulta5);
			$t6 = mysqli_fetch_row($consulta6);
			
			@mysqli_free_result($consulta1);
			@mysqli_free_result($consulta2);
			@mysqli_free_result($consulta3);
			@mysqli_free_result($consulta4);
			@mysqli_free_result($consulta5);
			@mysqli_free_result($consulta6);
	?>
	<div class="filtros">
		<strong>Filtros:</strong> 
		    <?php if ($_SESSION['admin']==1) { ?>
		    <a href="<?=$slug?>&filtro=0" <?php if($filtro==0){echo 'class="activate"';} ?> >Solicitudes (<?=$t1[0]?>)</a>
		    <a href="<?=$slug?>&filtro=1" <?php if($filtro==1){echo 'class="activate"';} ?> >En reparación (<?=$t2[0]?>)</a>
			<a href="<?=$slug?>&filtro=2" <?php if($filtro==2){echo 'class="activate"';} ?> >Reparado (<?=$t3[0]?>)</a>
			<a href="<?=$slug?>&filtro=3" <?php if($filtro==3){echo 'class="activate"';} ?> >Entregado (<?=$t4[0]?>)</a>
			<a href="<?=$slug?>&filtro=4" <?php if($filtro==4){echo 'class="activate"';} ?> >No apto para garantía (<?=$t5[0]?>)</a>
			<a href="<?=$slug?>&nofilter=true" <?php if($filtro<0){echo 'class="activate"';} ?> >Todos (<?=$t6[0]?>)</a>
			<?php } ?>
		<div class="search"><strong>Buscar por número de solicitud:</strong><input type="text" name="orden" class="orden" id="orden" placeholder="12345" oninput="buscar(event);"><a class="button norden" href="">Buscar</a></div>
	</div>

	<div id="lista_tabla">
		<div class="lista_row cabecera">
		    <span class="id">ID</span>
			<span class="cname"># Orden</span>
			<span class="cdir">Descripción de la solicitud</span>
			<span class="cphone">Status</span>
			<span class="cemail">Fecha de solicitud</span>
			<span class="actions">Acciones</span>
		</div>
	<?php
		if(   mysqli_num_rows($query)>0   ) {
				//$mes = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
				
				$aux = 1;
				while(   $row =  mysqli_fetch_array($query, MYSQLI_ASSOC)   ) {
						switch(   $row['status']   ) {
								case 0:     $status = 'Solicitado';
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
								case 4:     $status = 'No apto para la garantía';
										$box = '<span style="display:inline-block; background:#9E9E9E; vertical-align:top; width:15px; height:15px; border-radius:3px;"></span>';
									break;
								default:    $status = 'N/A';
										$box = '';
									break;
						}
					
									
						$fecha = explode(' ', $row['fecha']);
						$fecha = explode('-', $fecha[0]);
						$datee = (   $fecha[0]>0   )? $fecha[2].'-'.$fecha[1].'-'.substr($fecha[0],2,2) : '---' ;
							
			?>
				<div id="article-id-<?=$row['id']?>" class="lista_row <?php if($aux%2==1){echo 'par';}else{echo 'inpar';} ?>">
					<span class="id"><?=$row['id']?></span>
					<span class="cname"><?=$row['AID']?></span>
					<span class="cdir"><?=$row['descripcion']?></span>
					<span class="cphone e_status" id="e_status_<?=$row['id']?>" data-aid="<?=$row['id']?>"><?=$box.''.$status?></span>  
					<span class="cemail"><?=$datee?></span>
					<span class="actions">
						<a href="?action=ver_garantia&aid=<?=$row['id']?>" title="Ver Ficha"><img src="img/view.png" /></a>
						<a href="?action=edit_garantia&aid=<?=$row['id']?>" title="Editar"><img src="img/edit.png" /></a>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="?action=delete_garantia&aid=<?=$row['id']?>" title="Eliminar"><img src="img/trash.png" /></a>
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
        document.querySelector(".button.norden").href = "https://clientes.repararelpc.es/panel.php?action=ver_garantias&orden=" + event.currentTarget.value;
    }
</script>