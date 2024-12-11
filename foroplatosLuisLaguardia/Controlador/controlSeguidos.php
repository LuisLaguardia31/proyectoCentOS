<?php
    $tamanioPagina=8;
	if(isset($_GET['numPagina'])){
		$numPagina=$_GET['numPagina'];
	}
	else{
		$numPagina=0;
	}
    include("../Modelo/usuariosCRUD.php");
	$numUsers = obtenerCantidadSeguidos();
    $maxPagina=floor($numUsers/$tamanioPagina);
    $primerUsuario=$numPagina*$tamanioPagina;
?>