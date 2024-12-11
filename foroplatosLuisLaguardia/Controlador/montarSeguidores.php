<?php
    include ("../Controlador/controlSeguidores.php");

    $usuarios = seguidores($_SESSION["idUsuario"], $primerUsuario, $tamanioPagina);
    
    foreach($usuarios as $usuario){
        echo '<div class="recipe-one-container">';
        echo '<div class="recipe">';
        echo '<h2>'.$usuario["username"].'</h2>';
        echo '<div class="info">';
        if($_SESSION["rol"] == "Administrador"){
            echo '<form action="../Controlador/modificarRol.php" method="post">';
            echo '<p><strong>Rol: </strong>
                <select name="rol" required>
                <option value="Usuario" '.($usuario["rol"]=="Usuario"?"selected":"").'>Usuario</option>
                <option value="Administrador" '.($usuario["rol"]=="Administrador"?"selected":"").'>Administrador</option>
                </select>';
                echo '<input type="hidden" name="id" value="'.$usuario["id"].'">';
            echo '<input type="submit" value="Modificar Rol">';
            echo '</form>';
        }else{
            echo '<p><strong>Rol: </strong>'.$usuario["rol"].'</p>';
        }
        
        switch($usuario["experience"]){
            case "Senior":
                echo '<p><strong>Experiencia: </strong>Senior</p>';
                break;
            case "Asociado":
                echo '<p><strong>Experiencia: </strong>Asociado</p>';
                break;
            case "Nivel Medio":
                echo '<p><strong>Experiencia: </strong>Nivel Medio</p>';
                break;
            default:
                echo '<p><strong>Experiencia: </strong>Junior</p>';
                break;
        }
        echo '<p><strong>Email: </strong>'.$usuario["email"].'</p>';
        if($_SESSION["rol"] == "Administrador"){
                echo '<form action="../Controlador/eliminarUsuario.php", method="post">';
                echo '<input type="hidden" name="id" value="'.$usuario["id"].'">';
                echo '<input type="submit" value="Eliminar Usuario">';
                echo '</form>';
        }
        if(!seSiguen($_SESSION["idUsuario"],$usuario["id"])){
            echo '<form action="../Controlador/seguirUsuario.php" method="post">';
            echo '<input type="hidden" name="idSeguidor" value="'.$_SESSION["idUsuario"].'">';
            echo '<input type="hidden" name="idSeguido" value="'.$usuario["id"].'">';
            echo '<input type="submit" name="siguiendo" value="Seguir">';
            echo '</form>';
        }
        echo '</div></div></div><br>';
    }
    echo "<br><ul class='paginacion'>";
    if($numPagina!=0){
		echo "<li><a href='../Controlador/administracionUsuarios.php?numPagina=".($numPagina-1)."'> Anterior </a></li>";
	} 
	if($numPagina!=$maxPagina &&  count(seguidores($_SESSION["idUsuario"],($numPagina+1)*$tamanioPagina, $tamanioPagina))!=0){
		echo"<li><a href='../Controlador/administracionUsuarios.php?numPagina=".($numPagina+1)."'> Siguiente </a></li>";
	}
    echo "</ul>";
?>