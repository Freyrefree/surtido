<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Compras</title>
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

</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<table width="100%" border="0">
  <tr>
  
    <div align="right">
    <form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
      <div class="input-append">
            
             <input name="bus" type="text" class="span2" size="60" list="characters" placeholder="Buscar" autocomplete="off">
              <datalist id="characters">
              <?php
                $buscar=$_POST['bus'];
                $can=mysql_query("SELECT * FROM compras");
                while($dato=mysql_fetch_array($can)){
                    echo '<option value="'.$dato['num_remision'].'">';
                    echo '<option value="'.$dato['nom_producto'].'">';
                }
              ?>
              </datalist>
            <button class="btn" type="submit">Buscar por Nombre / Comprobante</button>
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
    <td colspan="8"><center><strong>Listado de Compras</strong></center></td>
  </tr>
  <tr>
    <td width="6%"><strong>ID</strong></td>
    <td width="25%"><strong>Producto</strong></td>
    <td width="10%"><strong>Remision</strong></td>
    <td width="10%"><strong>cantidad</strong></td>
    <td width="10%"><strong>costo</strong></td>
    <td width="8%"><strong>fecha</strong></td>
    <td width="20%"><strong>Comprobante</strong></td>

  </tr>
    <?php 
    if(empty($_POST['bus'])){
        $can=mysql_query("SELECT * FROM compras ORDER BY fecha DESC");
    }else{
        $buscar=$_POST['bus'];
        $can=mysql_query("SELECT * FROM compras where nom_producto LIKE '$buscar%' or num_remision LIKE '$buscar%'");
    }
    while($dato=mysql_fetch_array($can)){
        if($dato['dir_file']!=""){
            $direccion = $dato['dir_file'];
            $id = $dato['num_remision'];

            //esta parte pendiente
            $estado='<a href="download_com.php?archivo='.$direccion.'&id='.$id.'&val=compra"><span class="label label-success">Documento</span></a>';
        }else{
            $estado='<span class="label label-alert">No Documento</span>';
        }
    ?>
  <tr>
    <td><?php echo $dato['id_compra']; ?></td>
    <td><?php echo $dato['nom_producto']; ?></td>
    <td><?php echo $dato['num_remision']; ?></td>
    <td><?php echo $dato['cantidad']; ?></td>
    <td>$ <?php echo number_format($dato['costo'],2,",","."); ?></td>
    <td><?php echo $dato['fecha']; ?></td>
    <td><?php echo $estado; ?></td>
    </tr>
    <?php } ?>
</table>
</div>
</body>
</html>