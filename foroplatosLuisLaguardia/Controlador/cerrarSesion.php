<?php
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../Controlador/index.php");
?>