<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
        $id_sucursal = $_SESSION['id_sucursal'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='te' or !$_SESSION['tipo_usu']=='su'){
			header('location:error.php');
        }
        
    if (!empty($_POST['id']) AND $_SESSION['tipo_usu']=='a') {
        $codigo = $_POST['id'];
        $imei = $_POST['imei'];
        $iccid = $_POST['iccid'];


        
        

        if (!empty($codigo)) {
            $sql0="UPDATE producto SET cantidad = cantidad-1 WHERE cod = '$codigo' AND id_sucursal = '$id_sucursal';";
            $resultado = mysql_query($sql0);
        }
        if (!empty($imei)) {
            $sql1="DELETE FROM codigo_producto WHERE identificador= '$imei' AND id_sucursal = '$id_sucursal'";
            $resultado = mysql_query($sql1);
        }
        if (!empty($imei)) {
            $sql2="DELETE FROM codigo_producto WHERE identificador='$iccid' AND id_sucursal = '$id_sucursal'";
            $resultado = mysql_query($sql2);
        }
        if (!empty($imei)) {
            $sql3="DELETE FROM codigo_producto WHERE identificador='$ficha' AND id_sucursal = '$id_sucursal'";
            $resultado = mysql_query($sql3);
        }
        if ($resultado) {
          echo 1;
        }
    }
?>
