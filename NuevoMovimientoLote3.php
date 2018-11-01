<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];

$n = $_REQUEST['NoProductos']; 
$SucursalEntrada = $_REQUEST['SucursalEntrada']; 
$IdMovimiento   = $_REQUEST['IdMovimiento'];  
$bandera = 0;
$arrayRespuestas =  array();	

for($y=1;$y<=$n;$y++)
{
    $cod       = trim($_REQUEST["producto$y"]);
    $cod = str_replace("_"," ", $cod);
    $CantMover = $_REQUEST["CantMover$y"];  	
    $IMEI      = $_REQUEST["IMEI$y"];  	
    $ICCID     = $_REQUEST["ICCID$y"];

    $IdFicha   = $_REQUEST["IdFicha$y"];  

    if($CantMover==""){
        $CantMover=1;
    }	

    if($IMEI!="" || $ICCID!="" || $IdFicha!=""){
         $CantMover=1;
    }

    if($IMEI == "" && $ICCID == ""){
        $respuestaBandera = moverProducto($cod,$CantMover,$id_sucursal,$SucursalEntrada,$IdMovimiento,$usu,$IMEI,$ICCID,$IdFicha);
        //respuestas($respuestaBandera);
        $respuestaHTML = respuestas($respuestaBandera);
        $arrayRespuestas[] =  array("respuestaAlert" => "<strong>".$cod."</strong>"."--".$respuestaHTML);

    }else if($IMEI == "" && $ICCID != ""){
        $respuestaBandera = moverProductoICCID($cod,$CantMover,$id_sucursal,$SucursalEntrada,$IdMovimiento,$ICCID,$usu,$IMEI,$IdFicha);
        //respuestas($respuestaBandera);
        $respuestaHTML = respuestas($respuestaBandera);
        $arrayRespuestas[] =  array("respuestaAlert" => "<strong>".$cod."</strong>"."--".$respuestaHTML);

    }else if($IMEI != "" && $ICCID == ""){
        $respuestaBandera = moverProductoIMEI($cod,$CantMover,$id_sucursal,$SucursalEntrada,$IdMovimiento,$IMEI,$usu,$ICCID,$IdFicha);
        //respuestas($respuestaBandera);
        $respuestaHTML = respuestas($respuestaBandera);
        $arrayRespuestas[] =  array("respuestaAlert" => "<strong>".$cod."</strong>"."--".$respuestaHTML);

    }else if($IMEI != "" && $ICCID != ""){
        $respuestaBandera = moverProductoIMEIICCID($cod,$CantMover,$id_sucursal,$SucursalEntrada,$IdMovimiento,$IMEI,$ICCID,$usu,$IdFicha);
        //respuestas($respuestaBandera);
        $respuestaHTML = respuestas($respuestaBandera);
        $arrayRespuestas[] =  array("respuestaAlert" => "<strong>".$cod."</strong>"."--".$respuestaHTML);

    }
}
echo json_encode($arrayRespuestas);

function moverProductoIMEIICCID($cod,$CantMover,$id_sucursal,$SucursalEntrada,$IdMovimiento,$IMEI,$ICCID,$usu,$IdFicha)
{
    include('php_conexion.php');
    $bandera = 1;
    $consultaConCodigo = "SELECT * FROM producto WHERE (cod='$cod' OR nom='$cod') AND id_sucursal='$id_sucursal';";
    $can=mysql_query($consultaConCodigo) or die(print"Error en consulta ciclica 1".mysql_error());

    if($dato=mysql_fetch_array($can))
    {
        $Cantidad   = $dato['cantidad'];
        $IdComision = $dato['id_comision'];
        $cod        = $dato['cod'];
        //*****************************Verifica Cantidad
        if($Cantidad == 0)
        {
            $bandera = 0; //**bandera cuando no hay existencias*/
        }//**********************************
        else
        {
            $consultaid_producto="SELECT id_producto FROM codigo_producto WHERE identificador = '$IMEI' AND id_sucursal = '$id_sucursal'";
            $ejecutar=mysql_query($consultaid_producto);
            $dato=mysql_fetch_array($ejecutar);
            $id_producto = $dato['id_producto'];

            if($cod != $id_producto)
            {
                $bandera = "4.1";  
            }
            else
            {
                $consultaid_sucursal="SELECT id_sucursal FROM codigo_producto WHERE identificador = '$ICCID' AND id_sucursal = '$id_sucursal'";
                $ejecutar=mysql_query($consultaid_sucursal);
                $dato=mysql_fetch_array($ejecutar);
                $id_sucursal2 = $dato['id_sucursal'];

                if($id_sucursal2 != $id_sucursal)
                {
                    $bandera = "4.2";
                }
                else
                {
                    $consulta2 = "SELECT * FROM movimientosxlote WHERE IdProducto='$cod' AND IdSucSalida='$id_sucursal' AND IdLote=$IdMovimiento AND IMEI = '$IMEI' AND Recibido = 0";        
                    $VerifLote=mysql_query($consulta2) or die(print"Error en comprobación de lote".mysql_error()); 
                    $ContarLote =  mysql_num_rows($VerifLote);
                    if($ContarLote != 0)
                    {
                        $bandera = 5;
                    }
                    else
                    {
                        $consulta3 = "SELECT * FROM movimientosxlote WHERE IdProducto='$cod' AND IdSucSalida='$id_sucursal' AND IMEI = '$IMEI' AND Recibido = 0";        
                        $VerifLote2=mysql_query($consulta3) or die(print"Error en comprobación de lote".mysql_error()); 
                        $ContarLote2 =  mysql_num_rows($VerifLote2);
                        if($ContarLote2 != 0)
                        {
                            $bandera = "7.1";
                        }
                        else
                        {
                            $consulta3 = "SELECT * FROM movimientosxlote WHERE IdProducto='$cod' AND IdSucSalida='$id_sucursal' AND ICCID = '$ICCID' AND Recibido = 0";        
                            $VerifLote2=mysql_query($consulta3) or die(print"Error en comprobación de lote".mysql_error()); 
                            $ContarLote2 =  mysql_num_rows($VerifLote2);
                            if($ContarLote2 != 0)
                            {
                                $bandera = "7.2";
                            }
                            else
                            {
                                if($bandera == 1 && $CantMover != 0 && $ContarLote == 0 && $ContarLote2 == 0)
                                {
                                    $consultaInsert="INSERT INTO movimientosxlote 
                                    (IdLote, 
                                    Tipo, 
                                    IdSucSalida, 
                                    IdSucEntrada, 
                                    UsuSalida, 
                                    IdProducto,
                                    IMEI,
                                    ICCID,
                                    IdFicha,
                                    Cantidad, 
                                    FechaSalida) 
                                    VALUES(
                                    $IdMovimiento,
                                    'traslado',
                                    $id_sucursal,
                                    $SucursalEntrada,
                                    '$usu',
                                    '$cod',
                                    '$IMEI',
                                    '$ICCID',
                                    '$IdFicha',
                                    $CantMover,
                                    NOW());";
            
                                    if(mysql_query($consultaInsert))
                                    {
                                        $bandera = 1;
                                    }
                                    else
                                    {
                                        $bandera = "ERROR";
                                    }
                                }
                                                                
                            }                            

                        }                        
                        
                    }
                    
                }
            }

        }

    }
    return $bandera;

}
function moverProductoIMEI($cod,$CantMover,$id_sucursal,$SucursalEntrada,$IdMovimiento,$IMEI,$usu,$ICCID,$IdFicha)
{
    include('php_conexion.php');
    $bandera = 1;
    $consultaConCodigo = "SELECT * FROM producto WHERE (cod='$cod' OR nom='$cod') AND id_sucursal='$id_sucursal';";
    $can=mysql_query($consultaConCodigo) or die(print"Error en consulta ciclica 1".mysql_error());

    if($dato=mysql_fetch_array($can))
    {
        $Cantidad   = $dato['cantidad'];
        $IdComision = $dato['id_comision'];
        $cod        = $dato['cod'];
        //*****************************Verifica Cantidad
        if($Cantidad == 0)
        {
            $bandera = 0; //**bandera cuando no hay existencias*/
        }//**********************************
        else
        {
            $consultaid_producto="SELECT id_producto FROM codigo_producto WHERE identificador = '$IMEI' AND id_sucursal = '$id_sucursal'";
            $ejecutar=mysql_query($consultaid_producto);
            $dato=mysql_fetch_array($ejecutar);
            $id_producto = $dato['id_producto'];

            if($cod != $id_producto)
            {
                $bandera = "4.1";  
            }
            else
            {
                $consulta2 = "SELECT * FROM movimientosxlote WHERE IdProducto='$cod' AND IdSucSalida='$id_sucursal' AND IdLote=$IdMovimiento AND IMEI = '$IMEI' AND Recibido = 0";        
                $VerifLote=mysql_query($consulta2) or die(print"Error en comprobación de lote".mysql_error()); 
                $ContarLote =  mysql_num_rows($VerifLote);
                if($ContarLote != 0)
                {
                    $bandera = 5;
                }
                else
                {
                    $consulta3 = "SELECT * FROM movimientosxlote WHERE IdProducto='$cod' AND IdSucSalida='$id_sucursal' AND IMEI = '$IMEI' AND Recibido = 0";        
                    $VerifLote2=mysql_query($consulta3) or die(print"Error en comprobación de lote".mysql_error()); 
                    $ContarLote2 =  mysql_num_rows($VerifLote2);
                    if($ContarLote2 != 0)
                    {
                        $bandera = 6;
                    }
                    else
                    {
                        if($bandera == 1 && $CantMover != 0 && $ContarLote == 0 && $ContarLote2 == 0)
                        {
                            $consultaInsert="INSERT INTO movimientosxlote 
                            (IdLote, 
                            Tipo, 
                            IdSucSalida, 
                            IdSucEntrada, 
                            UsuSalida, 
                            IdProducto,
                            IMEI,
                            ICCID,
                            IdFicha,
                            Cantidad, 
                            FechaSalida) 
                            VALUES(
                            $IdMovimiento,
                            'traslado',
                            $id_sucursal,
                            $SucursalEntrada,
                            '$usu',
                            '$cod',
                            '$IMEI',
                            '$ICCID',
                            '$IdFicha',
                            $CantMover,
                            NOW());";
    
                            if(mysql_query($consultaInsert))
                            {
                                $bandera = 1;
                            }
                            else
                            {
                                $bandera = "ERROR";
                            }
                        } 

                    }
                }                
            }
        }
    }
    return $bandera;
}
function moverProductoICCID($cod,$CantMover,$id_sucursal,$SucursalEntrada,$IdMovimiento,$ICCID,$usu,$IMEI,$IdFicha)
{
    include('php_conexion.php');
    $bandera = 1;
    $consultaConCodigo = "SELECT * FROM producto WHERE (cod='$cod' OR nom='$cod') AND id_sucursal='$id_sucursal';";
    $can=mysql_query($consultaConCodigo) or die(print"Error en consulta ciclica 1".mysql_error());

    if($dato=mysql_fetch_array($can))
    {
        $Cantidad   = $dato['cantidad'];
        $IdComision = $dato['id_comision'];
        $cod        = $dato['cod'];
        //*****************************Verifica Cantidad
        if($Cantidad == 0)
        {
            $bandera = 0; //**bandera cuando no hay existencias*/
        }//**********************************
        else
        {
            $consultaid_producto="SELECT id_producto FROM codigo_producto WHERE identificador = '$ICCID' AND id_sucursal = '$id_sucursal'";
            $ejecutar=mysql_query($consultaid_producto);
            $dato=mysql_fetch_array($ejecutar);
            $id_producto = $dato['id_producto'];

            if($cod != $id_producto)
            {
                $bandera = 4;
            }
            else
            {
                $consulta2 = "SELECT * FROM movimientosxlote WHERE IdProducto='$cod' AND IdSucSalida='$id_sucursal' AND IdLote=$IdMovimiento AND ICCID = '$ICCID' AND Recibido = 0";        
                $VerifLote=mysql_query($consulta2) or die(print"Error en comprobación de lote".mysql_error()); 
                $ContarLote =  mysql_num_rows($VerifLote);
                if($ContarLote != 0)
                {
                    $bandera = 5;
                }
                else
                {
                    $consulta3 = "SELECT * FROM movimientosxlote WHERE IdProducto='$cod' AND IdSucSalida='$id_sucursal' AND ICCID = '$ICCID' AND Recibido = 0";        
                    $VerifLote2=mysql_query($consulta3) or die(print"Error en comprobación de lote".mysql_error()); 
                    $ContarLote2 =  mysql_num_rows($VerifLote2);
                    if($ContarLote2 != 0)
                    {
                        $bandera = 6;
                    }
                    else
                    {
                        if($bandera == 1 && $CantMover != 0 && $ContarLote == 0 && $ContarLote2 == 0)
                        {
                            $consultaInsert="INSERT INTO movimientosxlote 
                            (IdLote, 
                            Tipo, 
                            IdSucSalida, 
                            IdSucEntrada, 
                            UsuSalida, 
                            IdProducto,
                            IMEI,
                            ICCID,
                            IdFicha,
                            Cantidad, 
                            FechaSalida) 
                            VALUES(
                            $IdMovimiento,
                            'traslado',
                            $id_sucursal,
                            $SucursalEntrada,
                            '$usu',
                            '$cod',
                            '$IMEI',
                            '$ICCID',
                            '$IdFicha',
                            $CantMover,
                            NOW());";
    
                            if(mysql_query($consultaInsert))
                            {
                                $bandera = 1;
                            }
                            else
                            {
                                $bandera = "ERROR";
                            }
                        } 

                    }
                }                
            }
        }
    }
    return $bandera;
}
function moverProducto($cod,$CantMover,$id_sucursal,$SucursalEntrada,$IdMovimiento,$usu,$IMEI,$ICCID,$IdFicha)
{
    include('php_conexion.php');
    $bandera = 1;
    $consultaSinCodigo = "SELECT * FROM producto WHERE (cod='$cod' OR nom='$cod') AND id_sucursal='$id_sucursal';";
    $can=mysql_query($consultaSinCodigo) or die(print"Error en consulta ciclica 1".mysql_error());

    if($dato=mysql_fetch_array($can))
    {
        $Cantidad   = $dato['cantidad'];
        $IdComision = $dato['id_comision'];
        $cod        = $dato['cod'];
        //*****************************Verifica Cantidad
        if($Cantidad == 0)
        {
            $bandera = 0; //**bandera cuando no hay existencias*/
        }//**********************************
        else
        {
            $NewCantidad  = $Cantidad-$CantMover;
            if($NewCantidad<0)
            {
                $bandera = 2;                        
            }
            else
            {
                $consulta2 = "SELECT * FROM movimientosxlote WHERE IdProducto='$cod' AND IdSucSalida='$id_sucursal' AND IdLote=$IdMovimiento";        
                $VerifLote=mysql_query($consulta2) or die(print"Error en comprobación de lote".mysql_error()); 
                $ContarLote =  mysql_num_rows($VerifLote);
                if($ContarLote != 0)
                {
                    $bandera = 3;
                }
                else
                {
                    if($bandera==1 && $CantMover!=0 && $ContarLote==0)
                    {
                        $consultaInsert="INSERT INTO movimientosxlote 
                        (IdLote, 
                        Tipo, 
                        IdSucSalida, 
                        IdSucEntrada, 
                        UsuSalida, 
                        IdProducto,
                        IMEI,
                        ICCID,
                        IdFicha,
                        Cantidad, 
                        FechaSalida) 
                        VALUES(
                        $IdMovimiento,
                        'traslado',
                        $id_sucursal,
                        $SucursalEntrada,
                        '$usu',
                        '$cod',
                        '$IMEI',
                        '$ICCID',
                        '$IdFicha',
                        $CantMover,
                        NOW());";

                        if(mysql_query($consultaInsert))
                        {
                            $bandera = 1;
                        }
                        else
                        {
                            $bandera = "ERROR";
                        }
                    } 
                }                                
            }
        }  

    }

    return $bandera;
}


 //////////////////////////////////////RESPUESTAS////////////////////////////////
 function respuestas($respuestaBandera)
 {
     $mensajeAlerta = "";
    //include('php_conexion.php');
     if($respuestaBandera == 0)
     {
        $mensajeAlerta = '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>¡No todos los elementos han sido movidos ya que se presentan movimientos de productos que no tienen existencias!</strong></div>';         
                     
     }else if($respuestaBandera == 2)
     {
        $mensajeAlerta = '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>La cantidad que se desea mover es Mayor a la Existente</strong></div>'; 
        
     }else if($respuestaBandera == 3)
     {
        $mensajeAlerta = '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>Ya existen Movimientos por Lote  Enviados desde ésta sucursal con la misma Información que no han sido aceptados por la sucursal destino</strong></div>'; 
             
    }else if($respuestaBandera == 1)
    {

        $mensajeAlerta = '<div class="alert alert-success" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>Se han enviado los productos correctamente</strong></div>'; 
       
    }else if($respuestaBandera == "ERROR")
    {
        $mensajeAlerta = '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>No se realizaron algunos movimientos</strong></div>'; 
        
    }else if($respuestaBandera == 4)
    {
        $mensajeAlerta = '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>Algún ICCID no coincide con su Nombre de producto ingresado</strong></div>'; 
       
    }else if($respuestaBandera == "4.1")
    {
        $mensajeAlerta = '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>Algún IMEI no coincide con su Nombre de producto ingresado</strong></div>';
       
    }else if($respuestaBandera == "4.2")
    {
        $mensajeAlerta = '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>Algún ICCID no le pertenece a la sucursal</strong></div>';
       
    }else if($respuestaBandera == 5)
    {
        $mensajeAlerta = '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>Ya existen Movimientos por Lote  Enviados desde ésta sucursal con la misma Información que no han sido aceptados por la sucursal destino</strong></div>';         
                    
    }else if($respuestaBandera == 6)
    {   
        $mensajeAlerta = '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>Ya existen Movimientos por Lote  Enviados desde ésta sucursal con la misma Información que no han sido aceptados por la sucursal destino</strong></div>';      

                       
    }
    else if($respuestaBandera == "7.1")
    {
        $mensajeAlerta = '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>Existen algún movimiento por lote en donde ya fué ingresado alguno de los IMEI y que no ha sido aceptado</strong></div>';         
                      
    }
    else if($respuestaBandera == "7.2")
    {
        $mensajeAlerta = '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>Existen algún movimiento por lote en donde ya fué ingresado alguno de los ICCID y que no ha sido aceptado</strong></div>';         
                    
    }
    return $mensajeAlerta;
 } 
?>

