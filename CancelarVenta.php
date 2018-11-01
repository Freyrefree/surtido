<?php
        session_start();
        include('php_conexion.php'); 
        $id_sucursal = $_SESSION['id_sucursal'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cancelar Venta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    <script src="js/bootstrap-affix.js"></script>
    <script src="js/holder/holder.js"></script>
    <script src="js/google-code-prettify/prettify.js"></script>
    <script src="js/application.js"></script>
    <script src="js/jquery-barcode.js"></script>
    <script src="js/html2canvas.js"></script>
    <script src="js/jspdf.debug.js"></script>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
    <script>
        $(document).ready(function(){
            var codigob = $('#codigo').val();
            $('#Barcode').barcode(codigob,"ean13",{barWidth:2,barHeight:50,output:"canvas"});
            
            //descargar en pdf automaticamente
            $('#btnd').click(function() {       
            html2canvas($("#Barcode"), {
                onrendered: function(canvas) {         
                    var imgData = canvas.toDataURL("image/png");              
                    var doc = new jsPDF('p', 'mm');
                    doc.addImage(imgData, 'PNG', 10, 10);
                    doc.save(codigob+'.pdf');
                }
            });
        });
        });
        /*function downloadcodebar(){
            //descraga directa como archivo
            var canvas = document.getElementById("Barcode");
            var dataUrl = canvas.toDataURL(); // obtenemos la imagen como png
            dataUrl=dataUrl.replace("image/png",'image/octet-stream'); // sustituimos el tipo por octet
            document.location.href =dataUrl; // para forzar al navegador a descargarlo
            //abrir en otra ventana y guardarlo manualmente
            var canvas = document.getElementById("Barcode");
            var dataUrl = canvas.toDataURL(); // obtenemos la imagen como png
            window.open(dataUrl, "Ejemplo", "width=400, height=400");
        }*/
    </script>
    <style>
        .codebar{
            border: 1px;
            border-style: solid;
            border-color: #000;
            margin-left: 30px;
            margin-bottom: 0px;
            margin-right: 10px;
            padding: 5px;
        }
        .hr{
            /* background: blue; */
            margin-bottom: -20px;
        }
        .thumb{
             height: 140px;
             width: 200px;
             border: 1px solid #000;
             margin: 5px 5px 0 0;
        }
        .panel-compra{
            padding-left: 10px;
            padding-top: 10px;
          border-style: solid;
          border-color: #BDBDBD;
          border-top-width: 1px;
          border-right-width: 1px;
          border-bottom-width: 1px;
          border-left-width: 1px;
        }
        /* .incd{
            margin-top: 20px;
        } */
    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div align="center">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="4"><center><strong>Datos de Venta Cancelar</strong></center></td>
  </tr>
   <tr>
    <td colspan="3">
    <div class="control-group info">
    <form name="form1" method="post" action="">
        <div class="input-append hr">
             <input class="span2 incd" id="ccodigo" name="ccodigo" type="text" placeholder="Folio de Venta" maxlength="12">
             <button class="btn incd" id="btnc" type="submit">Buscar No. Folio</button>
        </div>
    </form>
    </div>
    <?php 
        $IdCajero = $_SESSION['ced'];
        $ExMachineCount=0;
        
        if(!empty($_POST['ccodigo']) or !empty($_GET['codigo'])){
        $factura="";$cantidad="";$importe="";$tipo = "";$fecha = "";$codigo='';$usuario="";
            $fechax=date("d").'/'.date("m").'/'.date("Y");
            $fechay=date("Y-m-d");
            if(!empty($_GET['codigo'])){
                $codigo=$_GET['codigo'];
            }
            if(!empty($_POST['ccodigo'])){
                $codigo=$_POST['ccodigo'];
            }
            $can=mysql_query("SELECT * FROM detalle where factura='$codigo' AND id_sucursal = '$id_sucursal'");
            while($dato=mysql_fetch_array($can)){
                $factura=$dato['factura'];
                $cantidad=$cantidad+$dato['cantidad'];
                $importe=$importe+$dato['importe'];
                $tipo = $dato['tipo'];
                $fecha = $dato['fecha_op'];
                $usuario = $dato['usu'];
                $boton="Cancelar Venta";
            }
            
            echo '  <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">X</button>
                      <strong>Tipo de Venta / '.$tipo.' </strong>
                </div>';    
    ?>
    </td>    
    <div class="control-group info">
    <form name="form2" method="post" enctype="multipart/form-data" action="">
    <tr>
        <td width="10%">
            <label>Folio Venta: </label><input type="text" name="codigo" id="codigo" value="<?php echo $codigo; ?>" readonly>
            <label>Usuario / Venta: </label><input type="text" name="usu" id="usu" value="<?php echo $usuario; ?>" readonly>
            <label>Tipo Venta: </label><input type="text" name="tipo" id="tipo" value="<?php echo $tipo; ?>" readonly>
            <label>Fecha / Hora: </label><input type="text" name="fecha" id="fecha" value="<?php echo $fecha; ?>" readonly>
            <br><br>
                <button type="submit" class="btn btn-large btn-primary"><?php echo $boton; ?></button>
        </td>
        <td width="25%">
            <label>Cantidad / Productos: </label><input type="text" name="cant" id="cant" value="<?php echo $cantidad; ?>" readonly>
            <label>Importe / Venta</label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="costo" size="10" id="costo" value="<?php echo $importe; ?>" readonly>
                <span class="add-on">.00</span>
            </div>
            <?php 
            //si la venta es a credito decir cuando abono en su compra
                if ($tipo == "CREDITO") {
                    $query=mysql_query("SELECT * FROM credito WHERE id_factura='$codigo'");
                    while($dato=mysql_fetch_array($query)){
                        $cre_rest = $dato['resto'];
                        $cre_abono = $dato['adelanto'];
                    }
                    echo '<label>Adeudo:</label>
                            <div class="input-prepend input-append">
                                <span class="add-on">$</span>
                                <input type="text" name="costo" size="10" id="costo" value="'.$cre_rest.'" readonly>
                                <span class="add-on">.00</span>
                            </div>';
                    echo '<label>Abono:</label>
                            <div class="input-prepend input-append">
                                <span class="add-on">$</span>
                                <input type="text" name="dev" size="10" id="dev" value="'.$cre_abono.'" readonly>
                                <span class="add-on">.00</span>
                            </div>';
                }
             ?>
        </td>
        <td>
            <div style="width: 90%; height: 250px; overflow-y: scroll;">
            <table width="80%" border="0" class="table">
              <tr>
                <td width="15%"><strong><center>ID</center></strong></td>
                <td width="30%"><strong>Nombre</strong></td>
                <td width="20%"><center><strong>Cantidad</strong></center></td>
                <td width="20%"><center><strong>Precio U.</strong></center></td>
              </tr>
              <?php
                $query=mysql_query("SELECT * FROM detalle WHERE factura='$codigo' AND id_sucursal = '$id_sucursal'");
                while($dato=mysql_fetch_array($query)){
                    $pro_codigo =$dato['codigo'];
                    $pro_cant   =$dato['cantidad'];
                    $pro_nombre =$dato['nombre'];
                    $pro_precio =$dato['valor'];
              ?>
              <tr>
                <td><center><?php echo $pro_codigo; ?></center></td>
                <td><?php echo $pro_nombre; ?></td>
                <td><center><?php echo $pro_cant; ?></center></td>
                <td><center><?php echo number_format($pro_precio,2,",","."); ?></center></td>
              </tr>
              <?php } ?>
            </table>
            </div>
        </td>
    </tr>
    </form>
    </div>
    <?php } ?>  
  </table>
   <?php 
        if(!empty($_POST['codigo'])){
            $gcodigo = $_POST['codigo'];
            $gtype = $_POST['tipo'];
            $devolucion = $_POST['dev'];

$username=$_SESSION['username'];
$tipousu= $_SESSION['tipo_usu'];
$sqlced=mysql_query("SELECT ced FROM usuarios WHERE usu = '$username' AND tipo = '$tipousu'");
$datoced=mysql_fetch_array($sqlced);
$idcaja = $datoced['ced'];

$consulta1 = "SELECT * FROM detalle WHERE factura='$gcodigo' AND id_sucursal = '$id_sucursal'";            
$sql=mysql_query($consulta1);

            while($dat=mysql_fetch_array($sql)){
                $cod_product = $dat['codigo'];
                $cant_det = $dat['cantidad'];
                $importe  = $dat['importe'];
                $IMEI     = $dat['IMEI'];
                $ICCID    = $dat['ICCID'];
                $nombreProd = $dat ['nombre'];
                $nombrechip = $dat['nombreChip'];

if($IMEI != "" && $ICCID != "")// Cuando la Venta fue de un Teléfono CON CHIP
{
    //**Agregar a código producto nuevo IMEI */
    $id_producto = $cod_product; //código producto celular
    $addnuevoimei = "INSERT INTO codigo_producto
    (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)VALUES
    ('$id_producto','IMEI','$IMEI',0,NOW(),'s','$id_sucursal');";

    if(mysql_query($addnuevoimei)){

        echo '  <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">X</button>
        <strong>El IMEI: '.$IMEI.' con nombre de producto: '.$nombreProd.' Ha sido devuelto a stock</strong>
        </div>';
    //**Agregar a código producto nuevo ICCID */}
    $consultaICCID="SELECT cod FROM producto WHERE nom = '$nombrechip' AND id_sucursal = '$id_sucursal'";
    $query = mysql_query($consultaICCID);

    if(mysql_num_rows($query) > 0)//validar si existe codigo de producto con ese nombre de chip (puede ser que lo hayan cambiado)
    {
        $dato = mysql_fetch_array($query);
        $id_productoiccid = $dato['cod']; //código producto chip

        $addnuevoiccid = "INSERT INTO codigo_producto
        (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)VALUES
        ('$id_productoiccid','ICCID','$ICCID',0,NOW(),'s','$id_sucursal');";

        if(mysql_query($addnuevoiccid)){

            //agregar mas 1 la cantidad de existencia del chip cancelado
            $cantidad = 1;
            $consultaupdcant = "UPDATE producto SET cantidad = (cantidad + '$cantidad') WHERE
             cod = '$id_productoiccid' AND id_sucursal = '$id_sucursal'";

             if(mysql_query($consultaupdcant)){

                echo '  <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">X</button>
                <strong>El ICCID: '.$ICCID.' con nombre de producto: '.$nombrechip.' Ha sido devuelto a stock</strong>
                </div>';
             }

        }

    }
    
    }
}else if($IMEI != "" && $ICCID == "")// Cuando la Venta fue de un Teléfono SIN CHIP
{
    //**Agregar a código producto nuevo IMEI */
    $id_producto = $cod_product; //código producto celular
    $addnuevoimei = "INSERT INTO codigo_producto
    (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)VALUES
    ('$id_producto','IMEI','$IMEI',0,NOW(),'s','$id_sucursal');";

    if(mysql_query($addnuevoimei))
    {
        echo '  <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">X</button>
        <strong>El IMEI: '.$IMEI.' con nombre de producto: '.$nombreProd.' Ha sido devuelto a stock</strong>
        </div>';

        //la suma de cantidad lo hace en el código de abajo
    }
    
}else if($IMEI == "" && $ICCID != "")
{
    $consultaICCID="SELECT cod FROM producto WHERE nom = '$nombrechip' AND id_sucursal = '$id_sucursal'";
    $query = mysql_query($consultaICCID);

    if(mysql_num_rows($query) > 0)//validar si existe codigo de producto con ese nombre de chip (puede ser que lo hayan cambiado)
    {
        $dato = mysql_fetch_array($query);
        $id_productoiccid = $dato['cod']; //código producto chip

        $addnuevoiccid = "INSERT INTO codigo_producto
        (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)VALUES
        ('$id_productoiccid','ICCID','$ICCID',0,NOW(),'s','$id_sucursal');";

        if(mysql_query($addnuevoiccid))
        {
            echo '  <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <strong>El ICCID: '.$ICCID.' con nombre de producto: '.$nombrechip.' Ha sido devuelto a stock</strong>
            </div>';

            //la suma de cantidad lo hace en el código de abajo           

        }

    }
}



                $resta = "UPDATE caja SET cantidad = (cantidad - $importe) WHERE estado='1' AND id_cajero = '$idcaja'";
                    mysql_query($resta);

                $consulta2="SELECT cantidad FROM producto where cod='$cod_product' AND id_sucursal = '$id_sucursal'";
                $pro_sql  = mysql_query($consulta2);
                if($datp=mysql_fetch_array($pro_sql)){
                    $cant =$cant_det+$datp['cantidad'];

                    
                    $act_sql="UPDATE producto SET cantidad='$cant' WHERE cod='$cod_product' AND id_sucursal = '$id_sucursal'";
                    mysql_query($act_sql);

                    $act_sql="UPDATE codigo_producto SET estado='s' WHERE id_producto='$cod_product' AND id_sucursal = '$id_sucursal'";
                    mysql_query($act_sql);
                }


                    $con_caj=mysql_query("SELECT cantidad FROM caja WHERE estado='1' AND id_cajero = '$IdCajero'") or die(print("Error en consulta de cajero"));
                    if($data=mysql_fetch_array($con_caj)){
                        $cantcaja = $data['cantidad'];
                    
                         if ($gtype == "CREDITO") {
                             if($ExMachineCount==0){
                                $query=mysql_query("SELECT * FROM credito WHERE id_factura='$gcodigo'");
                                if($dato=mysql_fetch_array($query)){
                                    $cre_abono = $dato['adelanto'];
                                }      
                                $CantCancel = $cantcaja - $cre_abono;
                                $act_sql="UPDATE caja SET cantidad='$CantCancel' WHERE id_cajero='$IdCajero'";
                                $ExMachineCount++;

                                if($cre_abono==""){
                                   $CantCancel = $cant_det; 
                                   $act_sql="UPDATE caja SET cantidad=cantidad-'$importe' WHERE id_cajero='$IdCajero'";
                                   $ExMachineCount++; 
                                }
                             }   
                         }else{
                             $CantCancel = $cantcaja - $importe;
                             $act_sql="UPDATE caja SET cantidad='$CantCancel' WHERE id_cajero='$IdCajero'";
                         }
                        mysql_query($act_sql);
                     
                    }
            }
            $consultaBitacora = "INSERT INTO venta_cancelada(factura,codigo,nombre,cantidad,valor,importe,tipo,ICCID,nombreChip,IMEI,fecha_op,usu,id_sucursal,garantia,
tipo_comision,fecha_cancelado)                                       
SELECT factura,codigo,nombre,cantidad,valor,importe,tipo,ICCID,nombreChip,IMEI,fecha_op,usu,id_sucursal,garantia,tipo_comision,
NOW() FROM detalle WHERE factura = '$gcodigo' AND id_sucursal = '$id_sucursal'";
            if(mysql_query($consultaBitacora))
            {
                $sql_d="DELETE FROM detalle WHERE factura='$gcodigo' AND id_sucursal = '$id_sucursal'";
                mysql_query($sql_d);
            }
            if ($gtype == "CREDITO") {
                if ($devolucion != "") {
                    echo '  <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              Dinero / Devolucion:<strong>$ '.number_format($devolucion,2,",",".").' </strong>
                        </div>';
                }
                $sql_c="DELETE FROM credito WHERE id_factura='$gcodigo'";
                mysql_query($sql_c);
            }
            echo '  <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">X</button>
                      <strong>Venta / Folio: '.$gcodigo.', Estatus: Cancelada</strong>
                </div>';
        }
        ?>
</div>

</body>
</html>