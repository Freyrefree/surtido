<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
    $id_sucursal = $_SESSION['id_sucursal'];
		/*if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}*/
        if (!empty($_POST['name'])) {
            /*$name = $_POST['name'];*/
            $tipo = $_POST['type'];
            $suma = 0;
            $productos = $_POST['name'];
            /*$productos = "TOUCH/ALFA/G850
                          ";*/
            $producto  = explode("\n", $productos);
            $cont = 0;
            $numero = count($producto);
            while ($cont < $numero) {
              $nombre = $producto[$cont];
              $nombre = trim($nombre);
              if (!empty($nombre)) {
                    $queryi=mysql_query("SELECT * FROM producto WHERE nom='$nombre' AND id_sucursal = '$id_sucursal'");
                    //echo "SELECT * FROM producto WHERE nom='$nombre' AND id_sucursal = '$id_sucursal' <br>";
                    if($dato=mysql_fetch_array($queryi)){
                        if ($tipo == "3") {
                          $valor = $dato['venta'];
                        }
                        if ($tipo == "2") {
                          $valor = $dato['mayor'];
                        }
                        if ($tipo == "1") {
                          $valor = $dato['especial'];
                        }
                        $suma = $suma + $valor;
                    }
                }
              $cont = $cont+1;
            }
            echo $suma;
            //print_r($producto);
        }
?>
