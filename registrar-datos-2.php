<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing</title>
  <style>
    * {
      font-family: "SF Pro Display",serif;
      margin: 0;
      box-sizing: border-box;
    }

    /**
      * Confetti
    **/

    .confetti {
      display: flex;
      justify-content: center;
      align-items: center;
      position: absolute;
      width: 60%;
      height: 200px;
      overflow: hidden;
      left: 14%;
      top: 9rem;
      z-index: -1;
    }

    .confetti-piece {
      position: absolute;
      width: 8px;
      height: 16px;
      background: #ffd300;
      top: 0;
      opacity: 0;
      animation: makeItRain 1000ms ease-out;
      animation-delay: 0ms;
    }

    .uno {
      transform: rotate(10deg);
      left: 7%;
      animation-duration: 1320ms;
      background: #17d3ff;
    }
    .dos {
      transform: rotate(60deg);
      left: 14%;
      animation-duration: 1610ms;
      background: #ffd300;
    }
    .tres {
      transform: rotate(30deg);
      left: 21%;
      animation-duration: 970ms;
      background: #ff4e91;
    }
    .cuatro {
      transform: rotate(-40deg);
      left: 28%;
      animation-duration: 890ms;
      background: #ffd300;
    }
    .cinco {
      transform: rotate(-50deg);
      left: 32%;
      animation-duration: 1190ms;
      background: #ff4e91;
    }
    .seis {
      transform: rotate(60deg);
      animation-duration: 1420ms;
      left: 35%;
      background: #ffd300;
    }
    .siete {
      transform: rotate(-80deg);
      left: 42%;
      animation-duration: 950ms;
      background: #17d3ff;
    }
    .ocho {
      transform: rotate(-60deg);
      left: 56%;
      animation-duration: 980ms;
      background: #ffd300;
    }
    .nueve {
      transform: rotate(90deg);
      left: 72%;
      animation-duration: 1010ms;
      background: #ffd300;
    }
    .diez {
      transform: rotate(10deg);
      left: 77%;
      animation-duration: 1110ms;
      background: #ff4e91;
    }
    .once {
      transform: rotate(70deg);
      left: 84%;
      animation-duration: 1410ms;
      background: #ffd300;
    }
    .doce {
      transform: rotate(40deg);
      left: 98%;
      animation-duration: 1000ms;
      background: #ffd300;
    }
    .trece {
      transform: rotate(20deg);
      left: 120%;
      animation-duration: 1210ms;
      background: #ffd300;
    }

    @keyframes makeItRain {
      from {
        opacity: 0;
      }
      50% {
        opacity: 1;
      }
      to {
        transform: translateY(200px);
      }
    }

    svg {
      position: absolute;
    }

    h1 {
      font-weight: 300;
      font-size: 2rem;
      line-height: 2.4rem;
    }

    select {
      min-width: 14rem;
      width: fit-content;
      padding: 0.68rem;
      background: white;
      border: 1.98px solid #396af5;
      border-radius: 8px;
      font-weight: 200;
      font-size: 0.88rem;
    }

    .subtitle {
      color: #9b9ba8;
      font-weight: 100;
      font-size: 1.18rem;
      letter-spacing: 0.038rem;
    }

    .container {
      padding: 2rem;
      display: flex;
      flex-direction: column;
      gap: 2rem;
      transition: opacity 0.5s;
      opacity: 0;
    }

    .container-form #resultado {
      display: flex;
      width: 740px;
      flex-direction: column;
      gap: 0.4rem;
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
    
    .logo {
        width: 14rem;
        height: auto;
    }

    button, .button {
      width: fit-content;
      padding: 1rem 2rem 1rem 2rem;
      cursor: pointer;
      font-size: 1rem;
      border-radius: 8px;
      transform: translateY(0) scaleY(1);
      transition-property: transform, opacity, -webkit-transform;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0.2rem;
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
      background: #3878F6;
      color: white;
      font-weight: 200;
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
      margin: 0;
      padding: 0;
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
      gap: 1rem;
      width: 745px;
    }

    label {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: start;
      gap: 0.6rem;
      font-weight: 200;
      font-size: 1.2rem;
      width: 100%;
    }

    input[type="text"], input[type="email"], input[type="password"] {
      border: 1px solid #D7D8E1;
      border-radius: 5px;
      padding: 0.8rem;
      font-weight: 200;
      width: 100%;
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
        input[type="text"], input[type="email"], input[type="password"] {
        width: 100%;
      }
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
      .conffeti {
          width: 100%;
          left: -25px;
          top: 73px;
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
          flex-direction: column;
      }
      .menu button {
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
     .conffeti {
        width: 100%;
        left: -25px;
        top: 73px;
      }
    }
  </style>
</head>
<body>
<div class="container">
  <div class="menu">
    <ul>
      <li><img class="logo" src="/assets/images/logo.png"></li>
    </ul>
    <a class="button secondary small" href="panel-cliente.php">Iniciar sesión</a>
  </div>
  <div class="container-form">
    <div class="status"></div>
    <div id="cliente">
      <form method="POST" action="#">
        <h1>Registrar orden de reparación</h1>
        <p class="subtitle">Para registrar tu orden de reparación, necesitamos que completes este formulario con tus datos personales.</p>
        <div class="form-control">
          <label for="nombres">
            Nombres y apellidos
            <input type="text" placeholder="Luis" name="nombres" id="nombres" oninput="changeInput(event)" autocomplete="off">
          </label>
        </div>
        <div class="form-control">
          <label for="nif">
          NIF / DNI
          <input type="text" placeholder="71039422" name="dni" id="nif" oninput="changeInput(event)"  autocomplete="off">
        </label>
        </div>
        <div class="form-control">
          <label for="email">
            Email
            <input type="email" placeholder="luis@gmail.com" name="email" id="email" oninput="changeInput(event)"  autocomplete="off">
          </label>
        </div>
        <div class="form-control">
          <label for="phone">
            Teléfono
            <input type="text" placeholder="931448012" name="telefono" id="phone" oninput="changeInput(event)"  autocomplete="off">
          </label>
        </div>
        <div class="form-control">
          <label for="direccion">
            Dirección
            <input type="text" placeholder="Madrid" name="direccion" id="direccion" oninput="changeInput(event)"  autocomplete="off">
          </label>
        </div>
        <button type="submit" class="primary">Siguiente <img src="assets/images/arrow-right.svg" alt="" style="width: 1.2rem;height: 1.2rem;"></button>
      </form>
    </div>
    <div style="display: none;" id="ordenador">
      <form method="POST">
        <h1>Registrar orden de reparación</h1>
        <p class="subtitle">Para registrar tu orden de reparación, necesitamos que completes este formulario con los datos de tu ordenador y la problemática.</p>
        <div class="form-control">
          <label for="tordenador">
          Tipo de ordenador
          <input type="text" placeholder="Laptop" name="tipoordenador" id="tordenador" oninput="changeInput(event)"  autocomplete="off">
        </label>
        </div>
        <div class="form-control">
          <label for="cordenador">
          Contraseña del ordenador
          <input type="password" placeholder="*****" name="password" id="cordenador" oninput="changeInput(event)"  autocomplete="off">
        </label>
        </div>
        <div class="form-control">
          <label for="marca">
          Marca del ordenador
          <input type="text" placeholder="Asus" name="marca" id="marca" oninput="changeInput(event)"  autocomplete="off">
        </label>
        </div>
        <div class="form-control">
          <label for="modelo">
          Modelo del ordenador
          <input type="text" placeholder="ML345" name="modelo" id="modelo" oninput="changeInput(event)" autocomplete="off">
        </label>
        </div>
        <div class="form-control">
        <label for="descripcion">
          Descripción del problema
          <input type="text" placeholder="No enciende" name="notas" id="descripcion" oninput="changeInput(event)">
        </label>
        </div>
        <div class="form-control">
          <label for="certificados" class="check">
            Cuenta con certificados digitales
            <input type="checkbox" name="certificado" id="certificados" oninput="changeInput(event)" autocomplete="off">
          </label>
        </div>
        <button type="submit" class="primary">Siguiente <img src="assets/images/arrow-right.svg" alt="" style="width: 1.2rem;height: 1.2rem;"></button>
      </form>
    </div>
    <div style="display: none;" id="orden">
      <form method="POST">
        <h1>Registrar orden de reparación</h1>
        <p class="subtitle">Para registrar tu orden de reparación, necesitamos que completes este formulario con el punto de recogida.</p>
        <label for="punto">
          Punto de recogida
          <select name="punto" id="punto" oninput="changeInput(event)">
            <?php
                include("config.php");
                $t_consulta = "SELECT * FROM puntos";
		        $query = mysqli_query($db, $t_consulta);
		        @mysqli_free_result( $t_query );
		        if (mysqli_num_rows($query)>0) {
    				while (   $row =  mysqli_fetch_array($query, MYSQLI_ASSOC)   ) {
    				    ?>
    				    <option value="<?php echo $row["GID"]; ?>"><?php echo $row["nombre"]." - ".$row["direccion"]; ?></option>
    				    <?php
    				}
		        }
                ?>
          </select>
        </label>
        <button type="submit" class="primary">Completar</button>
      </form>
    </div>
    <div style="display: none;" id="resultado">
      <div class="confetti">
        <div class="confetti-piece uno"></div>
        <div class="confetti-piece dos"></div>
        <div class="confetti-piece tres"></div>
        <div class="confetti-piece cuatro"></div>
        <div class="confetti-piece cinco"></div>
        <div class="confetti-piece seis"></div>
        <div class="confetti-piece siete"></div>
        <div class="confetti-piece ocho"></div>
        <div class="confetti-piece nueve"></div>
        <div class="confetti-piece diez"></div>
        <div class="confetti-piece once"></div>
        <div class="confetti-piece doce"></div>
        <div class="confetti-piece trece"></div>
      </div>
      <h1 class="success">Su orden ha sido registrada</h1>
      <p class="subtitle">Acaba de completar el registro con éxito, a continuación te proveemos los datos de acceso para que puedas realizar el seguimiento del mismo.</p>
      <div class="success result-form">
          <!---
        <div class="item-s">
          <h2>Número de orden: </h2>
          <div>32452</div>
        </div>
        <div class="item-s">
          <h2>Usuario: </h2>
          <div>luis32452</div>
        </div>
        <div class="item-s">
          <h2>Contraseña: </h2>
          <div>orden32452</div>
        </div>
        --->
      </div>
    </div>
  </div>
</div>
</body>
<script>
    function toArray(formData) {
      let jsonObject = {};
      formData.forEach((value, key) => {
        // Check if the key already exists in the jsonObject
        if (jsonObject.hasOwnProperty(key)) {
          // If it's an array, push the new value
          if (!Array.isArray(jsonObject[key])) {
            jsonObject[key] = [jsonObject[key]];
          }
          jsonObject[key].push(value);
        } else {
          // If the key doesn't exist, simply set the value
          jsonObject[key] = value;
        }
      });
      return jsonObject;
    }
  function changeInput(event) {
    let node = event.currentTarget.closest(".form-control");
    if (event.currentTarget.value === "") {
      let nodeError = document.createElement("p");
      nodeError.textContent = "El campo " + event.target.name + " no puede estar vacio";
      nodeError.classList.add("error-" +event.target.name);
      node.appendChild(nodeError);
    }
    else {
      let nodeError = node.querySelector("p[class^='error-']");
      if (nodeError) {
        node.removeChild(nodeError);
      }
    }
  }
  function StatusBar(selector, items) {
    this.items = items;
    this.selector = selector;
  }
  StatusBar.prototype.render = function (item) {
    let circle = document.querySelector(".step-" + item.id).querySelector(".circle");
    circle.className = "circle " + item.status;
    let p = document.querySelector(".step-" + item.id).querySelector("p");
    p.className = "active";
    if(item.status === "fulled") {
      let line = document.querySelector(".step-" + item.id + " + div");
      if(line) {
        line.className = "line active";
      }
    }
  }
  StatusBar.prototype.next = function () {
    let item_active = this.items.find((element) => element.status === "active");
    item_active.status = "fulled";
    this.render(item_active);
    let new_item_active = this.items[this.items.findIndex((element) => element === item_active) + 1];
    if(new_item_active) {
      new_item_active.status = "active";
      this.render(new_item_active);
    }
  }
  StatusBar.prototype.build = function () {
    let container = document.createElement("div");
    container.classList.add("container-status");

    for (const item in this.items) {
      let step = document.createElement("div");
      step.classList.add("step-" + this.items[item].id);

      let p = document.createElement("p");
      p.classList.add(this.items[item].status);
      p.textContent = this.items[item].title;

      let circle = document.createElement("div");
      circle.classList.add(this.items[item].status);
      circle.classList.add("circle");

      step.appendChild(p);
      step.appendChild(circle);
      container.append(step);

      if(item < this.items.length - 1) {
        let line = document.createElement("div");
        line.classList.add("line");
        container.append(line);
      }
    }
    document.querySelector(this.selector).appendChild(container);
  }

  function ValidatorFields(fieldsToValidate, fields) {
    this.fieldsToValidate = fieldsToValidate;
    this.fields = fields;
    this.errors = [];
  }
  ValidatorFields.prototype.validate = function () {
    for (let field of this.fields) {
      if (this.fieldsToValidate.includes(field[0]) && field[1] === "") {
        this.errors.push({"field": field[0], "message": "El campo " + field[0] + " no puede estar vacio"});
      }
    }
  }
  ValidatorFields.prototype.show = function () {
    for (let error of this.errors) {
      let node = document.querySelector('input[name="' + error.field + '"]').closest(".form-control");
      let nodeError = document.createElement("p");
      nodeError.textContent = error.message;
      nodeError.classList.add("error-" + error.field);
      node.appendChild(nodeError);
    }
  }
  ValidatorFields.prototype.clear = function () {
    for (let error of this.errors) {
      let node = document.querySelector('input[name="' + error.field + '"]').closest(".form-control");
      let nodeError = document.querySelector(".error-" + error.field);
      if(nodeError)
        node.removeChild(nodeError);
    }
    this.errors = [];
  }
  ValidatorFields.prototype.valid = function () {
    return this.errors.length === 0;
  }

  let status = [
    { id: 1, title: "Datos personales", status: "active" },
    { id: 2, title: "Datos del ordenador", status: "inactive" },
    { id: 3, title: "Confirmar orden", status: "inactive" }
  ];
  let fieldsValidateClient = [ "nombres", "dni", "email", "telefono", "direccion" ];
  let fieldsValidateComputer = [ "tipoordenador", "marca", "modelo", "notas" ];
  let fieldsValidateOrder = [ "punto" ];
  let dataForm = {};
  let result = null;
  let statusBar = new StatusBar(".container-form .status", status);
  statusBar.build();
  let validator = new ValidatorFields([], []);

  setTimeout(() => { document.querySelector(".container").classList.add("animated"); }, 0);

  window.addEventListener("DOMContentLoaded", () => {
    document.querySelector("#cliente form").addEventListener("submit", (event) => {
      event.preventDefault();
      validator.clear();
      let data = new FormData(event.target);
      dataForm = { ... dataForm, ...toArray(data) };
      validator = new ValidatorFields(fieldsValidateClient, data.entries());
      validator.validate();
      validator.show();
      if (validator.valid()) {
        statusBar.next();
        document.querySelector(".container-form #cliente").style.display = "none";
        document.querySelector(".container-form #ordenador").style.display = "block";
      }
    });
    document.querySelector("#ordenador form").addEventListener("submit", (event) => {
      event.preventDefault();
      validator.clear();
      let data = new FormData(event.target);
      dataForm = { ... dataForm, ...toArray(data) };;
      validator = new ValidatorFields(fieldsValidateComputer, data.entries());
      validator.validate();
      validator.show();
      if (validator.valid()) {
        statusBar.next();
        document.querySelector(".container-form #orden").style.display = "block";
        document.querySelector(".container-form #ordenador").style.display = "none";
      }
    });
    document.querySelector("#orden form").addEventListener("submit", async (event) => {
      event.preventDefault();
      validator.clear();
      let data = new FormData(event.target);
      dataForm = { ... dataForm, ...toArray(data), "register": 1 };
      validator = new ValidatorFields(fieldsValidateOrder, data.entries());
      validator.validate();
      validator.show();
      if (validator.valid()) {
          const urlSearchParams = new URLSearchParams(dataForm);
          const urlEncodedString = urlSearchParams.toString();
          console.log(urlEncodedString);
          try {
            const response = await fetch("https://clientes.repararelpc.es/ajax/regc.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/x-www-form-urlencoded",
              },
              body: urlEncodedString,
            });
            result = await response.json();
            console.log("Success:", result);
            statusBar.next();
            document.querySelector(".container-form #orden").style.display = "none";
            document.querySelector(".container-form #resultado").style.display = "flex";
            
            let div = document.createElement("div");
            div.classList.add("item-s");
            
            let h2 = document.createElement("h2");
            h2.textContent = "Número de orden:";
            
            let divIn = document.createElement("div");
            divIn.textContent = result.orden;
            
            div.appendChild(h2);
            div.appendChild(divIn);
            
            let divUser = document.createElement("div");
            divUser.classList.add("item-s");
            
            let h2User = document.createElement("h2");
            h2User.textContent = "Usuario:";
            
            let divInUser = document.createElement("div");
            divInUser.textContent = result.user;
            
            divUser.appendChild(h2User);
            divUser.appendChild(divInUser);
            
            let divPass = document.createElement("div");
            divPass.classList.add("item-s");
            
            let h2Pass = document.createElement("h2");
            h2Pass.textContent = "Contraseña:";
            
            let divInPass = document.createElement("div");
            divInPass.textContent = result.pass;
            
            divPass.appendChild(h2Pass);
            divPass.appendChild(divInPass);
            
            document.querySelector(".result-form").appendChild(div);
            document.querySelector(".result-form").appendChild(divUser);
            document.querySelector(".result-form").appendChild(divPass);
          } catch (error) {
            console.error("Error:", error);
          }  
      }
    });
  });
</script>
</html>