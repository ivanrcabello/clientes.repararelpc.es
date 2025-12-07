        <style>
             .drop {
              position: fixed;
              top: 0;
              left: -70%; /* Inicia oculto */
              /*width: 60%;*/
              height: 100%;
              background-color: #f7f7f7;
              transition: left 0.3s ease-out;
              padding-top: 2rem;
              padding-left: 1.4rem;
              padding-right: 2.4rem;
              z-index:5;
              display: flex;
              justify-content: start;
              flex-direction: column;
              align-items: start;
              gap: 0.48rem;
              font-size: 0.92rem;
              font-weight: 300;
            }
            .drop .item {
              padding: 2rem;
            }
            .menu-mobile {
                width: 60%;
            }
            .menu-mobile .drop a {
              text-decoration: none;
              color: black;
            }
            .menu-mobile .drop li {
              list-style: none;
              border-bottom: 1px solid #5750501a;
              padding-bottom: 0.4rem;
              width: 100%;
            }
            .backdrop {
              position: absolute;
              inset: 0;
              background: #0000002e;
              cursor: pointer;
            }
            .menu-mobile .drop.active {
                left: 0%;
                /*width: 20%;*/
            }
        </style>
        <div class="menu-mobile">
            <img src="assets/images/hamburger.svg" alt="menu" style="width: 1.8rem;height: 1.8rem;cursor: pointer;">
            <ul class="drop">
                <li class="active"><a href="dashboard-cliente.php">Inicio</a></li>
                <li><a href="registro-garantia.php">Registro de garantía</a></li>
                <li><a href="seguimiento-garantia.php">Seguimiento de garantías</a></li>
            </ul>
        </div>
        <div class="menu">
            <ul>
                <!--
                <li style="font-weight: 300;font-size: 1.44rem;"><a href="dashboard-cliente.php" style="border:none;"><img src="assets/images/logo.png" alt="repararelpc.es" style="width: 10rem;height: auto;"></a></li>
                -->
                <li class="active"><a href="dashboard-cliente.php">Inicio</a></li>
                <li><a href="registro-garantia.php">Registro de garantía</a></li>
                <li><a href="seguimiento-garantia.php">Seguimiento de garantías</a></li>
            </ul>
            <ul>
                <form method="POST" action="#">
                    <input type="submit" name="logout" class="logout" value="Cerrar sesión">
                </form>
            </ul>
        </div>
        <script>
            let openMenu = false;
            let backdrop = null;
            window.addEventListener("DOMContentLoaded", () => {
                document.addEventListener("click", (event) => {
                    if (!openMenu && event.target.closest(".menu-mobile")) {
                        //document.querySelector(".menu-mobile .drop").style.left = "0%";
                        document.querySelector(".menu-mobile .drop").classList.add("active");
                        backdrop = document.createElement("div");
                        backdrop.className = "backdrop";
                        document.querySelector("body").appendChild(backdrop);
                        openMenu = true;
                    }
                    else {
                        if (openMenu && !event.target.closest(".menu-mobile")) {
                        //document.querySelector(".menu-mobile .drop").style.left = "-70%";
                        document.querySelector(".menu-mobile .drop").classList.remove("active");
                        document.querySelector("body").removeChild(backdrop);
                        openMenu = false;
                    }
                    }
                });
            });
        </script>