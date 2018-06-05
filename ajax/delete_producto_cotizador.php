<?php 
	$mysqli = new mysqli("localhost", "root", "", "cotizador_bs3");

	$result = $mysqli->query("DELETE FROM detalle_cotizacion_demo WHERE id_detalle_cotizacion='".$_GET["id"]."'");
	if ($result) {
		
	}
 ?>