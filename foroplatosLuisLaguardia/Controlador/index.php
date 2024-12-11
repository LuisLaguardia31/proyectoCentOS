<?php
    session_start();
    include("../Modelo/usuariosCRUD.php");
    if(isset($_GET["filtro"]) && isset($_GET["valor"]) && $_GET["filtro"] != "" && $_GET["valor"] != ""){
        $filtro=$_GET["filtro"]=="Título"?"Título":"Ingrediente";
        $valor= $_GET["valor"];
    }
    if (isset($_SESSION["username"]) && isset($_SESSION["pwd"]) && isset($_SESSION["rol"])) {
        $inicioSesion = obtenerUsuarioRegistrado($_SESSION["username"], $_SESSION["pwd"], $_SESSION["rol"]);
    
        if ($_SESSION["username"] == $inicioSesion["username"] && $_SESSION["pwd"] == $inicioSesion["pwd"]) {
            if ($inicioSesion["rol"] == "Administrador") {
                include("../Vista/indexLogedAdmin.php");
            } else {
                include("../Vista/indexLoged.php");
            }
        } else {
            session_destroy();
            session_start();
            $_SESSION["error"] = "No existe ese usuario y/o Contraseña, volviste al inicio";
            include("../Vista/index.php");
        }
    } else {
        include("../Vista/index.php");
        
    }
?>