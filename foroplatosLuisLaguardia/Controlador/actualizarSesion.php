<?php
    if(isset($_SESSION["time"]) && $_SESSION["time"]<time()){
        session_unset();
        session_destroy();
        session_start();
        $_SESSION["error"] = "Has estado mucho tiempo inactivo, ergo se te ha cerrado la sesion";
        header("Location: ../Controlador/index.php");
    }else{
        $_SESSION["time"] = time()+300;
    }
?>