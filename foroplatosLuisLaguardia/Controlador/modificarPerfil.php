<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(!isset($_POST["id"]) 
    || !isset($_POST["rol"]) 
    || !isset($_POST["username"]) 
    || !isset($_POST["name"]) 
    || !isset($_POST["surname"]) 
    || !isset($_POST["experience"]) 
    || !isset($_POST["email"])){
        $_SESSION["error"] = "Te ha faltado algun campo por rellenar, volviendo a menu de inicio";
        header("Location: ../Controlador/index.php");
    }else{
        include("../Modelo/usuariosCRUD.php");
        $nombresRegistrados = obtenerNombresRegistrados();
        foreach($nombresRegistrados as $nombre){
            if($_POST["username"] == $nombre && $_POST["username"] != $_SESSION["username"]){
                $_SESSION["error"] = "Ese usuario ya existe, no se ha podido modificar, volviendo a menu de inicio";
                header("Location: ../Controlador/index.php");
                
            }
        }
        $conseguido = modificarUsuario($_POST["id"],$_POST["rol"],$_POST["username"],$_POST["name"],$_POST["surname"],$_POST["experience"],$_POST["email"]);
        if($conseguido){
            $_SESSION["username"] = $_POST["username"];
            setcookie("aviso", "Usuario modificado Correctamente", time()+300);
            header("Location: ../Controlador/index.php");
        }else{
            $_SESSION["error"] = "Te ha faltado algun campo por rellenar, volviendo a menu de inicio";
            header("Location: ../Controlador/index.php");
        }
    }
?>