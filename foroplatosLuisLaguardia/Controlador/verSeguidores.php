<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(isset($_SESSION["rol"])){
        include("../Vista/verSeguidores.php");
    }else{
        $_SESSION["error"] = "No estas Logueado";
        header("Location: ../Controlador/index.php");
    }
?>  