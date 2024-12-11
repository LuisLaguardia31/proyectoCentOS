<?php
    function coincideUsuarioContrasenya($user, $pwd){
        include("../Modelo/conexion.php");

        $resultado = $pdo->query("select username,pwd from usuarios");
        while($receta = $resultado->fetch(PDO::FETCH_ASSOC)){
            if($receta["username"] == $user 
            && $receta["pwd"] == $pwd){
                return true;
            }
        }
        return false;
    }

    function existeUsuario($user){
        include("../Modelo/conexion.php");

        $sql = "select username from usuarios where username=?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$user]);
        if($statement->rowCount() === 0){
            return false;
        }else{
            return true;
        }        
    }
?>