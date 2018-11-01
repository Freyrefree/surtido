<?php 
	session_start();
	include('php_conexion.php');
	$usu=$_SESSION['username'];
	$id_sucursal = $_SESSION['id_sucursal'];
	/*if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
		header('location:caja.php');
	}else{*/
		//Declaracion de variables para la consulta
		$codigo = $_GET['codigo'];
		if($_SESSION['username']==""){
		}else{
			if($_SESSION['tipo_usu']=='a' || $_SESSION['tipo_usu']=='ca' || $_SESSION['tipo_usu']=='te'){
				$poblaciones = array();
			
				$peticion = mysql_query("SELECT * FROM paquetes_datos WHERE codigo = '$codigo'");
				//echo '<option value="0">Seleccionar</option>';
				while($fila = mysql_fetch_array($peticion)) {
					$poblaciones[$fila['costo']] = $fila['costo']." - ".$fila['vigencia'] ." - ".$fila['nombre'];
				    //echo '<option value="'.$fila["valor"].'">'.$fila["valor"].'</option>';
				}
				print_r(json_encode($poblaciones));
				// Liberar resultados
				//mysql_free_result($peticion);
			}
		}
	//}
	//header('location:caja.php');
?>