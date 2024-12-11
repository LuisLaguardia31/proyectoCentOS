<?php
    function crearComentario($contenido, $id_receta, $id_usuario) {
        include("conexion.php");
        try {
            $sql = "insert into comentarios (contenido, id_receta, id_usuario, id_comentario_padre) values (?, ?, ?, NULL)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$contenido, $id_receta, $id_usuario]);
            return "Comentario creado con éxito.";
        } catch (PDOException $e) {
            return "Error al crear el comentario: " . $e->getMessage();
        }
    }
    
    function contestarComentario($contenido, $id_receta, $id_usuario, $id_comentario_padre) {
        include("conexion.php");
        try {
            $sql = "insert into comentarios (contenido, id_receta, id_usuario, id_comentario_padre) values (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql); 
            $stmt->execute([$contenido, $id_receta, $id_usuario, $id_comentario_padre]);
            setcookie("aviso","Comentario respondido con exito",time()+300);
        } catch (PDOException $e) {
            $_SESSION["error"] = "Error al responder el comentario: " . $e->getMessage();
        }
    }
    
    function modificarComentario($id_comentario, $nuevo_contenido) {
        include("conexion.php");
        try {    
            $sql = "update comentarios set contenido = ? where id = ?";
            $stmt = $pdo->prepare($sql); 
            $stmt->execute([$nuevo_contenido, $id_comentario]); 
            return "Comentario modificado con éxito.";
        } catch (PDOException $e) {
            return "Error al modificar el comentario: " . $e->getMessage();
        }
    }

    function eliminarComentario($id_comentario, $rol_usuario) {
        include("conexion.php");
        try {
            $sql = "update comentarios set contenido=? where id = ?";
            $stmt = $pdo->prepare($sql); 
            $stmt->execute(["\"Este comentario ha sido borrado por el usuario\"",$id_comentario]);
            setcookie("aviso","Comentario Eliminado con Exito",time()+300);
        } catch (PDOException $e) {
            $_SESSION["error"] = "Error al eliminar el comentario: " . $e->getMessage();
        }
    }

    function eliminarComentarioAdmin($id_comentario, $rol_usuario) {
        include("conexion.php");
        try {
            $sql = "update comentarios set contenido=? where id = ?";
            $stmt = $pdo->prepare($sql); 
            $stmt->execute(["\"Este comentario ha sido borrado por un administrador\"",$id_comentario]); 
            setcookie("aviso","Comentario Eliminado con Exito",time()+300);
        } catch (PDOException $e) {
            $_SESSION["error"] = "Error al eliminar el comentario: " . $e->getMessage();
        }
    }

    function mostrarComentarios($id_receta) {
        include("conexion.php");
        $resultado = [];
        try {
            $sql = "select c.id, c.contenido, c.id_receta, c.id_usuario, c.id_comentario_padre, c.fecha_creacion, u.username as nombre_usuario, u.rol as rol from comentarios c left join usuarios u on c.id_usuario = u.id where c.id_receta = ? order by c.fecha_creacion asc";
            $stmt = $pdo->prepare($sql); 
            $stmt->execute([$id_receta]);
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION["error"] = "Error al mostrar los comentarios: " . $e->getMessage();
        }
        return $resultado;
    }

    
    
?>