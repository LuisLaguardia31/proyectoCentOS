<?php
    if(isset($_SESSION["rol"]) && $_SESSION["rol"] == "Administrador"){
        include("../Controlador/actualizarSesion.php");
    }else{
        header("Location: ../Controlador/index.php");
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
            <li><a href='../Controlador/index.php'>Volver a Inicio</a></li>
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
        ?>
        <div class="recipe-create-container">
            <form action="../Controlador/validarCrearReceta.php" method="post" enctype="multipart/form-data">
                <div class="recipe-create">    
                    <h2>Titulo</h2>
                    <div class="info">
                        <input type="text" name="titulo" placeholder="Titulo" require/>
                    </div>
                </div>
                <div class="recipe-create">    
                    <h2>Imagen</h2>
                    <div class="info">
                        <input type="file" name="foto" id="foto" accept="image/*" require>
                    </div>
                </div>
                <div class="recipe-create">    
                    <h2>Ingredientes</h2>
                    <div class="info">
                        <textArea name="ingredientes" rows="4" cols="50" placeholder="Mayonesa, Ketchup, Patata" required></textArea>
                    </div>
                </div>
                <div class="recipe-create">    
                    <h2>Elaboracion</h2>
                    <div class="info">
                        <textArea name="elaboracion" rows="4" cols="50" placeholder="Descripcion de los pasos a seguir para la receta" required></textArea>
                    </div>
                </div>
                <div class="recipe-create">    
                    <h2>Tipo de Coccion</h2>
                    <div class="info">
                        <select name="tipo" required>
                            <option value="Recetas Tradicionales" selected>Recetas Tradicionales</option>
                            <option value="Recetas de Slow Food">Recetas de Slow Food</option>
                            <option value="Recetas de Freidoras Sin Aceite">Recetas de Freidoras Sin Aceite</option>
                        </select>
                    </div>
                </div>
                <div class="recipe-create">    
                    <h2>Dificultad</h2>
                    <div class="info">
                        <select name="dificultad" required>
                            <option value="facil" selected>Facil</option>
                            <option value="medio">Medio</option>
                            <option value="dificil">Dificil</option>
                            <option value="muy dificil">Muy Dificil</option>
                        </select>
                    </div>
                </div>
                <div class="recipe-create">    
                    <h2>Tiempo Estimado</h2>
                    <div class="info">
                        <input type="text" name="tiempoElaboracion" placeholder="20 min" required/>
                    </div>
                </div>
                <div class="recipe-create">    
                    <h2>Valoracion</h2>
                    <div class="info">
                        <select name="valoracion" required>
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
                <?php echo '<input type="hidden" name="idUsuario" value="'.$_SESSION["idUsuario"].'"/>' ?>
                <input type="submit" value="Crear Receta"/>
            </form>
        </div>
    </main>

    <footer>
        <p>2024 Foro de Recetas de Cocina</p>
    </footer>
</body>
</html>
