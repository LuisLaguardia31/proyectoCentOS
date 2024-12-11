<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(isset($_POST["id"]) && isset($_POST["idUser"]) && isset($_POST["id_user"]) && isset($_POST["rol"]) && $_POST["id"] != "" && $_POST["idUser"] != "" && $_POST["id_user"] != "" && $_POST["rol"] != ""){
        include("../Modelo/comentariosCRUD.php");
        if($_POST["idUser"] == $_POST["id_user"]){
            eliminarComentario($_POST["id"],$_POST["rol"]);
        } else{
            eliminarComentarioAdmin($_POST["id"],$_POST["rol"]);
        }
        
        header("Location: ../Controlador/index.php");
    }else{
        $_SESSION["error"] = "Te ha faltado algun campo por rellenar";
        header("Location: ../Controlador/index.php");
    }
?>