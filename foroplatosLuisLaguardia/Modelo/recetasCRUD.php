<?php
    function obtenerRecetas(){
        include ("conexion.php");
        $resultado = $pdo->query("select titulo,foto,ingredientes,elaboracion,tipo,dificultad,tiempoElaboracion,valoracion from recetas");
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    function obtenerRecetasFiltradas($titulo, $ingrediente, $primeraReceta, $tamanioPagina) {
        include("conexion.php");
        $sql = "select recetas.*, usuarios.username, usuarios.foto as usuarios_foto 
                from recetas 
                left join usuarios on recetas.id_usuario = usuarios.id ";
        
        $conditions = null;
        $parametro = null;
    
        if ($titulo) {
            $conditions = "recetas.titulo like ?";
            $parametro = "%$titulo%";
        }
    
        if ($ingrediente) {
            $conditions = "recetas.ingredientes like ?";
            $parametro = "%$ingrediente%";
        }
    
        if (!empty($conditions)) {
            $sql .= "where " . $conditions . " ";
        }
    
        $sql .= "order by valoracion desc limit $primeraReceta, $tamanioPagina";
        
        if($parametro!=null){
            $statement = $pdo->prepare($sql);
            $statement->execute([$parametro]);
        }else{
            $statement = $pdo->prepare($sql);
            $statement->execute([]);
        }
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function obtenerUnaReceta($idPorGet){
        include ("conexion.php");
        $receta = $pdo->query("select recetas.*,usuarios.username,usuarios.foto as usuarios_foto from recetas inner join usuarios on recetas.id_usuario = usuarios.id where recetas.id = {$idPorGet}");
        return $receta->fetch(PDO::FETCH_ASSOC);
    }

    function obtenerCantidadRecetas(){
        include ("conexion.php");
        $numRecetas = $pdo->query("select COUNT(*) from recetas");
        return $numRecetas->fetch()[0];
    }

    function modificarValoracion($id, $valoracion){
        include("../Modelo/conexion.php");
        $sql = "update recetas set valoracion=? where id=?";
        $statement = $pdo->prepare($sql); 
        return $statement->execute([$valoracion, $id]);
    }

    function modificarReceta($id, $titulo, $ingredientes, $elaboracion, $foto, $tipo, $dificultad, $tiempoElaboracion, $valoracion) {
        include("../Modelo/conexion.php");
        $pdo->beginTransaction();
            
        try {
            $sqlActualizarReceta = "update recetas set titulo = ?, elaboracion = ?, foto = ?, tipo = ?, dificultad = ?, tiempoElaboracion = ?, valoracion = ? where id = ?";
            $stmt = $pdo->prepare($sqlActualizarReceta);
            $stmt->execute([$titulo, $elaboracion, $foto, $tipo, $dificultad, $tiempoElaboracion, $valoracion, $id]);

            $ingredientesObtenidos = array_unique(array_map('trim', explode(", ", $ingredientes)));

            foreach ($ingredientesObtenidos as $ingrediente) {
                $sqlVerificarIngrediente = "select id from ingredientes where trim(nombre) = ?";
                $stmt = $pdo->prepare($sqlVerificarIngrediente);
                $stmt->execute([$ingrediente]);

                if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sqlinsertarIngrediente = "insert into ingredientes (nombre) values (?)";
                    $stmt = $pdo->prepare($sqlinsertarIngrediente);
                    $stmt->execute([$ingrediente]);
                }
            }

            $idsIngredientes = [];
            foreach ($ingredientesObtenidos as $ingrediente) {
                $sqlObtenerIDIngrediente = "select id from ingredientes where trim(nombre) = ?";
                $stmt = $pdo->prepare($sqlObtenerIDIngrediente);
                $stmt->execute([$ingrediente]);

                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $idsIngredientes[] = $row['id'];
                }
            }

            $sqlEliminarRelaciones = "delete from recetas_ingredientes where receta_id = ?";
            $stmt = $pdo->prepare($sqlEliminarRelaciones);
            $stmt->execute([$id]);

            foreach ($idsIngredientes as $idIngrediente) {
                $sqlinsertarRelacion = "insert into recetas_ingredientes (receta_id, ingrediente_id) values (?, ?)";
                $stmt = $pdo->prepare($sqlinsertarRelacion);
                $stmt->execute([$id, $idIngrediente]);
            }

            $ingredientesConcatenados = implode(", ", $ingredientesObtenidos);
            $sqlActualizarIngredientesReceta = "update recetas set ingredientes = ? where id = ?";
            $stmt = $pdo->prepare($sqlActualizarIngredientesReceta);
            $stmt->execute([$ingredientesConcatenados, $id]);

            $pdo->commit();
        
            setcookie("aviso", "Receta Modificada Correctamente", time() + 300);
        } catch (Exception $e) {
            $pdo->rollback();
            $_SESSIon["error"] = "Error al actualizar la receta: " . $e->getMessage();
        }
    }

    function eliminarReceta($id){
        include("../Modelo/conexion.php");

        try {
            $pdo->beginTransaction();

            $sqlObtenerFoto = "select foto from recetas where id = ?";
            $stmt = $pdo->prepare($sqlObtenerFoto);
            $stmt->execute([$id]);
            $foto = $stmt->fetchColumn();
            if ($foto && file_exists($foto)) {
                unlink($foto);
            }
        
            $sqlEliminarRelaciones = "delete from recetas_ingredientes where receta_id = ?";
            $stmt = $pdo->prepare($sqlEliminarRelaciones);
            $stmt->execute([$id]);
        
            $sqlEliminarReceta = "delete from recetas where id = ?";
            $stmt = $pdo->prepare($sqlEliminarReceta);
            $stmt->execute([$id]);
        
            $pdo->commit();
        
            setcookie("aviso", "Receta Eliminada Correctamente", time() + 300);
        } catch (Exception $e) {
            $pdo->rollback();
            $_SESSIon["error"] = "Error al borrar la receta: " . $e->getMessage();
        }
    }

    function crearReceta($titulo, $ingredientes, $elaboracion, $foto, $tipo, $dificultad, $tiempoElaboracion, $valoracion, $idUsuario){
        include("../Modelo/conexion.php");

        $rutaSubida = null;

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $directorioFotos = "../Imagenes/";
            $nombreArchivo = time() . "_" . basename($_FILES['foto']['name']);
            $rutaSubida = $directorioFotos . $nombreArchivo;

            
            $tipoArchivo = mime_content_type($_FILES['foto']['tmp_name']);
            if (!in_array($tipoArchivo, ['image/jpeg', 'image/png', 'image/jpg'])) {
                $_SESSIon["error"] = "El archivo subido no es una imagen válida.";
                header("Location: ../Controlador/index.php");
            }

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaSubida)) {
                $rutaFoto = "../Imagenes/" . $nombreArchivo;
            } else {
                $_SESSIon["error"] = "No se pudo guardar la foto.";
                header("Location: ../Controlador/index.php");
            }
        }else{
            $directorioFotos = "../Imagenes/";
            $imagenPredeterminada = "../Utilidad/imagenReceta.jpg";
            $nombreArchivo = time() . "_" . $titulo . ".jpg";
            $rutaDestino = $directorioFotos . $nombreArchivo;
    
            if (file_exists($imagenPredeterminada)) {
                if (copy($imagenPredeterminada, $rutaDestino)) {
                    $rutaSubida = "../Imagenes/" . $nombreArchivo;
                } else {
                    $_SESSIon["error"] = "No se pudo copiar la imagen predeterminada.";
                    header("Location: ../Controlador/index.php");
                    exit;
                }
            } else {
                $_SESSIon["error"] = "La imagen predeterminada no existe.";
                header("Location: ../Controlador/index.php");
                exit;
            }
        }
        try {
            $pdo->beginTransaction();

            $sql = "insert into recetas (titulo, ingredientes, elaboracion, foto, tipo, dificultad, tiempoElaboracion, valoracion, id_usuario) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$titulo, $ingredientes, $elaboracion, $rutaSubida, $tipo, $dificultad, $tiempoElaboracion, $valoracion, $idUsuario]);
            

            $recetaId = $pdo->lastinsertId();

            $ingredientesArray = array_unique(array_map('trim', explode(", ", $ingredientes)));

            foreach ($ingredientesArray as $ingrediente) {
                $sqlinsertIngrediente = "insert IGNORE into ingredientes (nombre) values (?)";
                $stmt = $pdo->prepare($sqlinsertIngrediente);
                $stmt->execute([$ingrediente]);

                $sqlObtenerIngrediente = "select id from ingredientes where nombre = ?";
                $stmt = $pdo->prepare($sqlObtenerIngrediente);
                $stmt->execute([$ingrediente]);
                $ingredienteId = $stmt->fetchColumn();

                $sqlRelacion = "insert into recetas_ingredientes (receta_id, ingrediente_id) values (?, ?)";
                $stmt = $pdo->prepare($sqlRelacion);
                $stmt->execute([$recetaId, $ingredienteId]);
            }

            $pdo->commit();
            setcookie("aviso","Receta Creada Correctamente",time()+300);
        } catch (Exception $e) {
            $pdo->rollBack();
            $_SESSIon["error"] = "Error al crear la receta: " . $e->getMessage();
            header("Location: ../Controlador/index.php");
        }
    }
?>