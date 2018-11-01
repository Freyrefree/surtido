<?php
        session_start();
        include('php_conexion.php');
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
        /*$time = time();
        echo $time;*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Gastos</title>
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

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="ico/favicon.png">
    <style>
        progress {  
        background-color: #f3f3f3;  
        border: 0;  
        height: 18px;  
        border-radius: 9px;
        }
        .boton{
            width: 8%;
            height: 40px;
            border-radius: 20px;
            color: #FAFAFA;
            background-color: #BDBDBD;
        }
        .boton:hover{
            width: 9%;
            height: 42px;
            background-color: #A4A4A4;
            /* border-radius: 20px; */
        }
    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<table width="100%" border="0">
  <tr>
    <td>
    <div class="btn-group" data-toggle="buttons-checkbox">
        <!-- <button type="button" class="btn btn-primary" onClick="window.location='PDFusuarios.php'">Reporte PDF</button> -->
    </div>
    </td>
    <td>
    <div align="right">
    <form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
      <div class="input-append">
            <input type="date" name="inicio" id="inicio">
            <input type="date" name="fin" id="fin">
            <?php 
                $datestart  = $_POST['inicio'];
                $datefinish = $_POST['fin'];
             ?>
             <!--<input name="busqueda" type="text" class="span2" size="60" list="characters" placeholder="Buscar" autocomplete="off">
              <datalist id="characters">
              <?php
                // $buscar=$_POST['busqueda'];
                // $can=mysql_query("SELECT * FROM registrobusquedas WHERE coincidencia = 'Abono' ORDER BY id DESC");
                // while($dato=mysql_fetch_array($can)){
                //     echo '<option value="'.$dato['usuario'].'">';
                //     echo '<option value="'.$dato['cliente'].'">';
                //     echo '<option value="'.$dato['id_reparacion'].'">';
                // }
              ?>
              </datalist>-->
            <button class="btn" type="submit">Mostrar por fechas</button>
      </div>
    </form>
    </div>
    </td>
  </tr>
</table>
</div>
<div align="center">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="7"><center><strong>Historial de Pagos</strong></center></td>
  </tr>
  <tr>
    <td width="5%" ><strong>No. Venta</strong></td>
    <td width="15%"><strong>Tipo Registro</strong></td>
    <td width="10%"><strong>Usuario</strong></td>
    <td width="20%"><strong>Cliente</strong></td>
    <td width="20%"><strong>Cantidad Recibida</strong></td>
    <td width="15%"><strong>Fecha / Hora</strong></td>
  </tr>
    <?php 
    if(empty($_POST['inicio']) && empty($_POST['inicio'])){
        $can=mysql_query("SELECT * FROM registrobusquedas WHERE coincidencia = 'Abono' ORDER BY id DESC");
    }else{
        $can=mysql_query("SELECT * FROM registrobusquedas 
                            where coincidencia = 'Abono' AND fecha BETWEEN '".$datestart."' AND '".$datefinish."' ORDER BY id DESC");
    }

    while($dato=mysql_fetch_array($can)){
    ?>
        
        <tr>
            <td><?php echo $dato['id_reparacion']; ?></td>
            <td><?php echo $dato['coincidencia']; ?></td>
            <td><?php echo $dato['usuario']; ?></td>
            <td><?php echo $dato['cliente']; ?></td>
            <td>$ <?php echo number_format($dato['observacion'],2,",","."); ?></td>
            <td><?php echo $dato['fecha']; ?></td>
        </tr>
    <?php } ?>
</table>
</div>
</body>
</html>