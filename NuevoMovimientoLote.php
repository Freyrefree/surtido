<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Movimientos</title>
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
<!-- Terminan los estilos -->

<?php
    $IdMovimiento = 1;
    $rs = mysql_query("SELECT * FROM movimientosxlote");
    $cuantos = mysql_num_rows($rs);

    if($cuantos > 0 ){
        $rs = mysql_query("SELECT MAX(Id) AS id FROM movimientosxlote");
        if ($row = mysql_fetch_row($rs)) {
            $IdMovimiento = trim($row[0]);
        }else{
            $IdMovimiento = 1;
        }
    }

?>

<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div align="center">
    <form enctype="multipart/form-data" class="contact-form" action="NuevoMovimientoLote2.php" method="POST" name="f1" id="f1" target="_self">
                <h3>Sucursal de destino</h3>
                <select name="SucursalEntrada" id="SucursalEntrada" required>
                    <option value="" selected>Seleecionar Sucursal </option>
                    <?php 
                        $can=mysql_query("SELECT id,empresa FROM empresa WHERE id!=$id_sucursal");
                        while($dato=mysql_fetch_array($can)){
                    ?>
                    <option value="<?php echo $dato['id']; ?>"><?php echo $dato['empresa']; ?></option>
                    <?php } ?>
                </select>
                <h3>Tamaño de la lista de productos</h3>

                <?php
                    echo"<input type='hidden' name='IdMovimiento' id='IdMovimiento' value='$IdMovimiento'>"; 
                 ?>

                <input type="number" name="NoProductos" id="NoProductos" required>
                <br>
                <input type="submit" value="Continuar" class="btn">


    </form>        
</div>
</body>
</html>