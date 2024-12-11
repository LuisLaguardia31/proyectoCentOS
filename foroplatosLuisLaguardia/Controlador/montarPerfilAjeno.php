<?php
    include ("../Modelo/usuariosCRUD.php");

    $usuario = selectUsuarioById($_POST["id"]);
    
    foreach($usuario as $clave=>$valor){
        
        if($usuario["id"] != 0 && $usuario["id"] != null){
            switch($clave){
                case "foto":
                    echo '<div class="informacionUsuario">';
                    echo '<div class="campo">';
                    echo '<h2>Foto</h2>';
                    echo '<div class="info">';
                    echo '<div class="image-container">';
                    echo '<img src="'.$valor.'" class="image" name="foto">';
                    echo '<input type="hidden" name="foto" value="'.$valor.'">';
                    echo '</div></div>';
                    echo '</div></div>';
                    break;
                case "rol":
                    echo '<div class="informacionUsuario">';
                    echo '<div class="campo">';
                    echo '<h2>Rol</h2>';
                    if(isset($_SESSION["rol"]) && $_SESSION["rol"] == "Administrador"){
                        echo '<form action="../Controlador/modificarRol.php" method="post">';
                        echo '<input type="hidden" name="id" value="'.$usuario["id"].'">';
                        echo '<div id="'.$clave.'" class="info"><select name="rol">
                        <option value="Administrador" '.($valor=="Administrador"?"selected":"").'>Administrador</option>
                        <option value="Usuario" '.($valor=="Usuario"?"selected":"").'>Usuario</option>
                        </select></div></form>';
                    }else{
                        echo '<div id="'.$clave.'" class="info">'.$valor.'</div>';
                    }
                    echo '</div></div>';
                    break;
                case "username":
                    echo '<div class="informacionUsuario">';
                    echo '<div class="campo">';
                    echo '<h2>Nombre de Usuario</h2>';
                    echo '<div id="'.$clave.'" class="info">'.$valor.'</div>';
                    echo '</div></div>';
                    break;
                case "experience":
                    echo '<div class="informacionUsuario">';
                    echo '<div class="campo">';
                    echo '<h2>Experiencia</h2>';
                    echo '<div id="'.$clave.'" class="info">'.$valor.'</div>';
                    echo '</div></div>';
                    break;
                case "email":
                    echo '<div class="informacionUsuario">';
                    echo '<div class="campo">';
                    echo '<h2>Email</h2>';
                    echo '<div id="'.$clave.'" class="info">'.$valor.'</div>';
                    echo '</div></div>';
                    break;
            }
        }else{
            $_SESSION["error"] = "Este usuario ha sido Borrado";
            header("Location: ../Controlador/index.php");
        }
        
    }
    if(isset($_SESSION["idUsuario"])){
        echo '<form action="../Controlador/seguirUsuario.php" method="post">';
        echo '<input type="hidden" name="idSeguidor" value="'.$_SESSION["idUsuario"].'">';
        echo '<input type="hidden" name="idSeguido" value="'.$usuario["id"].'">';
        echo '<input type="submit" name="siguiendo" value="'.(seSiguen($_SESSION["idUsuario"],$usuario["id"])>0?"Dejar de Seguir":"Seguir").'">';
        echo '</form>';
    }
    

?>