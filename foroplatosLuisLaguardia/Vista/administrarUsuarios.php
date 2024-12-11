<?php
    if(!isset($_SESSION["username"]) || !isset($_SESSION["rol"]) ||  $_SESSION["rol"]!="Administrador"){
        header("Location: ../Controlador/index.php");
    }
    setcookie("aviso","",time());
?>
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <link rel="stylesheet" href="../Vista/styleReceta.css">
</head>
<body>
    <header>
        <h1>Perfil </h1>
    </header>
    <nav class="menu">
        <ul>
            <li><a href="../Controlador/index.php">Volver</a></li>
        </ul>
    </nav>
    <main>
        <?php
            include("../Controlador/montarAdministracionUsuarios.php");
        ?>
    </main>
    <footer>
        <p>2024 Foro de Recetas de Cocina</div>
    </footer>
</body>
</html>