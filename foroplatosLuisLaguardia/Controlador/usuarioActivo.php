<?php
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["pwd"] = $_POST["pwd"];
    $_SESSION["time"] = time()+300;
    $_SESSION["rol"] = $user["rol"];
    $_SESSION["idUsuario"] = $user["id"];
?>