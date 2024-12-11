<?php
    if(isset($_POST["username"])){
        include("../Modelo/usuariosCRUD.php");
        insertUsuario($_FILES["foto"],"Usuario",$_POST['username'],$_POST['pwd'],$_POST['name'],$_POST['surname'],$_POST['experience'],$_POST['email']);
        $id = selectUsuarioByUsername($_POST["username"]);
        $user = selectUsuarioById($id);
        include("../Controlador/usuarioActivo.php");
        setcookie("aviso", "Usuario Logueado Correctamente", time()+300);
    }
    header("Location: ../Controlador/index.php");
?>