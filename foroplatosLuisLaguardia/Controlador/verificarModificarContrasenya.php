<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(isset($_SESSION["username"]) && isset($_SESSION["pwd"])){
        include("../Vista/nuevaContrasenya.php");
    }else{
        $_SESSION["error"] = "No estabas registrado";
        header("Location: ../Controlador/index.php");
    }
?>