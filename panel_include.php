<?php 
// extraemos config
$config = array();
$qc = mysqli_query($db, "SELECT * FROM config");
if(    mysqli_num_rows($qc)>0    ) {
	while(   $rc = mysqli_fetch_array($qc, MYSQLI_ASSOC)   ) {
		$config[ $rc['config_key'] ] = $rc['config_value'];
	} // end while
}
@mysqli_free_result($qc);
?>
<!DOCTYPE html>
<html lang="es-ES" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />

	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1" />
	<link rel="stylesheet" id="style-css" href="style.css?v=1.0.0.025<?=strtotime(date('Y-m-d H:i:s'))?>" type="text/css" />
	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
  
	<title>Técnicos | Reparación</title>
</head>
<body>

<header id="header">
	<h2>Panel de Control</h2>
	<span id="menu-mobile">
		<img src="https://cdn4.iconfinder.com/data/icons/simple-lines-2/32/Menu_List_Text_Line_Item_Bullet_Paragraph-48.png" />
	</span>
	<span id="search">
		<img src="https://cdn0.iconfinder.com/data/icons/citycons/150/Citycons_magnify-64.png" />
	</span>
	<span><span>Hola <strong><?=ucfirst(  $_SESSION['name']  )?></strong> </span><a href="logout.php">Cerrar Sesión</a></span>
</header>


<div id="form_search">
	<form method="post" action="#">
		<input type="text" placeholder="Buscar cliente por Nombre o Dirección" name="buscarcliente" />
	</form>
	<ul id="response"></ul>
</div>


<div id="table">
	<div id="row">
		<div class="cell columna">
			<?php include( 'inc/sidebar.php' ); ?>
		</div>
		<div class="cell cuerpo">
<?php
	$opcion = (   isset($_GET['action'])   )? $_GET['action'] : '' ;
	switch( $opcion ) {
			case 'ver_clientes':
				include( 'action/ver_clientes.php' );
				break;
			case 'ver_articulos_cliente':
				include( 'action/ver_articulos_cliente.php' );
				break;
			case 'add_cliente':
				include( 'action/add_cliente.php' );
				break;
			case 'edit_cliente':
				include( 'action/edit_cliente.php' );
				break;
			case 'delete_cliente':
				include( 'action/delete_cliente.php' );
				break;
				
			case 'ver_reparaciones':
				include( 'action/ver_reparaciones.php' );
				break;
			case 'ver_reparacion':
				include( 'action/ver_reparacion.php' );
				break;
			case 'add_reparacion':
				include( 'action/add_reparacion.php' );
				break;
			case 'edit_reparacion':
				include( 'action/edit_reparacion.php' );
				break;
			case 'delete_reparacion':
				include( 'action/delete_reparacion.php' );
				break;
			case 'ver_garantias':
				include( 'action/ver_garantias.php' );
				break;
			case 'ver_garantia':
				include( 'action/ver_garantia.php' );
				break;
			case 'edit_garantia':
				include( 'action/edit_garantia.php' );
				break;
			case 'delete_garantia':
				include( 'action/delete_garantia.php' );
				break;
			
			case 'send':
				include( 'action/send.php' );
				break;
			case 'sendpresupuesto':
				include( 'action/sendpresupuesto.php' );
				break;
			case 'sendfactura':
				include( 'action/sendfactura.php' );
				break;

			case 'ver_presupuestos':
				include( 'action/ver_presupuestos.php' );
				break;
			case 'ver_presupuesto':
				include( 'action/ver_presupuesto.php' );
				break;
			case 'add_presupuesto':
				include( 'action/add_presupuesto.php' );
				break;
			case 'edit_presupuesto':
				include( 'action/edit_presupuesto.php' );
				break;
			case 'delete_presupuesto':
				include( 'action/delete_presupuesto.php' );
				break;
			case 'ver_presupuestos_cliente':
				include( 'action/ver_presupuestos_cliente.php' );
				break;

				// gastos

				case 'ver_gastos':
					include( 'action/ver_gastos.php' );
					break;
				case 'ver_gasto':
					include( 'action/ver_gasto.php' );
					break;
				case 'add_gasto':
					include( 'action/add_gasto.php' );
					break;
				case 'edit_gasto':
					include( 'action/edit_gasto.php' );
					break;
				case 'delete_gasto':
					include( 'action/delete_gasto.php' );
					break;
					
				// puntos

				case 'ver_puntos':
					include( 'action/ver_puntos.php' );
					break;
				case 'ver_punto':
					include( 'action/ver_punto.php' );
					break;
				case 'add_punto':
					include( 'action/add_punto.php' );
					break;
				case 'edit_punto':
					include( 'action/edit_punto.php' );
					break;
				case 'delete_punto':
					include( 'action/delete_punto.php' );
					break;
					
					
					// tickets

				case 'ver_tickets':
					include( 'action/ver_tickets.php' );
					break;
				case 'ver_ticket':
					include( 'action/ver_ticket.php' );
					break;
				case 'add_ticket':
					include( 'action/add_ticket.php' );
					break;
				case 'edit_ticket':
					include( 'action/edit_ticket.php' );
					break;
				case 'delete_ticket':
					include( 'action/delete_ticket.php' );
					break;


				// fin gastos

			case 'add_factura':
				include( 'action/add_factura.php' );
				break;
			case 'ver_factura':
				include( 'action/ver_factura.php' );
				break;
			case 'delete_factura':
				include( 'action/delete_factura.php' );
				break;
			case 'ver_facturas':
				include( 'action/ver_facturas.php' );
				break;
			case 'ver_facturas_cliente':
				include( 'action/ver_facturas_cliente.php' );
				break;
			case 'edit_factura':
				include( 'action/edit_factura.php' );
				break;

			case 'admin_ver_clientes':
				include( 'action/admin_ver_clientes.php' );
				break;
			case 'admin_edit_cliente':
				include( 'action/admin_edit_cliente.php' );
				break;
			case 'admin_ver_reparaciones':
				include( 'action/admin_ver_reparaciones.php' );
				break;
			case 'admin_edit_reparacion':
				include( 'action/admin_edit_reparacion.php' );
				break;
			case 'admin_ver_presupuestos':
				include( 'action/admin_ver_presupuestos.php' );
				break;
			case 'admin_add_presupuesto':
				include( 'action/add_presupuesto.php' );
				break;
			case 'admin_edit_presupuesto':
				include( 'action/edit_presupuesto.php' );
				break;
			case 'admin_delete_presupuesto':
				include( 'action/delete_presupuesto.php' );
				break;
				
			case 'admin_ver_estadisticas':
				include( 'action/admin_ver_estadisticas.php' );
				break;

			case 'admin_ver_usuarios':
				include( 'action/admin_ver_usuarios.php' );
				break;
			case 'admin_add_usuario':
				include( 'action/admin_add_user.php' );
				break;
			case 'admin_edit_user':
				include( 'action/admin_edit_user.php' );
				break;
			case 'admin_delete_user':
				include( 'action/admin_delete_user.php' );
				break;
			case 'admin_ver_facturas':
				include( 'action/admin_ver_facturas.php' );
				break;
			case 'admin_delete_factura':
				include( 'action/admin_delete_factura.php' );
				break;

			case 'admin_config':
				include( 'action/admin_config.php' );
				break;
			case 'admin_reset':
				include( 'action/admin_reset.php' );
				break;
				
			case 'export_status':
				include( 'action/download_status.php' );
				break;

				
			default:
			?>
				<img id="logo" src="img/repararelpcV2.png" />
			<?php break;
	} // end switch
?>
		</div>
	</div>
</div>






<!-- ---------------------------------------------------------- DIV "VER" ----------------------------- -->

<div id="ver" style="display:none;">
<div style="display:table; width:100%; height:100%; position:fixed; top:0; left:0; background:rgba(22,180,255,0.7); z-index:999;">
	<div style="display:table-cell; vertical-align:middle; text-align:center;">
		<div style="display:inline-block; width:80%; /*max-width:480px;*/ min-height:280px; height:80%; background:#111; border:3px solid #222;
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
						border-radius:0 4px 4px 0;">ID CHECKER: </span>
				<span id="ver_checker"> - </span>
			</p>
			
			<p style="text-align:left; padding-top:1px;">
				<span style="display:inline-block; min-width:120px; height:30px; line-height:30px; text-indent:10px; background:#222;
						border-radius:0 4px 4px 0;">DNI/NIF: </span>
				<span id="ver_nif"> - </span>
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
			
					<p style="margin:15px; border-bottom:1px solid #333;"></p>

			<p style="text-align:left; padding-top:1px;">
				<span style="display:inline-block; min-width:120px; height:30px; line-height:30px; text-indent:10px; background:#222;
						border-radius:0 4px 4px 0;">Reparaciones: </span>
				<span id="ver_articles"> ? </span>
				<a id="ver_link_articles" href="#" style="background:#A0222F; padding:1px 9px; border-radius:4px; margin-left:3px; border-bottom:4px solid #B32F35;">
					ver
				</a>
			</p>
			<p style="text-align:left; padding-top:1px;">
				<span style="display:inline-block; min-width:120px; height:30px; line-height:30px; text-indent:10px; background:#222;
						border-radius:0 4px 4px 0;">Presupuestos: </span>
				<span id="ver_presupuestos"> ? </span>
				<a id="ver_link_presupuestos" href="#" style="background:#A0222F; padding:1px 9px; border-radius:4px; margin-left:3px; border-bottom:4px solid #B32F35;">
					ver
				</a>
			</p>
			<p style="text-align:left; padding-top:1px;">
				<span style="display:inline-block; min-width:120px; height:30px; line-height:30px; text-indent:10px; background:#222;
						border-radius:0 4px 4px 0;">Facturas: </span>
				<span id="ver_facturas"> ? </span>
				<a id="ver_link_facturas" href="#" style="background:#A0222F; padding:1px 9px; border-radius:4px; margin-left:3px; border-bottom:4px solid #B32F35;">
					ver
				</a>
			</p>
		

					<p style="margin:15px; border-bottom:1px solid #333;"></p>

			<div style="text-align:left; padding-left:5px; font-size:0;">
				<a id="crear_reparacion" href="#" style="display:inline-block; height:48px; line-height:48px; padding:0 12px; background:#a0222f; font-size:16px; margin-right:10px;">Añadir Reparacion</a>
				<a id="crear_presupuesto" href="#" style="display:inline-block; height:48px; line-height:48px; padding:0 12px; background:#1786bb; font-size:16px; margin-right:10px;">Añadir Presupuesto</a>
			</div>
			
			
		</div>
	</div>
</div>
</div> <!-- end #ver -->

<script>
$(document).ready( function() {
	$('#menu-mobile').click( function() {
			if(   $(this).hasClass('active')   ) {
					/* ya estaba activo, lo cerramos */
					$(".columna").animate({left:'-201px'});
					$('.active').removeClass('active');
			} else {
					/* no estaba activo, lo mostramos y añadimos la clase */
					$(".columna").animate({left:'0'});
					$(this).addClass('active');
			}
			
			return false;
	});

	$('input[name="buscarcliente"]').keyup( function(u){
			var c = $(this).val();
			
			if(   c.length>=3   ) {
					/* hacemos un Ajax, para extraer los clientes que coincidan */
					$.ajax({
							//url:'ajax/coincidencias_clientes.php',
							url:'ajax/list_clientes.php',
							type:'POST',
							dataType:'JSON',
							data:{cliente:c},
							beforeSend: function() {
									console.log( "Enviando Ajax. Coincidencias con STRING( "+ c +" )" );
							},
							success: function(e) {
									if( e.clientes ) {
											var l = e.clientes.length;
											var html = '';
											
											var rango_edit = (  <?=$_SESSION['admin']?>==1 )? 'admin_edit' : 'edit' ;

											for(var i=0; i<l; i++) {
													var n = e.clientes[i].name.toLowerCase();
														n = n.replace(c.toLowerCase(),'<u style="text-decoration:underline; color:#C00;">'+c.toLowerCase()+'</u>');
													var a = e.clientes[i].address.toLowerCase();
														a = a.replace(c.toLowerCase(),'<u style="text-decoration:underline; color:#C00;">'+c.toLowerCase()+'</u>')
													
													html += '<li class="nolink">'+n+'&nbsp;&nbsp;('+a+')&nbsp;&nbsp;&nbsp;';
													html += '<span class="jq_ver" id="'+e.clientes[i].id+'">Ver Datos</span>';
													html += '<a href="?action=ver_articulos_cliente&cid='+e.clientes[i].id+'">Ver Articulos</a>';
													html += '<a href="?action=ver_presupuestos_cliente&cid='+e.clientes[i].id+'">Ver Presupuestos</a>';
													html += '<a href="?action=ver_facturas_cliente&cid='+e.clientes[i].id+'">Ver Facturas</a>';
													html += '<a href="?action='+rango_edit+'_cliente&id='+e.clientes[i].id+'">Editar Cliente</a>';
													html += '</li>';
											}
											$("#response").html( html );
									} else {
											/* No hay clientes / coincidencias */
											$("#response").html('<li class="nolink" style="color:#b00">No hay coincidencias.</li>');
									}
							},
							error: function(x,y,z) {
									console.log( x +"\n\n"+ y +"\n\n"+ z );
							}
					});
			} else {
					/* menor a 3 caracteres, no mostrarmos nada */
					$("#response").html('<li class="nolink">Escriba minimo 3 caracteres.</li>');
			}

			return false;
	});


	$('body').on('click', '.jq_ver', function() {
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
							$('#ver_checker').html( e.checker );
							$('#ver_nif').html( e.nif );
							$('#ver_address').html( e.address );
							$('#ver_phone').html( e.phone );
							$('#ver_email').html( e.email );
								$('#ver_email').attr('href', 'mailto:' + e.email );
							$('#ver_date').html( e.date );

						/* Cantidad de Articulos y botoncito ver */
							$('#ver_articles').html( e.articles );
								if(   e.articles>0   ) {
									$('#ver_link_articles').css({'display':'inline'});
									$('#ver_link_articles').attr('href', '?action=ver_articulos_cliente&cid='+e.CID );
								} else {
									$('#ver_link_articles').css({'display':'none'});
								}
						/* Cantidad de Presupuestos y botoncito ver */
							$('#ver_presupuestos').html( e.presupuestos );
								if(   e.presupuestos>0   ) {
									$('#ver_link_presupuestos').css({'display':'inline'});
									$('#ver_link_presupuestos').attr('href', '?action=ver_presupuestos_cliente&cid='+e.CID );
								} else {
									$('#ver_link_presupuestos').css({'display':'none'});
								}
						/* Cantidad de Facturas y botoncito ver */
							$('#ver_facturas').html( e.facturas );
								if(   e.facturas>0   ) {
									$('#ver_link_facturas').css({'display':'inline'});
									$('#ver_link_facturas').attr('href', '?action=ver_facturas_cliente&cid='+e.CID );
								} else {
									$('#ver_link_facturas').css({'display':'none'});
								}

						/* BOTONES DE CREACION */
							$('#crear_reparacion').attr('href','?action=add_reparacion&cliente='+e.CID);
							$('#crear_presupuesto').attr('href','?action=add_presupuesto&cliente='+e.CID);
								
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


	$("#search").click( function() {
			if(   $("#form_search").hasClass('active')   ) {
					$("#form_search").removeClass('active');
					$("#form_search").slideUp(200);
			} else {
					$("#form_search").addClass('active');
					$("#form_search").slideDown(200);
			}

			return false;
	});
	
	$('body').on('click', '.e_status', function() {
		console.log( "CAMBIAR ESTADO" );
		var aid = $(this).data('aid');
		var t = $(this);
		
		$('.status_options').remove();
		
		var h = '';
			h += '<div id="status_options_'+aid+'" class="status_options">';
				h += '<span class="s_opt rec" data-aid="'+aid+'" data-status="recibido">Recibido</span>';
				h += '<span class="s_opt rep" data-aid="'+aid+'" data-status="reparacion">En reparación</span>';
				h += '<span class="s_opt repa" data-aid="'+aid+'" data-status="reparado">Reparado</span>';
				h += '<span class="s_opt ent" data-aid="'+aid+'" data-status="entregado">Entregado</span>';
				h += '<span class="s_opt gar" data-aid="'+aid+'" data-status="garantia">En garantía</span>';
					h += '<span class="s_opt ele" data-aid="'+aid+'" data-status="electronica">Electrónica</span>';
					h += '<span class="s_opt nor" data-aid="'+aid+'" data-status="no reparable">No reparable</span>';
						h += '<span class="s_opt esp" data-aid="'+aid+'" data-status="esperando material">Esperando material</span>';
						h += '<span class="s_opt presu" data-aid="'+aid+'" data-status="presupuestando">Presupuestando</span>';
			h += '</div>';
			
		$(this).parent().after( h );
		
		return false;
	});
	
	$('body').on('click', '.i_status', function() {
		console.log( "CAMBIAR ESTADO" );
		var tid = $(this).data('tid');
		var t = $(this);
		
		$('.status_options').remove();
		
		var h = '';
			h += '<div id="status_options_'+tid+'" class="status_options">';
				h += '<span class="i_opt nor" data-tid="'+tid+'" data-status="no resuelto">No resuelto</span>';
				h += '<span class="i_opt rev" data-tid="'+tid+'" data-status="revisando caso">Revisando caso</span>';
				h += '<span class="i_opt res" data-tid="'+tid+'" data-status="resuelto">Resuelto</span>';

			h += '</div>';
			
		$(this).parent().after( h );
		
		return false;
	});
	
	var cambiando = false;
	$('body').on('click', '.s_opt', function() {
		if(   cambiando===false   ) {
				console.log( "opcion cambiando estado" );
				var aid = $(this).data('aid');
				var status = $(this).data('status');
				
				$('#e_status_'+aid).html( 'Espere...' );
				cambiando = true;
				
				// hacemos ajax
				$.ajax({
					url:'ajax/cambiar_status.php',
					type:'POST',
					dataType:'JSON',
					data:{
						aid:aid,
						status:status
					},
					success:function(e) {
						console.log( e );
						
						setTimeout( function() {
							$('#e_status_'+aid).html( e.span_status );
							cambiando = false;
						},300);
						
						if(   e.success==200   ) {}
						else { alert("No se pudo cambiar status, ocurrio un error"); }
					}
				});
		}
		
		return false;
	});
	
	var cambiandodos = false;
	$('body').on('click', '.i_opt', function() {
		if(   cambiandodos===false   ) {
				console.log( "opcion cambiando estado" );
				var tid = $(this).data('tid');
				var status = $(this).data('status');
				
				$('#i_status_'+tid).html( 'Espere...' );
				cambiandodos = true;
				
				// hacemos ajax
				$.ajax({
					url:'ajax/cambiar_status_ticket.php',
					type:'POST',
					dataType:'JSON',
					data:{
						tid:tid,
						status:status
					},
					success:function(e) {
						console.log( e );
						
						setTimeout( function() {
							$('#i_status_'+tid).html( e.span_status );
							cambiandodos = false;
						},300);
						
						if(   e.success==200   ) {}
						else { alert("No se pudo cambiar status, ocurrio un error"); }
					}
				});
		}
		
		return false;
	});
	
	
	$('[name="mes"]').change( function() {
		var mes = $(this).val();
		
		window.location.href = '?action=admin_ver_estadisticas&mes='+mes;
	});
}); // end document ready
</script>
</body>
</html>