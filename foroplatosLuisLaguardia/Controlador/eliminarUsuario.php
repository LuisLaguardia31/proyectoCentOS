<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(isset($_SESSION["username"]) && isset($_SESSION["pwd"]) && isset($_SESSION["rol"])){
        if($_SESSION["rol"] == "Administrador"){
            if(isset($_POST["id"]) && $_POST["id"] != ""){
                include("../Modelo/usuariosCRUD.php");
                eliminarUsuario($_POST["id"]);
                header("Location: ../Controlador/index.php");
            }else{
                $_SESSION["error"] = "Te has dejado un campo por rellenar";
                header("Location: ../Controlador/index.php");
            }
        }else{
            $_SESSION["error"] = "Usuario sin permisos";
            header("Location: ../Controlador/index.php");
        }
    }else{
        $_SESSION["error"] = "Usuario no logueado";
        header("Location: ../Controlador/index.php");
    }
?>