<?php 
session_start();
include('php_conexion.php');
$usu=$_SESSION['username'];
$id_sucursal = $_SESSION['id_sucursal'];

if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
	header('location:clientes.php');
}else{

	$id = $_POST['id'];
	//$id = "7500326211539";

	if($_SESSION['username']==""){
	}else{
		if($_SESSION['tipo_usu']=='a' OR $_SESSION['tipo_usu']=='ca' OR $_SESSION['tipo_usu']=='te' OR $_SESSION['tipo_usu']=='su'){
			//echo "session de tro del else --> if: ".$_SESSION['tipo_usu'];
			$peticion = mysql_query("SELECT * FROM codigo_producto WHERE id_producto = '$id' AND id_sucursal = '$id_sucursal' AND estado = 's'");
			//echo "<br> SELECT * FROM codigo_producto WHERE id_producto = '$id' AND id_sucursal = '$id_sucursal' AND estado = 's'";
			$queryp = mysql_query("SELECT * FROM producto WHERE cod = '$id' AND id_sucursal = '$id_sucursal'");
			if($row2 = mysql_fetch_array($queryp)) {
				$nombre = $row2['nom'];
				$id_comision = $row2['id_comision'];
				$cantidad = $row2['cantidad'];
			}
			$queryt = mysql_query("SELECT * FROM comision WHERE id_comision = '$id_comision'");
			if($row3 = mysql_fetch_array($queryt)) {
				$tipo = $row3['tipo'];
			}
			$arr = array();
			if ($tipo == "TELEFONO") {
				$arrimei = array();
				$arricid = array();
				$contimei = 0;
				$conticid = 0;
				while($row = mysql_fetch_array($peticion)) {
					if ( $row['tipo_identificador']=="IMEI") {
						$arrimei[$contimei]=$row['identificador'];
						$contimei++;
					}
					if ( $row['tipo_identificador']=="ICCID" ) {
						$arricid[$conticid]=$row['identificador'];
						$conticid++;
					}
				}
				/*print_r($arrimei);
				echo "<br>";
				print_r($arricid);*/
				$cont = 0;
				while (count($arrimei) > $cont OR count($arricid) > $cont) {
					$arr[]=array( 'id_articulo' => $id,
				                   'nombre' => $nombre,
								   'imei' => $arrimei[$cont],
								   'iccid' =>  "-",
								   'ficha' =>  "-"
					);
					$cont++;
				}
			}
			if ($tipo == "CHIP") {
				while($row = mysql_fetch_array($peticion)) {
					$arr[]=array( 'id_articulo' => $id,
				                   'nombre' => $nombre,
								   'imei' => "-",
								   'iccid' =>  $row['identificador'],
								   'ficha' =>  "-"
					);
				}
			}
			if ($tipo == "FICHA") {
				while($row = mysql_fetch_array($peticion)) {
					$arr[]=array( 'id_articulo' => $id,
				                   'nombre' => $nombre,
								   'imei' => "-",
								   'iccid' =>  "-",
								   'ficha' =>  $row['identificador']
					);
				}
			}
			if ($tipo != "FICHA" && $tipo != "CHIP" && $tipo != "TELEFONO") {
				/*while($row = mysql_fetch_array($peticion)) {*/
				$cont = 0;
				while ($cantidad > $cont) {
					$arr[]=array( 'id_articulo' => $id,
				                   'nombre' => $nombre,
								   'imei' => "-",
								   'iccid' =>  "-",
								   'ficha' =>  "-"
					);
					$cont++;
				}
				/*}*/
			}
			echo json_encode($arr);
		}
	}
}
//header('location:clientes.php');
	?>