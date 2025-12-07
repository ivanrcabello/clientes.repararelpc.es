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
    <title>Registro de garantía</title>
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

    .status.uno {
        color: #888282;
        background: #c7ccc724;
        border: 1.6px solid #dedfda;
    }

    .status.dos {
        background: #096ff01a;
        border: 1.6px solid #c6c8e8;
        color: #2f809f;
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

    button {
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
    
      .success {
        display: flex;
        justify-content: center;
        align-items: start;
        flex-direction: column;
        gap: 0.4rem;
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
  
  .resultado {
      display: none;
  }
  
        .menu-mobile {
          display: none;
        }
        .resultado.visible {
            display: flex;
          flex-direction: column;
          gap: 0.6rem;
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
        }
        .container {
            padding: 1.6rem;
        }
        .flex {
            gap: 0.4rem;
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
        .list tbody tr {
          flex-basis: auto;
          width: 100%;
        }
        
    }
</style>
<body>
<div class="container">
    <?php include('menu.php'); ?>
    <div class="flex">
        <div class="formulario">
                    <div class="flex-space">
            <div>
                <h1>Registro de garantías</h1>
                <p class="subtitle">Completa los siguientes campos para registrar la problemática cubierta por la garantía.</p>
            </div>
            <div class="buttons">
                <button class="secondary">Solicitar soporte remoto</button>
                <button class="primary">Crear orden de reparación</button>
            </div>
        </div>
        <form class="rg" method="POST">
            <div class="form-control">
                <label for="orden">
                    Órden de reparación
                    <select name="orden" id="orden" required>
                         <?php
                        include("config.php");
                        $t_consulta = "SELECT * FROM articulos  WHERE CID = ".$_SESSION['ID'];
        		        $query = mysqli_query($db, $t_consulta);
        		        @mysqli_free_result( $t_query );
        		        if (mysqli_num_rows($query)>0) {
            				while (   $row =  mysqli_fetch_array($query, MYSQLI_ASSOC)   ) {
            				    ?>
            				    <option value="<?php echo $row["AID"]; ?>"><?php echo "#".$row["AID"] . " - ". $row["articulo"] . " - ". $row["marca"] . " - ". $row["modelo"]; ?></option>
            				    <?php
            				}
        		        }
                        ?>
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label for="orden">
                    Descripción del problema
                    <textarea name="problema" id="problema" class="problema" required></textarea>
                </label>
            </div>
            <button class="primary font-weight-200 box-shadow-none" name="submit" type="submit">Registrar</button>
        </form>
        </div>
        <div class="resultado">
           <h1 class="success">Su petición de garantía ha sido registrada</h1>
           <p class="subtitle">Acabar de completar el registro con éxito, a continuación te proveemos el número de petición para que puedas realizar el seguimiento del mismo.</p>
          <div class="success result-form">
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
    
    window.addEventListener("DOMContentLoaded", () => {
    document.querySelector(".rg").addEventListener("submit", async (event) => {
        console.log(event);
      event.preventDefault();
      let data = new FormData(event.target);
      dataForm = toArray(data);
      
      const urlSearchParams = new URLSearchParams(dataForm);
      const urlEncodedString = urlSearchParams.toString();
      try {
            const response = await fetch("https://clientes.repararelpc.es/ajax/registrar-garantia.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/x-www-form-urlencoded",
              },
              body: urlEncodedString,
            });
            result = await response.json();
            console.log("Success:", result);
            
            let div = document.createElement("div");
            div.classList.add("item-s");
            
            let h2 = document.createElement("h2");
            h2.textContent = "Número de petición de garantía:";
            
            let divIn = document.createElement("div");
            divIn.textContent = result.orden;
            
            div.appendChild(h2);
            div.appendChild(divIn);
            
            document.querySelector(".result-form").appendChild(div);
            
            document.querySelector(".formulario").style.display = "none";
            document.querySelector(".resultado").classList.add("visible");
          } catch (error) {
            console.error("Error:", error);
          }  
      
    });
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