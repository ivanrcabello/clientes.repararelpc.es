<ul>
	<li>
	    
		<ul class="clickeables">
			<li><a href="index.php">Portal</a></li>
		</ul>
	</li>
	<?php if($_SESSION['admin']==1) { ?>
	<li class="no-click">Clientes</li>
	<li>
		<ul class="clickeables">
			<li><a href="?action=ver_clientes">Ver Clientes</a></li>
			<li><a href="?action=add_cliente">Añadir Cliente</a></li>
		</ul>
	</li>
	<li class="no-click">Reparaciones</li>
	<li>
		<ul class="clickeables">
			<li><a href="?action=ver_reparaciones">Ver Reparaciones</a></li>
			<li><a href="?action=add_reparacion">Añadir Reparación</a></li>
			<li><a href="?action=ver_garantias">Ver Garantías</a></li>
		</ul>
	</li>
	<li class="no-click">Presupuestos</li>
	<li>
		<ul class="clickeables">
			<li><a href="?action=ver_presupuestos">Ver Presupuestos</a></li>
			<li><a href="?action=add_presupuesto">Crear Presupuesto</a></li>
		</ul>
	</li>

	<li class="no-click">Facturas</li>
	<li>
		<ul class="clickeables">
			<li><a href="?action=ver_facturas">Ver Facturas</a></li>
		</ul>
	</li>

	<li class="no-click">Gastos</li>
	<li>
		<ul class="clickeables">
			<li><a href="?action=ver_gastos">Ver Gastos</a></li>
			<li><a href="?action=add_gasto">Crear Gasto</a></li>
		</ul>
	</li>
	<li class="no-click">Puntos de recogida</li>
	<li>
		<ul class="clickeables">
			<li><a href="?action=ver_puntos">Ver puntos</a></li>
			<li><a href="?action=add_punto">Crear puntos</a></li>
		</ul>
	</li>
	<li class="no-click">Tickets</li>
	<li>
		<ul class="clickeables">
			<li><a href="?action=ver_tickets">Ver Tickets</a></li>
		</ul>
	</li>
    <?php } else if ($_SESSION['admin'] == 0) {
    ?>
    <li class="no-click">Reparaciones</li>
	<li>
		<ul class="clickeables">
			<li><a href="?action=ver_reparaciones">Ver Reparaciones</a></li>
		</ul>
	</li>
	<?php } ?>

	<?php if(   $_SESSION['admin'] == 1   ) { ?>
	<li class="no-click admin">ADMIN</li>
	<li>
		<ul class="clickeables admin">
			<li><a href="?action=admin_ver_clientes">Ver Clientes</a></li>
			<li><a href="?action=admin_ver_reparaciones">Ver Reparaciones</a></li>
			<li><a href="?action=ver_reparaciones&filtro=4">Ver Garantías</a></li>
			<li><a href="?action=admin_ver_presupuestos">Ver Presupuestos</a></li>
			<li><a href="?action=admin_ver_presupuestos">Ver Gastos</a></li>
			<li><a href="?action=admin_ver_facturas">Ver Facturas</a></li>

			<li style="margin-top:10px;"><a href="?action=admin_ver_estadisticas">Estadísticas</a></li>
			
			<li style="margin-top:10px;"><a href="?action=admin_ver_usuarios">Ver Usuarios</a></li>
			<li><a href="?action=admin_add_usuario">Añadir Usuario</a></li>
			
			<li style="margin-top:10px;"><a href="?action=admin_config">Configuración</a></li>
		</ul>
	</li>
	<?php } ?>


</ul>