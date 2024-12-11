<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(isset($_SESSION["username"]) && isset($_SESSION["pwd"]) && isset($_SESSION["rol"])){
        if($_SESSION["rol"] == "Administrador"){
            if(isset($_POST["rol"]) && $_POST["rol"] != "" && isset($_POST["id"]) && $_POST["id"] != ""){
                include("../Modelo/usuariosCRUD.php");
                $conseguido = modificarRol($_POST["rol"], $_POST["id"]);
                if($conseguido){
                    setcookie("aviso","Rol Modificado Correctamente");
                    header("Location: ../Controlador/index.php");
                }else{
                    $_SESSION["error"] = "No se ha podido modificar el Rol del usuario";
                    header("Location: ../Controlador/index.php");
                }
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