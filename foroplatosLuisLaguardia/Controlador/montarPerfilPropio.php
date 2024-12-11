<?php
    include ("../Modelo/usuariosCRUD.php");

    $usuario = selectUsuarioById($_SESSION["idUsuario"]);
    
    echo '<form action="../Controlador/modificarPerfil.php" method="post" enctype="multipart/form-data">';
    foreach($usuario as $clave=>$valor){
        
        switch($clave){
            case "foto":
                echo '<div class="informacionUsuario">';
                echo '<div class="campo">';
                echo '<h2>Foto</h2>';
                echo '<div class="info">';
                echo '<div class="image-container">';
                echo '<img src="'.$valor.'" class="image" name="foto">';
                echo '<input type="hidden" name="foto" value="'.$valor.'">';
                echo '<br><input type="file" name="nuevaFoto" id="nuevaFoto" accept="image/*">';
                echo '</div></div>';
                echo '</div></div>';
                break;
            case "rol":
                echo '<div class="informacionUsuario">';
                echo '<div class="campo">';
                echo '<h2>Rol</h2>';
                echo '<div id="'.$clave.'" class="info"><span>'.$valor.'</span><input type="hidden" name="'.$clave.'" value="'.$valor.'"></div>';
                echo '</div></div>';
                break;
            case "username":
                echo '<div class="informacionUsuario">';
                echo '<div class="campo">';
                echo '<h2>Nombre de Usuario</h2>';
                echo '<div id="'.$clave.'" class="info"><input type="text" name="'.$clave.'" value="'.$valor.'"/></div>';
                echo '</div></div>';
                break;
            case "name":
                echo '<div class="informacionUsuario">';
                echo '<div class="campo">';
                echo '<h2>Nombre</h2>';
                echo '<div id="'.$clave.'" class="info"><input type="text" name="'.$clave.'" value="'.$valor.'"/></div>';
                echo '</div></div>';
                break;
            case "surname":
                echo '<div class="informacionUsuario">';
                echo '<div class="campo">';
                echo '<h2>Apellido</h2>';
                echo '<div id="'.$clave.'" class="info"><input type="text" name="'.$clave.'" value="'.$valor.'"/></div>';
                echo '</div></div>';
                break;
            case "experience":
                echo '<div class="informacionUsuario">';
                echo '<div class="campo">';
                echo '<h2>Experiencia</h2>';
                echo '<div id="'.$clave.'" class="info"><select name="'.$clave.'">';
                echo '<option value="Junior"'.($valor=="Junior"?" selected":"").'>Junior</option>';
                echo '<option value="Asociado"'.($valor=="Asociado"?" selected":"").'>Asociado</option>';
                echo '<option value="Nivel Medio"'.($valor=="Nivel Medio"?" selected":"").'>Nivel Medio</option>';
                echo '<option value="Senior"'.($valor=="Senior"?" selected":"").'>Senior</option>';
                echo'</select></div>';
                echo '</div></div>';
                break;
            case "email":
                echo '<div class="informacionUsuario">';
                echo '<div class="campo">';
                echo '<h2>Email</h2>';
                echo '<div id="'.$clave.'" class="info"><input type="text" name="'.$clave.'" value="'.$valor.'"/></div>';
                echo '</div></div>';
                break;
            default:
                echo '<input type="hidden" name="'.$clave.'" value="'.$valor.'">';
                break;
        }
        
    }
    echo '<input type="submit" value="Modificar Usuario"/>';
    echo '</form>';

    echo '<form action="../Controlador/verificarModificarContrasenya.php" method="post">';
    echo '<div class="informacionUsuario">';
    echo '<div class="campo">';
    echo '<h2>Contraseña</h2>';
    echo '<div id="pwd" class="info"><input type="submit" value="Modificar Contraseña"/></div>';
    echo '</div></div>';
    echo '</form>';
?>