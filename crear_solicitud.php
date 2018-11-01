<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        $id_sucursal = $_SESSION['id_sucursal'];
        $sucursal = $_SESSION['sucursal'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        //-------------------------------------------------------
        function generaid(){
            $id_sucursal = $_SESSION['id_sucursal'];
            $can=mysql_query("SELECT MAX(id_solicitud)as numero FROM solicitud WHERE id_sucursal = '$id_sucursal'");
            if($dato=mysql_fetch_array($can)){
                $numero=$dato['numero'] + 1;
            } //genera codigo autimaticamente
            return $numero;
        }
        $id_solicitud='';$producto='';$marca='';$especificacion='';$cantidad='';$fecha='';
        if(!empty($_GET['codigo'])){
            $id_solicitud=$_GET['codigo'];

            $can=mysql_query("SELECT * FROM solicitud where id_solicitud = '$id_solicitud'");
            if($dato=mysql_fetch_array($can)){

                $id_solicitud=$dato['id_solicitud'];$producto=$dato['producto'];$marca=$dato['marca'];
                $especificacion=$dato['especificacion'];$cantidad=$dato['cantidad'];$fecha=$dato['fecha'];
                $boton="Actualizar Solicitud";
            }
        }else{
            $boton="Guardar Solicitud";
            $id_solicitud = generaid();
            $fecha=date("Y-m-d");
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Agregar Solicitud</title>
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
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
    <script>
        
    </script>
    <style>
    input{
        text-transform:uppercase;
    }
    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
  <?php
    if(!empty($_POST['id'])){// and !empty($_POST['tipo'])
        
        $id_solucitud=$_POST['id'];$producto=strtoupper($_POST['producto']);$marca=strtoupper($_POST['marca']);
        $especificacion=strtoupper($_POST['especificacion']);$cantidad=$_POST['cantidad'];$fecha=$_POST['fecha'];

        
        $can=mysql_query("SELECT * FROM solicitud where id_solicitud='$id_solicitud' AND id_sucursal = '$id_sucursal'");
        if($dato=mysql_fetch_array($can)){
            if($boton=='Actualizar Gasto'){
                $nombre_archivo == "";$nombres_archivos="";
                $xSQL="UPDATE solicitud SET id_solicitud = '$id_solicitud',
                                         id_sucursal='$id_sucursal',
                                         usuario='$usu',
                                         producto='$producto',
                                         marca='$marca',
                                         especificacion='$especificacion',
                                         cantidad='$cantidad',
                                         fecha='$fecha',
                                    WHERE id_solicitud='$id_solicitud'";
                    
                    mysql_query($xSQL);
                    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                            <strong>Solicitud</strong> Actualizado con Exito</div>';
                }else{
                    echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>Solicitud Existente</div>';
                }
        }else{
                $sql = "INSERT INTO solicitud (id_solicitud,id_sucursal,usuario,producto,marca,especificacion,cantidad,fecha)
                         VALUES ('$id_solicitud','$id_sucursal','$usu','$producto','$marca','$especificacion','$cantidad','$fecha')";
                mysql_query($sql);
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Solicitud!</strong> Guardado con Exito</div>';
                          $id_solicitud='';$producto='';$marca='';$especificacion='';$cantidad='';
                    $id_solicitud = generaid();
                  }
        }
    ?>
<div class="control-group info">
  <form name="form1" enctype="multipart/form-data" method="post" action="">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="3"><center><strong>Nueva Solicitud ! <?= $sucursal ?> ¡</strong></center></td>
  </tr>
  <tr>
    <td>
        <label for="textfield">* Identificador: </label>
        <input type="text" name="id" id="id" <?php if(!empty($id_solicitud)){echo 'readonly';} ?> value="<?php echo $id_solicitud; ?>">
        <label for="textfield">* Tipo de Producto: </label>
        <select name="producto" id="producto">
            <option value="telefono">EQUIPO / TELEFONO</option>
            <option value="accesorio">ACCESORIO</option>
            <option value="servicio">SERVICIO</option>
            <option value="otro">OTRO</option>
        </select>
        <label for="textfield">* Marca: </label><input type="text" name="marca" id="marca" value="<?php echo $marca; ?>" autocomplete="off" maxlength="70">
        <label for="textfield">* Especificación: </label><input type="text" name="especificacion" id="especificacion" value="<?php echo $especificacion; ?>" autocomplete="off" maxlength="80"><br>
        
        <br>
        <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
        <?php if($boton=='Actualizar Solicitud'){ ?> <a href="crear_solicitud.php" class="btn btn-large">Cancelar</a><?php }  ?>
    </td>
    <td>
        <label for="textfield">Fecha: </label><input type="date" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
        <br>
        <label for="textfield">* Cantidad: </label><input type="text" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>" autocomplete="off" maxlength="30"><br>
    </td>
  </tr>
</table>
</form>
</div>
</body>
</html>