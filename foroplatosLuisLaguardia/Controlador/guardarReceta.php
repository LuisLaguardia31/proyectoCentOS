<?php
   if(!isset($_SESSION["username"])){
      header("Location: ../Controlador.index");
      exit();
   }
   function guardarReceta($foto){
      $fotoActual = isset($foto) ? $foto : null;
      $rutaFoto = null;
      if (isset($_FILES['nuevaFoto']) && $_FILES['nuevaFoto']['error'] === UPLOAD_ERR_OK) {
         $directorioFotos = "../Imagenes/";
         $nombreArchivo = time()."_".basename($_FILES['nuevaFoto']['name']);
         $rutaSubida = $directorioFotos . $nombreArchivo;
   
         $tipoArchivo = mime_content_type($_FILES['nuevaFoto']['tmp_name']);
         if (!in_array($tipoArchivo, ['image/jpeg', 'image/png', 'image/jpg'])) {
            $_SESSION["error"] = "El archivo subido no es una imagen válida.";
         }
   
         if (move_uploaded_file($_FILES['nuevaFoto']['tmp_name'], $rutaSubida)) {
            $rutaFoto = "../Imagenes/" . $nombreArchivo;
   
            if ($fotoActual && file_exists($fotoActual)) {
               unlink($fotoActual);
            }
         } else {
            $_SESSION["error"] = "El archivo subido no es una imagen válida.";
         }
      } else {
            $rutaFoto = $fotoActual;
      }
      return $rutaFoto;
   }
?>