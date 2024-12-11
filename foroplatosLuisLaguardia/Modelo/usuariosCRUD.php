<?php
    function selectUsuarioById($id){
        include("../Modelo/conexion.php");
        $sql = "select * from usuarios where id=?";
        $statement = $pdo->prepare($sql); 
        $statement->execute([$id]);
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    function selectUsuarioByUsername($username){
        include("../Modelo/conexion.php");
        $sql = "select id from usuarios where username=?";
        $statement = $pdo->prepare($sql); 
        $statement->execute([$username]);
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultado["id"];
    }

    function obtenerNombresRegistrados(){
        include("../Modelo/conexion.php");
        $sql = "select username from usuarios";
        $statement = $pdo->prepare($sql); 
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
        return $resultado;
    }

    function obtenerUsuarioRegistrado($username, $pwd, $rol){
        if(!isset($username) || !isset($pwd) || !isset($rol)){
            return null;
        }else{
            include("../Modelo/conexion.php");
            $sql = "select username,pwd,rol from usuarios where username=?";
            $statement = $pdo->prepare($sql); 
            $statement->execute([$username]);
            return $statement->fetch(PDO::FETCH_ASSOC);
        }
    }
    function insertUsuario($foto, $rol, $username, $pwd, $name, $surname, $experience, $email){
        include("../Modelo/conexion.php");
        $rutaSubida = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $directorioFotos = "../ImagenPerfil/";
            $nombreArchivo = time() . "_" . $username . ".jpg";
            $rutaSubida = $directorioFotos . $nombreArchivo;
    
            $tipoArchivo = mime_content_type($_FILES['foto']['tmp_name']);
            if (!in_array($tipoArchivo, ['image/jpeg', 'image/png', 'image/jpg'])) {
                $_SESSION["error"] = "El archivo subido no es una imagen válida.";
                header("Location: ../Controlador/index.php");
                exit;
            }
    
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaSubida)) {
                $rutaFoto = "ImagenPerfil/" . $nombreArchivo;
            } else {
                $_SESSION["error"] = "No se pudo guardar la foto.";
                header("Location: ../Controlador/index.php");
                exit;
            }
        } else {
            $directorioFotos = "../ImagenPerfil/";
            $imagenPredeterminada = "../Utilidad/imagenPerfil.jpg";
            $nombreArchivo = time() . "_" . $username . ".jpg";
            $rutaDestino = $directorioFotos . $nombreArchivo;
    
            if (file_exists($imagenPredeterminada)) {
                if (copy($imagenPredeterminada, $rutaDestino)) {
                    $rutaSubida = "../ImagenPerfil/" . $nombreArchivo;
                } else {
                    $_SESSION["error"] = "No se pudo copiar la imagen predeterminada.";
                    header("Location: ../Controlador/index.php");
                    exit;
                }
            } else {
                $_SESSION["error"] = "La imagen predeterminada no existe.";
                header("Location: ../Controlador/index.php");
                exit;
            }
        }
        $sql = "insert into usuarios (foto,rol,username,pwd,name,surname,experience,email)
        values (?,?,?,?,?,?,?,?)";
        $statement = $pdo->prepare($sql);
        $statement->execute([$rutaSubida,$rol,$username,$pwd,$name,$surname,$experience,$email]);
    }
    function eliminarUsuario($id){
        include("../Modelo/conexion.php");
        $rutaFoto = null;
        try{
            $pdo->beginTransaction();

            $sqlObtenerFotoUser = "SELECT foto FROM usuarios WHERE id=?";
            $stmt = $pdo->prepare($sqlObtenerFotoUser);
            $stmt->execute([$id]);
            $foto = $stmt->fetchColumn();
            if ($foto && file_exists($foto)) {
                unlink($foto);
            }

            $sqlBorrarUsuario = "delete from usuarios where id=?";
            $statement = $pdo->prepare($sqlBorrarUsuario); 
            $statement->execute([$id]);

            $pdo->commit();
            setcookie("aviso", "Usuario eliminado Correctamente", time() + 300);
        } catch (Exception $e) {
            $pdo->rollback();
            $_SESSION["error"] = "Error al eliminar al Usuario: " . $e->getMessage();
        }
        
    }

    function modificarUsuario($id, $rol, $username, $name, $surname, $experience, $email){
        include("../Modelo/conexion.php");
        $sql = "update usuarios set rol=?, username=?, name=?, surname=?, experience=?, email=? where id=?";
        $statement = $pdo->prepare($sql); 
        return $statement->execute([$rol,$username,$name,$surname,$experience,$email,$id]);
    }

    function modificarContrasenya($username, $pwd){
        include("../Modelo/conexion.php");
        $sql = "update usuarios set pwd=? where username=?";
        $statement = $pdo->prepare($sql); 
        return $statement->execute([$pwd,$username]);
    }

    function obtenerUsuariosAdministracion($primeraReceta, $tamanioPagina){
        include("../Modelo/conexion.php");
        $resultado = $pdo->query("select id,username,name,surname,rol,experience,email from (select id,username,name,surname,rol,experience,email from usuarios limit $primeraReceta,$tamanioPagina) as subconsulta order by rol desc");
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    function obtenerCantidadUsuarios(){
        include ("conexion.php");
        $numUsers = $pdo->query("SELECT COUNT(*) FROM usuarios");
        return $numUsers->fetch()[0];
    }

    function modificarRol($rol, $id){
        include ("conexion.php");
        $sql = "update usuarios set rol=? where id=?";
        $statement = $pdo->prepare($sql); 
        return $statement->execute([$rol,$id]);
    }

    function seguirUsuario($idSeguidor, $idseguido){
        include ("conexion.php");
        $sql = "insert into seguidores (id_seguidor, id_seguido) values (?, ?);";
        $statement = $pdo->prepare($sql); 
        return $statement->execute([$idSeguidor,$idseguido]);
    }
    function dejarSeguirUsuario($idSeguidor, $idseguido){
        include ("conexion.php");
        $sql = "delete from seguidores where id_seguidor=? and id_seguido=?;";
        $statement = $pdo->prepare($sql); 
        return $statement->execute([$idSeguidor,$idseguido]);
    }

    function seSiguen($idSeguidor, $idSeguido){
        include("conexion.php");
        $sql = "select count(*) as sigue from seguidores where id_seguidor = ? and id_seguido = ?";
        $statement = $pdo->prepare($sql); 
        $statement->execute([$idSeguidor,$idSeguido]);
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultado["sigue"];
    }

    function seguidores($idSeguido, $primeraReceta, $tamanioPagina){
        include("conexion.php");
        $sql = "select u.* from usuarios u join seguidores s on u.id = s.id_seguidor where s.id_seguido = ? limit $primeraReceta,$tamanioPagina";
        $statement = $pdo->prepare($sql); 
        $statement->execute([$idSeguido]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function seguidos($idSeguidor, $primeraReceta, $tamanioPagina){
        include("conexion.php");
        $sql = "select u.* from usuarios u join seguidores s on u.id = s.id_seguido where s.id_seguidor = ? limit $primeraReceta,$tamanioPagina";
        $statement = $pdo->prepare($sql); 
        $statement->execute([$idSeguidor]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function obtenerCantidadSeguidores(){
        include ("conexion.php");
        $numUsers = $pdo->query("SELECT COUNT(distinct id_seguidor) FROM seguidores");
        return $numUsers->fetch()[0];
    }

    function obtenerCantidadSeguidos(){
        include ("conexion.php");
        $numUsers = $pdo->query("SELECT COUNT(distinct id_seguido) FROM seguidores");
        return $numUsers->fetch()[0];
    }
?>