<?php 
session_start();
include('php_conexion.php');
$usu=$_SESSION['username'];
$id_sucursal = $_SESSION['id_sucursal'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
	//header('location:clientes.php');
}else{

	/*$tipo = $_POST['tipo'];*/
	$id_comision = $_POST['tipo'];
	$palabra = $_POST['valor'];
	$precios = $_POST['p'];

	/*$id_comision = "3";
	$palabra = "2";
	$precios = "p";*/
	/*$id_comision = "6";
	$palabra = "m";*/
	//$palabra = '354080067236186';//
	if($_SESSION['username']==""){
	}else{
		if($_SESSION['tipo_usu']=='a' OR $_SESSION['tipo_usu']=='ca' OR $_SESSION['tipo_usu']=='te'){
		#tipo de producto a buscar (telefono, accesorio, ficha, chip)
			/*$con=mysql_query("SELECT * FROM comision WHERE tipo='$tipo'");
            if($dat=mysql_fetch_array($con)){
                $id_comision = $dat['id_comision'];
            }*/
        #fin tipo de producto a buscar (telefono, accesorio, ficha, chip)
			if ($palabra == "") {
				$peticion = mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND id_sucursal = '$id_sucursal'");//
			}else {
				if ($id_comision == "0") {
					$peticion = mysql_query("SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' AND (categoria LIKE '%$palabra%' OR cod LIKE '%$palabra%' OR nom LIKE '%$palabra%' OR modelo LIKE '%$palabra%' OR marca LIKE '%$palabra%' OR compania LIKE '%$palabra%')");//AND id_comision = '$id_comision' 
				}else {
					if ($precios == "p") {
						$peticion = mysql_query("SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' AND id_comision = '$id_comision' AND CAST(venta AS DECIMAL) <= '$palabra'");
						//echo "SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' AND id_comision = '$id_comision' AND venta <= '$palabra'";
					}else {
						$peticion = mysql_query("SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' AND id_comision = '$id_comision' AND (categoria LIKE '%$palabra%' OR cod LIKE '%$palabra%' OR nom LIKE '%$palabra%' OR modelo LIKE '%$palabra%' OR marca LIKE '%$palabra%' OR compania LIKE '%$palabra%')");//
					}
				}
				//echo "SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' AND id_comision = '$id_comision' AND (cod LIKE '%$palabra%' OR nom LIKE '%$palabra%' OR modelo LIKE '%$palabra%' OR marca LIKE '%$palabra%' OR compania LIKE '%$palabra%') <br>";

				/*echo "SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' AND (cod LIKE '%$palabra%' OR nom LIKE '%$palabra%' OR modelo LIKE '%$palabra%' OR marca LIKE '%$palabra%' OR compania LIKE '%$palabra%')<br>";
				echo $peticion;*/
			}
			$arr = array();
			if (mysql_num_rows($peticion) > 0) {
					//echo "Cantidad registros: ".count(mysql_num_rows($peticion));
				while($row = mysql_fetch_array($peticion)) {
					//echo "entra";
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
										   'marca' =>  $row['marca'],
										   'modelo' =>  $row['modelo'],
										   'cantidad' => $row['cantidad'],
										   'sucursal' => $nombre_sucursal,
								);
						}
					}else {
						//echo "si llega al el";
						$id_sucursal = $row['id_sucursal'];
						$query=mysql_query("SELECT empresa FROM empresa WHERE id='$id_sucursal'");
			            if($row2=mysql_fetch_array($query)){
			                $nombre_sucursal = $row2['empresa'];
			            }
						$arr[]=array( 'id_articulo' => $row['cod'],
					                   'nombre' => $row['nom'],
									   'precio' => $row['venta'],
									   'marca' => $row['marca'],
									   'modelo' =>  $row['modelo'],
									   'cantidad' => $row['cantidad'],
									   'sucursal' => $nombre_sucursal,
							);
					}
				}
			}else {
				//echo "si entra al else";
				if ($palabra != "") {
					$peticion = mysql_query("SELECT * FROM codigo_producto WHERE identificador = '$palabra' AND estado ='s'");
				}
				while($rows = mysql_fetch_array($peticion)) {
					$cod_producto = $rows['id_producto'];
					//if ($row['cantidad'] <= 0) {
						$queryplus = mysql_query("SELECT * FROM producto WHERE cod = '$cod_producto' AND id_sucursal = '$id_sucursal'");
						while($row = mysql_fetch_array($queryplus)) {
							$id_suc = $row['id_sucursal'];
							$query=mysql_query("SELECT empresa FROM empresa WHERE id='$id_suc'");
				            if($row2=mysql_fetch_array($query)){
				                $nombre_sucursal = $row2['empresa'];
				            }
							$arr[]=array( 'id_articulo' => $row['cod'],
						                   'nombre' => $row['nom'],
										   'precio' => $row['venta'],
										   'marca' =>  $row['marca'],
										   'modelo' =>  $row['modelo'],
										   'cantidad' => '1',//$row['cantidad'],
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
//header('location:clientes.php');
	?>