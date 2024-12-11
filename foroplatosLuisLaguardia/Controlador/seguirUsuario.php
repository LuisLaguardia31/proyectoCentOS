<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(isset($_SESSION["idUsuario"]) && isset($_POST["idSeguidor"]) && isset($_POST["idSeguido"]) && isset($_POST["siguiendo"])){
        include("../Modelo/usuariosCRUD.php");
        if($_POST["siguiendo"] == "Seguir"){
            $conseguido = seguirUsuario($_POST["idSeguidor"],$_POST["idSeguido"]);
            if($conseguido){
                setcookie("aviso","Usuario Seguido Correctamente",time()+300);
            }else{
                $_SESSION["error"] = "Ha habido algun error, volviendo";
            }
        }else{
            $conseguido = dejarSeguirUsuario($_POST["idSeguidor"],$_POST["idSeguido"]);
            if($conseguido){
                setcookie("aviso","Usuario Dejado de Seguir Correctamente",time()+300);
            }else{
                $_SESSION["error"] = "Ha habido algun error, volviendo";
            }
        }
        header("Location: ../Controlador/index.php");
    }else{
        $_SESSION["error"] = "No estas logueado";
        header("Location: ../Controlador/index.php");
    }
?>