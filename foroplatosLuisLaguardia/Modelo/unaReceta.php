<?php
    include("../Modelo/recetasCRUD.php");
    $receta = obtenerUnaReceta($_GET["idReceta"]);

    foreach($receta as $campo => $valor){
        echo "<a href='unaReceta.php?idReceta={$receta['id']}>{$receta['titulo']}</a>'";
    }
?>