<?php 
    session_start(); 
    include("../Controlador/actualizarSesion.php");
    if(isset($_SESSION["username"])){
        $_SESSION["error"] = "Ya habias inicializado sesion";
        header("Location: ../Controlador/index.php");
    }
?>
    
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styleRegistro.css">
</head>
<body>
    <header><h1>Inicio de sesión</h1></header>
    <nav class="menu">
        <ul>
            <li><a href="../Controlador/index.php">Volver</a></li>
        </ul>
    </nav>
    <main>
        <form class="formulario" action="../Controlador/validarRegistro.php" method="post" enctype="multipart/form-data">
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
                <h2>Foto</h2>
                <div class="datos">
                    <p><input type="file" name="foto"></p>
                </div>
            </div>
            <p></p>
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
                <h2>Nombre</h2>
                <div class="datos">
                    <p><input type="text" placeholder="Nombre" name="name" size="80%"></p>
                </div>
            </div>
            <p></p>
            <div class="campo">
                <h2>Apellidos</h2>
                <div class="datos">
                    <p><input type="text" placeholder="Apellidos" name="surname" size="80%"></p>
                </div>
            </div>
            <p></p>
            <div class="campo">
                <h2>Experiencia</h2>
                <div class="datos">
                    <p><select name="experience">
                        <option value="Junior" selected>Junior</option>
                        <option value="Asociado">Asociado</option>
                        <option value="Nivel Medio">Nivel Medio</option>
                        <option value="Nivel Medio">Senior</option>
                    </select></p>
                </div>
            </div>
            <p></p>
            <div class="campo">
                <h2>Email</h2>
                <div class="datos">
                    <p><input type="text" placeholder="Email" name="email" size="80%"></p>
                </div>
            </div>
            <p></p>
            <div class="campo">
                <h2>Validar</h2>
                <div class="datos">
                    <p><input type="submit" name="register" value="Registrar"></p>
                </div>
            </div>
        </form>
    </main>
    <footer>
        <p>2024 Foro de Recetas de Cocina</p>
    </footer>
</body>