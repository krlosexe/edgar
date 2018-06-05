<?php
	
session_start();
$session_id= session_id();
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['precio_venta'])){$precio_venta=$_POST['precio_venta'];}
if (isset($_POST['ancho'])){$ancho=$_POST['ancho'];}
if (isset($_POST['alto'])){$alto=$_POST['alto'];}
if (isset($_POST['unidad'])){$unidad=$_POST['unidad'];}


	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
if (!empty($id) and !empty($cantidad) and !empty($precio_venta))
{
$insert_tmp=@mysqli_query($con, "INSERT INTO tmp_cotizacion (id_producto,cantidad_tmp,precio_tmp,session_id,ancho_tmp,alto_tmp, unidad_medida_tmp) VALUES ('$id','$cantidad','$precio_venta','$session_id','$ancho','$alto','$unidad')");
}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM tmp_cotizacion WHERE id_tmp='".$id_tmp."'");
}

?>
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
	$sumador_total=0;
	$sql=mysqli_query($con, "select * from productos_demo, tmp_cotizacion where productos_demo.id_producto=tmp_cotizacion.id_producto and tmp_cotizacion.session_id='".$session_id."'");
	while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["id_tmp"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad_tmp'];
	$nombre_producto=$row['nombre_producto'];
    $unidad=$row['unidad_medida_tmp'];
    $ancho_producto=$row['ancho_tmp'];
    $alto_producto=$row['alto_tmp'];
	$id_marca_producto=$row['id_marca_producto'];
	
     
        
	$precio_venta=$row['precio_tmp'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	
		?>
		<tr>
			<td class='text-center'><?php echo $codigo_producto;?></td>
			<td class='text-center'><?php echo $cantidad;?></td>
			<td><?php echo $nombre_producto;?></td>
            <td><?php echo $unidad;?></td>
            <td><?php echo $ancho_producto;?></td>
            <td><?php echo $alto_producto;?></td>
			<td class='text-right'><?php echo $precio_venta_f;?></td>
			<td class='text-right'><?php echo $precio_total_f;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	
	$subtotal=number_format($sumador_total,2,'.','');
	

?>
<tr>
	<td class='text-right' colspan=4>TOTAL: </td>
	<td class='text-right'>S/<?php echo number_format($sumador_total,2);?></td>
	<td></td>
</tr>


</table>
					<div class="form-group row">
							<label for="condiciones" class="col-md-2 control-label">Condiciones de pago:</label>
							<div class="col-md-3">
								<select class="form-control" id="condiciones">
									<option value='Contado'>Contado</option>
									<option value='Crédito 30 días'>Crédito 30 días</option>
									<option value='Crédito 45 días'>Crédito 45 días</option>
									<option value='Crédito 60 días'>Crédito 60 días</option>
									<option value='Crédito 90 días'>Crédito 90 días</option>
								</select>
							</div>
							<label for="validez" class="col-md-2 control-label">Validez de la oferta:</label>
							<div class="col-md-2">
								<select class="form-control" id="validez">
									<option value='5 días'>5 días</option>
									<option value='10 días'>10 días</option>
									<option value='15 días' selected>15 días</option>
									<option value='30 días'>30 días</option>
									<option value='60 días'>60 días</option>
								</select>
							</div>
							<label for="entrega" class="col-md-1 control-label">Tiempo:</label>
							<div class="col-md-2">
								<input type="text" class="form-control" id="entrega" placeholder="Tiempo de entrega" value="Inmediato">
							</div>
						</div>
