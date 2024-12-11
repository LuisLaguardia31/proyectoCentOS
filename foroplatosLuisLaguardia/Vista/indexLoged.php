<?php
    if(!isset($_SESSION["username"])){
        header("Location: ../Controlador/index.php");
    }
    setcookie("aviso","",time());
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Foro de Recetas de Cocina</title>
    <link rel="stylesheet" href="../Vista/styleIndex.css">
</head>
<body>
    <header>
        <h1>Foro de Recetas de Cocina</h1>
    </header>
    
    <nav class="menu">
        <ul>
            <li><a href="../Controlador/VerPerfil.php">Perfil</a></li>
            <li><a href="../Controlador/cerrarSesion.php">Cerrar Sesion</a></li>
            <li><a href="../Controlador/verificarDarDeBaja.php">Darse de Baja</a></li>
            <li><a href="../Controlador/verSeguidores.php">Seguidores</a></li>
            <li><a href="../Controlador/verSeguidos.php">Seguidos</a></li>
        </ul>

        <form action="../Controlador/index.php" method="get">
            <label>Busqueda:
                Titulo<input type="radio" name="filtro" value="Título"/>
                Ingrediente<input type="radio" name="filtro" value="Ingrediente"/>
                <input type="text" name="valor" placeholder="Nombra el Título o Ingrediente"/>
                <input type="submit" value="Buscar"/> 
            </label>
        </form>
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
            include("../Controlador/montarReceta.php");           
        ?>
    </main>

    <footer>
        <p>2024 Foro de Recetas de Cocina</p>
    </footer>
</body>
</html>
