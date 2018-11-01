<?php
 		session_start();
     error_reporting(E_ALL ^ E_DEPRECATED);
     error_reporting(0);
     include("host.php");
     include("funciones.php");
		$usu=$_SESSION['username'];
    $id_sucursal = $_SESSION['id_sucursal'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='te'){
			header('location:error.php');
		}
    
        $id_reparacion = $_POST['id_repar'];
        $motivo_reingreso = $_POST['observacion'];


        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB))
        {
          $consulta = "SELECT * FROM reparacion WHERE id_reparacion = '$id_reparacion'";

          if ($paquete = consultar($con, $consulta)) 
          {
              if ($fila = mysqli_fetch_array($paquete)) {
                  $usu = $fila['usuario'];
                  $cod_cliente = $fila['cod_cliente'];
                  $imei = $fila['imei'];
                  $marca = $fila['marca'];
                  $modelo = $fila['modelo'];
                  $color = $fila['color'];
                  $precio = $fila['precio'];
                  $abono = $fila['abono'];
                  $motivo = $fila['motivo'];
                  $observacion = $fila['observacion'];
                  $fecha_ingreso = $fila['fecha_ingreso'];
                  $fecha_salida = $fila['fecha_salida'];
                  $id_comision = $fila['id_comision'];
                  $chip = $fila['chip'];
                  $memoria = $fila['memoria'];
                  $costo = $fila['costo'];
                  $nombre_contacto = $fila['nombre_contacto'];
                  $telefono_contacto = $fila['telefono_contacto'];
                  $rfccurp = $fila['rfc_curp_contacto'];

                  $consulta2 = "INSERT INTO reparacion 
              (id_sucursal,usuario,cod_cliente, imei,
               marca, modelo, color, precio,abono,motivo,observacion,fecha_ingreso,
               fecha_salida,id_comision,estado,chip,memoria,costo,nombre_contacto,
               telefono_contacto,rfc_curp_contacto,garantia, id_garantia)
              VALUES ('$id_sucursal','$usu','$cod_cliente','$imei',
              '$marca','$modelo','$color','$precio','$abono','$motivo','$motivo_reingreso','$fecha_ingreso',
              '$fecha_salida','$id_comision','1','$chip','$memoria','$costo','$nombre_contacto',
              '$telefono_contacto','$rfccurp','s','$id_reparacion')";

                  if ($paquete = agregar($con, $consulta2)) {
                      echo 1;
                  } else {
                      echo 0;
                  }
              } else {
                  echo 0;
              }
          }else{
            echo 0;
          }
        
        }
        else{}
?>
