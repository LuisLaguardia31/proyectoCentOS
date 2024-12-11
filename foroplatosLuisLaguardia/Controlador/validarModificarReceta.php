<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(isset($_SESSION["idUsuario"])){
        $patron = '/^([\p{L}0-9]+(?:, [\p{L}0-9]+)*)$/u';
        if(preg_match($patron, $_POST["ingredientes"])){
            include("../Controlador/modificarReceta.php");
        }else{
            $_SESSION["error"] = "Has de introducir los ingredientes con el formato: 'ingrediente', 'ingrediente', 'ingrediente', ...";
            header("Location: ../Controlador/index.php");
        }
    }else{
        $_SESSION["error"] = "No estas logueado";
        header("Location: ../Controlador/index.php");
    }

?>