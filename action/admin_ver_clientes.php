<?php
if(   $_SESSION['admin']==1   ) {

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
$slug = '?action=admin_ver_clientes';
$current = (   isset($_GET['page'])   )? $_GET['page'] : 1 ;
	$current = (   $current>0   )? $current : 1 ;
$post_per_page = 50;

		//Total de resultados
		$t_consulta = "SELECT * FROM clientes";
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
	<p id="cabecera_action">Inicio > Ver Todos los Clientes</p>
	
	<?php
			/* Extraemos los clientes */
			$consulta = "SELECT * FROM clientes ORDER BY CID DESC LIMIT ".$apartir_limit.",".$post_per_page;
			$query = mysqli_query($db, $consulta);
	?>
	<div id="lista_tabla">
		<div class="lista_row cabecera">
			<span class="cname">Nombre</span>
			<span class="cemail">Dirección</span>
			<span class="cphone">Telefono</span>
			<span class="actions">Acciones</span>
		</div>
	<?php
		if(   mysqli_num_rows($query)>0   ) {
				$aux = 1;
				while(   $row =  mysqli_fetch_array($query, MYSQLI_ASSOC)   ) {
					
						/* Extraemos nombre del usuario */
						$query_user = mysqli_query($db, "SELECT user FROM usuarios WHERE ID=".$row['UID']);
						if(   mysqli_num_rows($query_user)>0   ) {
								$rowe = mysqli_fetch_array($query_user, MYSQLI_ASSOC);
								$usernick = $rowe['user'];
						} else {
								$usernick = "N/A";
						}
						@mysqli_free_result($query_user);
			?>
				<div id="cliente-id-<?=$row['CID']?>" class="lista_row <?php if($aux%2==1){echo 'par';}else{echo 'inpar';} ?>">
					<span class="cname"><?=$row['name']?></span>
					<span class="cemail"><?=$row['address']?></span>
					<span class="cphone"><?=$row['phone']?></span>
					<span class="actions">
						<a href="javascript:void(0);" class="jq_ver" id="<?=$row['CID']?>" title="Ver Ficha"><img src="img/view.png" /></a>
						<a href="?action=admin_edit_cliente&id=<?=$row['CID']?>" title="Editar"><img src="img/edit.png" /></a>
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
<?php
}
?>