<!DOCTYPE html>
<html lang="es">
<head>
<title>Registro de incidencia de garantia</title>
<style>
	html, body, * {padding:0; margin:0; border:0; font-family:'Calibri', Verdana, Cambria, Sans-Serif;}
	#container {max-width:980px; margin:0 auto;}

	img#logo {max-width:100%; width:100%; min-height:75px;}
	a.back {display:inline-block; color:#fff; text-decoration:none; padding:10px; background:#222;}

	.form {margin:38px 0;}
	.form h3 {background:#9807c8; color:#fff; padding:12px 10px; margin-bottom:12px;}
	.form input {width:100%; height:62px; line-height:62px; padding:0 20px; border:1px solid #bb33ef; box-sizing:border-box;
			font-size:17px; color:#111;}
	.form button {margin-top:15px; padding:20px 60px; color:#fff; background:#9807c8; font-size:16px;}
	.form button:hover {cursor:pointer; background:#a820df;}

	.footer {height:30px; background:#9807c8;}

	#load {display:none; width:100%; height:100%; position:fixed; top:0; left:0; background:rgba(0,0,0,0.4); z-index:9;}
	.cell {display:table-cell; vertical-align:middle; text-align:center;}
	.cell span {display:inline-block; background:#ccc;border-radius:9px; padding:10px;}

	/* Resultados dinamicos (ajax) */
	#result {padding:10px 14px; background:#dc9ff1; margin-bottom:30px; display:none;}
	#result h2 {color:white; background:#a039c3; padding:5px 20px; margin-bottom:20px; font-weight:normal; font-size:21px;}
	#result > p {margin-bottom:2px; border-bottom:1px solid #a039c3;}
		.tage {display:inline-block; background:#a039c3; padding:3px 15px; width:120px; margin-right:20px; color:#fff;}
	.status em {display:inline-block; width:12px; height:12px; border-radius:50%; font-size:0;}
		.status em.status0 {background:#81F7F3;}
		.status em.status1 {background:#F3F781;}
		.status em.status2 {background:#FE2E2E;}
		.status em.status3 {background:#40FF00;}
	p.tage.full {display:block; margin:0; width:auto;}
	p.notes {padding:10px 12px;}

	@media(max-width:680px) {
			
	}
	@media(max-width:480px) {
			
	}
</style>
</head>
<body>

<div id="load">
	<div class="cell">
		<span>
			<svg width='80px' height='80px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-gears"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><g transform="translate(-20,-20)"><path d="M79.9,52.6C80,51.8,80,50.9,80,50s0-1.8-0.1-2.6l-5.1-0.4c-0.3-2.4-0.9-4.6-1.8-6.7l4.2-2.9c-0.7-1.6-1.6-3.1-2.6-4.5 L70,35c-1.4-1.9-3.1-3.5-4.9-4.9l2.2-4.6c-1.4-1-2.9-1.9-4.5-2.6L59.8,27c-2.1-0.9-4.4-1.5-6.7-1.8l-0.4-5.1C51.8,20,50.9,20,50,20 s-1.8,0-2.6,0.1l-0.4,5.1c-2.4,0.3-4.6,0.9-6.7,1.8l-2.9-4.1c-1.6,0.7-3.1,1.6-4.5,2.6l2.1,4.6c-1.9,1.4-3.5,3.1-5,4.9l-4.5-2.1 c-1,1.4-1.9,2.9-2.6,4.5l4.1,2.9c-0.9,2.1-1.5,4.4-1.8,6.8l-5,0.4C20,48.2,20,49.1,20,50s0,1.8,0.1,2.6l5,0.4 c0.3,2.4,0.9,4.7,1.8,6.8l-4.1,2.9c0.7,1.6,1.6,3.1,2.6,4.5l4.5-2.1c1.4,1.9,3.1,3.5,5,4.9l-2.1,4.6c1.4,1,2.9,1.9,4.5,2.6l2.9-4.1 c2.1,0.9,4.4,1.5,6.7,1.8l0.4,5.1C48.2,80,49.1,80,50,80s1.8,0,2.6-0.1l0.4-5.1c2.3-0.3,4.6-0.9,6.7-1.8l2.9,4.2 c1.6-0.7,3.1-1.6,4.5-2.6L65,69.9c1.9-1.4,3.5-3,4.9-4.9l4.6,2.2c1-1.4,1.9-2.9,2.6-4.5L73,59.8c0.9-2.1,1.5-4.4,1.8-6.7L79.9,52.6 z M50,65c-8.3,0-15-6.7-15-15c0-8.3,6.7-15,15-15s15,6.7,15,15C65,58.3,58.3,65,50,65z" fill="#2b2b29"><animateTransform attributeName="transform" type="rotate" from="90 50 50" to="0 50 50" dur="1s" repeatCount="indefinite"></animateTransform></path></g><g transform="translate(20,20) rotate(15 50 50)"><path d="M79.9,52.6C80,51.8,80,50.9,80,50s0-1.8-0.1-2.6l-5.1-0.4c-0.3-2.4-0.9-4.6-1.8-6.7l4.2-2.9c-0.7-1.6-1.6-3.1-2.6-4.5 L70,35c-1.4-1.9-3.1-3.5-4.9-4.9l2.2-4.6c-1.4-1-2.9-1.9-4.5-2.6L59.8,27c-2.1-0.9-4.4-1.5-6.7-1.8l-0.4-5.1C51.8,20,50.9,20,50,20 s-1.8,0-2.6,0.1l-0.4,5.1c-2.4,0.3-4.6,0.9-6.7,1.8l-2.9-4.1c-1.6,0.7-3.1,1.6-4.5,2.6l2.1,4.6c-1.9,1.4-3.5,3.1-5,4.9l-4.5-2.1 c-1,1.4-1.9,2.9-2.6,4.5l4.1,2.9c-0.9,2.1-1.5,4.4-1.8,6.8l-5,0.4C20,48.2,20,49.1,20,50s0,1.8,0.1,2.6l5,0.4 c0.3,2.4,0.9,4.7,1.8,6.8l-4.1,2.9c0.7,1.6,1.6,3.1,2.6,4.5l4.5-2.1c1.4,1.9,3.1,3.5,5,4.9l-2.1,4.6c1.4,1,2.9,1.9,4.5,2.6l2.9-4.1 c2.1,0.9,4.4,1.5,6.7,1.8l0.4,5.1C48.2,80,49.1,80,50,80s1.8,0,2.6-0.1l0.4-5.1c2.3-0.3,4.6-0.9,6.7-1.8l2.9,4.2 c1.6-0.7,3.1-1.6,4.5-2.6L65,69.9c1.9-1.4,3.5-3,4.9-4.9l4.6,2.2c1-1.4,1.9-2.9,2.6-4.5L73,59.8c0.9-2.1,1.5-4.4,1.8-6.7L79.9,52.6 z M50,65c-8.3,0-15-6.7-15-15c0-8.3,6.7-15,15-15s15,6.7,15,15C65,58.3,58.3,65,50,65z" fill="#59595c"><animateTransform attributeName="transform" type="rotate" from="0 50 50" to="90 50 50" dur="1s" repeatCount="indefinite"></animateTransform></path></g></svg>
		</span>
	</div>
</div>

<div id="container">
	<a href="index.php">
		<img id="logo" src="img/repararelpc.png" />
	</a>
	<br/>
	<a class="back" href="index.php">Regresar al Portal</a>

	<div class="form">
		<h3>Ingresa datos de la incidencia:</h3>
		<p>Ingresa tus nombres:</p>
		<input type="text" name="nombres" id="nombres" placeholder="Ingrese tus nombres" required />
			<p>&nbsp;</p>
		<p>Ingresa tu DNI/NIF:</p>
		<input type="text" name="dni" id="dni" placeholder="Ingrese tu DNI" required />
		<p>Ingresa tu direccion:</p>
		<input type="text" name="direccion" id="direccion" placeholder="Ingrese tu direccion" required />
		<p>Ingresa tu telefono:</p>
		<input type="text" name="telefono" id="telefono" placeholder="Ingrese tu telefono" required />	
		<p>Ingresa tu email:</p>
		<input type="email" name="email" id="email" placeholder="Ingrese tu email" required />
		
		<p>Ingresa la descripcion del problema:</p>
		<input type="text" name="notas" id="notas" placeholder="Ingrese tu problema" required />
		<div style="padding-bottom: 11px;">
		<label style="padding-bottom: 11px;"><input type="checkbox" id="acepto" name="acepto" style="width: 46px;height: 47px;position: relative;bottom: -15px;"> <a href="https://repararelpc.es/condiciones-generales-repararelpc/" target="_blank">He leído y acepto las condiciones de uso del portal y su política de privacidad</a></label><br>
        </div>
		<button id="registrardatos"> Registrar incidencia </button>
	</div>
	
	<div id="result"></div>

	<div class="footer"></div>
</div>

<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script>
$(document).ready( function() {
		$('#registrardatos').click( function() {

				var $nombres = $('#nombres').val();
				var $dni = $('#dni').val();
				var $direccion = $('#direccion').val();
				var $telefono = $('#telefono').val();
				var $email = $('#email').val();
				var $notas = $('#notas').val();
				var acepto = $('#acepto').is(':checked');
				
                console.log(acepto)
if(acepto==false) {
				    alert('Tienes que aceptar las condiciones de uso del sitio.');
				    return;
				}
    
  

							$.ajax({
								url:'ajax/regi.php',
								dataType:'JSON',
								type:'POST',
								data:{nombres: $nombres, dni: $dni, direccion: $direccion, telefono: $telefono, email: $email,  notas: $notas},
								beforeSend: function() {
									$('#load').css({'display':'table'});
								},
								success: function(response) {
								    
									var htmls = '';

									if( response.error ) {
										htmls += '<h1>Error</h1>';
										htmls += '<p>'+ response.error +'</p>';
									} else  {
									    //console.log(response.folio)
										htmls += '<h2>Su orden ha sido registrada.</h2>';

										htmls += 'Su numero de ticket es:<em class="status"></em>  <span>'+response.orden+'</span><br>';
									}
									var inte = setInterval( function(){ 
											$('#result').css({'display':'block'});
											$('#result').html( htmls );

											$('#load').fadeOut(350);
											clearInterval( inte );
									}, 1200);
								}
							});
		});
});
</script>

</body>
</html>