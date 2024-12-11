<?php
    if(!isset($_POST["numPagina"])){
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Foro de Recetas de Cocina</title>
    <link rel="stylesheet" href="../Vista/styleReceta.css">
</head>
<body>
    <header>
        <h1>Detalle de la receta</h1>
    </header>
    
    <nav class="menu">
        <ul>
            <?php
                echo "<li><a href='../Controlador/index.php?numPagina=".$_POST['numPagina']."'>Volver a Inicio</a></li>";
            ?>
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
            include("../Controlador/detalleRecetaAdmin.php");
        ?>
    </main>

    <footer>
        <p>2024 Foro de Recetas de Cocina</p>
    </footer>
</body>
</html>
