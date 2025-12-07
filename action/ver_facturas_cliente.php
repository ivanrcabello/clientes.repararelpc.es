<?php
if(   isset($_GET['cid']) && $_GET['cid']>0   ) {
$cid = $_GET['cid'];

/* PAGINADOR */
$slug = '?action=ver_facturas_cliente&cid='.$cid;
$current = (   isset($_GET['page'])   )? $_GET['page'] : 1 ;
$post_per_page = 50;

		//Total de resultados
		if(   $_SESSION['admin']==1   ) {
				$t_consulta = "SELECT * FROM facturas WHERE CID=".$cid;
		} else {
				$t_consulta = "SELECT * FROM facturass WHERE UID = ".$_SESSION['ID']." AND CID=".$cid;
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
	<p id="cabecera_action">Inicio > Ver Facturas del cliente: <span style="text-decoration:underline;"><?=$nombre?> (<?=$total?> facturas)</span></p>
	
	<?php
			/* Extraemos los articulos */
			if(   $_SESSION['admin']==1   ) {
					$consulta = "SELECT * FROM facturas WHERE CID=".$cid." ORDER BY FID DESC LIMIT ".$apartir_limit.",".$post_per_page;
			} else {
					$consulta = "SELECT * FROM facturas WHERE UID = ".$_SESSION['ID']." AND CID=".$cid." ORDER BY FID DESC LIMIT ".$apartir_limit.",".$post_per_page;
			}
			$query = mysqli_query($db, $consulta);
	?>

	<div id="lista_tabla">
		<div class="lista_row cabecera">
			<div class="lista_row cabecera">
			<span class="cname">No. Factura</span>
			<span class="cemail">Cliente</span>
			<span class="cphone">Total</span>
			<span class="cactions">Acciones</span>
		</div>
	<?php
		if(   mysqli_num_rows($query)>0   ) {
				$aux = 1;
				while(   $row =  mysqli_fetch_array($query, MYSQLI_ASSOC)   ) {

						/* extraemos cliente */
						$querye = mysqli_query($db, "SELECT * FROM clientes WHERE CID=".$row['CID']." LIMIT 1");
						if(   mysqli_num_rows($querye)>0   ) {
								$rowe = mysqli_fetch_array($querye);
								$cliente = $rowe['name'];
						} else {
								$cliente = 'N/A';
						}
						@mysqli_free_result($querye);
						
						if(   $row['VERSION']==0   ) {
			?>
				<div id="cliente-id-<?=$row['FID']?>" class="lista_row <?php if($aux%2==1){echo 'par';}else{echo 'inpar';} ?>">
					<span class="cname"><?=$row['FOLIO']?></span>
					<span class="ccancel" style="font-weight:bold; color:red;">CANCELADO</span>
				</div>
			<?php 
						} else {
			?>
				<div id="cliente-id-<?=$row['FID']?>" class="lista_row <?php if($aux%2==1){echo 'par';}else{echo 'inpar';} ?>">
					<span class="cname"><?=$row['FID']?></span>
					<span class="cemail"><?=$cliente?></span>
					<span class="cphone"><?=number_format($row['total'],2).' &euro;' ?></span>
					<span class="cactions">
						<a href="?action=ver_factura&id=<?=$row['FID']?>" title="Ver Factura"><img src="img/view.png" /></a>
						<a href="?action=delete_factura&id=<?=$row['FID']?>" title="Eliminar"><img src="img/trash.png" /></a>
					</span>
				</div>
			<?php
						}
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