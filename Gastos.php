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
        <button type="button" class="btn btn-primary" onClick="window.location='AgregarGastos.php'">Ingresar Nuevo</button>
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
             <!-- <input name="bus" type="text" class="span2" size="60" list="characters" placeholder="Buscar" autocomplete="off">
              <datalist id="characters">
              <?php
                $buscar=$_POST['bus'];
                $can=mysql_query("SELECT * FROM gastos"); 
                while($dato=mysql_fetch_array($can)){
                    echo '<option value="'.$dato['nom'].'">';
                    echo '<option value="'.$dato['ced'].'">';
                }
              ?>
              </datalist> -->
            <button class="btn" type="submit">Buscar por Fechas</button>
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
    <td colspan="8"><center><strong>Listado de Gastos</strong></center></td>
  </tr>
  <tr>
    <td width="6%"><strong>ID</strong></td>
    <td width="25%"><strong>Concepto</strong></td>
    <td width="10%"><strong>Factura</strong></td>
    <td width="10%"><strong>Fecha</strong></td>
    <td width="10%"><strong>Importe</strong></td>
    <td width="8%"><strong>Iva</strong></td>
    <td width="20%"><strong>Descripción</strong></td>
    <td width="20%"><strong>Comprobante</strong></td>

  </tr>
    <?php 
    if(empty($_POST['inicio']) && empty($_POST['inicio'])){
        $can=mysql_query("SELECT * FROM gastos WHERE id_sucursal = '$id_sucursal' ORDER BY fecha DESC, id_gasto DESC ");
    }else{
        $datestart  = $_POST['inicio'];
        $datefinish = $_POST['fin'];
        
        $can=mysql_query("SELECT * FROM gastos where fecha BETWEEN '".$datestart."' AND '".$datefinish."' AND id_sucursal = '$id_sucursal'");
    }

    while($dato=mysql_fetch_array($can)){
        if($dato['documento']!=""){
            $direccion = $dato['documento'];
            $id = $dato['id_gasto'];
            $estado='<a href="download_com.php?archivo='.$direccion.'&id='.$id.'&val=gasto"><span class="label label-success">Documento</span></a>';
        }else{
            $estado='<span class="label label-alert">No Documento</span>';
        }
    ?>
  <tr>
    <td><?php echo $dato['id_gasto']; ?></td>
    <td>
        <a href="AgregarGastos.php?codigo=<?php echo $dato['id_gasto']; ?>"><?php echo $dato['concepto']; ?></a>
    </td>
    <td><?php echo $dato['numero_fact']; ?></td>
    <td><?php echo $dato['fecha']; ?></td>
    <td>$ <?php echo number_format($dato['total'],2,",","."); ?></td>
    <td>$ <?php echo number_format($dato['iva'],2,",","."); ?></td>
    <td><?php echo $dato['descripcion']; ?></td>
    <td><?php echo $estado; ?></td>
    </tr>
    <?php } ?>
</table>
</div>
<!-- <progress value="20" max="100"></progress>
<button type="button" class="boton">Aceptar</button> -->
</body>
</html>