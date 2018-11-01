<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
        if (!empty($_POST['name'])) {
            echo $name = $_POST['name'];
            echo $tipo = $_POST['type'];
            $can=mysql_query("SELECT * FROM producto where nom='$name'");
            while($dato=mysql_fetch_array($can)){
              if ($tipo == "3") {
                $valor = $dato['venta'];
              }
              if ($tipo == "2") {
                $valor = $dato['mayor'];
              }
              if ($tipo == "1") {
                $valor = $dato['especial'];
              }
            }
            echo $valor;
        }
?>
