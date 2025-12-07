<?php
session_start();
if (isset($_SESSION['user'])) {
    if (isset($_POST['logout'])) {
        unset($_SESSION['user']);
        unset($_SESSION['id']);
        unset($_SESSION['admin']);
        unset($_SESSION['pass']);
        header("Location: panel-cliente.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detalles de órden</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    * {
        font-family: "SF Pro Display",serif;
        margin: 0;
        box-sizing: border-box;
        letter-spacing: 0.04rem;
    }

    .container {
        padding: 1.8rem 2.8rem 2.8rem 2.8rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .status {
        background: #75f47521;
        padding: 0.4rem 0.6rem 0.4rem 0.6rem;
        border: 1.44px solid #b4d540;
        color: #008000c7;
        border-radius: 21px;
        font-weight: 300;
        font-size: 0.72rem;
    }
    
    .status-0 {
        background: #096ff01a;
        border: 1.6px solid #c6c8e8;
        color: #2f809f;
    }
    
    .status-1 {
        background: #edf0f285;
        color: #7c8288;
        border: 1px solid #b1bbc43d;
    }
    
    .status-2 {
      background: #eacc7130;
      color: #ccaa43de;
      border: 1.44px solid #ccaa4380;
    }

    .status-3 {
       background: #75f47521;
       border: 1.44px solid #b4d540;
       color: #008000c7;
    }
    
    .status-4 {
        background: #c5acea21;
        border: 1.44px solid #c5acea99;
        color: #c5acea;
    }
    
    .status-10 {
        color: #888282;
        background: #c7ccc724;
        border: 1.6px solid #dedfda;
    }
    
    .status-12 {
      color: #f01010bf;
      background: #ee101012;
      border: 1.6px solid #df1e143d;
    }
    
    .status-13 {
      background: #dfdfd824;
      border: 1.44px solid #c1c1b985;
      color: #757567cf;
    }
    
    .status-14 {
      background: #11c8db1f;
      border: 1.44px solid #11c8db9c;
      color: #0da9b9f7;
    }


    .table {
        margin-top: 1rem;
    }

    table {
        width: 100%;
    }

    thead, tbody {
        display: flex;
        justify-content: start;
        align-items: center;
        border-bottom: 1px solid #f0f0f0;
    }

    thead {
        background: #fbfafa;
        border: 1px solid transparent;
        border-radius: 6px;
        flex-grow: 4.5;
        padding: 0.44rem 1rem 0.44rem 1rem;
    }

    tbody {
        padding: 0.6rem 1rem 0.6rem 1rem;
    }

    tr {
        flex-basis: 8rem;
    }

    tr:nth-child(1) {
        flex-grow: 0.1;
    }

    tr:nth-child(2) {
        flex-grow: 0.4;
    }

    tr:nth-child(3) {
        flex-grow: 0.5;
    }

    tr:nth-child(4) {
        flex-grow: 0.5;
    }

    tr:nth-child(5) {
        flex-grow: 2;
    }

    tr:nth-child(6) {
        flex-grow: 0.5;
    }

    tr:nth-child(7) {
        flex-grow: 0.5;
    }

    th {
        font-size: 0.88rem;
        font-weight: 200;
        color: #686565;
    }

    td {
        font-weight: 200;
        font-size: 0.92rem;
        color: #2d2929;
    }

    h1 {
        font-weight: 300;
        font-size: 1.4rem;
        line-height: 2.4rem;
        letter-spacing: 0;
    }

    h2 {
        font-size: 1.48rem;
        font-weight: 300;
        line-height: 2.4rem;
    }

    .subtitle {
        font-weight: 200;
    }

    .menu {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .menu ul {
        display: flex;
        gap: 2rem;
        list-style: none;
        justify-content: center;
        align-items: center;
        font-size: 1.08rem;
        font-weight: 200;
        padding: 0;
    }

    .menu ul li {
        cursor: pointer;
        font-size: 0.94rem;
    }
    
    .menu ul li a {
        color: #6325ea;
      text-decoration: none;
      font-weight: 300;
      border-bottom: 1px solid #6325ea;
      padding-bottom: 0.24rem;
    }
    
    .menu ul li.active a {
      color: white;
    }

    .menu ul li.active {
        background: #6325ea;
        color: white;
        padding: 0.6rem 1.4rem 0.6rem 1.4rem;
        border-radius: 4px;
        font-weight: 200;
    }
    

    .flex-space {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logout {
        background: white;
        color: #5e5555;
        padding: 0.8rem 1.4rem 0.8rem 1.4rem;
        font-size: 0.88rem;
        border-radius: 6px;
        border: 1px solid #f0f0f0;
        cursor: pointer;
    }

    .orders {
        display: flex;
        justify-content: center;
        align-items: start;
        gap: 1.2rem;
        flex-direction: column;
        margin-top: 0.6rem;
    }

    .tabs-filter {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .filter {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .tabs-filter span {
        padding: 0.6rem 1.2rem 0.6rem 1.2rem;
        border: 0.8px solid #eee5e5;
        font-weight: 200;
        font-size: 0.94rem;
        cursor: pointer;
    }

    .tabs-filter span:nth-child(1) {
        border-radius: 8px 0px 0px 8px;
    }

    .tabs-filter span:nth-child(4) {
        border-radius: 0px 8px 8px 0px;
    }

    .tabs-filter span.active {
        background: #6325ea;
        color: white;
    }

    input[type="text"], input[type="email"], input[type="password"] {
        border: 1px solid #D7D8E1;
        border-radius: 5px;
        padding: 0.8rem;
        font-weight: 200;
        width: 12rem;
        height: 2.4rem;
    }

    input[type="text"]:focus,input[type="email"]:focus, input[type="password"]:focus {
        border: none;
    }

    input[placeholder] {
        font-weight: 200;
        font-size: 0.88rem;
    }

    button, .button {
        width: fit-content;
        padding: 1rem 2rem 1rem 2rem;
        cursor: pointer;
        font-size: 0.92rem;
        border-radius: 4px;
        transform: translateY(0) scaleY(1);
        transition-property: transform, opacity, -webkit-transform;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.2rem;
        box-shadow: 0px 2px 13px #6325ea36;
        text-decoration: none;
    }

    .primary:hover {
        background: #296EF4;
    }

    .secondary:hover {
        background: #F6F7F9;
    }

    .primary {
        border: none;
        background: #6325ea;
        color: white;
        font-weight: 300;
    }

    .secondary {
        background: white;
        box-shadow: 0px 4px 17px -9px #0000001f;
        color: #5e5555;
        font-size: 0.88rem;
        border-radius: 6px;
        border: 1px solid #f0f0f0;
    }

    .grid {
        display: flex;
        justify-content: start;
        align-items: center;
        gap: 1rem;
    }

    .flex {
        display: flex;
        gap: 1.2rem;
        flex-direction: column;
    }

    .card {
        border: 1.48px solid #0000000f;
        padding: 1.4rem;
        display: flex;
        justify-content: center;
        align-items: start;
        flex-direction: column;
        border-radius: 4px;
        font-size: 0.98rem;
        font-weight: 200;
        gap: 0.48rem;
        min-width: 20rem;
        min-height: 6rem;
    }

    .card .number {
        font-size: 1.8rem;
        font-weight: 300;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .card .number small {
        color: #6325EA91;
        font-weight: 300;
        font-size: 0.72rem;
        padding: 0.44rem;
        border-radius: 14px;
        background: #0638fb0a;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.14rem;
    }

    .card .number small img {
        width: 0.8rem;
        height: 0.8rem;
    }

    .card .title {
        color: #6c5454;
        font-weight: 300;
        font-size: 1.08rem;
    }

    .search {
        font-weight: 200;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #f2f2f6;
        padding: 0.2rem 0.4rem 0.2rem 0.4rem;
        border-radius: 8px;
        box-shadow: -2px 7px 7px -7px #f3f5f7;
        width: 15.6rem;
        height: 2.6rem;
        gap: 0.24rem;
    }

    .search img {
        width: 1.12rem;
        height: 1.12rem;
        opacity: 0.6;
    }

    input#search {
        border: none;
        padding: 0.12rem;
    }

    input#search:focus {
        border: none;
    }

    .buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.8rem;
    }

    form {
        display: flex;
        justify-content: center;
        align-items: start;
        flex-direction: column;
        gap: 0.88rem;
        margin-top: 1rem;
    }

    label {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: start;
        gap: 0.48rem;
        font-weight: 300;
        font-size: 0.98rem;
        width: 100%;
    }

    .box-shadow-none {
        box-shadow: none;
    }

    .font-weight-200 {
        font-weight: 200;
    }

    #orden {
        width: fit-content;
        min-width: 12rem;
        height: 2.4rem;
        padding: 0.6rem;
        background: white;
        border: 1px solid #e8d8d8;
        border-radius: 6px;
        font-weight: 200;
    }

    .form-control {
        width: 30rem;
    }

    #problema {
        width: 100%;
        border: 1px solid #e8d8d8;
        border-radius: 6px;
        padding: 0.6rem;
        font-weight: 200;
        font-size: 0.86rem;
    }

    .orden {
        display: flex;
        justify-content: start;
        align-items: start;
        flex-direction: column;
        gap: 1rem;
        width: 40rem;
    }

    .item {
        display: flex;
        align-items: center;
        gap: 1rem;
        justify-content: space-between;
        width: 100%;
    }

    .field {
        display: flex;
        justify-content: center;
        flex-direction: column;
        gap: 0.26rem;
        width: 11rem;
    }

    .orden .item .field .name {
        font-size: 0.88rem;
        color: #4A575A;
        font-weight: 200;
    }

    .orden .item .field .description {
        font-weight: 200;
        color: #001F28;
        font-size: 0.868rem;
    }

    hr {
        width: 42rem;
        border: 1px solid #f7f5f5;
        margin-top: 0.8rem;
    }

    .tracking {
        border-bottom: 2px solid #1F736F;
        padding-bottom: 0.28rem;
        color: #1F736F;
        font-weight: 200;
        font-size: 0.88rem;
    }

    .state {
        display: flex;
      justify-content: center;
      align-items: start;
      flex-direction: row;
      gap: 0.6rem;
      min-width: 8rem;
    }

    .container-tracking {
        display: flex;
        justify-content: center;
        align-items: start;
        flex-direction: column;
        gap: 1rem;
    }

    .time {
        display: flex;
        justify-content: center;
        align-items: start;
        flex-direction: column;
        gap: 0.14rem;
    }

    .state .name {
      font-size: 0.88rem;
      color: #000;
      font-weight: 200;
      display: flex;
      justify-content: start;
      align-items: center;
      gap: 0.26rem;
    }

    .state .date {
        font-weight: 100;
        font-size: 0.80rem;
        color: #000;
    }
    
    .flex-column {
      display: flex;
      justify-content: center;
      align-items: start;
      flex-direction: column;
      gap: 0.2rem;
    }
    
    .container-state .state img {
      width: 1rem;
      height: 1rem;
    }

    .container-track {
        display: flex;
        flex-direction: row;
        gap: 0.8rem;
    }

    .norden {
        font-weight: 200;
        justify-content: start;
        align-items: center;
        gap: 0.68rem;
        display: flex;
    }

    .norden img, .track img {
        width: 2.2rem;
        height: auto;
        opacity: 0.76;
        border: 2.4px solid #eae6e6;
        padding: 0.44rem;
        border-radius: 50%;
        box-shadow: 1px 1px 2px -1px #eae1e1;
    }

    .container-state .state .name img {
        width: 1.1rem;
        height: auto;
        opacity: 0.5;
    }

    .estimation {
        display: flex;
        align-items: center;
        gap: 1rem;
        justify-content: space-between;
        width: 100%;
    }

    .estimation .avatar img {
        width: 3rem;
        height: 3rem;
        box-shadow: none;
        border-radius: 50%;
        border: none;
        padding: 0;
        opacity: 1;
    }

    .time .title {
        font-size: 0.88rem;
        color: #4A575A;
        font-weight: 200;
    }

    .time .value {
        font-weight: 200;
        color: #001F28;
        font-size: 0.84rem;
    }

    .message {
        padding: 0.4rem 1rem 0.4rem 1rem;
        box-shadow: none;
        border: none;
        font-weight: 200;
        font-size: 0.74rem;
        background: black;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.4rem;
    }

    .container-estimation {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.8rem;
    }

    .first {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 1.4rem;
        width: 100%;
    }

    .container-state {
        display: flex;
        justify-content: center;
        flex-direction: column;
        gap: 1rem;
        align-items: start;
    }

    .track {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 1.28rem;
    }

    .circle {
        width: 0.8rem;
        height: 0.8rem;
        background: #ece7e7;
        border-radius: 50%;
    }

    .container-circle {
      border: 2.4px solid #eae6e6;
      padding: 0.56rem;
      border-radius: 50%;
      box-shadow: 1px 1px 2px -1px #eae1e1;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .norden img {
        border: 1px solid #eae6e6;
        border-radius: 10px;
        box-shadow: 1px 1px 4px -1px #eae1e1;
    }

    .message img {
        box-shadow: none;
        width: 1rem;
        height: auto;
        opacity: 1;
        padding: 0;
        border: none;
    }
    
    .menu-mobile {
            display: none;
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
        .flex-space {
            flex-direction: column;
            gap: 1rem;
        }
        .flex {
            gap: 1.4rem;
        }
    }

    @media screen and (max-width: 460px) {
        .form-control {
            width: 100%;
        }
        #orden {
            width: 100%;
        }
        .flex-space {
            flex-direction: column;
            gap: 0.68rem;
        }
        .buttons {
            display: none;
        }
        button {
            width: 100%;
            font-size: 0.88rem;
            font-weight: 200;
        }
        .grid {
            flex-direction: column;
        }
        .filter {
            flex-direction: column;
            gap: 0.6rem;
        }
        .tabs-filter span {
            font-size: 0.9rem;
            padding: 0.8rem 1.2rem 0.8rem 1.2rem;
            border-radius: 4px;
        }
        .tabs-filter {
            justify-content: start;
            text-align: center;
            gap: 0.4rem;
            width: 100%;
            flex-wrap: wrap;
        }
        .container {
            padding: 1.6rem;
        }
        .flex {
            gap: 1rem;
        }
        .search {
            padding: 0.2rem 0.4rem 0.2rem 0.8rem;
            width: 100%;
            justify-content: start;
        }
        .table {
            margin-top: 0.8rem;

        }
        .card {
            width: 100%;
        }
        .tabs-filter span:nth-child(1), .tabs-filter span:nth-child(4) {
            border-radius: 4px;
        }
        .menu {
            display: none;
        }
        .menu-mobile {
            display: block;
        }
        .flex-space {
            justify-content: start;
            align-items: start;
        }
        .orden, .first {
            width: 100%;
        }
        .list tbody tr {
          flex-basis: auto;
          width: 100%;
        }
        .time .title {
            font-size: 0.84rem;
        }
    }
</style>
<body>
<div class="container">
    <?php include("menu.php"); ?>
    <div class="flex">
        <div class="flex-space">
            <div>
                <h1>Detalles de la órden</h1>
                <p class="subtitle">Visualiza los datos de tu órden de reparación</p>
            </div>
        </div>
        <div class="orden">
            <div class="first">
                <div class="item">
                    <div class="field">
                        <p class="norden"><img src="assets/images/orden.svg"> #4223 </p>
                    </div>
                    <div class="field" style="align-items: end;">
                        <p class="status" style="width: fit-content;border-radius: 4px;border: none;">Entregada</p>
                    </div>
                </div>
                <div class="estimation">
                    <div class="container-estimation">
                        <div class="avatar">
                            <img src="assets/images/avatar1.svg" alt="">
                        </div>
                        <div class="time">
                            <p class="title">Estimado de reparación</p>
                            <p class="value">2 días, 6 horas</p>
                        </div>
                    </div>
                    <div>
                        <a class="message button" target="_blank" href="https://api.whatsapp.com/send/?phone=+34690041105&text=Hola&type=phone_number&app_absent=0"><img src="assets/images/chat.svg" alt=""> Enviar mensaje</a>
                        <!--<button class="message"><img src="assets/images/chat.svg" alt="">Enviar mensaje</button>-->
                    </div>
                </div>
            </div>
            <hr style="margin-top: 0rem;">
            <div class="item">
                <div class="field tipo-ordenador">
                    <p class="name">Tipo de ordenador</p>
                    <p class="description">Laptop</p>
                </div>
                <div class="field marca">
                    <p class="name">Marca</p>
                    <p class="description">Asus</p>
                </div>
                <div class="field modelo">
                    <p class="name">Modelo</p>
                    <p class="description">ML233X</p>
                </div>
            </div>
            <div class="item">
                <div class="field notas">
                    <p class="name">Descripción del problema</p>
                    <p class="description">No enciende, suena raro</p>
                </div>
                <div class="field fecha_entrada">
                    <p class="name">Fecha de recepción</p>
                    <p class="description">12/12/2023</p>
                </div>
                <div class="field certificado">
                    <p class="name">Certificados</p>
                    <p class="description">Cuenta con certificados</p>
                </div>
            </div>
            <div class="item">
                <div class="field funda">
                    <p class="name">Funda</p>
                    <p class="description">Si</p>
                </div>
                <div class="field cargador">
                    <p class="name">Cargador</p>
                    <p class="description">Si</p>
                </div>
                <div class="field bateria">
                    <p class="name">Bateria</p>
                    <p class="description">No</p>
                </div>
            </div>
            <hr>
            <div class="container-tracking">
                <p class="tracking">Tracking</p>
                <div class="container-track">
                    <!--
                    <div class="track">
                    </div>-->
                    <div class="container-state">
                        <div class="state sin-recepcion">
                            <div class="container-circle"><div class="circle"></div></div>
                            <div class="flex-column">
                                <p class="name"><img src="assets/images/package-variant-closed-remove.svg" alt="">Sin recepcionar</p>
                                <p class="date">Enero 19 Nov, 10:23 a.m</p>
                            </div>
                        </div>
                        <!--
                        <div class="state recepcion">
                            <div class="container-circle"><div class="circle"></div></div>
                            <div class="flex-column">
                                <p class="name"><img src="assets/images/package-check.svg" alt="">En recepción</p>
                                <p class="date">Enero 19 Nov, 10:23 a.m</p>
                            </div>
                        </div>
                        <div class="state reparacion">
                            <div class="container-circle"><div class="circle"></div></div>
                            <div class="flex-column">
                                <p class="name"><img src="assets/images/package-variant.svg" alt="">En reparación</p>
                                <p class="date">Enero 20 Nov, 7:23 a.m</p>
                            </div>
                        </div>-->
                        <!--
                        <div class="state entregado">
                            <div class="container-circle"><img src="assets/images/map-marker.svg" alt=""></div>
                            <div class="flex-column">
                                <p class="name"><img src="assets/images/package-variant-closed.svg" alt="">Entregado</p>
                                <p class="date">Enero 21 Nov, 4:23 p.m</p>
                            </div>
                        </div>
                        -->
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
</body>
<script>
    let orden = [];
    let ordenId = <?php echo $_GET['id']; ?>;
    let status = [{id: 11, name: "Electrónica"},{id: 10, name: "Sin recepcionar"}, {id: 0, name: "Recibido"}, {id: 1, name: "En reparación"}, {id: 2, name: "Reparado"}, {id: 3, name: "Entregado"}, {id: 4, name: "En garantía"}, {id: 12, name: "No reparable"}, {id: 13, name: "Esperando material"}, {id: 14, name: "Presupuestando"}];
    
    function restarFechasYDuracion(fecha1, fecha2) {
        // Convertir las fechas al formato de timestamp
        const timestampFecha1 = new Date(fecha1).getTime();
        const timestampFecha2 = new Date(fecha2).getTime();
    
        // Calcular la diferencia en milisegundos
        const diferenciaEnMilisegundos = timestampFecha1 - timestampFecha2;
    
        // Convertir la diferencia a días y horas
        const dias = Math.floor(diferenciaEnMilisegundos / (1000 * 60 * 60 * 24));
        const horas = Math.floor((diferenciaEnMilisegundos % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    
        return { dias, horas };
    }

    
    function formatearFecha(fechaString) {
      var fechaOriginal = new Date(fechaString);
    
      var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
      var nombreMes = meses[fechaOriginal.getMonth()];
    
      var dia = fechaOriginal.getDate();
      var año = fechaOriginal.getFullYear();
    
      var horas = fechaOriginal.getHours() % 12 || 12;
      var minutos = fechaOriginal.getMinutes();
      var ampm = fechaOriginal.getHours() < 12 ? 'a.m.' : 'p.m.';
    
      var fechaFormateada = dia + ' ' + nombreMes + ' ' + año + ', ' + horas + ':' + (minutos < 10 ? '0' : '') + minutos + ' ' + ampm;
    
      return fechaFormateada;
    }
    
    function agregarUnDia(fechaString, dias = 1) {
      var fechaOriginal = new Date(fechaString);
    
      // Agrega un día
      fechaOriginal.setDate(fechaOriginal.getDate() + dias);
    
      // Formatea la nueva fecha
      var año = fechaOriginal.getFullYear();
      var mes = (fechaOriginal.getMonth() + 1).toString().padStart(2, '0');
      var dia = fechaOriginal.getDate().toString().padStart(2, '0');
      var horas = fechaOriginal.getHours().toString().padStart(2, '0');
      var minutos = fechaOriginal.getMinutes().toString().padStart(2, '0');
      var segundos = fechaOriginal.getSeconds().toString().padStart(2, '0');
    
      var nuevaFecha = año + '-' + mes + '-' + dia + ' ' + horas + ':' + minutos + ':' + segundos;
    
      return nuevaFecha;
    }
    
    function obtenerFechaActualConFormato() {
      var fechaActual = new Date();
    
      var año = fechaActual.getFullYear();
      var mes = (fechaActual.getMonth() + 1).toString().padStart(2, '0');
      var dia = fechaActual.getDate().toString().padStart(2, '0');
      var horas = fechaActual.getHours().toString().padStart(2, '0');
      var minutos = fechaActual.getMinutes().toString().padStart(2, '0');
      var segundos = fechaActual.getSeconds().toString().padStart(2, '0');
    
      var fechaFormateada = año + '-' + mes + '-' + dia + ' ' + horas + ':' + minutos + ':' + segundos;
    
      return fechaFormateada;
    }

    
    async function created() {
        try {
            const response = await fetch("https://clientes.repararelpc.es/ordenes.php?norden=" + ordenId);
            let res = await response.json();
            orden = res.data;
            document.querySelector(".orden .norden").innerHTML = "<img src='assets/images/orden.svg'> #" + orden[0].AID;
            let statusOrden = document.querySelector(".orden .status");
            statusOrden.classList.add("status-" + orden[0].status);
            statusOrden.textContent = status.find((elem) => elem.id == orden[0].status).name;
            document.querySelector(".orden .field.tipo-ordenador .description").textContent = orden[0].articulo;
            document.querySelector(".orden .field.marca .description").textContent = orden[0].marca;
            document.querySelector(".orden .field.modelo .description").textContent = orden[0].modelo;
            document.querySelector(".orden .field.notas .description").textContent = orden[0].notas;
            document.querySelector(".orden .field.fecha_entrada .description").textContent = orden[0].fecha_entrada;
            document.querySelector(".orden .field.certificado .description").textContent = orden[0].certificado === 1 ? "Sí" : "No";
            document.querySelector(".orden .field.funda .description").textContent = orden[0].funda === 1 ? "Sí" : "No";
            document.querySelector(".orden .field.cargador .description").textContent = orden[0].cargador === 1 ? "Sí" : "No";
            document.querySelector(".orden .field.bateria .description").textContent = orden[0].bateria === 1 ? "Sí" : "No";
            document.querySelector(".container-state .sin-recepcion .date").textContent = formatearFecha(orden[0].fecha_entrada);
            let diferencia = restarFechasYDuracion(orden[0].estimado_tiempo, orden[0].fecha_entrada);
            document.querySelector(".estimation .time .value").textContent = diferencia.dias + (diferencia.dias > 1 ? " días, " : " día, ") + diferencia.horas + " horas";
            
            console.log(orden[0].status);
            
            if(orden[0].status != "10") {
                let div = document.createElement("div");
                div.className = "state";
                div.innerHTML = '<div class="container-circle"><div class="circle"></div></div><div class="flex-column"><p class="name"><img src="assets/images/package-check.svg" alt="">' + status.find((elem) => elem.id == orden[0].status).name + ' </p><p class="date">'+ formatearFecha(obtenerFechaActualConFormato()) +'</p></div>';
                document.querySelector(".container-state").appendChild(div);
            }
            
            if (orden[0].fecha_entrada != orden[0].fecha_salida) {
                let div = document.createElement("div");
                div.className = "state recepcion";
                div.innerHTML = '<div class="container-circle"><img src="assets/images/map-marker.svg" alt=""></div><div class="flex-column"><p class="name"><img src="assets/images/package-variant-closed.svg" alt="">Entregado</p><p class="date">'+ formatearFecha(orden[0].fecha_salida) +'</p></div>';
                document.querySelector(".container-state").appendChild(div);
            }
            console.log("Success:", orden);
          } catch (error) {
            console.error("Error:", error);
          }  
    }
    
    window.addEventListener("DOMContentLoaded", () => {
        created();
    });
</script>
</html>
<?php 
    }
    else {
        header("Location: panel-cliente.php");
        exit;
    }
?>