<?php
    session_start();
    include("../Controlador/actualizarSesion.php");
    if(isset($_POST["antiguapwd"]) && $_POST["antiguapwd"] != "" && isset($_POST["nuevapwd"]) && $_POST["nuevapwd"] != ""&& isset($_POST["confirmapwd"]) && $_POST["confirmapwd"] != "" && isset($_POST["username"]) && $_POST["username"] != ""){
        if($_POST["username"] == $_SESSION["username"] && $_POST["antiguapwd"] = $_SESSION["pwd"]){

            if($_POST["nuevapwd"] == $_POST["confirmapwd"]){
                include("../Modelo/usuariosCRUD.php");
                $conseguido = modificarContrasenya($_SESSION["username"],$_POST["nuevapwd"]);
                if($conseguido){
                    $_SESSION["pwd"] = $_POST["nuevapwd"];
                    setcookie("aviso","Contraseña Modificada Correctamente",time()+300);
                    header("Location: ../Controlador/index.php");
                }else{
                    $_SESSION["error"] = "Algo a salido mal, volviendo al inicio";
                    header("Location: ../Controlador/index.php");
                }
            }else{
                $_SESSION["error"] = "No es correcta";
                header("Location: ../Controlador/index.php");
            }

        }else{
            $_SESSION["error"] = "Credenciales erroneas";
            header("Location: ../Controlador/index.php");
        }
    }else{
        $_SESSION["error"] = "Te ha faltado algun campo por llenar";
        header("Location: ../Controlador/index.php");
    }
?>