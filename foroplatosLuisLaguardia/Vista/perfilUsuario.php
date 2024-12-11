<?php
    if(!isset($_SESSION["idUsuario"])){
        $_SESSION["error"] = "No se ha especificado ningun usuario, has vuelto a la pagina inicial";
        header("Location: ../Controlador/index.php");
    }    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <link rel="stylesheet" href="../Vista/stylePerfil.css">
</head>
<body>
    <header>
        <h1>Perfil </h1>
    </header>
    <nav class="menu">
        <ul>
            <li><a href="../Controlador/index.php">Volver</a></li>
        </ul>
    </nav>
    <main>
        <?php
            if(isset($_COOKIE["aviso"])){
                echo '<div class="contenedorMensajeAviso"><div class="mensajeAviso">'.$_COOKIE["aviso"].'</div></div>';
            }
            if(isset($_SESSION["error"])){
                echo '<div class="contenedorMensajeError"><div class="mensajeError">'.$_SESSION["error"].'</div></div>';
                unset($_SESSION["error"]);
            }
            include("../Controlador/montarPerfilPropio.php");
        ?>
    </main>
    <footer>
        <p>2024 Foro de Recetas de Cocina</div>
    </footer>
</body>
</html>