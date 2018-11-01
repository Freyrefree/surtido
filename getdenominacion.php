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
			if($_SESSION['tipo_usu']=='a'){
				$poblaciones = array();
				$sent=mysql_query("SELECT * FROM compania_tl WHERE codigo ='$codigo'");
			        if($data=mysql_fetch_array($sent)){ 
					$id_compania = $data['id_compania'];
			      }
				$peticion = mysql_query("SELECT * FROM denominacion WHERE id_compania = '$id_compania'");
				//echo '<option value="0">Seleccionar</option>';
				while($fila = mysql_fetch_array($peticion)) {
					$poblaciones[$fila['valor']] = $fila['valor'];
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