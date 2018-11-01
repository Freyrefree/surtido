<?php
include("funciones.php");
include("host.php");
session_start();

$usuario=$_SESSION['username'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
	header('location:error.php');
}

$idSucursal = $_SESSION['id_sucursal'];

###  Datos POST
$ccpago         = $_POST['ccpago2'];#abono
$tpagar         = $_POST['tpagar'];#total
$resto          = ($tpagar - $ccpago);#restante
$pagoDenomina   = $_POST['denominacion'];

## calculo Cambio Cuando aplique ##
$cambio = $pagoDenomina - $ccpago;
##

$tipo           = $_POST['tipocompra'];
$tipsis         = $_POST['tipsis'];
$cliente        = $_POST['client'];
$fechapago      = $_POST['fecha'];

$explodeC       = explode('||',$cliente);
$idCliente      = $explodeC[0];

$checkCliente   = isset($_POST['checkCliente']);
if($checkCliente == false){
    $checkCliente = 0;
}

## POST DATOS CLIENTE ##

$nombreCliente  = $_POST['nombreCliente'];
$appCliente     = $_POST['appCliente'];
$apmCliente     = $_POST['apmCliente'];
$telCliente     = $_POST['telCliente'];
$emailCliente   = $_POST['emailCliente'];
$empresaCliente = $nombreCliente." ".$appCliente." ".$apmCliente;

$nombreCompleto = utf8_encode($nombreCliente)." ".utf8_encode($appCliente);

## Variables iniciadas
$t_importe = 0;

if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
{

    if($_POST['button'] == 'Cobrar Dinero Recibido'){


        ######  Obtener Id Cliente -> Agergar Nuevo Cliente#####
        if ($checkCliente == 1) {
            $consultaC = "INSERT INTO cliente (nom,apaterno,amaterno,correo,tel,estatus,empresa) 
            VALUES ('$nombreCliente','$appCliente','$apmCliente','$emailCliente','$telCliente','s','$empresaCliente')";
            $idCliente = agregarCliente($con,$consultaC);
        }else{
            ## Consulta Cliente ##
            $consultaCliente = "SELECT CONCAT (nom,' ',apaterno,' ',amaterno) AS nombreCompleto FROM cliente WHERE codigo = '$idCliente';";
            $paqueteCliente = consultar($con,$consultaCliente);
            $datoCliente = mysqli_fetch_array($paqueteCliente);
            $nombreCompleto = utf8_encode($datoCliente['nombreCompleto']);
        }

        $consultaCaja = "SELECT * FROM caja_tmp where usu='$usuario'";
        if($paquete = consultar($con,$consultaCaja)){

            #Insertar en tabla de credito
            $consultaCredito = "INSERT INTO credito 
            (total, adelanto, resto, fecha_venta,fecha_pago,
                estatus, tipo,id_sucursal,idCliente)
            VALUES ('$tpagar','$ccpago','$resto',NOW(),
            '$fechapago',0,'$tipsis','$idSucursal','$idCliente')";

            

            if(($paqueteCredito = agregarCreditoApartado($con,$consultaCredito)) != false)
            {
                ## Insertar en tabla de pagos el primer pago ##
                $consultaPago = "INSERT INTO creditoPago(idCredito,abono,fechaPago) VALUES ('$paqueteCredito','$ccpago',NOW())";
                $paquetePago = agregar($con,$consultaPago);

                ## Insertar en tabla detalle el primer pago ##
                $consultaVenta = "INSERT INTO detalle
                (factura, codigo, nombre, cantidad, valor, importe, tipo,
                fecha_op,usu,id_sucursal,tipo_comision,modulo)
                VALUES ('$paqueteCredito','$idCliente','$nombreCompleto','1','$ccpago','$ccpago','ABONO',
                NOW(),'$usuario','$idSucursal','apartado','CR')";

                $paqueteVenta = agregar($con,$consultaVenta);

                ## Busacar en tabala cajaTMP ##

                while($fila = mysqli_fetch_array($paquete)){

                    $cod            = $fila['cod'];			
                    $nom            = $fila['nom'];			
                    $cant           = $fila['cant'];
                    $venta          = $fila['venta'];		
                    $importe        = $fila['importe'];	
                    $t_importe      = $t_importe + $importe;
                    $imei           = $fila['imei'];		
                    $iccid          = $fila['iccid'];	
                    $n_ficha        = $fila['n_ficha'];  
                    $tipo_comision  = $fila['tipo_comision'];





                    ## ACTUALIZAR LA EXISTENCIA ##
                    $consultaExis = "SELECT * FROM producto where cod='$cod' AND id_sucursal = '$idSucursal'";
                    if($paqueteExist = consultar($con,$consultaExis)){

                        $filaE = mysqli_fetch_array($paqueteExist);

                        $e_actual   = $filaE['cantidad'];
                        //$comision   = $filaE['id_comision'];
                        //$compania   = $filaE['compania'];

                        $n_cantidad = ($e_actual - $cant);

                        if($n_cantidad<0){	$n_cantidad=0;	} ## Si la cantidad da negativo ponerlo en 0

                        $actualizaCant = "UPDATE producto SET cantidad='$n_cantidad' WHERE cod='$cod' AND id_sucursal = '$idSucursal'";
                        
                        
                        if($actualiza = actualizar($con,$actualizaCant)){

                            ## Insertar cada producto en la tabla de detalle Credito
                            $consultaDetalle = "INSERT INTO creditodetalle(idCredito,idProducto,precioUnitario,precioProducto,cantidad,iccid,imei)
                            VALUES ('$paqueteCredito','$cod','$venta','$importe',$cant,'$iccid','$imei')";
                            $paqueteDetalle = agregar($con,$consultaDetalle);                                

                        }

                        ## Consulta Comision ##
                        // $consultaComi = "SELECT * FROM comision where id_comision = '$comision' ";
                        // if($paqueteComi = consultar($con,$consultaComi)){

                        //     $filaC = mysqli_fetch_array($consultaComi);
                        //     $tipo_pro = $filaC['tipo'];
                        // }

                    }

                  

                    ## En la siguiente validación se hará un update a cantidad del producto cuando el iccid entre como producto secundario. 
                    ## Ya que en ocaciones es primario y la modificacion para un primario se encuentra arriba 

                    if($imei != "" && $iccid != ""){

                        ## Update a Cantidad de ICCID ##

                        $updateIccid = "SELECT id_producto,id_sucursal FROM codigo_producto WHERE identificador  = '$iccid'";
                        if($paqueteiccid = consultar($con,$updateIccid)){

                            $datoIccid          = mysqli_fetch_array($paqueteiccid);
                            $idProductoIccid    = $datoIccid['id_producto'];
                            $idSucursalIccid    = $datoIccid['id_sucursal'];

                            ## Cantidad actual del producto
                            $consultaCant = "SELECT COUNT(*) FROM codigo_producto WHERE id_sucursal = '$idSucursal' AND id_producto = '$idProductoIccid'";
                            if($paqueteCant = consultar($con,$consultaCant)){
                                $datoCant = mysqli_fetch_array($paqueteCant);
                                $cantidadAtual = $datoCant[0];

                                $cantTotal = $cantidadAtual - 1;
                                $actualizaCantIccid = "UPDATE producto SET cantidad='$cantTotal' WHERE cod='$idProductoIccid' AND id_sucursal = '$idSucursalIccid'";
                                actualizar($con,$actualizaCantIccid);
                            }
                        }
                    }


                      ## Consultas para eliminar el IMEI o ICCID según el caso ##
                      if($imei != ""){

                        $eliminar   = "DELETE FROM codigo_producto WHERE identificador  =  '$imei' ";
                        $paqElimiar = eliminar($con,$eliminar);
                    }

                    if($iccid != ""){

                        $eliminar   = "DELETE FROM codigo_producto WHERE identificador  =  '$iccid'" ;
                        $paqElimiar = eliminar($con,$eliminar);

                    }

                    ## Consulta para eliminar prodcutos de caja temporal

                    $consultaBorrado = "DELETE FROM caja_tmp WHERE usu='$usuario' ";
                    $paqElimiarTMP = eliminar($con,$consultaBorrado);


                }

                ## Imprimir Ticket ##
                header("location:credito.php?tipo=CREDITO&tpagar=".$tpagar."&ccpago=".$ccpago."&factura=".$paqueteCredito."&resto=".$resto."&cambio=".$cambio."&denominacion=".$pagoDenomina);	
                
                
                       

            }


        }else{
            echo "Sin Prodcutos, caja vacía";
        }

    }
}



?>