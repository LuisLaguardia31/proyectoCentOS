<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(isset($_POST["idUsuario"]) && isset($_POST["idReceta"]) && isset($_POST["comentario"]) && $_POST["idUsuario"] != "" && $_POST["idReceta"] != "" && $_POST["comentario"] != ""){
        include("../Modelo/comentariosCRUD.php");
        crearComentario($_POST["comentario"],$_POST["idReceta"],$_POST["idUsuario"]);
        setcookie("aviso","Comentario Creado con Exito",time()+300);
        header("Location: ../Controlador/index.php");
    }else{
        $_SESSION["error"] = "Te ha faltado algun campo por llenar";
        header("Location: ../Controlador/index.php");
    }
?>