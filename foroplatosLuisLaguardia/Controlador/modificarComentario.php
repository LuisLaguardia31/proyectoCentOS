<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(isset($_POST["id"]) && isset($_POST["comentario"]) && $_POST["id"] != "" && $_POST["comentario"] != ""){
        include("../Modelo/comentariosCRUD.php");
        modificarComentario($_POST["id"],$_POST["comentario"]);
        setcookie("aviso","Comentario Modificado Correctamente",time()+300);
        header("Location: ../Controlador/index.php");
    }else{
        $_SESSION["error"] = "Te falta algun campo por rellenar";
        header("Location: ../Controlador/index.php");
    }
?>