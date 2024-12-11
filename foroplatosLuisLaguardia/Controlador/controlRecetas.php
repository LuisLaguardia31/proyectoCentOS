<?php
    $tamanioPagina=5;
	if(isset($_GET['numPagina'])){
		$numPagina=$_GET['numPagina'];
	}
	else{
		$numPagina=0;
	}
    include("../Modelo/recetasCRUD.php");
	$numRecetas = obtenerCantidadRecetas();
    $maxPagina=floor($numRecetas/$tamanioPagina);
    $primeraReceta=$numPagina*$tamanioPagina;
?>