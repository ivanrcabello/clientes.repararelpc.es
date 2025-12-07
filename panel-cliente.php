<?php session_start();
$error =  false;

if (isset($_POST['submit'])) {
	$u = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
	$p = md5($_POST['pass']);
	
	if ((strlen($u)*strlen($u)) > 0) {
		require( 'config.php' );
		$consulta = "SELECT * FROM usuarios WHERE user='".addslashes($u)."' AND pass='".addslashes($p)."' LIMIT 1";
		$query = mysqli_query($db, $consulta);
		if(mysqli_num_rows($query)) {
			$data = mysqli_fetch_array( $query, MYSQLI_ASSOC);
			$_SESSION['ID'] = $data['user'];
			$_SESSION['admin'] = $data['admin'];
			$_SESSION['name'] = $data['name'];
			$_SESSION['user'] = $data['user'];
			header("Location: dashboard-cliente.php");
			exit;
		} else {
			$error = true;
		}
	}
}

if (isset($_SESSION['user'])) {
	header("Location: dashboard-cliente.php");
	exit;
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            font-family: "SF Pro Display",serif;
            margin: 0;
            box-sizing: border-box;
        }

        h1 {
            font-weight: 200;
            font-size: 1.48rem;
            line-height: 2.4rem;
        }

        .box {
            padding: 1.4rem;
            border: 1px solid #a5a5b117;
            border-radius: 6px;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .form-control {
            width: 100%;
        }

        .subtitle {
            color: #9b9ba8;
            font-weight: 100;
            font-size: 1rem;
            letter-spacing: 0.038rem;
        }

        .container {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
            transition: opacity 0.5s;
            opacity: 0;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container.animated {
            opacity: 1;
        }

        .menu {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .menu ul li {
            cursor: pointer;
        }

        input[type="submit"] {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 1rem;
            cursor: pointer;
            font-size: 1rem;
            border-radius: 6px;
            transform: translateY(0) scaleY(1);
            transition-property: transform, opacity, -webkit-transform;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.2rem;
        }

        .primary:hover {
            background: #296EF4;
        }

        .secondary:hover {
            background: #F6F7F9;
        }

        .primary {
            border: none;
            background: #3878F6;
            color: white;
            font-weight: 200;
            width: 100%;
        }

        .secondary {
            background: #FBFCFF;
            color: black;
            border: 2px solid #ECEEF0;
            font-weight: 300;
        }



        .success {
            display: flex;
            justify-content: center;
            align-items: start;
            flex-direction: column;
            gap: 0.4rem;
            margin-top: 1rem;
        }

        .success h2 {
            font-size: 1.2rem;
            font-weight: 200;
            color: #b5b6b6;
        }

        .success .item-s {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.4rem;
            font-size: 1.4rem;
        }

        .success .item-s div {
            font-weight: 200;
            font-size: 1.2rem;
        }

        .small {
            font-size: 0.84rem;
            padding: 1rem 2.4rem 1rem 2.4rem;
        }

        .menu ul {
            display: flex;
            gap: 2rem;
            list-style: none;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;
            font-weight: 200;
        }

        .container-form {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 1.4rem;
        }

        div[class^="step-"] {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 0.6rem;
            width: 8.4rem;
            text-align: center;
        }

        div[class^="step-"] p {
            font-size: 0.88rem;
            font-weight: 100;
            color: #80899C;
            letter-spacing: 0.034rem;
        }

        div[class^="step-"] p.active {
            color: #396AF5;
        }

        .line {
            width: 200px;
            height: 1.95px;
            /*background: #396AF5;*/
            background: #DFDFE7;
            margin-top: 1.8rem;
            margin-left: -3.7rem;
            margin-right: -3.7rem;
        }

        .line.active {
            background: #396AF5;
        }

        .circle {
            width: 1rem;
            height: 1rem;
            border: 1.99167px solid #DFDFE7;
            border-radius: 50%;
        }

        .circle.active {
            border: 1.99167px solid #396AF5;
        }

        .circle.fulled {
            background: #396AF5;
            border: none;
        }

        p[class^="error-"]{
            color: red;
            font-size: 0.96rem;
            font-weight: 200;
            margin-top: 0.4rem;
        }

        form {
            display: flex;
            justify-content: center;
            align-items: start;
            flex-direction: column;
            gap: 0.74rem;
        }

        label {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: start;
            gap: 0.48rem;
            font-weight: 200;
            font-size: 0.98rem;
            width: 100%;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            border: 1px solid #D7D8E1;
            border-radius: 5px;
            padding: 0.8rem;
            font-weight: 200;
            width: 100%;
            height: 2.4rem;
        }

        input[type="text"]:focus,input[type="email"]:focus, input[type="password"]:focus {
            border: none;
        }

        input[placeholder] {
            font-weight: 200;
            font-size: 1rem;
        }

        .container-status {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .status {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .check {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: row-reverse;
            font-size: 1.14rem;
        }

        input[type="checkbox"] {
            width: 1.4rem;
            height: 1.4rem;
        }
        
        .error {
          color: white;
          font-weight: 200;
          background: #f009;
          padding: 0.68rem;
          border-radius: 4px;
          font-size: 0.88rem;
        }

        @font-face {
            font-family: 'SF Pro Display';
            src: url('./assets/fonts/sf-pro-display/SF-Pro-Display-Thin.otf');
            font-weight: 10;
            font-style: normal;
        }

        @font-face {
            font-family: 'SF Pro Display';
            src: url('./assets/fonts/sf-pro-display/SF-Pro-Display-Ultralight.otf');
            font-weight: 50;
            font-style: normal;
        }

        @font-face {
            font-family: 'SF Pro Display';
            src: url('./assets/fonts/sf-pro-display/SF-Pro-Display-Light.otf');
            font-weight: 100;
            font-style: normal;
        }

        @font-face {
            font-family: 'SF Pro Display';
            src: url('./assets/fonts/sf-pro-display/SF-Pro-Display-Regular.otf');
            font-weight: 200;
            font-style: normal;
        }

        @font-face {
            font-family: 'SF Pro Display';
            src: url('./assets/fonts/sf-pro-display/SF-Pro-Display-Medium.otf');
            font-weight: 300;
            font-style: normal;
        }

        @font-face {
            font-family: 'SF Pro Display';
            src: url('./assets/fonts/sf-pro-display/SF-Pro-Display-Semibold.otf');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'SF Pro Display';
            src: url('./assets/fonts/sf-pro-display/SF-Pro-Display-Bold.otf');
            font-weight: 500;
            font-style: normal;
        }

        @font-face {
            font-family: 'SF Pro Display';
            src: url('./assets/fonts/sf-pro-display/SF-Pro-Display-Heavy.otf');
            font-weight: 600;
            font-style: normal;
        }

        @font-face {
            font-family: 'SF Pro Display';
            src: url('./assets/fonts/sf-pro-display/SF-Pro-Display-Black.otf');
            font-weight: 700;
            font-style: normal;
        }

        @media screen and (max-width: 800px) {
            .container-form #resultado {
                width: 100%;
            }
            div[class^="step-"] {
                width: 10.4rem;
            }
            .line {
                margin-top: 1.68rem;
                margin-left: -7.2rem;
                margin-right: -7.2rem;
            }
            form {
                width: 100%;
            }
            .container-status {
                gap: 3rem;
            }
            .container {
                height: 100%;
            }
        }

        @media screen and (max-width: 460px) {
            input[type="text"], input[type="email"], input[type="password"] {
                width: 100%;
            }
            button {
                width: 100%;
            }
            h1 {
                font-size: 1.6rem;
                line-height: 1.8rem;
            }
            .menu {
                display: none;
            }
            .subtitle {
                font-weight: 100;
                font-size: 0.98rem;
                letter-spacing: 0.048rem;
            }
            .line {
                width: 200px;
                margin-top: 2.68rem;
                margin-left: -5.2rem;
                margin-right: -5.2rem;
            }
            .step p {
                font-size: 0.8rem;
            }
            .container-form {
                gap: 2rem;
            }
            label {
                font-size: 1.1rem;
            }
            .container {
                height: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box">
            <img src="assets/images/logo.png" alt="repararelpc.es" style="width: 14rem; height: 4.8rem;margin: auto;">
            <div style="width: 326px;">

                <h1>Iniciar sesión</h1>
                <p class="subtitle">Ingresa tus credenciales para dar seguimiento a tus órdenes.</p>
            </div>
            <?php   
            if ( $error ) { ?>
			    <p class="error">Credenciales inválidas</p>
			<?php   }   ?>
            <form method="POST" action="">
                <div class="form-control">
                    <label>
                        Usuario
                        <input type="text" name="user" id="user" class="user" autocomplete="off" required>
                    </label>
                </div>
                <div class="form-control">
                    <label>
                        Contraseña
                        <input type="password" name="pass" id="pass" class="pass" autocomplete="off" required>
                    </label>
                </div>
                <div class="form-control">
                    <input class="primary" type="submit" name="submit" value="Ingresar">
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    setTimeout(() => { document.querySelector(".container").classList.add("animated"); }, 0);
    window.addEventListener("DOMContentLoaded", () => {
    
    });
</script>
</html>