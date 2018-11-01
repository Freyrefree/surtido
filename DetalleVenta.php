<?php 
session_start();
include('php_conexion.php');
$usu=$_SESSION['username'];
$id_sucursal = $_SESSION['id_sucursal'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
	header('location:clientes.php');
}else{
	$codigo = $_POST['codigo'];
	//$codigo = "1003";
	if($_SESSION['username']==""){
	}else{
		if($_SESSION['tipo_usu']=='a' OR $_SESSION['tipo_usu']=='ca' OR $_SESSION['tipo_usu']=='te'){
		
			//$peticion = mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND id_sucursal = '$id_sucursal'");s
			$peticion=mysql_query("SELECT * FROM detalle WHERE factura='$codigo' AND id_sucursal = '$id_sucursal'");
			$arr = array();
			
			while($row = mysql_fetch_array($peticion)) {
			
			$arr[]=array( 'id_articulo' => $row['codigo'],
		                   'nombre' => $row['nombre'],
						   'cantidad' => $row['cantidad'],
						   'valor' =>  number_format($row['valor'], 2, '.', ''),
				);
			}

			echo json_encode($arr);
		}
	}
}
header('location:caja.php');
	?>