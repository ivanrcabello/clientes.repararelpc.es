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
$slug = '?action=admin_ver_usuarios';
$current = (   isset($_GET['page'])   )? $_GET['page'] : 1 ;
	$current = (   $current>0   )? $current : 1 ;
$post_per_page = 50;

		//Total de resultados
		$t_consulta = "SELECT * FROM usuarios";
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
	<p id="cabecera_action">Inicio > Ver Todos los Usuarios</p>
	
	<?php
			/* Extraemos los usuarios */
			$consulta = "SELECT * FROM usuarios ORDER BY admin DESC, ID DESC LIMIT ".$apartir_limit.",".$post_per_page;
			$query = mysqli_query($db, $consulta);
	?>
	<div id="lista_tabla">
		<div class="lista_row cabecera">
			<span class="ulogin admin">User Login</span>
			<span class="uadmin admin">Admin?</span>
			<span class="uname admin">Nombre</span>
			<span class="ufecha admin">Fecha Reg.</span>
			<span class="uactions admin">Acciones</span>
		</div>
	<?php
		if(   mysqli_num_rows($query)>0   ) {
				$mes = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
				
				$aux = 1;
				while(   $row =  mysqli_fetch_array($query, MYSQLI_ASSOC)   ) {
						if(   $row['admin']==1   ) {$admin='si';} else {$admin='no';}
						
						$d = explode(' ', $row['datei']);
						$d = explode('-', $d[0]);
						
						$datee = $d[2]." ".$mes[ ($d[1]-1) ]." ".$d[0];
			?>
				<div id="cliente-id-<?=$row['ID']?>" class="lista_row <?php if($aux%2==1){echo 'par';}else{echo 'inpar';} ?>">
					<span class="ulogin admin"><?=$row['user']?></span>
					<span class="uadmin admin"><img src="img/<?=$admin?>.png" /></span>
					<span class="uname admin"><?=$row['name']?></span>
					<span class="ufecha admin"><?=$datee?></span>
					<span class="uactions admin">
						<a href="?action=admin_edit_user&id=<?=$row['ID']?>" title="Editar"><img src="img/edit.png" /></a>
						<a href="?action=admin_delete_user&id=<?=$row['ID']?>" title="Eliminar"><img src="img/trash.png" /></a>
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


<div id="ver" style="display:none;">
<div style="display:table; width:100%; height:100%; position:absolute; top:0; left:0; background:rgba(0,0,0,0.4); z-index:999;">
	<div style="display:table-cell; vertical-align:middle; text-align:center;">
		<div style="display:inline-block; width:100%; max-width:480px; min-height:280px; background:#111; border:3px solid #222;
				border-radius:6px; color:white;">
			
			<p style="background:#222; padding:8px; position:relative;">
				Cliente ID: <span id="ver_cid">0</span>
				<a href="#" id="close_ver" style="display:inline-block; background:#A0222F; border-bottom:5px solid #B32F35; border-radius:50%; width:26px;
						height:21px; line-height:23px; text-align:center; position:absolute; right:0; top:0;">x</a>
			</p>
			
			<p style="text-align:left; padding-top:1px;">
				<span style="display:inline-block; min-width:120px; height:30px; line-height:30px; text-indent:10px; background:#222;
						border-radius:0 4px 4px 0;">Nombre: </span>
				<span id="ver_name"> - </span>
			</p>
			
			<p style="text-align:left; padding-top:1px;">
				<span style="display:inline-block; min-width:120px; height:30px; line-height:30px; text-indent:10px; background:#222;
						border-radius:0 4px 4px 0;">Dirección: </span>
				<span id="ver_address"> - </span>
			</p>
			
			<p style="text-align:left; padding-top:1px;">
				<span style="display:inline-block; min-width:120px; height:30px; line-height:30px; text-indent:10px; background:#222;
						border-radius:0 4px 4px 0;">Telefono: </span>
				<span id="ver_phone"> 0000000000 </span>
			</p>
			
			<p style="text-align:left; padding-top:1px;">
				<span style="display:inline-block; min-width:120px; height:30px; line-height:30px; text-indent:10px; background:#222;
						border-radius:0 4px 4px 0;">Correo: </span>
				<a id="ver_email" style="text-decoration:underline;" href="#"> - </a>
			</p>
			
			<p style="text-align:left; padding-top:1px;">
				<span style="display:inline-block; min-width:120px; height:30px; line-height:30px; text-indent:10px; background:#222;
						border-radius:0 4px 4px 0;">Fecha Registro: </span>
				<span id="ver_date"> N/A </span>
			</p>
			
			<p style="text-align:left; padding-top:1px;">
				<span style="display:inline-block; min-width:120px; height:30px; line-height:30px; text-indent:10px; background:#222;
						border-radius:0 4px 4px 0;">Articulos: </span>
				<span id="ver_articles"> ? </span>
				<a id="ver_link_articles" href="#" style="background:#A0222F; padding:1px 9px; border-radius:4px; margin-left:3px; border-bottom:4px solid #B32F35;">
					ver
				</a>
			</p>
			
			
		</div>
	</div>
</div>
</div> <!-- end #ver -->

<script>
	$('.jq_ver').click( function() {
		var cid = $(this).attr('id');
		
		$.ajax({
			type:'POST',
			dataType:'json',
			url:'ajax/ver_cliente.php',
			data:{cid:cid},
			beforeSend: function() {
					//
			},
			success: function(e) {
					if(   e.CID   ) {
							$('#ver_cid').html( e.CID );
							$('#ver_name').html( e.name );
							$('#ver_address').html( e.address );
							$('#ver_phone').html( e.phone );
							$('#ver_email').html( e.email );
								$('#ver_email').attr('href', 'mailto:' + e.email );
							$('#ver_date').html( e.date );
							$('#ver_articles').html( e.articles );
								if(   e.articles>0   ) {
									$('#ver_link_articles').css({'display':'inline'});
									$('#ver_link_articles').attr('href', '?action=ver_articulos_cliente&cid='+e.CID );
								} else {
									$('#ver_link_articles').css({'display':'none'});
								}
								
							$('#ver').fadeIn(120);
					} else if(   e.wrong   ) {
							window.location.reload();
					}
			}
		});
		
		return false;
	});
	
	$('#close_ver').click( function() {
		$('#ver').fadeOut(120);
		
		return false;
	});
	$(document).keyup(function(e) {
			if (e.keyCode == 27) {
				$('#ver').fadeOut(120);
			}
	});
</script>

<?php
}
?>