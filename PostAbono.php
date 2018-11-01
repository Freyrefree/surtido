<?php
session_start();
include('host.php');
include('funciones.php'); 
$usu=$_SESSION['username'];
$idSucursal = $_SESSION['id_sucursal'];

$opcion = $_POST['opcion'];

if($opcion == 1){

      if (!empty($_POST['id'])) {
            $identificador = $_POST['id'];
      
            $consultaCA = "SELECT * FROM credito WHERE id = $identificador";
            if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) {
      
                  if($paquete = consultar($con,$consultaCA))
                        while($dato=mysqli_fetch_array($paquete)){

                              ## verificar si ya tiene ICCID ##

                              $consultaiccid = "SELECT iccid FROM creditodetalle WHERE idCredito  = '$identificador'";

                              if($paqueteiccid = consultar($con,$consultaiccid)){
                                    $datoiccid =mysqli_fetch_array($paqueteiccid);
                                    $iccid = $datoiccid['iccid'];
                              }
      
                              $valor      = number_format($dato['resto'],2,".","").';'.$dato['fecha_pago'];
                              $idcliente  = $dato['idCliente'];
      
                              $consultaCliente = "SELECT * FROM cliente WHERE codigo = '$idcliente' ";
                              $cliente_sql = consultar($con,$consultaCliente);
      
                              $dat = mysqli_fetch_array($cliente_sql);
                              $valor = $valor.';'.$dat['nom']." ".$dat['apaterno']." ".$dat['amaterno'].';'.$idcliente.';'.$iccid;
                        }
                  echo $valor;
            }
      }

}else if($opcion == 2){

      date_default_timezone_set('America/Mexico_City');
      include('IMP_abono.php');
      $time = date('H:i:s');

      $iccid            = $_POST['finaliccid'];

      $idCliente        = $_POST['inputIDCliente'];
      $nombreCompleto   = $_POST['inputCliente'];

      $id_venta         = $_POST['idventa'];
      $fecha            = $_POST['fecha'];
      $datetime         = date('Y-m-d H:i:s', strtotime("$fecha $time"));

      $total_resto      = $_POST['tpagar'];
      $dinero_recibido  = $_POST['ccpago'];
      $abono            = $dinero_recibido;
      
      $denominacion     = $_POST['denominacion'];
      $cambio           = $denominacion - $dinero_recibido;

      $consultaCA = "SELECT * FROM credito where id='$id_venta' ";

      if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
      {

          if ($paqueteCA = consultar($con,$consultaCA)) 
          {
                  $dato = mysqli_fetch_array($paqueteCA);

                  $adelanto   = $dato['adelanto'];
                  $total      = $dato['total'];
                 

                  $dinero_recibido = ($dinero_recibido + $adelanto);
                  if ($dinero_recibido > $total) {
                        $resto = 0;
                        $dinero_recibido = $total;
                  } else {
                        $resto = ($total-$dinero_recibido);
                  }
                  

                  $estatus = 0;
                  if ($resto == 0) {
                        $estatus = 1;
                  }


                  ## agregar ICCID ##

                  if($iccid != ""){

                        $consultaIccid="SELECT id_producto,id_sucursal FROM codigo_producto WHERE identificador  = '$iccid'";
                        if($paqueteiccid = consultar($con,$consultaIccid)){


                              ## update a tabla de detalle credito##

                              $consultaUpdate = "UPDATE creditodetalle SET iccid = '$iccid' WHERE idCredito = '$id_venta'";
                              actualizar($con,$consultaUpdate);


                              $datoIccid = mysqli_fetch_array($paqueteiccid);
                              
                              $idProductoIccid      = $datoIccid['id_producto']; 
                              $idSucursalIccid       = $datoIccid['id_sucursal'];
                              
                              $consultaCant = "SELECT COUNT(*) FROM codigo_producto WHERE id_sucursal = '$idSucursal' AND id_producto = '$idProductoIccid'";
                            if($paqueteCant = consultar($con,$consultaCant)){
                                $datoCant = mysqli_fetch_array($paqueteCant);
                                $cantidadAtual = $datoCant[0];

                                $cantTotal = $cantidadAtual - 1;
                                $actualizaCantIccid = "UPDATE producto SET cantidad='$cantTotal' WHERE cod='$idProductoIccid' AND id_sucursal = '$idSucursalIccid'";
                                if(actualizar($con,$actualizaCantIccid)){

                                    $eliminar   = "DELETE FROM codigo_producto WHERE identificador  =  '$iccid'" ;
                                    $paqElimiar = eliminar($con,$eliminar);

                                }
                            }
                              


                        }else{

                             echo '<div class="alert alert-danger" role="alert">
                            EL ICCID es Incorrecto, intente de nuevo!
                           </div>';


                              exit;
                        }

                  }

                  $tipo = "ABONO";
                  $ccpago = $dinero_recibido;
                  $a_sql="UPDATE credito SET adelanto='$dinero_recibido',estatus='$estatus',resto='$resto' where id=$id_venta";

                  if ($resultado = actualizar($con,$a_sql)) {

                        $consultaCAPago = "INSERT INTO creditopago(idcredito,abono,fechaPago)
                        VALUES('$id_venta','$abono','$datetime' );";

                        if($paqueteCAPago = agregar ($con,$consultaCAPago)){

                              $consultaVenta = "INSERT INTO detalle
                              (factura, codigo, nombre, cantidad, valor, importe, tipo,
                              fecha_op,usu,id_sucursal,tipo_comision,modulo,esComision)
                              VALUES ('$id_venta','$idCliente','$nombreCompleto','1','$abono','$abono','ABONO',
                              NOW(),'$usu','$idSucursal','apartado','CR',0)";

                              if($paqueteVenta = agregar ($con,$consultaVenta)){

                                    PDFA($id_venta,$abono,$resto,$cambio,$denominacion,$dinero_recibido);
                                    header('location:abono.php?denominacion='.$denominacion.'&abono='.$abono.'&cambio='.$cambio.'&resto='.$resto.'&idCredito='.$id_venta);

                              }

                        }
                  }

          }

             
      }
}


?>
