<?php

	# conectare la base de datos
    $con=@mysqli_connect('localhost', 'root', '', 'cotizador_bs3');
    if(!$con){
        die("imposible conectarse: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Conexión falló: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }
?>
