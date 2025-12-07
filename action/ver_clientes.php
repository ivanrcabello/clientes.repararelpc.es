<?php
	$last = (   isset($_GET['last'])   )? $_GET['last'] : 0 ;
?>
<style>
#cliente-id-<?=$last?> {
    box-shadow: 0 0 3px 1px red;
    position: relative;
    z-index: 999;
}
</style>
<?php
/* PAGINADOR */
$slug = '?action=ver_clientes';
$current = (   isset($_GET['page'])   )? $_GET['page'] : 1 ;
	$current = (   $current>0   )? $current : 1 ;
$post_per_page = 50;

		//Total de resultados
		$t_consulta = "SELECT * FROM clientes WHERE UID = ".$_SESSION['ID'];
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
	<p id="cabecera_action">Inicio > Ver Clientes</p>
	
	<?php
			/* Extraemos los clientes */
			$consulta = "SELECT * FROM clientes WHERE UID = ".$_SESSION['ID']." ORDER BY CID DESC LIMIT ".$apartir_limit.",".$post_per_page;
			$query = mysqli_query($db, $consulta);
	?>
	<div id="lista_tabla">
		<div class="lista_row cabecera">
			<span class="cname">Nombre</span>
			<span class="cemail">Dirección</span>
			<span class="cphone">Telefono</span>
			<span class="cactions">Acciones</span>
		</div>
	<?php
		if(   mysqli_num_rows($query)>0   ) {
				$aux = 1;
				while(   $row =  mysqli_fetch_array($query, MYSQLI_ASSOC)   ) {
			?>
				<div id="cliente-id-<?=$row['CID']?>" class="lista_row <?php if($aux%2==1){echo 'par';}else{echo 'inpar';} ?>">
					<span class="cname"><?=$row['name']?></span>
					<span class="cemail"><?=$row['address']?></span>
					<span class="cphone"><?=$row['phone']?></span>
					<span class="cactions">
						<!--
						<a href="?action=add_reparacion&cliente=<?=$row['CID']?>" class="jq_addr" title="Agregar Reparación"><img src="img/addr.png" /></a>
						&nbsp;&nbsp;
						-->
						<a href="javascript:void(0);" class="jq_ver" id="<?=$row['CID']?>" title="Ver Ficha"><img src="img/view.png" /></a>
						&nbsp;&nbsp;
						<a href="?action=edit_cliente&id=<?=$row['CID']?>" title="Editar"><img src="img/edit.png" /></a>
						<a href="?action=delete_cliente&id=<?=$row['CID']?>" title="Eliminar"><img src="img/trash.png" /></a>
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