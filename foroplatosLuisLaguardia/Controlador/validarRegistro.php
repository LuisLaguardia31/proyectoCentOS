<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    include("../Modelo/existeUsuario.php");
    if(!(isset($_POST["username"]) 
    && isset($_POST["pwd"]) 
    && isset($_POST["name"]) 
    && isset($_POST["surname"]) 
    && isset($_POST["experience"]) 
    && isset($_POST["email"]))
    || $_POST["username"] == "" 
    || $_POST["pwd"] == ""
    || $_POST["name"] == "" 
    || $_POST["surname"] == ""
    || $_POST["experience"] == "" 
    || $_POST["email"] == ""){
        $_SESSION["error"] = "Te has dejado un campo vacio";
        header("Location: ../Vista/registro.php");
    }else if(existeUsuario($_POST["username"],$_POST["pwd"])){
        $_SESSION["error"] = "Ya existe ese nombre de usuario, pruebe con otro";
        header("Location: ../Vista/registro.php");
    }else if(strlen($_POST["pwd"])<6){
        $_SESSION["error"] = "La contraseña ha de tener un minimo de 6 caracteres";
        header("Location: ../Vista/registro.php");
    }else{
        include("../Controlador/registro.php");
    }
?>