<?php
    include("../Modelo/usuariosCRUD.php");
    $emojis = [
        ':sunglasses:' => '../Utilidad/emojiSunglasses.png',
        ':spiralEyes:' => '../Utilidad/emojiSpiralEyes.png',
        ':lookUp:' => '../Utilidad/emojiLookUp.png',
    ];
    echo '<div class="recipe-one-container">';
    echo '<div class="recipe">';
    echo '<div class="image-container">';
    if(isset($_SESSION["idUsuario"])){
        $seSiguen = seSiguen($_SESSION["idUsuario"],$receta["id_usuario"]);
    }
    echo '<p><strong>Usuario: </strong>'.$receta["username"].'</p><img src="'.$receta["usuarios_foto"].'" class="mini-recipe-image"/>'.($seSiguen>0?' <img src="../Utilidad/Seguido.png" class="mini-recipe-image"/>':'');
    echo '</div>';
    echo '<form action="../Controlador/verPerfil.php" method="post">';
    echo '<input type="hidden" name="id" value="'.$receta["id_usuario"].'">';
    echo '<input type="submit" value="Ver Perfil" class="botonVerPerfil">';
    echo '</form>';
    echo '<form action="../Controlador/validarModificarReceta.php" method="post" enctype="multipart/form-data">';
    echo '<h2><input type="text" name="titulo" value="'.$receta["titulo"].'"/></h2>';
    echo '<div class="info">';
    echo '<div class="image-container">';
    echo '<img src="'.$receta["foto"].'" class="recipe-image" name="foto">';
    echo '<input type="hidden" name="foto" value="'.$receta["foto"].'">';
    echo '<br><input type="file" name="nuevaFoto" id="nuevaFoto" accept="image/*">';
    echo '</div>';
    echo '<p><strong>Ingredientes: </strong><textArea name="ingredientes" rows="4" cols="50" required>'.$receta["ingredientes"].'</textArea></p>';
    echo '<p><strong>Elaboracion: </strong><textArea name="elaboracion" rows="4" cols="50" required>'.$receta["elaboracion"].'</textArea></p>';
    echo '<p><strong>Tipo de Cocción: </strong>
    <select name="tipo" required>
    <option value="Recetas Tradicionales" '.($receta["tipo"]=="Recetas Tradicionales"?"selected":"").'>Recetas Tradicionales</option>
    <option value="Recetas de Slow Food" '.($receta["tipo"]=="Recetas de Slow Food"?"selected":"").'>Recetas de Slow Food</option>
    <option value="Recetas de Freidoras Sin Aceite" '.($receta["tipo"]=="Recetas de Freidoras Sin Aceite"?"selected":"").'>Recetas de Freidoras Sin Aceite</option>
    </select>';
    echo '<p><strong>Dificultad: </strong>
    <select name="dificultad" required>
    <option value="facil" '.($receta["dificultad"]=="facil"?"selected":"").'>Facil</option>
    <option value="medio" '.($receta["dificultad"]=="medio"?"selected":"").'>Medio</option>
    <option value="dificil" '.($receta["dificultad"]=="dificil"?"selected":"").'>Dificil</option>
    <option value="muy dificil" '.($receta["dificultad"]=="muy dificil"?"selected":"").'>Muy Dificil</option>
    </select>';
    echo '<p><strong>Tiempo estimado: </strong><input type="text" name="tiempoElaboracion" value="'.$receta["tiempoElaboracion"].'" required/></p>';
    echo '<p><strong>Valoracion: </strong>
    <select name="valoracion" required>
    <option value="1" '.($receta["valoracion"]=="1"?"selected":"").'>1</option>
    <option value="2" '.($receta["valoracion"]=="2"?"selected":"").'>2</option>
    <option value="3" '.($receta["valoracion"]=="3"?"selected":"").'>3</option>
    <option value="4" '.($receta["valoracion"]=="4"?"selected":"").'>4</option>
    <option value="5" '.($receta["valoracion"]=="5"?"selected":"").'>5</option>
    </select>
    <input type="hidden" name="id" value="'.$receta["id"].'"/>
    <input type="submit" value="Modificar Receta"/>
    </p>';    
    echo '</form>';
    echo '<form action="../Controlador/crearComentario.php" method="post">';
    echo '<textArea name="comentario" maxlength="500" placeholder="Escribe tu comentario aquí..." rows="4" cols="50" required></textArea>';
    echo '<input type="hidden" name="idUsuario" value="'.$_SESSION["idUsuario"].'"/>';
    echo '<input type="hidden" name="idReceta" value="'.$receta["id"].'"/>';
    echo '<input type="submit" value="Comentar"/>';
    echo '</form>';
    echo '<p><strong>Comentarios: </strong>';
    
    if ($comentarios) {
        echo '</p><div class="comentarios-container">';
        foreach ($comentarios as $comentario) {
            if ($comentario['id_comentario_padre'] == null) {
                $comentario_contenido = $comentario['contenido'];
                foreach ($emojis as $codigo => $imagen) {
                    $comentario_contenido = str_replace($codigo, '<img src="' . $imagen . '" alt="' . $codigo . '" class="emoji">', $comentario_contenido);
                }
                echo '<div class="comentario nivel-1" '.($_SESSION["idUsuario"]==$comentario["id_usuario"]?'style="background-color: #FFCC99;"':'').'>';
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
    echo '</div></div>';
    echo '<form action="../Controlador/eliminarReceta.php" method="post">';
    echo '<input type="hidden" name="id" value="'.$receta["id"].'"/>';
    echo '<input type="submit" value="Eliminar Receta"/>';
    echo '</form>';
    
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
                echo '<div class="comentario nivel-1" '.($_SESSION["idUsuario"]==$comentario["id_usuario"]?'style="margin-left: ' . $marginLeft . 'px; background-color: #FFCC99;"':'style="margin-left: ' . $marginLeft . 'px;"').'>';
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