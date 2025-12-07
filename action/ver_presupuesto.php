<?php
if(   isset($_GET['id']) && $_GET['id']>0   ) {
	$pid = $_GET['id'];

	/* Verificamos que el articulo EXISTE y sea de este usuario */
	if(   $_SESSION['admin']==1   ) {
		$consulta = "SELECT * FROM presupuestos WHERE PID=".$pid." LIMIT 1";
	} else {
		$consulta = "SELECT * FROM presupuestos WHERE UID = ".$_SESSION['ID']." AND PID=".$pid." LIMIT 1";
	}
	$query = mysqli_query($db, $consulta);
	if(   mysqli_num_rows($query)>0   ) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	} else {
			/* No existe este presupuesto o no esta relacionado al ID del usuario logueado */
			?>
				NO EXISTE PRESUPUESTO
			<?php
			exit;
	}
	@mysqli_free_result($query);
	
	/* Extraemos datos del cliente */
	$c = "SELECT * FROM clientes WHERE CID=".$row['CID']." LIMIT 1";
	$q = mysqli_query($db, $c);
	if(   mysqli_num_rows($q)>0   ) {
			$cliente = mysqli_fetch_array($q, MYSQLI_ASSOC);
	}
	@mysqli_free_result($q);
?>
<div id="cuerpo_action">
	<p id="cabecera_action">Inicio > Ver Presupuesto ( #<?=$pid?> )</p>
	
	<div style="width:90%; margin:0 auto;">
		
		<br/>
		
		<button class="print">IMPRIMIR PRESUPUESTO</button>
		<a href="?action=sendpresupuesto&pid=<?=$pid?>" class="send">ENVIAR POR CORREO ELECTRONICO</a>
		
		<br/><br/>
		
		<p style="background:#A11; color:white; font-size:16px; padding:4px 14px; border-radius:4px; margin-right:3px; line-height:normal;
				height:100%;">
			&euro; <?=$row['presupuesto']?><br/>
			<em style="font-size:11px;">(Presupuesto)</em>
		</p>

		<br/>

		<p style="background:#eee; line-height:32px; padding:2px 1px; width:49%;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Fecha:</span> 
			<?php
				/* fecha */
				$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
				$f = explode(' ', $row['fecha']);
					$f1 = explode('-', $f[0]);
					$h1 = explode(':', $f[1]);
				$fecha = $f1[2].' '.$meses[ ($f1[1]-1) ].' '.$f1[0].', '.$h1[0].':'.$h1[1].' Hrs';

				echo $fecha;
			?>
		</p>
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Datos Cliente:</span> 
			<span><?=$cliente['name']; ?></span>
		</p>
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:inline-block; min-width:120px; padding:0 10px; background:#ccc; border-radius:2px;">Dirección:</span> 
			<span><?=$cliente['address']; ?></span>
		</p>	
		<div style="clear:both;"></div>
	</div>
	
	<div style="width:90%; margin:0 auto;">
		<p style="background:#fff; line-height:32px; padding:2px 1px;">
			<span style="display:block; padding:0 10px; background:#ccc; border-radius:2px;">Notas:</span> 
			
			<span style="display:inline-block; line-height:20px;">
				<?=$row['notas']?>
			</span>
		</p>
		
		<br/>
		
		<button class="print">IMPRIMIR PRESUPUESTO</button>
		<a href="?action=sendpresupuesto&pid=<?=$pid?>" class="send">ENVIAR POR CORREO ELECTRONICO</a>
		
		<br/>
		<br/>
		
	</div>
</div> <!-- end #cuerpo_action -->

<?php
}
/* *************************************** AREA PARA IMPRIMIR ********************************* */
?>
<div id="areaprint">

	<div style="text-align:center;">
		<img src="img/repararelpc.png" style="width:100%;"/>
		<p>
			Calle marques de Berna 18 Nave 2, 28042 Madrid - 91 155 85 05 | 690 041 105
			<br/>
			Ordemat Soluciones SL B-86744042   info@repararelpc.es
		</p>
		
		<p class="barra">DATOS DEL CLIENTE</p>
		
			<div style="margin:10px 0;"></div>
		
		<div style="text-align:left; font-size:0;">

			<div class="c28">Presupuesto:</div><div class="c20">&euro; <?=$row['presupuesto']?></div>

				<div style="margin:10px 0;"></div>

			<div class="c28">Fecha:</div><div class="c70"><?=$fecha?></div>
			
				<div style="margin:10px 0;"></div>
				
			<div class="c28">NOMBRE:</div><div class="c70"><?=$cliente['name']; ?></div>
			
			<div class="c28">Dirección:</div><div class="c70"><?=$cliente['address']; ?></div>
			
			<div class="c28">Telefono:</div><div class="c70"><?php if( $cliente['phone'] != '' ) { echo $cliente['phone']; } else { echo '-'; } ?></div>
			
			<div class="c28">Correo:</div><div class="c70"><?php if( $cliente['email'] != '' ) { echo $cliente['email']; } else { echo '-'; } ?></div>
		</div>
		
			<div style="margin:10px 0;"></div>
		
		<p class="barra">DESCRIPCIÓN DEL PRESUPUESTO</p>
		<div class="c90">
			<?=$row['notas']?>
		</div>
			<div style="margin:10px 0;"></div>
			
		<div class="firma">Firma Conforme</div>
	</div>

</div> <!-- // TERMINA AREA PARA IMPRIMIR -->


<script>
	$(".print").click( function() {
			window.print();
			
			return false;
	});
</script>