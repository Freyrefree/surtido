<?php
 		session_start();
		include('php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a'){
			header('location:error.php');
		}
?>

<?php
ini_set('max_execution_time', 600); //600 seconds = 10 minutes

$codigoHTML= '<font size="2" face="Courier New" ><table id="example" class="display" cellspacing="0" width="100%">';
$consultaSucursales = "SELECT id,empresa FROM empresa";
$ejecutar = mysql_query($consultaSucursales);
$codigoHTML.='<thead><tr>';
$codigoHTML.= '<th>Producto</th>';
while($fila = mysql_fetch_array($ejecutar))
{
    $codigoHTML.= '<th>'.$fila['empresa'].'</th>';
}
$codigoHTML.= '<th>Total</th>';
$codigoHTML.='</tr><tbody>';

$consultaCods = "SELECT cod,LEFT(nom , 30) AS nom FROM producto GROUP BY cod";
$ejecutaC = mysql_query($consultaCods);

while ($filac = mysql_fetch_assoc($ejecutaC)) { 
    $array[] = $filac; 
}
for($i = 0;$i < count($array);$i++) {
    
    
    $cod =  $array[$i]['cod'];
    $nombre_producto =  $array[$i]['nom'];

    $codigoHTML.='<tr>';
    $codigoHTML.= '<td>'.$nombre_producto.'</td>';
       $consultaSucursales = "SELECT id,empresa FROM empresa";
       $ejecutar = mysql_query($consultaSucursales);
       $valorSuma = 0;
       
       while($fila = mysql_fetch_array($ejecutar))
       {
           $id_sucursal = $fila['id'];
           $respuesta = datos($id_sucursal,$cod);
           $retornos = explode("_", $respuesta);

           $codigoHTMLdos = $retornos[0];
           $cantidad = $retornos[1];
           $suma = $cantidad;
           $valorSuma = $valorSuma + $suma;
           $codigoHTML.= $codigoHTMLdos;
       }
    $codigoHTML.= '<td>'.$valorSuma.'</td>';
    $codigoHTML.='</tr>';

}


$codigoHTML.='</tbody></table></font>';

echo $codigoHTML;

function datos($id_sucursal,$cod)
{
    $consultaCantidades = "SELECT cantidad FROM producto WHERE id_sucursal = '$id_sucursal' AND cod = '$cod'";
    $ejecutar2 = mysql_query($consultaCantidades);
    $codigoHTML2 = "";
    $cantidad = 0;
    
    while($fila2 = mysql_fetch_array($ejecutar2))
    {   
        $cantidad =  $fila2['cantidad'];                         
        $codigoHTML2.= '<td>'.$fila2['cantidad'].'</td>';
        //$cantidad = $cantidad + $cantidad;           
    }
    //$codigoHTML2.= '<td>'.$cantidad.'</td>';
    return $codigoHTML2."_".$cantidad;

}

?>
