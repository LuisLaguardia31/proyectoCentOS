<?php
    if(isset($_POST["username"]) && isset($_POST["pwd"])){
        include("../Modelo/usuariosCRUD.php");
        $id = selectUsuarioByUsername($_POST["username"]);
        $user = selectUsuarioById($id);
        include("../Controlador/usuarioActivo.php");
    }
    header("Location: ../Controlador/index.php");
?>