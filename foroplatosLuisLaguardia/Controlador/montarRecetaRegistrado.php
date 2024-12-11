<?php
    include ("../Controlador/controlRecetas.php");
    $recetas = null;
    if(isset($filtro) && isset($valor) && $filtro != "" && $valor != ""){
        if($filtro == "Título"){
            $recetas = obtenerRecetasFiltradas($valor, null, $primeraReceta, $tamanioPagina);
        }else{
            $recetas = obtenerRecetasFiltradas(null, $valor, $primeraReceta, $tamanioPagina);
        }
    }else{
        $recetas = obtenerRecetasFiltradas(null, null, $primeraReceta, $tamanioPagina);
    }
    for($i=0;$i<count($recetas);$i+=2){
        $seSiguen = 0;
        if(empty($recetas[$i+1])){
            echo '<div class="recipe-one-container">';
            echo '<div class="recipe">';
            echo '<h2>'.$recetas[$i]["titulo"].'</h2>';
            echo '<div class="info">';
            echo '<div class="image-container">';
            $seSiguen = seSiguen($_SESSION["idUsuario"],$recetas[$i]["id_usuario"]);
            echo '<p><strong>Usuario: </strong>'.$recetas[$i]["username"].' <img src="'.$recetas[$i]["usuarios_foto"].'" class="mini-recipe-image"/>'.($seSiguen>0?' <img src="../Utilidad/Seguido.png" class="mini-recipe-image"/>':'').'</p>';
            echo '</div>';
            echo '<form action="../Controlador/verPerfil.php" method="post">';
            echo '<input type="hidden" name="id" value="'.$recetas[$i]["id_usuario"].'">';
            echo '<input type="submit" value="Ver Perfil" class="botonVerPerfil">';
            echo '</form>';
            echo '<div class="image-container">';
            echo '<img src="'.$recetas[$i]["foto"].'" class="recipe-image">';
            echo '</div>';
            echo '<p><strong>Ingredientes: </strong>'.$recetas[$i]["ingredientes"].'</p>';
            echo '<p><strong>Elaboracion: </strong>'.$recetas[$i]["elaboracion"].'</p>';
            echo '<p><strong>Tipo de Cocción: </strong>'.$recetas[$i]["tipo"].'</p>';
            switch($recetas[$i]["dificultad"]){
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
            echo '<p><strong>Tiempo estimado: </strong>'.$recetas[$i]["tiempoElaboracion"].'</p>';
            echo '<p><strong>Valoracion: </strong>'.$recetas[$i]["valoracion"].'</p>';
            echo '<form action="../Controlador/irAReceta.php" method="post">';
            echo '<input type="hidden" name="idReceta" value="'.$recetas[$i]["id"].'">';
            echo '<input type="hidden" name="numPagina" value="'.$numPagina.'">';
            echo '<input type="submit" value="Ver Detalle" class="botonVerDetalle">';
            echo '</form></div></div>';
            echo '</div>';
        }else{
            echo '<div class="recipe-two-container">';
            echo '<div class="recipe">';
            echo '<h2>'.$recetas[$i]["titulo"].'</h2>';
            echo '<div class="info">';
            echo '<div class="image-container">';
            $seSiguen = seSiguen($_SESSION["idUsuario"],$recetas[$i]["id_usuario"]);
            echo '<p><strong>Usuario: </strong>'.$recetas[$i]["username"].' <img src="'.$recetas[$i]["usuarios_foto"].'" class="mini-recipe-image"/>'.($seSiguen>0?' <img src="../Utilidad/Seguido.png" class="mini-recipe-image"/>':'').'</p>';
            echo '</div>';
            echo '<form action="../Controlador/verPerfil.php" method="post">';
            echo '<input type="hidden" name="id" value="'.$recetas[$i]["id_usuario"].'">';
            echo '<input type="submit" value="Ver Perfil" class="botonVerPerfil">';
            echo '</form>';
            echo '<div class="image-container">';
            echo '<img src="'.$recetas[$i]["foto"].'" class="recipe-image">';
            echo '</div>';
            echo '<p><strong>Ingredientes: </strong>'.$recetas[$i]["ingredientes"].'</p>';
            echo '<p><strong>Elaboracion: </strong>'.$recetas[$i]["elaboracion"].'</p>';
            echo '<p><strong>Tipo de Cocción: </strong>'.$recetas[$i]["tipo"].'</p>';
            switch($recetas[$i]["dificultad"]){
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
            echo '<p><strong>Tiempo estimado: </strong>'.$recetas[$i]["tiempoElaboracion"].'</p>';
            echo '<p><strong>Valoracion: </strong>'.$recetas[$i]["valoracion"].'</p>';
            echo '<form action="../Controlador/irAReceta.php" method="post">';
            echo '<input type="hidden" name="idReceta" value="'.$recetas[$i]["id"].'">';
            echo '<input type="hidden" name="numPagina" value="'.$numPagina.'">';
            echo '<input type="submit" value="Ver Detalle" class="botonVerDetalle">';
            echo '</form></div></div>';
            echo '<div class="recipe">';
            echo '<h2>'.$recetas[$i+1]["titulo"].'</h2>';
            echo '<div class="info">';
            echo '<div class="image-container">';
            $seSiguen = seSiguen($_SESSION["idUsuario"],$recetas[$i+1]["id_usuario"]);
            echo '<p><strong>Usuario: </strong>'.$recetas[$i+1]["username"].' <img src="'.$recetas[$i+1]["usuarios_foto"].'" class="mini-recipe-image"/>'.($seSiguen>0?' <img src="../Utilidad/Seguido.png" class="mini-recipe-image"/>':'').'</p>';
            echo '</div>';
            echo '<form action="../Controlador/verPerfil.php" method="post">';
            echo '<input type="hidden" name="id" value="'.$recetas[$i+1]["id_usuario"].'">';
            echo '<input type="submit" value="Ver Perfil" class="botonVerPerfil">';
            echo '</form>';
            echo '<div class="image-container">';
            echo '<img src="'.$recetas[$i+1]["foto"].'">';
            echo '</div>';
            echo '<p><strong>Ingredientes: </strong>'.$recetas[$i+1]["ingredientes"].'</p>';
            echo '<p><strong>Elaboracion: </strong>'.$recetas[$i+1]["elaboracion"].'</p>';
            echo '<p><strong>Tipo de Cocción: </strong>'.$recetas[$i+1]["tipo"].'</p>';
            switch($recetas[$i+1]["dificultad"]){
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
            echo '<p><strong>Tiempo estimado: </strong>'.$recetas[$i+1]["tiempoElaboracion"].'</p>';
            echo '<p><strong>Valoracion: </strong>'.$recetas[$i+1]["valoracion"].'</p>';
            echo '<form action="../Controlador/irAReceta.php" method="post">';
            echo '<input type="hidden" name="idReceta" value="'.$recetas[$i+1]["id"].'">';
            echo '<input type="hidden" name="numPagina" value="'.$numPagina.'">';
            echo '<input type="submit" value="Ver Detalle" class="botonVerDetalle">';
            echo '</form></div></div></div>';
        }
    }
    echo "<br><ul class='paginacion'>";
    
    if(isset($filtro) && isset($valor) && $filtro != "" && $valor != ""){
        if($numPagina!=0){
            echo "<li><a href='../Controlador/index.php?numPagina=".($numPagina-1)."&filtro=".$filtro."&valor=".$valor."'> Anterior </a></li>";
        }
        if($filtro=="Título"){
            if($numPagina!=$maxPagina &&  count(obtenerRecetasFiltradas($valor, null, ($numPagina+1)*$tamanioPagina, $tamanioPagina))!=0){
                echo"<li><a href='../Controlador/index.php?numPagina=".($numPagina+1)."&filtro=".$filtro."&valor=".$valor."'> Siguiente </a></li>";
            }
        }else{
            if($numPagina!=$maxPagina &&  count(obtenerRecetasFiltradas(null, $valor, ($numPagina+1)*$tamanioPagina, $tamanioPagina))!=0){
                echo"<li><a href='../Controlador/index.php?numPagina=".($numPagina+1)."&filtro=".$filtro."&valor=".$valor."'> Siguiente </a></li>";
            }
        }
    }else{
        if($numPagina!=0){
            echo "<li><a href='../Controlador/index.php?numPagina=".($numPagina-1)."'> Anterior </a></li>";
        }
        if($numPagina!=$maxPagina &&  count(obtenerRecetasFiltradas(null, null, ($numPagina+1)*$tamanioPagina, $tamanioPagina))!=0){
            echo"<li><a href='../Controlador/index.php?numPagina=".($numPagina+1)."'> Siguiente </a></li>";
        }
    }
	
    echo "</ul>";
?>