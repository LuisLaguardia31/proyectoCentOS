<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(!isset($_POST["id"])
        || !isset($_POST["valoracion"])){
        $_SESSION["error"] = "Te ha faltado algun campo por rellenar, volviendo a menu de inicio";
        header("Location: ../Controlador/index.php");
    }else{
        include("../Modelo/recetasCRUD.php");
        $conseguido = modificarValoracion($_POST["id"], $_POST["valoracion"]);
        if($conseguido){
            setcookie("aviso", "Valoracion modificada Correctamente", time()+300);
            header("Location: ../Controlador/index.php");
        }else{
            $_SESSION["error"] = "Te ha faltado algun campo por rellenar, volviendo a menu de inicio";
            header("Location: ../Controlador/index.php");
        }
    }
    
?>