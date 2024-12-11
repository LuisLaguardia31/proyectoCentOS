<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(!(isset($_POST["titulo"]) 
    && isset($_POST["ingredientes"]) 
    && isset($_POST["elaboracion"]) 
    && isset($_POST["tipo"]) 
    && isset($_POST["dificultad"])
    && isset($_POST["tiempoElaboracion"]) 
    && isset($_POST["valoracion"])
    && isset($_POST["idUsuario"]))
    || $_POST["titulo"] == "" 
    || $_POST["ingredientes"] == "" 
    || $_POST["elaboracion"] == ""
    || $_POST["tipo"] == "" 
    || $_POST["dificultad"] == ""
    || $_POST["tiempoElaboracion"] == "" 
    || $_POST["valoracion"] == ""
    || $_POST["idUsuario"] == ""){
        $_SESSION["error"] = "Te has dejado al menos un campo por añadir, volviendo";
        header("Location: ../Controlador/index.php");
    }else{
        $patron = '/^(?:[\p{L}0-9]+(?:, )?)+$/u';
        if(preg_match($patron, $_POST["ingredientes"])){
            include("../Modelo/recetasCRUD.php");
            crearReceta($_POST["titulo"], $_POST["ingredientes"], $_POST["elaboracion"], $_FILES["foto"], $_POST["tipo"], $_POST["dificultad"], $_POST["tiempoElaboracion"], $_POST["valoracion"], $_POST["idUsuario"]);
            header("Location: ../Controlador/index.php");
        }else{
            $_SESSION["error"] = "Has de introducir los ingredientes con el formato: 'ingrediente', 'ingrediente', 'ingrediente', ...";
            header("Location: ../Controlador/index.php");
        }
        
    }
?>