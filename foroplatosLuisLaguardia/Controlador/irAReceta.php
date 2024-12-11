<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    include("../Modelo/recetasCRUD.php");
    include("../Modelo/comentariosCRUD.php");
    $receta = obtenerUnaReceta($_POST["idReceta"]);
    $comentarios = mostrarComentarios($receta["id"]);
    if(isset($_SESSION["error"])){
        header("Location: ../Controlador/index.php");
    }else{
        if(isset($_SESSION["rol"]) && $_SESSION["rol"] == "Administrador"){
            include("../Vista/detalleRecetaAdmin.php");
        }else if(isset($_SESSION["username"])){
            include("../Vista/detalleRecetaRegistrado.php");
        }else{
            include("../Vista/detalleReceta.php");
        }
    }
    
?>