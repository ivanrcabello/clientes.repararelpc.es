<!DOCTYPE html>
<html lang="es-ES" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximun-scale=1, minimun-scale=1" />
	<script src="http://localhost/wp/wp-includes/js/wp-emoji-release.min.js?ver=4.6.1" type="text/javascript"></script>
	<link rel="stylesheet" id="inka-style-css" href="#" type="text/css" media="all" />
	<title>Técnicos | Reparación</title>
	
	<style>
		html, body, * {margin:0; padding:0; border:0; outline:none; color:inherit; text-decoration:none; font-family:inherit;}
		html, body, * {-webkit-transition:all 0.2s ease; -moz-transition:all 0.2s ease; -ms-transition:all 0.2s ease;
				-o-transition:all 0.2s ease; transition:all 0.2s ease;}
		html, body {width:100%; height:100%; background:#333; font-family:'Calibri', Arial, Sans-serif;}
		
		#table {display:table; width:100%; height:100%;}
		#cell {display:table-cell; width:100%; height:100%; vertical-align:middle; text-align:center;}
		
		#cell > form {background:#111; width:100%; max-width:420px; margin:0 auto; padding:5px 10px 20px 10px; text-align:left;
				border:6px solid #222; box-shadow:0 0 80px 0 #999;}
			#cell .back {display:inline-block; color:#eee; margin-bottom:10px; background:#444; padding:8px 14px;}
			#cell label {display:block; color:white; font-size:19px; margin-bottom:20px;}
			#cell input[type='text'],
			#cell input[type='password'] {margin-top:6px; width:100%; height:52px; line-height:52px; text-indent:10px; color:black;}
			button {background:#A0222F; color:white; font-size:16px; padding:0 20px; min-width:120px; border-bottom:7px solid #B32F35;
					height:60px; line-height:60px;}
			button:hover {cursor:pointer; background:#B32F35; border-color:#A0222F;}
			
			p.error {color:white; background:#A22; text-align:center; padding:8px 0; border-radius:2px; margin-bottom:8px;}
	</style>
</head>
<body>

<div id="table">
	<div id="cell">
		<form method="POST" action="">
			<a class="back" href="index.php">Regresar al portal</a>

			<?php   if( $error ) { /* $error esta declarada en index.php */   ?>
			<p class="error">Error. Usuario o Contraseña Incorrectos.</p>
			<?php   }   ?>
			<label>Usuario:<br/>
				<input type="text" name="user" placeholder="Usuario..." required />
			</label>
			<label>Contraseña:<br/>
				<input type="password" name="pass" placeholder="Contraseña..." required />
			</label>
						<input type="hidden" value="ok" name="enviar" />
			<br/>
			
			<button>Login</button>
		</form>
	</div>
</div>

</body>
</html>