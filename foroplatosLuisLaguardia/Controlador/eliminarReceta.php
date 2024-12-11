<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(!isset($_POST["id"]) || $_POST["id"] == ""){
        $_SESSION["error"] = "No se ha podido eliminar la receta";
        header("Location: ../Controlador/index.php");
    }else{
        include("../Modelo/recetasCRUD.php");
        eliminarReceta($_POST["id"]);
        header("Location: ../Controlador/index.php");
    }
?>