<?php
        session_start();
        include('php_conexion.php'); 
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        //$id_sucursal = $_SESSION['id_sucursal'];
        $usu = $_SESSION['username'];
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
    <script>
        function ExportarGeneral(){
            var fi = document.getElementById('fi').value;
            var ff = document.getElementById('ff').value;
            document.location.href = 'ReporteExcel.php?fi='+ fi +'&ff='+ ff;
            
        }
        function ExportarSucursal(){
            var fi = document.getElementById('fi').value;
            var ff = document.getElementById('ff').value;
            document.location.href = 'ReporteExcelSucursal.php?fi='+ fi +'&ff='+ ff;
        }
        function ExportarIndividual(){
            var fi = document.getElementById('fi').value;
            var ff = document.getElementById('ff').value;
            var usuario = document.getElementById('usuarioi').value;
            document.location.href = 'ReporteExcelIndividual.php?fi='+ fi +'&ff='+ ff +'&usuario='+ usuario;
        }
        function ExportarTaeIndividual(){
            var fi = document.getElementById('fi').value;
            var ff = document.getElementById('ff').value;
            var usuario = document.getElementById('usuarioi').value;
            //alert('ReporteRecargas.php?fi='+ fi +'&ff='+ ff +'&usuario = '+ usuario);
            document.location.href = 'ReporteRecargas.php?fi='+ fi +'&ff='+ ff +'&usuario='+ usuario;
        }
        function ExportarTaeGeneral(){
            var fi = document.getElementById('fi').value;
            var ff = document.getElementById('ff').value;
            document.location.href = 'ReporteRecargasGeneral.php?fi='+ fi +'&ff='+ ff;
        }
    </script>

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
    <td colspan="4"><center><strong>Calculo de Comisiones</strong></center></td>
  </tr>
   <tr>
    <td colspan="3">
    <div class="control-group info">
<form name="form1" method="post" action="">    
    Fecha Inicio: <input type="date" name="fecha_inicio" id="fecha_inicio" >
    Fecha Fin: <input type="date" name="fecha_fin" id="fecha_fin" >
    <?php 
            $datestart  = $_POST['inicio'];
            $datefinish = $_POST['fin'];
    ?>
    <?php
        $consultaCajero = "SELECT usu,nom FROM usuarios WHERE estado = 's';";
        $sql=mysql_query($consultaCajero);
        if(mysql_num_rows($sql))
        {
            $select= 'Cajero <select class="input-xlarge" id="ccodigo" name="ccodigo">';
            $select.= '<option value="0">Selecciona el Cajero</option>';
            $select.= '<option value="TODOS">TODOS</option>';
            while($rs=mysql_fetch_array($sql))
            {
                $select.='<option value="'.$rs['usu'].'">'.$rs['nom'].'</option>';
            }
        }
        $select.='</select>';
        echo $select;
    ?>
    <button class="btn incd" id="btnc" type="submit">Buscar</button>     
</form>
    </div>
    <?php
        if(!empty($_POST['ccodigo'])){// or !empty($_GET['codigo'])
        $factura="";$tipo = "";$fecha = "";$codigo='';$usuario=""; //variables que no se usan
        $datestart  = $_POST['fecha_inicio'];
        $datestart = $datestart.' 00:00:00';
        $datefinish = $_POST['fecha_fin'];
        $datefinish = $datefinish.' 23:59:59';
        //echo "fi: ".$datestart."<br>";echo "ff: ".$datefinish."<br>";
        $cantidad_ventas="";$total_ventas="";
            $fechax=date("d").'/'.date("m").'/'.date("Y");
            $fechay=date("Y-m-d");
            $codigo=$_POST['ccodigo'];
            if($codigo != "TODOS")
            {
                $consultasucursal="SELECT id_sucursal FROM usuarios WHERE usu ='$codigo'";
            }

            

            $ejecutarquery = mysql_query($consultasucursal);
            $dato = mysql_fetch_array($ejecutarquery);
            $id_sucursal = $dato['id_sucursal'];

            //*********Total productos vendidos**********
            if ($codigo != "TODOS") {
                $consultaProd = "SELECT SUM(cantidad) FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' AND usu = '$codigo';";
            }else{
                $consultaProd = "SELECT SUM(cantidad) FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish'";
            }
            $ejecutarqueryp = mysql_query($consultaProd);
            if($datocant = mysql_fetch_array($ejecutarqueryp))
            {
                $cantidad_Productos = $datocant[0];
            }
            //*******************************************/

            //obtiene cantidad de ventas
            //$consulta = "SELECT COUNT(*) FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' AND usu='$codigo' AND id_sucursal = '$id_sucursal'";
            if($codigo != "TODOS")
            {
            $consulta = "SELECT COUNT(*) FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' AND usu='$codigo'";
            }else
            {
                $consulta = "SELECT COUNT(*) FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish'"; 
            }
            $query=mysql_query($consulta);
            if($dato=mysql_fetch_array($query)){
                $cantidad_ventas= $cantidad_ventas+$dato[0];
            }
            //obtiene cantidad de repparaciones
            if ($codigo != "TODOS") {
                $quer=mysql_query("SELECT COUNT(*) FROM reparacion WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND usuario='$codigo' AND id_sucursal = '$id_sucursal' AND estado = '3'");
            }else{
                $quer=mysql_query("SELECT COUNT(*) FROM reparacion WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND estado = '3'");
            }
            if($dator=mysql_fetch_array($quer)){
                $cantidad_ventas= $cantidad_ventas+$dator[0];
            }
            
                $query2=mysql_query("SELECT * FROM usuarios WHERE usu='$codigo' ");/*AND id_sucursal='$id_sucursal'*/
           
            
            if (mysql_num_rows($query2)>0) {
                while ($dato=mysql_fetch_array($query2)) {
                    $cedula = $dato['ced'];
                    $nombre = $dato['nom'];
                    $usuario = $dato['usu'];
                    $boton="Cancelar Venta";
                }
            }else{

                $cedula = "TODOS";
                $nombre = "TODOS";
                $usuario = "TODOS";
                $boton="Cancelar Venta";

            }
            if ($codigo != "TODOS") {
                $query2=mysql_query("SELECT * FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' AND usu='$codigo' AND id_sucursal='$id_sucursal'");
            }else{
                $query2=mysql_query("SELECT * FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish'");
            }
            while($dato=mysql_fetch_array($query2)){
                $total_ventas = $total_ventas+$dato['importe'];
            }
            if ($codigo != "TODOS") {
                $quer2=mysql_query("SELECT * FROM reparacion WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND usuario='$codigo' AND id_sucursal='$id_sucursal' AND estado = '3'");
            }else{
                $quer2=mysql_query("SELECT * FROM reparacion WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND estado = '3'");
            }
            while($dat2=mysql_fetch_array($quer2)){
                $total_ventas = $total_ventas+$dat2['precio'];
            }
            /*echo '  <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">X</button>
                      <strong>PENDIENTE SUMAR RECARGAS </strong>
                </div>';*/
    ?>
    <input type="hidden" name="fi" id="fi" value="<?php echo $datestart; ?>" readonly>
    <input type="hidden" name="ff" id="ff" value="<?php echo $datefinish; ?>" readonly>
    <input type="hidden" name="usuarioi" id="usuarioi" value="<?php echo $usuario; ?>" readonly>

    <input type="button" name="button1" id="button1" class="btn btn-primary" onclick="exportarResult();"  value="REPORTE EXCEL">

    <!-- <input type="button" name="button" id="button" class="btn btn-primary" onclick="ExportarGeneral();" value="REPORTE GENERAL EXCEL">
    <input type="button" name="button" id="button" class="btn btn-primary" onclick="ExportarSucursal();" value="REPORTE SUCURSAL EXCEL">
    <input type="button" name="button" id="button" class="btn btn-primary" onclick="ExportarTaeIndividual();" value="REPORTE TAE">
    <input type="button" name="button" id="button" class="btn btn-primary" onclick="ExportarTaeGeneral();" value="REPORTE TAE GENERAL"> -->




    <!-- <form name="form2" method="POST" enctype="multipart/form-data" action="ReporteExcel.php">
        <input type="hidden" name="fi" id="fi" value="<?php echo $datestart; ?>" readonly>
        <input type="hidden" name="ff" id="ff" value="<?php echo $datefinish; ?>" readonly>
        <input type="submit" name="button" id="button" class="btn btn-primary" value="REPORTE GENERAL EXCEL">
    </form>
    <form name="form2" method="POST" enctype="multipart/form-data" action="ReporteExcelSucursal.php">
        <input type="hidden" name="fi" id="fi" value="<?php echo $datestart; ?>" readonly>
        <input type="hidden" name="ff" id="ff" value="<?php echo $datefinish; ?>" readonly>
        <input type="submit" name="button" id="button" class="btn btn-primary" value="REPORTE SUCURSAL EXCEL">
    </form>
    <form name="form2" method="POST" enctype="multipart/form-data" action="ReporteRecargas.php">
        <input type="hidden" name="fi" id="fi" value="<?php echo $datestart; ?>" readonly>
        <input type="hidden" name="ff" id="ff" value="<?php echo $datefinish; ?>" readonly>
        <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario; ?>" readonly>
        <input type="submit" name="button" id="button" class="btn btn-primary" value="REPORTE TAE">
    </form> -->
    </td>    
    <div class="control-group info">
    <form>
    <tr>
        <td width="30%">
            <label>Cedula: </label><input type="text" name="codigo" id="codigo" value="<?php echo $cedula; ?>" readonly>
            <label>Nombre: </label><input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" readonly>

            <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario; ?>" readonly>
            <input type="hidden" name="fi" id="fi" value="<?php echo $datestart; ?>" readonly>
            <input type="hidden" name="ff" id="ff" value="<?php echo $datefinish; ?>" readonly>

            <label>Cantidad / Ventas: </label><input type="text" name="cant" id="cant" value="<?php echo $cantidad_ventas; ?>" readonly>
            <label>Cantidad / Productos Vendidos: </label><input type="text" name="cant" id="cant" value="<?php echo $cantidad_Productos; ?>" readonly>
            <label>Total / Ventas</label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="total_ventas" size="10" id="total_ventas" value="<?php echo number_format($total_ventas,2,".",","); ?>" readonly>
                <span class="add-on">.00</span>
            </div>
            <label>Total / Comisiones</label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="total_comisiones" size="10" id="total_comisiones"  readonly>
                <span class="add-on">.00</span>
            </div>
            <br><br>
            
            
        </td>
        <td>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#comisiones">COMISIONES</a></li>
                <li><a data-toggle="tab" href="#ventas">VENTAS</a></li>
            </ul>
            <div class="tab-content">
                <div id="comisiones" class="tab-pane fade in active">
                  <div style="width: 90%; height: 250px; overflow-y: scroll;">
                    <table width="100%" border="0" class="table">
                      <tr>
                        <td width="5%"><strong><center>N.</center></strong></td>
                        <td width="10%"><strong>Cod Producto</strong></td>
                        <td width="20%"><strong>Nombre</strong></td>
                        <td width="5%"><center><strong>Cant.</strong></center></td>
                        <td width="10%"><center><strong>Tipo Producto.</strong></center></td>
                        <td width="10%"><center><strong>Tipo Venta.</strong></center></td>
                        <td width="7%"><center><strong>% .</strong></center></td>
                        <td width="14%"><strong>Precio U.</strong></td>
                        <td width="10%"><center><strong>Comisión</strong></center></td>
                      </tr>
                      <?php
                        $contador = 0;
                        if ($codigo != "TODOS") {
                            $query=mysql_query("SELECT * FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' AND usu='$codigo'");
                        }else{
                            $query=mysql_query("SELECT * FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish'");
                        }
                        while($dato=mysql_fetch_array($query)){
                            $contador++;
                            $pro_tipo = "TAE";
                            $pro_codigo =$dato['codigo'];
                            $pro_cant   =$dato['cantidad'];
                            $pro_nombre =$dato['nombre'];
                            $pro_precio =$dato['valor'];
                            //************************************Para mostrar en tabla*****************************                            
                            $tipo_comision = $dato['tipo_comision'];
                             if(($tipo_comision == "venta"))
                             {
                                 $tipo_comisionshow = "público";
                             }else if($tipo_comision == "especial")
                             {
                                $tipo_comisionshow = "especial";
                             }else if($tipo_comision == "mayoreo" )
                             {
                                 $tipo_comisionshow ="mayoreo";
                             }
                             //************************************************************************************
                            if ($codigo != "TODOS") {
                                $query2=mysql_query("SELECT * FROM producto WHERE cod = '$pro_codigo' AND id_sucursal='$id_sucursal'");
                            }else{
                                $query2=mysql_query("SELECT * FROM producto WHERE cod = '$pro_codigo' AND id_sucursal='1'");
                            }
                            while($dato2=mysql_fetch_array($query2)){
                                $id_comision = $dato2['id_comision'];
                                $pro_costo = $dato2['costo'];
                                $query3=mysql_query("SELECT * FROM comision WHERE id_comision = '$id_comision'");
                                while($dato3=mysql_fetch_array($query3)){
                                    $pro_tipo = $dato3['tipo'];


                                    //**************************Tipo porcentaje de acuerdo al tipo de venta************************
                                    
                                    if(($tipo_comision == "venta"))
                                    {
                                        $pro_porcentaje = $dato3['porcentaje'];
                                    }else if($tipo_comision == "especial")
                                    {
                                        $pro_porcentaje = $dato3['porcentajeespecial'];
                                    }else if($tipo_comision == "mayoreo" )
                                    {
                                        $pro_porcentaje = $dato3['porcentajemayoreo'];
                                    }
                                    //************************************************************************************************
                                }
                            }
                    if ($pro_tipo != "TAE") {
                            $pro_comision = (($pro_precio-$pro_costo)*($pro_porcentaje/100)*$pro_cant);
                            $total_comisiones = $total_comisiones+$pro_comision;
                        }else {
                            $pro_comision = 0;
                        }
                      ?>
                      <tr>
                        <td><?php echo $contador; ?></td>
                        <td><?php echo $pro_codigo; ?></td>
                        <td><?php echo $pro_nombre; ?></td>                        
                        <td><center><?php echo $pro_cant; ?></center></td>
                        <td><center><?php echo $pro_tipo; ?></center></td>
                        <td><center><?php echo $tipo_comisionshow; ?></center></td>
                        <td><center><?php echo $pro_porcentaje." %"; ?></center></td>
                        <td><?php echo "$ ".number_format($pro_precio,2,",","."); ?></td>
                        <td style="text-align:right"><?php echo "$ ".number_format($pro_comision,2,",","."); ?></td>
                      </tr>
                      <?php  } 
                      ?>
                      <tr>
                          <td  colspan="9" style="text-align:right" >Total Comisiones: <?= "$ ".number_format($total_comisiones,2,",","."); ?></td>
                      </tr>
                    </table>
                  </div>
                </div>

            </div>
        </td>
    </tr>
    </form>
    </div>
    <?php } ?>
  </table>
</div>
</body>
</html>
<script type="text/javascript">
function exportarResult()
{
    var usuario = "<?php echo $usuario; ?>";
    var fecha_inicio = "<?php echo $datestart;?>";
    var fecha_fin = "<?php echo $datefinish ?>";
    //alert(usuario+"-"+fecha_inicio+"-"+fecha_fin);
    //
    if(usuario != "TODOS")
    {
        location.href = "ReporteExcelIndividual.php?usuario="+usuario+"&fi="+fecha_inicio+"&ff="+fecha_fin;
    }else{
        location.href = "ReporteExceltodos.php?fi="+fecha_inicio+"&ff="+fecha_fin;
    }
    

}

</script>

<script type="text/javascript">

$(document).ready(function() {
    var total_comisiones = "<?php echo $total_comisiones ?>";
    document.getElementById("total_comisiones").value = total_comisiones;
});

</script>