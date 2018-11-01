<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
    $id_sucursal = $_SESSION['id_sucursal'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
    if (!empty($_POST['id'])) {
        $codigo = $_POST['id'];
        $faltantes = $_POST['faltantes'];
        $sobrantes = $_POST['sobrantes'];
        if (empty($sobrantes)) {
            $sobrantes = "0";
        }
        if (!empty($faltantes)) {
            $query = mysql_query("SELECT * FROM producto WHERE cod = '$codigo' AND id_sucursal='$id_sucursal'");
            if($row = mysql_fetch_array($query)) {
                $cantidad = $row['cantidad'];
            }
            $ncantidad = $cantidad-$faltantes;
            $sql="UPDATE producto SET cantidad = $ncantidad WHERE cod='$codigo' AND id_sucursal = '$id_sucursal'";
            mysql_query($sql);
        }
        $s_sql="UPDATE producto SET faltantes='$faltantes', sobrantes='$sobrantes' WHERE cod='$codigo' AND id_sucursal = '$id_sucursal'";
        $resultado = mysql_query($s_sql);
        if ($resultado) {
          echo $valor;
        }
    }
?>
