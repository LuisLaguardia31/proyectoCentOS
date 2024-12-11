<?php
    session_start();
    include("../Modelo/usuariosCRUD.php");
    setcookie("aviso","Usuario Eliminado Correctamente",time()+300);
    if($_POST["user"] == $_SESSION["username"]){
        eliminarUsuario($_SESSION["idUsuario"]);
        session_unset();
        session_destroy();
        header("Location: ../Controlador/index.php");
    }else{
        eliminarUsuario($_POST["idUsuario"]);
        header("Location: indexLogedAdmin.php");
    }
    
    
    
?>