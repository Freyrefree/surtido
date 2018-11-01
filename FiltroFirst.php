<?php 
session_start();
include('php_conexion.php');
$usu=$_SESSION['username'];
$id_sucursal = $_SESSION['id_sucursal'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
	header('location:clientes.php');
}else{
	//Declaracion de variables para la consulta
	$id_marca = $_POST['id_marca'];
	//$id_modelo = $_POST['id_modelo'];
	$tipo = $_POST['tipo'];
	$palabra = $_POST['valor'];
	if($_SESSION['username']==""){
	}else{
		if($_SESSION['tipo_usu']=='a' OR $_SESSION['tipo_usu']=='ca' OR $_SESSION['tipo_usu']=='te'){
			// Realizo consulta
			/*if ($id_modelo == "n") {
				$peticion = mysql_query("SELECT * FROM producto WHERE id_marca = '$id_marca' AND id_sucursal = '$id_sucursal' ");
			}else {*/
			/*}*/
			$con=mysql_query("SELECT * FROM comision WHERE tipo='$tipo'");
            if($dat=mysql_fetch_array($con)){
                $id_comision = $dat['id_comision'];
            }
            $can=mysql_query("SELECT nombre FROM marca WHERE id_marca='$id_marca'");
            if($dato=mysql_fetch_array($can)){
                $marca = $dato['nombre'];
            }
			if ($palabra == "") {
				$peticion = mysql_query("SELECT * FROM producto WHERE id_marca = '$id_marca' AND id_comision = '$id_comision' AND id_sucursal = '$id_sucursal'");
			}else {
				$peticion = mysql_query("SELECT * FROM producto WHERE id_marca = '$id_marca' AND id_comision = '$id_comision' AND id_sucursal = '$id_sucursal' AND nom LIKE '%$palabra%'");
			}
			/*if($dato3=mysql_fetch_array($peticion)){
                if ($dato3['cantidad'] <= 0) {
					$peticion = mysql_query("SELECT * FROM producto WHERE id_marca = '$id_marca' AND id_comision = '$id_comision' AND nom LIKE '%$palabra%' AND cantidad > '0'");
				}
            }*/
			$arr = array();
			if ($peticion > 1) {
				while($row = mysql_fetch_array($peticion)) {
					$cod_producto = $row['cod'];
					if ($row['cantidad'] <= 0) {
						$queryplus = mysql_query("SELECT * FROM producto WHERE cod = '$cod_producto' AND cantidad > '0'");
						while($row = mysql_fetch_array($queryplus)) {
							$id_sucursal = $row['id_sucursal'];
							$query=mysql_query("SELECT empresa FROM empresa WHERE id='$id_sucursal'");
				            if($row2=mysql_fetch_array($query)){
				                $nombre_sucursal = $row2['empresa'];
				            }
							$arr[]=array( 'id_articulo' => $row['cod'],
						                   'nombre' => $row['nom'],
										   'precio' => $row['venta'],
										   'marca' => $marca,
										   'cantidad' => $row['cantidad'],
										   'sucursal' => $nombre_sucursal,
								);
						}
					}else {
						$id_sucursal = $row['id_sucursal'];
						$query=mysql_query("SELECT empresa FROM empresa WHERE id='$id_sucursal'");
			            if($row2=mysql_fetch_array($query)){
			                $nombre_sucursal = $row2['empresa'];
			            }
						$arr[]=array( 'id_articulo' => $row['cod'],
					                   'nombre' => $row['nom'],
									   'precio' => $row['venta'],
									   'marca' => $marca,
									   'cantidad' => $row['cantidad'],
									   'sucursal' => $nombre_sucursal,
							);
					}
				}
			}else {
				if ($palabra != "") {
					$peticion = mysql_query("SELECT * FROM codigo_producto WHERE identificador = '$palabra'");
				}
				while($row = mysql_fetch_array($peticion)) {
					$cod_producto = $row['id_producto'];
					//if ($row['cantidad'] <= 0) {
						$queryplus = mysql_query("SELECT * FROM producto WHERE cod = '$cod_producto'");
						while($row = mysql_fetch_array($queryplus)) {
							$id_sucursal = $row['id_sucursal'];
							$query=mysql_query("SELECT empresa FROM empresa WHERE id='$id_sucursal'");
				            if($row2=mysql_fetch_array($query)){
				                $nombre_sucursal = $row2['empresa'];
				            }
							$arr[]=array( 'id_articulo' => $row['cod'],
						                   'nombre' => $row['nom'],
										   'precio' => $row['venta'],
										   'marca' => "-",
										   'cantidad' => $row['cantidad'],
										   'sucursal' => $nombre_sucursal,
								);
						}
					//}
				}
			}
			
			echo json_encode($arr);
		}
	}
}
header('location:clientes.php');
	?>