<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(isset($_POST["idComentario"]) && isset($_POST["idReceta"]) && isset($_POST["idUsuario"]) && isset($_POST["respuesta"]) && $_POST["idComentario"] != "" && $_POST["idReceta"] != "" && $_POST["idUsuario"] != "" && $_POST["respuesta"] != ""){
        include("../Modelo/comentariosCRUD.php");
        contestarComentario($_POST["respuesta"],$_POST["idReceta"],$_POST["idUsuario"],$_POST["idComentario"]);
        header("Location: ../Controlador/index.php");
    }else{
        $_SESSION["error"] = "Te ha faltado algun campo por rellenar";
        header("Location: ../Controlador/index.php");
    }
?>
