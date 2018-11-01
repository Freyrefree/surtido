<?php
$conexion = mysql_connect("localhost","root","");
mysql_select_db("tienda_surtidocell",$conexion);

for($i=1;$i<=12;$i++)
{
    echo "id_sucursal".$i;
    echo "<br>";
    sucursal($i);
    echo "<br>";
    echo "////////////////////////////////////////";
    echo "<br>";

}



function sucursal($id_sucursal)
{
$consulta = "SELECT cod FROM producto WHERE id_sucursal = 2 AND id_comision = 3";
$ejecutar = mysql_query($consulta);

while($dato=mysql_fetch_array($ejecutar))
{
    
    $codigo = $dato['cod'];
    //echo $codigo;
    //echo "<br>";
    $consulta2 = "UPDATE producto SET cantidad = (
        SELECT COUNT(tipo_identificador) FROM codigo_producto   WHERE id_sucursal = $id_sucursal
        AND tipo_identificador = 'IMEI' AND id_producto = '$codigo' )
        WHERE cod = '$codigo' AND id_sucursal = $id_sucursal AND estado = 's'; ";
        $ejecutar2 = mysql_query($consulta2);
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes

        echo $codigo."- OK";
        echo "<br>";

}
}

?>