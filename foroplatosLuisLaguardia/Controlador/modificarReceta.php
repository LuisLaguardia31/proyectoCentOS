<?php
    include("../Controlador/actualizarSesion.php");
    if(!isset($_POST["id"]) 
    || !isset($_POST["titulo"]) 
    || !isset($_POST["ingredientes"]) 
    || !isset($_POST["elaboracion"]) 
    || !isset($_POST["tipo"]) 
    || !isset($_POST["dificultad"]) 
    || !isset($_POST["tiempoElaboracion"]) 
    || !isset($_POST["valoracion"])){
        $_SESSION["error"] = "Te ha faltado algun campo por rellenar, volviendo a menu de inicio";
        header("Location: ../Controlador/index.php");
    }else{
        include("../Controlador/guardarReceta.php");
        $rutaFoto = guardarReceta($_POST["foto"]);
        include("../Modelo/recetasCRUD.php");
        if(!isset($_SESSION["error"])){
            modificarReceta($_POST["id"],$_POST["titulo"],$_POST["ingredientes"],$_POST["elaboracion"],$rutaFoto,$_POST["tipo"],$_POST["dificultad"],$_POST["tiempoElaboracion"],$_POST["valoracion"]);
        }
        header("Location: ../Controlador/index.php");
    }
?>