<?php
    if(!isset($_SESSION["username"])){
        header("Location: ../Controlador/index.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Foro de Recetas de Cocina</title>
    <link rel="stylesheet" href="../Vista/styleDarDeBaja.css">
</head>
<body>
    <header>
        <h1>Foro de Recetas de Cocina</h1>
    </header>
    
    <nav class="menu">
        <ul>
            <li><a href="../Controlador/index.php">Volver</a></li>
        </ul>
    </nav>

    <main>
        <form action="../Controlador/darDeBaja.php" method="post">
        <h1>Estimado/a <?php echo $_SESSION["username"]; ?></h1>

        Lamentamos que estés decidiendo borrar tu cuenta. Queremos asegurarnos de que todo esté claro antes de proceder con la eliminación. Al eliminar tu cuenta:<br>
        <ul>
            <li>Se borrarán todos tus datos.</li>
            <li>Este proceso es irreversible y no podrás recuperar tu cuenta ni su información una vez eliminada.</li>
        </ul><br>
        Si realmente deseas continuar con la eliminación, por favor confirma tu decisión haciendo clic en el boton de abajo.<br>

        Atentamente,<br>
        El equipo de Foroplatos
        <input type="hidden" name="user" value="<?php echo $_SESSION["username"] ?>">
        <input type="submit" value="Confirmar">
        </form>
    </main>

    <footer>
        <p>2024 Foro de Recetas de Cocina</p>
    </footer>
</body>
</html>
