<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];

        $IdElemento=$_REQUEST['Elemento'];
        $elemento = explode("?", $IdElemento);
        $IdProducto = $elemento[0]; // IdProducto
        $IMEI       = $elemento[1]; // IMEI
        $ICCID      = $elemento[2]; // ICCID
        $IdFicha    = $elemento[3]; // IdFicha
        $IdLote     = $elemento[4]; // IdLote

       $Aceptados=$_REQUEST['Aceptados'];

        $consulta1 = "UPDATE movimientosxlote SET Recibido=1, FechaEntrada=NOW(), IdSucEntrada=$id_sucursal, UsuEntrada='$usu' WHERE IdProducto='$IdProducto' AND IMEI='$IMEI' AND ICCID='$ICCID' AND IdFicha='$IdFicha' AND IdLote=$IdLote";
        


        $ActLista=mysql_query($consulta1) or die (print("Error al Aceptar Elemento de Lote".mysql_error())); 

        $consulta3 = "SELECT * FROM producto WHERE (cod='$IdProducto' OR nom='$IdProducto') AND id_sucursal='$id_sucursal'";
        $can1=mysql_query($consulta3) or die(print"Error al consultar cantidad de producto".mysql_error());
        if($dato1=mysql_fetch_array($can1)){
                
                $CantProd=$dato1['cantidad'];

                $can=mysql_query("SELECT * FROM movimientosxlote WHERE IdProducto='$IdProducto' AND IdLote='$IdLote' AND IMEI='$IMEI' AND ICCID='$ICCID' AND IdFicha='$IdFicha' AND IdSucEntrada=$id_sucursal") or die(print"Error al consultar cantidad".mysql_error());
                        if($dato=mysql_fetch_array($can)){
                                
                                $Cantidad = $dato['Cantidad'];
                                $IdSucSalida = $dato['IdSucSalida'];
                                

                                if($Aceptados!="" && $Aceptados<=$Cantidad){
                                   $Cantidad = $Aceptados;        
                                }

                        
                                $SumaCant = $Cantidad + $CantProd;
             

                                $can=mysql_query("UPDATE movimientosxlote SET CantRecibida=$Cantidad WHERE IdProducto='$IdProducto' AND IdLote='$IdLote' AND (IMEI='$IMEI' OR ICCID='$ICCID' OR IdFicha='$IdFicha') AND IdSucEntrada=$id_sucursal") or die(print"Error al consultar cantidad".mysql_error());

                                $can=mysql_query("UPDATE producto SET cantidad=cantidad-'$Cantidad' WHERE (cod='$IdProducto' or nom='$IdProducto') AND id_sucursal='$IdSucSalida' AND cantidad>=0")or die (print("Error al Actualizar Inventario en sucursal Actual".mysql_error()));
	                        

                                $can3=mysql_query("UPDATE producto SET cantidad='$SumaCant', fecha=NOW() WHERE (cod='$IdProducto' OR nom='$IdProducto') AND id_sucursal='$id_sucursal'") or die (print("Error al Aceptar Elemento de Lote".mysql_error()));
                                if($IMEI!="" || $ICCID!="" || $IdFicha!=""){
                                //Consulta para cambiar de sucursal el IMEI
                                   $consulta="UPDATE codigo_producto SET fecha=NOW(), id_sucursal='$id_sucursal' WHERE id_producto='$IdProducto' AND identificador='$IMEI'";
                                   $can4=mysql_query($consulta) or die (print("Error al Aceptar Elemento en codigo_producto".mysql_error()));
                                //consulta para cambiar de sucursal el ICCID
                                $consultaICCID = "UPDATE codigo_producto SET id_sucursal = '$id_sucursal' WHERE identificador = '$ICCID';";
                                $ejecutar = mysql_query($consultaICCID);

if(($dato['IMEI']!="") && ($dato['ICCID']!=""))
{
        ///////consulta para sacar el cod del producto ICCID
        $consultaCodICCID = "SELECT id_producto FROM codigo_producto  WHERE identificador = '$ICCID' AND id_sucursal = '$id_sucursal' AND tipo_identificador = 'ICCID'";
        $ejecutarCodICCID = mysql_query($consultaCodICCID);
        $fila = mysql_fetch_array($ejecutarCodICCID);
        $productoICCID = $fila['id_producto'];


        ////////consulta para restar cantidad producto tipo ICCID sucursal salida
        $consultaRestaICCID = "UPDATE producto SET cantidad = cantidad - '$Cantidad' WHERE cod = '$productoICCID' AND id_sucursal = '$IdSucSalida';";
        $ejecutarRestaICCID = mysql_query($consultaRestaICCID);


        ////// consulta para aumentar cantidad producto tipo ICCID sucursal destino
        $consultaSumaICCID = "UPDATE producto SET cantidad = cantidad + '$Cantidad' WHERE cod = '$productoICCID' AND id_sucursal = '$id_sucursal';";
        $ejecutarSumaICCID = mysql_query($consultaSumaICCID);
}



                                ////////////////ELIMINAR IMEI REPETIDOS/////////////////
                                // $consultaRep = "SELECT * FROM codigo_producto WHERE identificador = '$IMEI' AND id_sucursal = '$id_sucursal'";
                                // $ejecutarRep = mysql_query($consultaRep);
                                // if (mysql_num_rows($ejecutarRep)>1)
                                // {
                                //      $consultaRep2 = "SELECT id_codigo FROM codigo_producto WHERE identificador = '$IMEI' AND id_sucursal = '$id_sucursal' ORDER BY id_codigo ASC LIMIT 1";
                                //      $ejecutarRep2 = mysql_query($consultaRep2);
                                //      $fila = mysql_fetch_array($ejecutarRep2);
                                //      $idIMEIRepetido = $fila['id_codigo'];

                                //      $consultaRep3 = "DELETE FROM codigo_producto WHERE id_codigo = '$idIMEIRepetido';";
                                //      $ejecutarRep3 = mysql_query($consultaRep3);
                                     
                                //      //sucursal($id_sucursal);
                                // }else{
                                //         //sucursal($id_sucursal);
                                // }
                                /////////////////////////Eliminar ICCID Repetidos///////////////////////////////
                                //$consultaRep4 = "";
                               


                                
                                


                                 }
                        } 
        }       
?>
<div class="label label-success" role="alert" style="font-size: x-large; padding: 6.5px">
        <strong>✓</strong>
</div>

<?php
function sucursal($id_sucursal)
{
$consulta = "SELECT cod FROM producto WHERE id_sucursal = 2 AND id_comision = 3";
$ejecutar = mysql_query($consulta);

while($dato=mysql_fetch_array($ejecutar))
{    
    $codigo = $dato['cod'];    
    $consulta2 = "UPDATE producto SET cantidad = (
        SELECT COUNT(tipo_identificador) FROM codigo_producto   WHERE id_sucursal = $id_sucursal
        AND tipo_identificador = 'IMEI' AND id_producto = '$codigo' )
        WHERE cod = '$codigo' AND id_sucursal = $id_sucursal AND estado = 's';";
        $ejecutar2 = mysql_query($consulta2);
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes     

}
}

?>