<?php
        session_start();
        include('php_conexion.php'); 
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
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
        <div class="input-append hr">
            <input type="date" name="fecha_inicio" id="fecha_inicio">
            <input type="date" name="fecha_fin" id="fecha_fin">
            <?php 
                $datestart  = $_POST['inicio'];
                $datefinish = $_POST['fin'];
             ?>
            <input type="text" autofocus class="input-xlarge" id="ccodigo" name="ccodigo" list="characters" placeholder="Nombre Empleado" autocomplete="off" >
              <datalist id="characters" >
              <?php 
              $can=mysql_query("SELECT * FROM usuarios WHERE estado = 's' and id_sucursal = '$id_sucursal' OR tipo = 'a'");
              while($dato=mysql_fetch_array($can)){
                  echo '<option value="'.$dato['usu'].'">';
                  }
              ?>
            </datalist>
            <!-- <button class="btn incd" id="btnc" type="submit">Buscar Empleado</button> -->
        </div>
    </form>
    </div>
    <?php
        if(!empty($_POST['ccodigo'])){// or !empty($_GET['codigo'])
        $factura="";$tipo = "";$fecha = "";$codigo='';$usuario=""; //variables que no se usan
        $datestart  = $_POST['fecha_inicio'];$datefinish = $_POST['fecha_fin'];
        //echo "fi: ".$datestart."<br>";echo "ff: ".$datefinish."<br>";
        $cantidad_ventas="";$total_ventas="";
            $fechax=date("d").'/'.date("m").'/'.date("Y");
            $fechay=date("Y-m-d");
            $usuario=$_SESSION['UsuCajero']=$codigo=$_POST['ccodigo'];

    
            $datefinish = strtotime ( '+1 day' , strtotime ( $datefinish ) ) ;
            $_SESSION['datefinish_recargas']=$datefinish = date ( 'Y-m-j' , $datefinish );
           
    ?>
    <input type="hidden" name="fi" id="fi" value="<?php echo $datestart; ?>" readonly>
    <input type="hidden" name="ff" id="ff" value="<?php echo $datefinish; ?>" readonly>
    <input type="hidden" name="usuarioi" id="usuarioi" value="<?php echo $usuario; ?>" readonly>
    <input type="button" name="button" id="button" class="btn btn-primary" onclick="ExportarGeneral();" value="REPORTE GENERAL EXCEL">
    <input type="button" name="button" id="button" class="btn btn-primary" onclick="ExportarSucursal();" value="REPORTE SUCURSAL EXCEL">
    <input type="button" name="button" id="button" class="btn btn-primary" onclick="ExportarTaeIndividual();" value="REPORTE TAE">
    <input type="button" name="button" id="button" class="btn btn-primary" onclick="ExportarTaeGeneral();" value="REPORTE TAE GENERAL">
    </td>    
  
                <div id="ventas" class="tab-pane fade">
                  <div style="width: 90%; height: 250px; overflow-y: scroll;">
                    <table width="80%" border="0" class="table">
                      <tr>
                        <td width="3%"><strong><center>ID</center></strong></td>
                        <td width="10%"><strong>Tipo de Venta</strong></td>
                        <td width="8%"><strong>Cantidad</strong></td>
                        <td width="8%" style="text-align:right"><strong>Total</strong></td>
                      </tr>
                      <?php
                        $query=mysql_query("SELECT * FROM comision");
                        while($dato=mysql_fetch_array($query)){
                            $id_comision = $dato['id_comision'];
                            $porcentaje = $dato['porcentaje'];

                            $query2=mysql_query("SELECT * FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' 
                                                AND id_sucursal = '$id_sucursal' 
                                                AND usu = '$usuario' 
                                                AND (codigo IN (SELECT cod FROM producto WHERE id_comision='$id_comision') OR codigo IN (SELECT codigo FROM compania_tl WHERE id_comision='$id_comision'))");

                            while($dato2=mysql_fetch_array($query2)){
                                $IdProducto = $dato2['codigo'];
                                $NombreProducto = $dato2['nombre'];
                                echo $CantidadProducto = $dato2['cantidad'];
                                $ImporteProducto = $dato2['importe'];
                            }
                            $query3=mysql_query(
                                "SELECT SUM(detalle.importe) AS total
                                 FROM detalle, producto 
                                 WHERE detalle.fecha_op BETWEEN '$datestart' AND '$datefinish' AND detalle.codigo = producto.cod AND detalle.id_sucursal = '$id_sucursal' AND producto.id_sucursal = '$id_sucursal' AND producto.id_comision = '$id_comision' AND detalle.usu = '$usuario'");
                            while($dato3=mysql_fetch_array($query3)){
                                $total_importe = $dato3['total'];
                            }
                            /*echo "SELECT COUNT(id_reparacion) AS cantidad, SUM(precio) AS total
                                 FROM reparacion 
                                 WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND estado = '2' AND id_sucursal = '$id_sucursal' AND id_comision = '$id_comision' AND usuario = '$usuario'";*/
                            $queryc=mysql_query("SELECT * FROM reparacion WHERE id_comision = '$id_comision'");
                            if($dat=mysql_fetch_array($queryc)){
                                $query4=mysql_query(
                                "SELECT COUNT(id_reparacion) AS cantidad, SUM(precio) AS total
                                 FROM reparacion 
                                 WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND estado = '3' AND id_sucursal = '$id_sucursal' AND id_comision = '$id_comision' AND usuario = '$usuario'");
                                while($dato4=mysql_fetch_array($query4)){
                                    $total_importe = $dato4['total'];
                                    $cantidad_ventas_tipo = $dato4['cantidad'];
                                }
                            }
                            $importe_total = $importe_total+$total_importe;
                      ?>
                      <tr>
                        <td><center><?php echo $id_comision; ?></center></td>
                        <td><?php echo $nombre_comision; ?></td>
                        <td><?php echo $cantidad_ventas_tipo; ?></td>
                        <td style="text-align:right"><?php echo "$ ".number_format($total_importe,2,",","."); ?></td>
                      </tr>
                      <?php } ?>
                      <tr>
                          <td  colspan="7" style="text-align:right" >Total Ventas: <?= "$ ".number_format($importe_total,2,",","."); ?></td>
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