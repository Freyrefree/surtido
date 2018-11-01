<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
            $codigo = genera();
        //-------------------------------------------------------
        function genera(){
            $can=mysql_query("SELECT MAX(id_comision)as numero FROM comision");
            if($dato=mysql_fetch_array($can)){
                $id=$dato['numero']+1;
            }//genera codigo autimaticamente
            return $id;
        }

        $nombre='';$tipo='';$porcentaje='';$descripcion='';
        if(!empty($_GET['codigo'])){
            $codigo=$_GET['codigo'];
            $can=mysql_query("SELECT * FROM comision where id_comision='$codigo'");
            if($dato=mysql_fetch_array($can)){
                $codigo=$dato['id_comision'];$nombre=$dato['nombre'];$tipo=$dato['tipo'];
                $porcentaje=$dato['porcentaje'];
                $porcentajemay=$dato['porcentajemayoreo'];
                $porcentajeesp=$dato['porcentajeespecial'];
                $descripcion=$dato['descripcion'];
                $boton="Actualizar Comision";
            }
        }else{
            $boton="Guardar Comision";
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Crear Comision</title>
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
    <style>
    input{
        text-transform:uppercase;
    }
    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">

  <?php 
    if(!empty($_POST['codigo']) and !empty($_POST['nombre'])){

        $codigo=$_POST['codigo'];$nombre=strtoupper($_POST['nombre']);$tipo=$_POST['tipo'];
        $porcentaje=$_POST['porcentaje'];
        $porcentajemaypost=$_POST['porcentajemay'];
        $porcentajeesppost=$_POST['porcentajeesp'];
        $descripcion=strtoupper($_POST['descripcion']);

        $can=mysql_query("SELECT * FROM comision where id_comision='$codigo'");
        if($dato=mysql_fetch_array($can)){
            if($boton=='Actualizar Comision'){
                $xSQL="UPDATE comision SET nombre='$nombre',
                                                tipo='$tipo',
                                                porcentaje='$porcentaje',
                                                porcentajemayoreo='$porcentajemaypost',
                                                porcentajeespecial='$porcentajeesppost',
                                                descripcion='$descripcion'
                                    WHERE id_comision='$codigo'";
                mysql_query($xSQL); 
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Comision</strong> Actualizado con Exito</div>';
                }else{
                    echo ' <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>El codigo Comision ya existe '.$dato['nombre'].'</div>';
            }       
        }else{
               $sql = "INSERT INTO comision (nombre, tipo, porcentaje, descripcion,porcentajemayoreo,porcentajeespecial)
                             VALUES ('$nombre','$tipo','$porcentaje','$descripcion','$porcentajemaypost','$porcentajeesppost')";
                mysql_query($sql);
                
                $nombre='';$tipo='';$porcentaje='';$descripcion='';
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Comision</strong> Guardado con Exito</div>';
                $codigo = genera();      
                  }
              }
?>

<div class="control-group info">
  <form name="form1" method="post" action="">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="2"><center><strong>Crear Comision</strong></center></td>
  </tr>
  <tr>
    <td>
        <label for="textfield">* Codigo: </label>
        <input type="text" name="codigo" id="codigo" <?php if(!empty($codigo)){echo 'readonly';} ?> value="<?php echo $codigo; ?>">

        <label for="textfield">* Nombre Comision: </label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" autocomplete="off" required maxlength="40">
        
        <label>* Tipo:</label>
            <select name="tipo" id="tipo">
              <option value="TELEFONO"   <?php if($tipo=="TELEFONO"){ echo 'selected'; } ?> >TELEFONIA</option>
              <option value="CHIP"       <?php if($tipo=="CHIP"){ echo 'selected'; } ?> >CHIPS</option>
              <option value="FICHA"      <?php if($tipo=="FICHA"){ echo 'selected'; } ?> >FICHAS</option>
              <option value="ACCESORIO"  <?php if($tipo=="ACCESORIO"){ echo 'selected'; } ?> >ACCESORIOS</option>
              <option value="REPARACION" <?php if($tipo=="REPARACION"){ echo 'selected'; } ?> >REPARACIONES</option>
              <option value="REFACCION"  <?php if($tipo=="REFACCION"){ echo 'selected'; } ?> >REFACCIONES</option>
              <option value="RECARGA"  <?php if($tipo=="RECARGA"){ echo 'selected'; } ?> >TAE</option>
            </select>
        <label>* Porcentaje Público:</label>
            <div class="input-prepend input-append">
                <input type="text" name="porcentaje" id="porcentaje" value="<?php echo $porcentaje; ?>">
                <span class="add-on">%</span>
            </div>
            <label>* Porcentaje Mayoreo:</label>
            <div class="input-prepend input-append">
                <input type="text" name="porcentajemay" id="porcentajemay" value="<?php echo $porcentajemay; ?>">
                <span class="add-on">%</span>
            </div>
            <label>* Porcentaje Especial:</label>
            <div class="input-prepend input-append">
                <input type="text" name="porcentajeesp" id="porcentajeesp" value="<?php echo $porcentajeesp; ?>">
                <span class="add-on">%</span>
            </div>
            <br>
        <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
        <?php if($boton=='Actualizar Comision'){ ?> <a href="Comisiones.php" class="btn btn-large">Cancelar</a><?php } ?>
    </td>
    <td>
        <label for="textfield">Descripcion: </label>
        <textarea name="descripcion" id="descripcion" cols="20" rows="10" value="" maxlength="280"><?php echo $descripcion; ?></textarea>
        
    </td>
  </tr>
</table>
</form>
</div>
</body>
</html>