<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventario Ineficaz</title>
        <!--  style -->
        <link href="css/bootstrap.css" rel="stylesheet">       
</head>
<body>
    

<?php
session_start();
include('php_conexion.php'); 
$usu=$_SESSION['username'];
$tipo_usu=$_SESSION['tipo_usu'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
    header('location:error.php');
}
else{
    
    //echo "Lista Inventario Ineficaz";
    $consulta = "SELECT * FROM inventarioineficaz";
    $query = (mysql_query($consulta));

    
	$codigo = '<table width="80%" border="0" class="table">
    <tr class="info">
      <td colspan="10"><center><strong>Inventario de Productos Defectuosos</strong></center></td>
    </tr>
    <tr>
      <td><strong>ID</strong></td>
      <td><strong>Factura</strong></td>
      <td><strong>Código</strong></td>
      <td><strong>Producto</strong></td>
      <td><strong>Descripción</strong></td>
      <td><strong>Usuario Garantía Entrada</strong></td>
      <td><strong>Sucursal Garantía Entrada</strong></td>
      <td><strong>Usuario Garantía Salida</strong></td>
      <td><strong>Sucursal Garantía Salida</strong></td>
      <td><strong>Fecha Salida</strong></td>
      
  
    </tr>';

	// Vamos acumulando de a una fila "tr" por vuelta:
	while ( $fila = mysql_fetch_array($query) )
	{
        $idsucursalentrada = $fila['id_sucursal_entrada'];
        $idsucursalsalida = $fila['id_sucursal_salida'];

        $consulta2 = "SELECT empresa FROM empresa WHERE id = '$idsucursalentrada'";
        $query2 = mysql_query($consulta2);
        $fila2 = mysql_fetch_array($query2);
        $nombresucursalentrada = $fila2['empresa'];

        $consulta3 = "SELECT empresa FROM empresa WHERE id = '$idsucursalsalida'";
        $query3 = mysql_query($consulta3);
        $fila3 = mysql_fetch_array($query3);
        $nombresucursalsalida = $fila3['empresa'];

        
		
		$codigo .= '<tr>';
		
		// Vamos acumulando tantos "td" como sea necesario:
		$codigo .= '<td>'.utf8_encode($fila["idi"]).'</td>';
		$codigo .= '<td>'.utf8_encode($fila["id_venta"]).'</td>';
		$codigo .= '<td>'.utf8_encode($fila["codigo"]).'</td>';
		$codigo .= '<td>'.utf8_encode($fila["producto"]).'</td>';
		$codigo .= '<td>'.utf8_encode($fila["descripcion"]).'</td>';
		$codigo .= '<td>'.utf8_encode($fila["usuario_garantia_entrada"]).'</td>';
        $codigo .= '<td>'.utf8_encode($nombresucursalentrada).'</td>';
        $codigo .= '<td>'.utf8_encode($fila["usuario_garantia_salida"]).'</td>';
        $codigo .= '<td>'.utf8_encode($nombresucursalsalida).'</td>';
        $codigo .= '<td>'.utf8_encode($fila['fechasalida']).'</td>';
		
		// Cerramos un "tr":
		$codigo .= '</tr>';

	}

	// Finalizado el bucle, cerramos por única vez la tabla:
    $codigo .= '</table>';
    echo $codigo;
}
?>
</body>
</html>