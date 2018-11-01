<?php
include('php_conexion.php');
$factura = $_POST['factura'];
$id_sucursallocal = $_POST['idsucursallocal'];
$usuariolocal = $_POST['usuariolocal'];




$consulta="SELECT * FROM garantia WHERE factura = '$factura'";

$query = (mysql_query($consulta));
$dato= mysql_fetch_array($query);
$facturaG = $dato['Factura'];
$codigoG = $dato['Codigo'];
$nombreG = $dato['Nombre'];
$tipo = $dato['Tipo'];
$fechaIngreso = $dato['FechaOP'];
$usuG = $dato['Usu'];
$id_sucursalG = $dato ['IdSucursal'];
$descripcion = $dato['Descripcion'];


//consulta para obtener cantidad del producto que se cambiará (el id de sucursal se obtiene de la sesión)
$consulta2 = "SELECT * FROM producto WHERE cod = '$codigoG' AND id_sucursal = '$id_sucursallocal'";
$query2 = mysql_query($consulta2);
$dato2 = mysql_fetch_array($query2);
$cantidad = $dato2['cantidad'];

if($cantidad > 0)
{
    //echo 1;
$consulta3="INSERT INTO inventarioineficaz 
(id_venta,codigo,producto,usuario_garantia_entrada,descripcion,id_sucursal_entrada,usuario_garantia_salida,id_sucursal_salida,fechasalida)
VALUES ('$facturaG','$codigoG','$nombreG','$usuG','$descripcion','$id_sucursalG','$usuariolocal','$id_sucursallocal',NOW())";

$consulta4 = "UPDATE producto SET cantidad = (cantidad-1) WHERE cod = '$codigoG' AND id_sucursal ='$id_sucursallocal'";

$consulta5 = "DELETE FROM garantia WHERE Factura='$factura'";

if ((mysql_query($consulta3)) and (mysql_query($consulta4)) and (mysql_query($consulta5))){
//    if ((mysql_query($consulta3)) and (mysql_query($consulta4))){
    echo 1;
}
else{
    echo 0;
}

}else{

    echo 2; 

}
?>