<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
    $id_sucursal = $_SESSION['id_sucursal'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='te'){
			header('location:error.php');
		}
    $id_reparacion = $_GET['id_repa']; //$_GET['id_repa'];
    if (!empty($id_reparacion)) {
         $s_sql="UPDATE reparacion SET estado='2' WHERE id_reparacion='$id_reparacion'";
         $resultado = mysql_query($s_sql);
         if ($resultado) {
              header("Location: reparaciones.php");
         }
    }else {
      header("Location: reparaciones.php");
    }
?>
