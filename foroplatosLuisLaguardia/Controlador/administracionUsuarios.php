<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(isset($_SESSION["username"]) && isset($_SESSION["pwd"]) && isset($_SESSION["rol"])){
        if($_SESSION["rol"] == "Administrador"){
            include("../Vista/administrarUsuarios.php");
        }else{
            $_SESSION["error"] = "Usuario Sin Permisos";
            header("Location: ../Controlador/index.php");
        }
    }else{
        $_SESSION["error"] = "Usuario no Logueado";
        header("Location: ../Controlador/index.php");
    }
    
?>