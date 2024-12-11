<?php
    include("../Modelo/usuariosCRUD.php");
    $emojis = [
        ':sunglasses:' => '../Utilidad/emojiSunglasses.png',
        ':spiralEyes:' => '../Utilidad/emojiSpiralEyes.png',
        ':lookUp:' => '../Utilidad/emojiLookUp.png',
    ];
    echo '<div class="recipe-one-container">';
    echo '<div class="recipe">';
    echo '<h2>'.$receta["titulo"].'</h2>';
    echo '<div class="info">';
    echo '<div class="image-container">';
    echo '<p><strong>Usuario: </strong>'.$receta["username"].'</p><img src="'.$receta["usuarios_foto"].'" class="mini-recipe-image"/>';
    echo '</div>';
    echo '<form action="../Controlador/verPerfil.php" method="post">';
    echo '<input type="hidden" name="id" value="'.$receta["id_usuario"].'">';
    echo '<input type="submit" value="Ver Perfil" class="botonVerPerfil">';
    echo '</form>';
    echo '<div class="image-container">';
    echo '<img src="'.$receta["foto"].'" class="recipe-image">';
    echo '</div>';
    echo '<p><strong>Ingredientes: </strong>'.$receta["ingredientes"].'</p>';
    echo '<p><strong>Elaboracion: </strong>'.$receta["elaboracion"].'</p>';
    echo '<p><strong>Tipo de Cocción: </strong>'.$receta["tipo"].'</p>';
    switch($receta["dificultad"]){
        case "facil":
            echo '<p><strong>Dificultad: Facil</strong></p>';
            break;
        case "medio":
            echo '<p><strong>Dificultad: Medio</strong></p>';
            break;
        case "dificil":
            echo '<p><strong>Dificultad: Dificil</strong></p>';
            break;
        default:
            echo '<p><strong>Dificultad: Muy Dificil</strong></p>';
            break;
    }
    echo '<p><strong>Tiempo estimado: </strong>'.$receta["tiempoElaboracion"].'</p>';
    echo '<p><strong>Valoracion: </strong>'.$receta["valoracion"].'</p>';
    echo '<p><strong>Comentarios: </strong>';
    
    if ($comentarios) {
        echo '</p><div class="comentarios-container">';
        foreach ($comentarios as $comentario) {
            if ($comentario['id_comentario_padre'] == null) {
                $comentario_contenido = $comentario['contenido'];
                foreach ($emojis as $codigo => $imagen) {
                    $comentario_contenido = str_replace($codigo, '<img src="' . $imagen . '" alt="' . $codigo . '" class="emoji">', $comentario_contenido);
                }
                echo '<div class="comentario nivel-1">';
                echo '<p><strong ' . ($comentario["rol"] == "Administrador" ? "style='color: darkred;'" : "style='color: black;'") . '>' . $comentario['nombre_usuario'] . ':</strong> ' . $comentario_contenido;
                echo ' -> ' . $comentario['fecha_creacion'] . '</p>';
                
                if($comentario['contenido'] != "\"Este comentario ha sido borrado por un administrador\"" && $comentario['contenido'] != "\"Este comentario ha sido borrado por el usuario\""){
                    echo '<div class="btn-container">';
                    if (isset($_SESSION['idUsuario']) && ($_SESSION['idUsuario'] == $comentario['id_usuario'] || $_SESSION['rol'] == "Administrador")) {
                        echo '<form method="POST" action="eliminarComentario.php">';
                        echo '<input type="hidden" name="id" value="' . $comentario['id'] . '">';
                        echo '<input type="hidden" name="id_user" value="' . $comentario['id_usuario'] . '">';
                        echo '<input type="hidden" name="idUser" value="' . $_SESSION['idUsuario'] . '">';
                        echo '<input type="hidden" name="rol" value="' . $_SESSION["rol"] . '">'; 
                        echo '<input type="submit" value="Eliminar Comentario" class="btnComentario">';
                        echo '</form>';
                    }
                    if (isset($_SESSION['idUsuario']) && $_SESSION['idUsuario'] == $comentario['id_usuario']) {
                        echo '<form method="POST" action="modificarComentario.php">';
                        echo '<textarea name="comentario" maxlength="500" rows="2" cols="25" required>' . $comentario['contenido'] . '</textarea>';
                        echo '<input type="hidden" name="id" value="' . $comentario['id'] . '">';
                        echo '<input type="submit" value="Modificar Comentario" class="btnComentario">';
                        echo '</form>';
                    }
                    if (isset($_SESSION['idUsuario'])) {
                        echo '<form method="POST" action="responderComentario.php">';
                        echo '<textarea name="respuesta" maxlength="500" rows="1" cols="25" placeholder="Responde aquí" required></textarea>';
                        echo '<input type="hidden" name="idComentario" value="' . $comentario['id'] . '">';
                        echo '<input type="hidden" name="idReceta" value="' . $receta['id'] . '">';
                        echo '<input type="hidden" name="idUsuario" value="' . $_SESSION["idUsuario"] . '">';
                        echo '<input type="submit" value="Responder" class="btnComentario">';
                        echo '</form>';
                    }
                    echo '</div>';
                }else{
                    echo '<br>';
                }
                echo '</div>';
                mostrarRespuestas($comentarios, $comentario['id'], 1, $receta["id"]);
            }
        }
        echo '</div>';
    } else {
        echo 'No hay comentarios aún. ¡Sé el primero en comentar!</p>';
    }

    echo '</div>';
    echo '</div>';
?>

<?php
    function mostrarRespuestas($comentarios, $id_comentario_padre, $nivel, $idReceta) {
        $emojis = [
            ':sunglasses:' => '../Utilidad/emojiSunglasses.png',
            ':spiralEyes:' => '../Utilidad/emojiSpiralEyes.png',
            ':lookUp:' => '../Utilidad/emojiLookUp.png',
        ];
        foreach ($comentarios as $comentario) {
            if ($comentario['id_comentario_padre'] == $id_comentario_padre) {
                $marginLeft = $nivel * 20; 
                $comentario_contenido = $comentario['contenido'];
                foreach ($emojis as $codigo => $imagen) {
                    $comentario_contenido = str_replace($codigo, '<img src="' . $imagen . '" alt="' . $codigo . '" class="emoji">', $comentario_contenido);
                }
                echo '<div class="comentario nivel-1" style="margin-left: ' . $marginLeft . 'px;">';
                echo '<p><strong ' . ($comentario["rol"] == "Administrador" ? "style='color: darkred;'" : "style='color: black;'") . '>' . $comentario['nombre_usuario'] . ':</strong> ' . $comentario_contenido;
                echo ' -> ' . $comentario['fecha_creacion'] . '</p>';
                
                if($comentario['contenido'] != "\"Este comentario ha sido borrado por un administrador\"" && $comentario['contenido'] != "\"Este comentario ha sido borrado\""){
                    echo '<div class="btn-container">';
                    if (isset($_SESSION['idUsuario']) && ($_SESSION['idUsuario'] == $comentario['id_usuario'] || $_SESSION['rol'] == "Administrador")) {
                        echo '<form method="POST" action="eliminarComentario.php">';
                        echo '<input type="hidden" name="id" value="' . $comentario['id'] . '">';
                        echo '<input type="hidden" name="id_user" value="' . $comentario['id_usuario'] . '">';
                        echo '<input type="hidden" name="idUser" value="' . $_SESSION['idUsuario'] . '">';
                        echo '<input type="hidden" name="rol" value="' . $_SESSION["rol"] . '">'; 
                        echo '<input type="submit" value="Eliminar Comentario" class="btnComentario">';
                        echo '</form>';
                    }
                    if (isset($_SESSION['idUsuario']) && $_SESSION['idUsuario'] == $comentario['id_usuario']) {
                        echo '<form method="POST" action="modificarComentario.php">';
                        echo '<textarea name="comentario" maxlength="500" rows="2" cols="25" required>' . $comentario['contenido'] . '</textarea>';
                        echo '<input type="hidden" name="id" value="' . $comentario['id'] . '">';
                        echo '<input type="submit" value="Modificar Comentario" class="btnComentario">';
                        echo '</form>';
                    }
                    if (isset($_SESSION['idUsuario'])) {
                        echo '<form method="POST" action="responderComentario.php">';
                        echo '<textarea name="respuesta" maxlength="500" rows="1" cols="25" placeholder="Responde aquí" required></textarea>';
                        echo '<input type="hidden" name="idComentario" value="' . $comentario['id'] . '">';
                        echo '<input type="hidden" name="idReceta" value="' . $idReceta . '">';
                        echo '<input type="hidden" name="idUsuario" value="' . $_SESSION["idUsuario"] . '">';
                        echo '<input type="submit" value="Responder" class="btnComentario">';
                        echo '</form>';
                    }
                    echo '</div>';
                }else{
                    echo '<br>';
                }
                echo '</div>';
                mostrarRespuestas($comentarios, $comentario['id'], $nivel + 1, $idReceta); 
            }
        }
    }
?>
