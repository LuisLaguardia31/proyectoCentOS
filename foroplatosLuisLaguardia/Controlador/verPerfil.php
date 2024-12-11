<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(isset($_SESSION["idUsuario"]) || isset($_POST["id"])){
        if(!isset($_POST["id"])){
            if(!isset($_SESSION["idUsuario"])){
                $_SESSION["error"] = "Usuario no especificado";
                header("Location: ../Controlador/index.php");
            }else{
                include "../Vista/perfilUsuario.php";  
            }
            
        }else {
            include "../Vista/perfilAjeno.php";  
        }
        
    }else{
        header("Location: ../Controlador/index.php");
    }
?>