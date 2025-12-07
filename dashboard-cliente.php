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
    <title>Dashboard</title>
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
        padding: 1.8rem 2.8rem 1.8rem 2.8rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .menu-mobile {
      display: none;
    }
    
    #search:focus-visible {
      outline: none;
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
        font-size: 1.6rem;
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
    
    .flex-center {
      display: flex;
      justify-content: center;
      align-items: center;
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
    
    .eye {
        width: 2.4rem;
        height: 2.2rem;
        opacity: 0.84;
        cursor: pointer;
        border: 1px solid #eae6e6;
        padding: 0.2rem 0.6rem 0.2rem 0.6rem;
        border-radius: 10px;
        box-shadow: 1px 1px 4px -1px #eae1e1;
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
      justify-content: start;
      align-items: center;
      width: 100%;
      flex-wrap: wrap;
      gap: 0.44rem;
    }

    .filter {
        display: flex;
        justify-content: space-between;
        align-items: start;
        width: 100%;
    }

    .tabs-filter span {
      padding: 0.6rem 1.2rem 0.6rem 1.2rem;
      border: 0.8px solid #eee5e5;
      font-weight: 300;
      font-size: 0.94rem;
      cursor: pointer;
      border-radius: 6px;
      box-shadow: 1px 1px 1px 1px #00000005;
    }

    /*
    .tabs-filter span:first-child {
        border-radius: 8px 0px 0px 8px;
    }

    .tabs-filter span:last-child {
        border-radius: 0px 8px 8px 0px;
    }*/

    .tabs-filter span.active {
        background: #6325ea;
        color: white;
    }
    
    .tabs-filter span.active:hover {
      background: #6325eaf2;
    }
    
    .tabs-filter span:hover {
      background: #f9fbfdb8;
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
        font-size: 0.92rem;
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
        text-decoration: none;
        /*box-shadow: 0px 2px 13px #6325ea36;*/
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
        /*box-shadow: 0px 4px 17px -9px #0000001f;*/
        color: #5e5555;
        font-size: 0.88rem;
        border-radius: 6px;
        border: 1px solid #f0f0f0;
        font-weight: 300;
    }

    .grid {
        display: flex;
        justify-content: start;
        align-items: center;
        gap: 1rem;
    }

    .flex {
        display: flex;
        gap: 0.6rem;
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
        padding: 0.2rem 0.8rem 0.2rem 0.8rem;
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

    @media screen and (max-width: 840px) {
        .flex-space {
           flex-direction: column;
            gap: 1rem;
        }
        .flex {
            gap: 1.4rem;
        }
        .container {
            padding: 1.8rem 1.8rem 1.8rem 1.8rem;
        }
        tr {
            min-width: 10rem;
            flex-basis: -moz-available;
        }
        tbody {
            padding: 0;
        }
        .table {
            margin-top: 0;
        }
        .filter {
          flex-direction: column;
          gap: 0.8rem;
          align-items: start;
        }
        .menu {
            display: none;
        }
        .menu-mobile {
          display: block;
        }
    }

    @media screen and (max-width: 460px) {
        .flex-space {
            flex-direction: column;
            gap: 0.68rem;
        }
        .buttons {
            flex-direction: column;
            width: 100%;
        }
        button {
            width: 100%;
            font-size: 0.88rem;
            font-weight: 200;
        }
        .button {
            width: 100%;
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
        }
        .container {
            padding: 1.8rem 1.8rem 1.8rem 1.8rem;
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
            margin-top: 0;
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
        table {
            width: max-content;
        }
        tr {
            flex: 1;
            word-break: break-all;
        }
        tr:nth-child(1) {
          min-width: 4rem;
          flex-grow: unset;
        }
        tr:nth-child(2) {
          flex-grow: unset;
          min-width: 10rem;
        }
        tr:nth-child(3) {
          flex-grow: unset;
          min-width: 8rem;
        }
        tr:nth-child(4) {
          flex-grow: unset;
          min-width: 10rem;
        }
        tr:nth-child(5) {
          flex-grow: unset;
          min-width: 12rem;
          max-width: 16rem;
        }
        tr.empty {
            min-width: unset;
            flex: 1;
        }

        tbody, thead {
            padding: 0.44rem;
            flex-grow: 10;
        }
        h1 {
            font-size: 1.2rem;
        }
    }
</style>
<body>
    <div class="container">
        <?php include('menu.php'); ?>
        <div class="flex">
            <div class="flex-space">
                <h1>Bienvenido de nuevo, <?php echo $_SESSION['name']; ?></h1>
                <div class="buttons">
                    <button class="secondary">Solicitar soporte remoto</button>
                    <a href="registro-reparacion.php" class="button primary">Crear orden de reparación</a>
                </div>
            </div>
            <div class="grid">
                <div class="card total-ordenes">
                    <p class="title">Total de órdenes</p>
                    <div style="display: flex;justify-content: space-between;align-items: center;width: 100%;">
                        <p class="number">12
                            <small><img src="/assets/images/arrow-up.svg" alt=""> 2,14% </small>
                        </p>
                    </div>

                </div>
                <div class="card total-garantias">
                    <p class="title">Total de garantías</p>
                    <div style="display: flex;justify-content: space-between;align-items: center;width: 100%;">
                        <p class="number">4
                            <small><img src="/assets/images/arrow-up.svg" alt=""> 1,4%</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="orders">
                <div>
                    <h2>Mis órdenes</h2>
                    <p class="subtitle">Revisa el historial de tus últimas órdenes de reparación.</p>
                </div>
                <div class="filter">
                    <div class="tabs-filter">
                        <!----
                        <span class="active">Ver todas</span>
                        <span>En recepción</span>
                        <span>En reparación</span>
                        <span>Entregadas</span>
                        --->
                    </div>
                    <div class="search">
                        <img src="assets/images/magnify.svg" alt="">
                        <input type="text" name="search" class="search" id="search" placeholder="Buscar" oninput="search(event)">
                    </div>
                </div>
            </div>
            <div class="table ordersList">
                <table>
                    <thead>
                        <tr><th>ID</th></tr>
                        <tr><th>Tipo de ordenador</th></tr>
                        <tr><th>Marca</th></tr>
                        <tr><th>Modelo</th></tr>
                        <tr><th>Descripción</th></tr>
                        <tr><th>Fecha de recepción</th></tr>
                        <tr><th>Estado</th></tr>
                        <tr><th>Acciones</th></tr>
                    </thead>
                    <!---
                    <tbody>
                        <tr><td>#1433</td></tr>
                        <tr><td>Laptop</td></tr>
                        <tr><td>Asus</td></tr>
                        <tr><td>ML452323</td></tr>
                        <tr><td>No enciende, suena raro</td></tr>
                        <tr><td>10 de mayo 2024</td></tr>
                        <tr><td class="status uno">En recepción</td></tr>
                        <tr><td><img src="assets/images/eye.svg" style="width: 2.4rem;height: 2.2rem;cursor: pointer;opacity: 0.84;border: 1px solid #eae6e6;padding: 0.2rem 0.6rem 0.2rem 0.6rem;border-radius: 10px;box-shadow: 1px 1px 4px -1px #eae1e1;"></td></tr>
                    </tbody>
                    <tbody>
                        <tr><td>#2534</td></tr>
                        <tr><td>Desktop</td></tr>
                        <tr><td>Macbook Pro</td></tr>
                        <tr><td>MX2356L</td></tr>
                        <tr><td>Está muy lenta</td></tr>
                        <tr><td>1 de enero 2024</td></tr>
                        <tr><td class="status tres">Entregada</td></tr>
                        <tr><td><img src="assets/images/eye.svg" style="width: 2.4rem;height: 2.2rem;opacity: 0.84;cursor: pointer;border: 1px solid #eae6e6;padding: 0.2rem 0.6rem 0.2rem 0.6rem;border-radius: 10px;box-shadow: 1px 1px 4px -1px #eae1e1;"></td></tr>
                    </tbody>
                    <tbody>
                        <tr><td>#3443</td></tr>
                        <tr><td>Gamer</td></tr>
                        <tr><td>Lenovo</td></tr>
                        <tr><td>ML4231323</td></tr>
                        <tr><td>Se quemó la placa</td></tr>
                        <tr><td>23 de febrero 2024</td></tr>
                        <tr><td class="status dos">En reparación</td></tr>
                        <tr><td><img src="assets/images/eye.svg" class="eye"></td></tr>
                    </tbody>
                    --->
                </table>
            </div>
        </div>

    </div>
</body>
<script>
    let ordenes = [];
    let status = [{id: -1, name: "Ver todas"},{id: 11, name: "Electrónica"},{id: 10, name: "Sin recepcionar"}, {id: 0, name: "Recibido"}, {id: 1, name: "En reparación"}, {id: 2, name: "Reparado"}, {id: 3, name: "Entregado"}, {id: 4, name: "En garantía"}, {id: 12, name: "No reparable"}, {id: 13, name: "Esperando material"}, {id: 14, name: "Presupuestando"}];
    let tbodyFragment = new DocumentFragment();
    let listaOrdenes = document.querySelector(".ordersList table");
    
    async function getOrders() {
        try {
            clearListOrders();
            const response = await fetch("https://clientes.repararelpc.es/ordenes.php");
            let res = await response.json();
            ordenes = res.data;
        } 
        catch (error) {
            console.error("Error:", error);
        }
    }
    
    async function getGarantias() {
        try {
            const response = await fetch("https://clientes.repararelpc.es/garantias.php");
            let res = await response.json();
            document.querySelector(".total-garantias .number").textContent = res.data.length;
        } 
        catch (error) {
            console.error("Error:", error);
        }
    }
    
    function structureListEmpty() {
        let tbody = document.createElement("tbody");
        tbody.classList.add("flex-center");
        let trEmpty = document.createElement("tr");
        trEmpty.classList.add("empty");
        let tdEmpty = document.createElement("td");
        tdEmpty.classList.add("empty");
        tdEmpty.textContent = "No se han encontrado registros.";
        trEmpty.appendChild(tdEmpty);
        tbody.appendChild(trEmpty);
        listaOrdenes.appendChild(tbody);
    }
    
    function structureList(orden) {
                let tbody = document.createElement("tbody");
                let trID = document.createElement("tr");
                let tdID = document.createElement("td");
                tdID.classList.add("id");
                tdID.textContent = orden.AID;
                trID.appendChild(tdID);
                
                let trTipo = document.createElement("tr");
                let tdTipo = document.createElement("td");
                tdTipo.classList.add("id");
                tdTipo.textContent = orden.articulo;
                trTipo.appendChild(tdTipo);
                
                let trMarca = document.createElement("tr");
                let tdMarca = document.createElement("td");
                tdMarca.classList.add("id");
                tdMarca.textContent = orden.marca;
                trMarca.appendChild(tdMarca);
                
                let trModelo = document.createElement("tr");
                let tdModelo = document.createElement("td");
                tdModelo.classList.add("id");
                tdModelo.textContent = orden.modelo;
                trModelo.appendChild(tdModelo);
                
                let trNotas = document.createElement("tr");
                let tdNotas = document.createElement("td");
                tdNotas.classList.add("id");
                tdNotas.textContent = orden.notas;
                trNotas.appendChild(tdNotas);
                
                let trFecha = document.createElement("tr");
                let tdFecha = document.createElement("td");
                tdFecha.classList.add("id");
                tdFecha.innerHTML = orden.fecha_entrada;
                trFecha.appendChild(tdFecha);
                
                let trStatus = document.createElement("tr");
                let tdStatus = document.createElement("td");
                tdStatus.className = "status status-" + orden.status;
                tdStatus.textContent = status.find((elem) => elem.id == orden.status).name;
                trStatus.appendChild(tdStatus);
                
                let trEye = document.createElement("tr");
                let tdEye = document.createElement("td");
                let aEye = document.createElement("a");
                aEye.href = "ver-orden.php?id=" + orden.AID;
                let imgEye = document.createElement("img");
                imgEye.src = "assets/images/eye.svg";
                imgEye.classList.add("eye");
                aEye.appendChild(imgEye);
                tdEye.appendChild(aEye);
                trEye.appendChild(tdEye);
                
                tbody.appendChild(trID);
                tbody.appendChild(trTipo);
                tbody.appendChild(trMarca);
                tbody.appendChild(trModelo);
                tbody.appendChild(trNotas);
                tbody.appendChild(trFecha);
                tbody.appendChild(trStatus);
                tbody.appendChild(trEye);
                tbodyFragment.append(tbody);
    }
    
    function clearListOrders() {
        let tbodies = document.querySelectorAll(".ordersList table tbody");
        for(let tbody of tbodies) {
            tbody.remove();
        }
    }
    
    async function requestOrders(keyword = '', type = "id") {
        try {
            clearListOrders();
            document.querySelector(".total-ordenes .number").textContent = ordenes.length;
            let ordenesTemp = ordenes;
            if ((keyword != '' || keyword === 0) && keyword != -1) {
                let ordenesTemporal = ordenes;
                ordenesTemp = ordenesTemporal.filter((elem) => type == "id" ? elem.AID == keyword : elem.status == keyword);
            }
            
            if (ordenesTemp.length > 0) {
                console.log(ordenesTemp);
                for(let orden of ordenesTemp) {
                    console.log(orden)
                    structureList(orden);
                }
                listaOrdenes.appendChild(tbodyFragment);
            }
            else {
                structureListEmpty();
            }
            console.log("Success:", ordenesTemp);
          } catch (error) {
            console.error("Error:", error);
          }  
    }
    
    function search(event) {
        requestOrders(event.currentTarget.value);
    }
    
    function renderFilterTab() {
        let spanFragment = new DocumentFragment();
        for(let state of status) {
            let span = document.createElement("span");
            span.textContent = state.name;
            state.id == -1 ? span.classList.add( "active") : '';
            span.onclick = () => {
                let spanActive = document.querySelector(".tabs-filter span.active");
                spanActive.classList.remove("active");
                span.classList.add("active");
                requestOrders(state.id, "status");
            }
            spanFragment.append(span);
        }
        document.querySelector(".tabs-filter").appendChild(spanFragment);
    }
    
    window.addEventListener("DOMContentLoaded", () => {
        renderFilterTab();
        getOrders().then(() => {
            requestOrders();
        });
        getGarantias();
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