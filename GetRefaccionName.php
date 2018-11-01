<?php 
	session_start();
	include('php_conexion.php');
	$usu=$_SESSION['username'];
	$id_sucursal = $_SESSION['id_sucursal'];
		//Declaracion de variables para la consulta
		if($_SESSION['username']==""){
		}else{
			if($_SESSION['tipo_usu']=='a' OR $_SESSION['tipo_usu']=='ca' OR $_SESSION['tipo_usu']=='te' OR $_SESSION['tipo_usu']=='su'){
				$categoria = $_GET['categoria'];
				$tipo = "REFACCION";
				$query = mysql_query("SELECT * FROM comision WHERE tipo = '$tipo'");
				//echo "SELECT * FROM comision WHERE tipo = '$tipo' <br>";
				if($row = mysql_fetch_array($query)) {
					$id_comision = $row['id_comision'];
				}
				$poblaciones = array();
				$peticion = mysql_query("SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' AND id_comision='$id_comision' AND categoria = '$categoria'");
				//echo "SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' AND (nom LIKE '%$palabra%' OR modelo LIKE '%$palabra%' OR marca LIKE '%$palabra%' OR compania LIKE '%$palabra%') AND id_comision='$id_comision'";
				while($fila = mysql_fetch_array($peticion)) {
					$poblaciones[] = $fila['nom'];/*$fila['nom']*/
				}
				print_r(json_encode($poblaciones));
			}
		}
	//}
	//header('location:caja.php');
?>