<?php 
if(   $_SESSION['admin']==1   ) {
?>
<style>
	#mes {padding:4px 6px; border:1px solid #ccc;}
</style>

<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Estadisticas</p>
	
	<?php 
		$m = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		
		$MES = date('Y-m');
		if(   isset($_GET['mes'])   ) {
			$MES = $_GET['mes'];
		}
		
		$HOY = date('Y-m-d H:i:s');
		
		$MES_ANTIGUO = date('Y-m');
		$TOTAL = 0;
		$TOTAL_GANANCIAS = 0;
		$ORDENES = array();
			/* Extraemos los articulos */
			$consulta = "SELECT * FROM articulos WHERE fecha_salida LIKE '%".$MES."%' AND (status=3 OR status=4) ORDER BY fecha_salida DESC";
																		// status 3 o 4 (entregado o en garantia)
			$query = mysqli_query($db, $consulta);
			
			if(   $query   ) {
				if(   mysqli_num_rows($query)>0   ) {
					$TOTAL = mysqli_num_rows($query);
					while(   $r = mysqli_fetch_array($query, MYSQLI_ASSOC)   ) {
						$TOTAL_GANANCIAS = floatval($TOTAL_GANANCIAS) + floatval($r['precio']);
						$ORDENES[] = $r;
					} // end while
				}
			}
			@mysqli_free_result($query);
	?>
	<div class="lista_tabla2">
	<?php 
		// Extraemos el mes mas antiguo
		$query2 = mysqli_query($db, "SELECT fecha_salida FROM articulos WHERE (status=3 OR status=4) AND fecha_salida NOT LIKE '%0000-00-00%' ORDER BY fecha_salida ASC LIMIT 1");
		if(   mysqli_num_rows($query2)>0   ) {
			$g = mysqli_fetch_array($query2, MYSQLI_ASSOC);
			
			$ggg = explode(' ', $g['fecha_salida']);
			$ggg2 = explode('-', $ggg[0]);
			$MES_ANTIGUO = $ggg2[0].'-'.$ggg2[1];
		}
		@mysqli_free_result($query2);
	?>
		<label>Mes: </label>
		<select name="mes" id="mes">
			<?php 
				$parar = false;
				$aux = 0;
				while(   $parar===false   ) {
					$temp_x = strtotime('-'.$aux.' months', strtotime($HOY));
					$temp_mes = date('Y-m', $temp_x);
					
					$d = explode('-', $temp_mes);
					
					if(   $MES==$temp_mes   ) {
						echo '<option value="'.$temp_mes.'" selected>'.$m[ ($d[1]-1) ].' '.$d[0].'</option>';
					} else {
						echo '<option value="'.$temp_mes.'">'.$m[ ($d[1]-1) ].' '.$d[0].'</option>';
					}
					
					$aux++;
					
					if(   $temp_mes==$MES_ANTIGUO   ) {
						$parar = true;
					}
				} // end while
			?>
		</select>
	</div>
	
	<?php 
		$x = explode('-', $MES);
		$fecha_text = $m[ ($x[1]-1) ].' '.$x[0];
	?>
	<div class="lista_tabla2">
		<div>
			<h3>Resumen</h3>
			<h4><?=$fecha_text?></h4>
			<p><?=$TOTAL?> Ordenes en total</p>
			<p>&euro; <?=number_format(floatval($TOTAL_GANANCIAS),2,'.',',')?> de ingresos en total</p>
		</div>
	</div>
	
	<div id="lista_tabla">
		<div class="lista_row cabecera">
			<span class="cname">ID Reparación</span>
			<span class="cdir">Precio</span>
			<span class="cphone">Fecha de Salida</span>
		</div>
		<?php if(   count($ORDENES)>0   ) {
				foreach(   $ORDENES as $orden   ) {
					$a = explode(' ', $orden['fecha_salida']);
					$d = explode('-', $a[0]);
					$h = explode(':', $a[1]);
					$fecha2 = $d[2].' '.$m[ ($d[1]-1) ].' '.$d[0];
			?>
			<div id="row-id-<?=$row['AID']?>" class="lista_row <?php if($aux%2==1){echo 'par';}else{echo 'inpar';} ?>">
				<span class="cname"><a href="?action=ver_reparacion&aid=<?=$orden['AID']?>">Orden ID <?=$orden['AID']?></a></span>
				<span class="cdir">&euro; <?=number_format($orden['precio'],2,'.',',')?></span>
				<span class="cphone"><?=$fecha2?></span>
			</div>
			
		<?php 
				} // end foreach
			} else { ?>
			<div>No hay resultados este mes.</div>
		<?php } ?>
	</div> <!-- end #lista_tabla -->
</div>
<?php
}
?>