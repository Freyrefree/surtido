<?php 
		session_start();
		include('php_conexion.php'); 
		$usuario=$_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		require_once('lib/nusoap.php');
		$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
		$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
		$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
		$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$WSRecargas = new nusoap_client("http://desarrollo.movivendor.com/wschan/", false,
								$proxyhost, $proxyport, $proxyusername, $proxypassword);
		$err = $WSRecargas->getError();
		if ($err) {
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
			echo '<h2>Debug</h2><pre>' . htmlspecialchars($WSRecargas->getDebug(), ENT_QUOTES) . '</pre>';
			exit();
		}
		//datos para Venta de Saldo
		$Id = "123456789019";
		$ClaveCanal = "SURTEST";
		$PassCanal = "prueba";
		$Terminal = "?";
		$Producto = "TL";
		$Destino = "7221725421";
		$Monto = "20";
		$Extra = "?";
		$XMLResultado = $WSRecargas->venta($Id,$ClaveCanal,$PassCanal,$Terminal,$Producto,$Destino,$Monto,$Extra);
		echo $XMLResultado;
		if ($XMLResultado->fault) {
			echo 'Fallo';
			print_r($result);
		} else {	// Chequea errores
			$err = $XMLResultado->getError();
			if ($err) {		// Muestra el error
				echo 'Error' . $err ;
			} else {		// Muestra el resultado
				echo 'Resultado';
				print_r ($XMLResultado);
			}
		}
		
		foreach($XMLResultado->Table as $table)
		  {
		    $output .= "<p>$table->Name</p>";
		  }
		  echo $output;
?>