<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    include("../Modelo/existeUsuario.php");
    if(!(isset($_POST["username"]) && isset($_POST["pwd"])) || $_POST["username"] == "" || $_POST["pwd"] == ""){
        $_SESSION["error"] = "Te has dejado un campo vacio";
        header("Location: ../Vista/login.php");
    }else if(!existeUsuario($_POST["username"])){
        $_SESSION["error"] = "El usuario y/o contraseña no coincide, prueba otra vez";
        header("Location: ../Vista/login.php");
    }else{
        include("../Controlador/login.php");
    }
?>