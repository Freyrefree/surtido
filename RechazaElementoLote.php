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

        $RazonRechazo=$_REQUEST['RazonRechazo'];

        if(isset($RazonRechazo)){

           $QRechazo=mysql_query("UPDATE movimientosxlote SET RazonRechazo='$RazonRechazo' WHERE IdProducto='$IdProducto' AND IMEI='$IMEI' AND ICCID='$ICCID' AND IdLote=$IdLote") or die (print("Error al procesar razón de rechazo".mysql_error()));      
           echo"<div class='alert alert-info' role='alert'><strong>Acción procesada</strong> El elemento ha sido marcado como rechazado</div>";
           exit();
        }

        $ActLista=mysql_query("UPDATE movimientosxlote SET Recibido=2, FechaEntrada=NOW(), UsuEntrada='$usu' WHERE IdProducto='$IdProducto' AND IMEI='$IMEI' AND ICCID='$ICCID' AND IdLote=$IdLote"); 

        $can1=mysql_query("SELECT * FROM producto WHERE (cod='$IdProducto' OR nom='$IdProducto') AND id_sucursal='$id_sucursal'") or die(print"Error al consultar cantidad de producto".mysql_error());
        if($dato1=mysql_fetch_array($can1)){
                
                $CantProd=$dato1['cantidad'];

                $can=mysql_query("SELECT * FROM movimientosxlote WHERE IdProducto='$IdProducto' AND IdLote='$IdLote' AND IMEI='$IMEI' AND ICCID='$ICCID' AND IdFicha='$IdFicha' AND IdSucEntrada=$id_sucursal") or die(print"Error al consultar cantidad".mysql_error());
                        if($dato=mysql_fetch_array($can)){
                                
                                $Cantidad = $dato['Cantidad'];
                                $IdSucSalida = $dato['IdSucSalida'];

                                $RestaCant = $Cantidad - $Aceptados;

                                if($RestaCant<0){
                                   $RestaCant = 0;        
                                }

                                if($Aceptados!="" && $Aceptados<=$Cantidad){
                                   $Cantidad = $Aceptados;        
                                }
                        

                                $can=mysql_query("UPDATE movimientosxlote SET CantRecibida=$RestaCant WHERE IdProducto='$IdProducto' AND IdLote='$IdLote' AND (IMEI='$IMEI' OR ICCID='$ICCID' OR IdFicha='$IdFicha') AND IdSucEntrada=$id_sucursal") or die(print"Error al consultar cantidad".mysql_error());

                                if($_REQUEST['Aceptados']==0){
                                       $can=mysql_query("UPDATE movimientosxlote SET CantRecibida=0 WHERE IdProducto='$IdProducto' AND IdLote='$IdLote' AND (IMEI='$IMEI' OR ICCID='$ICCID' OR IdFicha='$IdFicha') AND IdSucEntrada=$id_sucursal") or die(print"Error al consultar cantidad".mysql_error());
                                }     



                        if($Aceptados!="" && $Aceptados!=0){

                                if($Aceptados<=$Cantidad){

                                $SumCant = $CantProd + $Cantidad;       
                                //$Cantidad = $RestaCant;

                                }else{

                                   $SumCant = $CantProd + $Cantidad;           

                                }   
                               

	                            $can=mysql_query("UPDATE movimientosxlote SET CantRecibida=$Cantidad WHERE IdProducto='$IdProducto' AND IdLote='$IdLote' AND (IMEI='$IMEI' OR ICCID='$ICCID' OR IdFicha='$IdFicha') AND IdSucEntrada=$id_sucursal") or die(print"Error al consultar cantidad".mysql_error());


                                if($IMEI!="" || $ICCID!="" || $IdFicha!=""){

                                   $can4=mysql_query("UPDATE codigo_producto SET fecha=NOW() WHERE id_producto='$IdProducto' AND (identificador='$IMEI' OR identificador='$ICCID' OR identificador='$IdFicha')") or die (print("Error al Aceptar Elemento en codigo_producto".mysql_error()));     
                                                
                                }
                        }   
                                
                        } 
        }       
?>
<div class="alert alert-danger" role="alert" style="font-size: small; padding: 6.5px">
        <strong>Rechazado</strong>
</div>

<?php

$IdModals=str_replace("?","",$IdElemento);

echo"
<script>
// show the modal onload
$('#$IdModals').modal({
    show: true
});
</script>
"
?>

<!-- Modal 
<a href="#" class="btn btn-default" id="openBtn">Open modal</a>
-->
<form name="form<?php echo $IdModals ?>" id="form<?php echo $IdModals ?>" action="" target="_SELFT">
<div id="<?php echo $IdModals ?>" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Razón del rechazo</h3>
            </div>
            <div class="modal-body">
                <p>     
                    <label for="male">Cantidad Rechazada</label>    
                    <input type="text" id="CantRechazada" name="CantRechazada" style="width:95%;" value="<?php echo $RestaCant ?>" disabled/>
                    <label for="male">Cantidad Aceptada (Excedente será ignorado)</label> 
                    <input type="text" id="CantAceptada" name="CantAceptada" style="width:95%;" value="<?php echo $Aceptados ?>"  disabled/>
                    <input type="hidden" id="Elemento" name="Elemento" style="width:95%;"  value="<?php echo $IdElemento ?>"/>
                    <input type="radio" name="RazonRechazo" value="No coincide" required> No coincide<br>
                    <input type="radio" name="RazonRechazo" value="Está roto"   required> Esta roto<br>
                    <input type="radio" name="RazonRechazo" value="usado"       required> Usado
                </p>
            </div>
            <div id="hayajax<?php echo $IdModals ?>"></div>
            <div class="modal-footer"> 
                <a href="#" class="btn" data-dismiss="modal">Cerrar</a>
                <input type="submit" class="btn btn-primary" value="Continuar">   
            </div>
        </div>
    </div>
</div>
</form> 


<script type="text/javascript">
$(function (e) {
	$('#form<?php echo $IdModals ?>').submit(function (e) {
	  e.preventDefault()
  $('#hayajax<?php echo $IdModals ?>').load('RechazaElementoLote.php?' + $('#form<?php echo $IdModals ?>').serialize());
})
})
</script>	