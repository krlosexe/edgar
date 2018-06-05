<?php 
	$id = $_POST["id_cotizacion"];

	$mysqli = new mysqli("localhost", "root", "", "cotizador_bs3");
	$result = $mysqli->query("UPDATE cotizaciones_demo SET atencion = '$_POST[atencion]',
										                   tel1 = '$_POST[tel1]',
										                   empresa = '$_POST[empresa]',
										                   tel2 = '$_POST[tel2]',
										                   email = '$_POST[email]'
								  
								  WHERE   id_cotizacion = '$id'
										                   ");
	if ($result) {
		header("Location: edit.php?id=$id");
	}
?>