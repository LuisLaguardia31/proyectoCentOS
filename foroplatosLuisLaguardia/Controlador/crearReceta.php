<?php
    session_start();
    if(isset($_SESSION["rol"]) && $_SESSION["rol"] = "Administrador"){
        include("../Vista/crearReceta.php");
    }else{
        $_SESSION["error"] = "No tienes los permisos para entrar en esta pagina";
        header("Location: ../Controlador/index.php");
    }
?>