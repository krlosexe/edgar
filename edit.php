<?php
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos


	$mysqli = new mysqli("localhost", "root", "", "cotizador_bs3");


	$result = $mysqli->query("SELECT *  FROM cotizaciones_demo WHERE id_cotizacion = '$_GET[id]'");
	$row = $result->fetch_object();
	

	$query_productos   = $mysqli->query("SELECT * FROM detalle_cotizacion_demo WHERE numero_cotizacion = '$_GET[id]'");
	





?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Cotizador de Productos Online</title>
   <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
		  <div class="row-fluid">
			<div class="col-md-12">
			<h2><span class="glyphicon glyphicon-edit"></span> Editar Cotización</h2>
			<hr>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				<div class="form-group row">
				  <label for="atencion" class="col-md-1 control-label">Atención:</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control" id="atencion" placeholder="Atención" required value="<?= $row->atencion ?>">
				  </div>
				  <label for="tel1" class="col-md-1 control-label">Teléfono:</label>
							<div class="col-md-2">
								<input type="text" class="form-control" id="tel1" placeholder="Teléfono" required value="<?= $row->tel1 ?>">
							</div>
				</div>
						<div class="form-group row">
							<label for="empresa" class="col-md-1 control-label">Empresa:</label>
							<div class="col-md-3">
								<input type="text" class="form-control" id="empresa" placeholder="Nombre de la empresa" value="<?= $row->empresa ?>">
							</div>
							<label for="tel2" class="col-md-1 control-label">Teléfono:</label>
							<div class="col-md-2">
								<input type="text" class="form-control" id="tel2" placeholder="Teléfono empresa" value="<?= $row->tel2 ?>">
							</div>
							<label for="email" class="col-md-1 control-label">Email:</label>
							<div class="col-md-3">
								<input type="email" class="form-control" id="email" placeholder="Email" value="<?= $row->email ?>">
							</div>
						</div>
				
				
				<div class="col-md-12">
					<div class="pull-right">
						<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-plus"></span> Agregar productos
						</button>
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</div>	
				</div>
			</form>
			<br><br>
		<div id="resultados" class='col-md-12'>
			<div class="table-responsive">
			  <table class="table">
				<tr>
					<th>CODIGO</th>
					<th>CANT.</th>
					<th>DESCRIPCION</th>
				    <th>U. MEDIDA</th>
				    <th>ANCHO</th>
				    <th>ALTO</th>
					<th><span class="pull-right">PRECIO UNIT.</span></th>
					<th><span class="pull-right">PRECIO TOTAL</span></th>
					<th></th>
				</tr>
				<?php
				while ($producto = $query_productos->fetch_object()){

					$id_producto     = $producto->id_producto; 

					$query_detalle_producto  = $mysqli->query("SELECT * FROM productos_demo WHERE id_producto = '$id_producto'");
					$result_detalle_producto = $query_detalle_producto->fetch_object();
	

					$codigo_producto = $result_detalle_producto->codigo_producto; 
					$nombre_producto = $result_detalle_producto->nombre_producto; 
                    $unidad          = $result_detalle_producto->unidad_medida_producto; 
                    $ancho_producto           = $result_detalle_producto->ancho_producto; 
                    $alto_producto            = $result_detalle_producto->alto_producto;
					$precio_venta    = $result_detalle_producto->precio_producto;
					$precio_venta    = number_format($precio_venta,2,'.','');
                  ?>
                  
					<tr>
						<td class='text-center'><?php echo $codigo_producto;?></td>
						<td class='text-center'><?php echo 1;?></td>
						<td><?php echo $nombre_producto;?></td>
			            <td><?php echo $unidad;?></td>
			            <td><?php echo $ancho_producto;?></td>
			            <td><?php echo $alto_producto;?></td>
						<td class='text-right'><?php echo $precio_venta;?></td>
						<td class='text-right'><?php echo $precio_venta;?></td>
						<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
					</tr>	
					<?php
				}
				?>
				<tr>
					<td colspan=5><span class="pull-right"><?
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
		</div><!-- Carga los datos ajax -->
	
			<!-- Modal -->
			<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
				  </div>
				  <div class="modal-body">
					<form class="form-horizontal">
					  <div class="form-group">
						<div class="col-sm-6">
						  <input type="text" class="form-control" id="q" placeholder="Buscar productos" onkeyup="load(1)">
						</div>
						<button type="button" class="btn btn-default" onclick="load(1)"><span class='glyphicon glyphicon-search'></span> Buscar</button>
					  </div>
					</form>
					<div id="loader" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
					<div class="outer_div" ></div><!-- Datos ajax Final -->
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					
				  </div>
				</div>
			  </div>
			</div>
			
			</div>	
		 </div>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script>
		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/productos_cotizacion.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}
	</script>
	<script>
	function agregar (id)
		{
			var precio_venta=document.getElementById('precio_venta_'+id).value;
			var cantidad=document.getElementById('cantidad_'+id).value;
            var ancho=document.getElementById('ancho_'+id).value;
            var alto=document.getElementById('alto_'+id).value;
             var unidad=document.getElementById('unidad_'+id).value;
            
			//Inicia validacion
			if (isNaN(cantidad))
			{
			alert('Esto no es un numero');
			document.getElementById('cantidad_'+id).focus();
			return false;
			}
			if (isNaN(precio_venta))
			{
			alert('Esto no es un numero');
			document.getElementById('precio_venta_'+id).focus();
			return false;
			}
            if (isNaN(ancho))
			{
			alert('Esto no es un numero');
			document.getElementById('ancho_'+id).focus();
			return false;
			}
            if (isNaN(alto))
			{
			alert('Esto no es un numero');
			document.getElementById('alto_'+id).focus();
			return false;
			}
            if (isNaN(unidad))
			{
			alert('Esto no es un numero');
			document.getElementById('unidad_'+id).focus();
			return false;
			}
            
			//Fin validacion
			
			$.ajax({
        type: "POST",
        url: "./ajax/agregar_cotizador.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&ancho="+ancho+"&alto="+alto+"&unidad="+unidad,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});
		}
		
			function eliminar (id)
		{
			
			$.ajax({
        type: "GET",
        url: "./ajax/agregar_cotizador.php",
        data: "id="+id,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});

		}
		
		$("#datos_cotizacion").submit(function(){
		  var atencion = $("#atencion").val();
		  var tel1 = $("#tel1").val();
		  var empresa = $("#empresa").val();
		  var tel2 = $("#tel2").val();
		  var email = $("#email").val();
		  var condiciones = $("#condiciones").val();
		  var validez = $("#validez").val();
		  var entrega = $("#entrega").val();
		 VentanaCentrada('pdf/documentos/cotizacion_pdf.php? atencion='+atencion+'&tel1='+tel1+'&empresa='+empresa+'&tel2='+tel2+'&email='+email+'&condiciones='+condiciones+'&validez='+validez+'&entrega='+entrega,'Cotizacion','','1024','768','true');
	 	});
	</script>
  </body>
</html>