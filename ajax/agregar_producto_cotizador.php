<?php
	
session_start();
$session_id= session_id();
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['precio_venta'])){$precio_venta=$_POST['precio_venta'];}
if (isset($_POST['ancho'])){$ancho=$_POST['ancho'];}
if (isset($_POST['alto'])){$alto=$_POST['alto'];}
if (isset($_POST['unidad'])){$unidad=$_POST['unidad'];}
$id_coti = $_POST['id_coti'];

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
if (!empty($id) and !empty($cantidad) and !empty($precio_venta))
{
$insert_tmp=@mysqli_query($con, "INSERT INTO detalle_cotizacion_demo (numero_cotizacion,id_producto,cantidad,precio_venta) VALUES ('$id_coti','$id','$cantidad','$precio_venta')");
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
	$mysqli = new mysqli("localhost", "root", "", "cotizador_bs3");
    $query_productos   = $mysqli->query("SELECT * FROM detalle_cotizacion_demo WHERE numero_cotizacion = '$id_coti'");
	$sumador_total=0;
	$sql=mysqli_query($con, "select * from productos_demo, tmp_cotizacion where productos_demo.id_producto=tmp_cotizacion.id_producto and tmp_cotizacion.session_id='".$session_id."'");
	while ($producto = $query_productos->fetch_object())
	{

		
	$id_producto     = $producto->id_producto; 

	$query_detalle_producto  = $mysqli->query("SELECT * FROM productos_demo WHERE id_producto = '$id_producto'");
	$result_detalle_producto = $query_detalle_producto->fetch_object();

	$id_tmp          = $producto->id_detalle_cotizacion; 
	$codigo_producto = $result_detalle_producto->codigo_producto; 
	$nombre_producto = $result_detalle_producto->nombre_producto; 
    $unidad          = $result_detalle_producto->unidad_medida_producto; 
    $ancho_producto           = $result_detalle_producto->ancho_producto; 
    $alto_producto            = $result_detalle_producto->alto_producto;
	$precio_venta    = $result_detalle_producto->precio_producto;
	$precio_venta    = number_format($precio_venta,2,'.','');
	
     
        
	$precio_venta=$precio_venta;
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
