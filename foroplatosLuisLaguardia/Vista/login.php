<?php 
    session_start(); 
    include("../Controlador/actualizarSesion.php");
    if(isset($_SESSION["username"])){
        $_SESSION["error"] = "Ya has inicializado sesion";
        header("Location: ../Controlador/index.php");
    }
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styleLogin.css">
</head>
<body>
    <header><h1>Inicio de sesión</h1></header>
    <nav class="menu">
        <ul>
            <li><a href="../Controlador/index.php">Volver</a></li>
        </ul>
    </nav>
    <main>
        <form class="formulario"  action="../Controlador/validarLogin.php" method="post">
            <?php
                if(isset($_COOKIE["aviso"])){
                    echo '<div class="contenedorMensajeAviso"><div class="mensajeAviso">'.$_COOKIE["aviso"].'</div></div>';
                }
                if(isset($_SESSION["error"])){
                    echo '<div class="contenedorMensajeError"><div class="mensajeError">'.$_SESSION["error"].'</div></div>';
                    unset($_SESSION["error"]);
                }
            ?>
            <div class="campo">
                <h2>Usuario</h2>
                <div class="datos">
                    <p><input type="text" placeholder="Nombre de usuario" name="username" size="80%"></p>
                </div>
            </div>
            <p></p>
            <div class="campo">
                <h2>Contraseña</h2>
                <div class="datos">
                    <p><input type="password" placeholder="Contraseña" name="pwd" size="80%"></p>
                </div>
            </div>
            <p></p>
            <div class="campo">
                <h2>Validar</h2>
                <div class="datos">
                    <p><input type="submit" name="login" value="Iniciar sesión"></p>
                </div>
            </div>
        </form>
    </main>
    <footer>
        <p>2024 Foro de Recetas de Cocina</p>
    </footer>
</body>