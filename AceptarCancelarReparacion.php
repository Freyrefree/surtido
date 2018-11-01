<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
    $id_sucursal = $_SESSION['id_sucursal'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='te'){
			header('location:error.php');
		}
    if (!empty($_GET['id'])) {
        $id_reparacion = $_GET['id'];
        $act = $_GET['act'];
        if ($act == 'si') {
          $xSQL="UPDATE reparacion SET estado='1'
                 WHERE id_reparacion='$id_reparacion'";
              mysql_query($xSQL);
        }else{
          $xSQL="UPDATE reparacion SET estado='4'
                 WHERE id_reparacion='$id_reparacion'";
              mysql_query($xSQL);
        }
     header('location:reparaciones.php');
    }
?>
