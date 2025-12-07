<!DOCTYPE html>
<html lang="es">
<head>

<style>
	html, body, * {padding:0; margin:0; border:0; font-family:'Calibri', Verdana, Cambria, Sans-Serif;}
	#container {max-width:980px; margin:0 auto;}

	img#logo {max-width:100%; width:100%;}
	.opciones {font-size:0; text-align:center; margin:20px 0;}
	.opciones a {display:inline-block; width:50%; font-size:initial; color:#111; text-decoration:none; padding:15px 0;}
	.opciones a:hover {background:#ddd; border-radius:20px;}

	.footer {height:30px; background:#9807c8;}

	@media(max-width:680px) {
			.opciones a {width:100%; max-width:480px;}
			.opciones a > img {width:200px;}
	}
	@media(max-width:480px) {
			.opciones a > img {width:140px;}
	}
</style>
</head>
<body>

<div id="container">
	<img id="logo" src="img/repararelpc.png" />
	<br/>
	<div class="opciones">
		<a href="panel.php">
			<h2> Login Personal </h2>
			<img src="https://cdn3.iconfinder.com/data/icons/watchify-v1-0-32px/32/lock-256.png" />
		</a>
		<a href="checker.php">
			<h2> Consulta el estado de la reparación </h2>
			<img src="https://cdn3.iconfinder.com/data/icons/glypho-free/64/pulse-box-256.png" />
		</a>
	</div>

	<div class="footer"></div>
</div>

</body>
</html>