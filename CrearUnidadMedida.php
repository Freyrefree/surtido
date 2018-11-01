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
            $can=mysql_query("SELECT MAX(id)as numero FROM unidad_medida");
            if($dato=mysql_fetch_array($can)){
                $id=$dato['numero']+1;
            }//genera codigo autimaticamente
            return $id;
        }

        $nombre='';$abreviatura='';$equivalente='';$descripcion='';
        if(!empty($_GET['codigo'])){    
            $codigo=$_GET['codigo'];
            $can=mysql_query("SELECT * FROM unidad_medida where id='$codigo'");
            if($dato=mysql_fetch_array($can)){
                $codigo=$dato['id'];$nombre=$dato['nombre'];$abreviatura=$dato['abreviatura'];$descripcion=$dato['descripcion'];
                $equivalente=$dato['equivalencia'];
                $boton="Actualizar Unidad";   
            }
        }else{
            $boton="Guardar Unidad";
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Crear Unidad Medida</title>
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

        $codigo=$_POST['codigo'];
        $nombre=strtoupper($_POST['nombre']);
        $equivalente=strtoupper($_POST['equivalente']);
        $descripcion=strtoupper($_POST['descripcion']);
        $abreviatura=strtoupper($_POST['abreviatura']);

        $can=mysql_query("SELECT * FROM unidad_medida where id='$codigo'");
        if($dato=mysql_fetch_array($can)){
            if($boton=='Actualizar Unidad'){
                $xSQL="UPDATE unidad_medida SET nombre='$nombre',
                                                abreviatura='$abreviatura',
                                                descripcion='$descripcion',
                                                equivalencia='$equivalente'
                                    WHERE id='$codigo'";
                mysql_query($xSQL); 
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Unidad de Medida</strong> Actualizado con Exito</div>';
                }else{
                    echo ' <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>El codigo identificador ya existe '.$dato['nombre'].'</div>';
            }       
        }else{
               $sql = "INSERT INTO unidad_medida (id, nombre, abreviatura, descripcion, equivalencia)
                             VALUES ('$codigo','$nombre','$abreviatura','$descripcion','$equivalente')";
                mysql_query($sql);
                
                $nombre='';$equivalente='';$descripcion='';$abreviatura='';
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Unidad de Medida</strong> Guardado con Exito</div>';
                $codigo = genera();      
                  }
              }
?>

<div class="control-group info">
  <form name="form1" method="post" action="">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="2"><center><strong>Crear Unidad de Medida</strong></center></td>
  </tr>
  <tr>
    <td>
        <label for="textfield">* Codigo: </label>
        <input type="text" name="codigo" id="codigo" <?php if(!empty($codigo)){echo 'readonly';} ?> value="<?php echo $codigo; ?>">

        <label for="textfield">* Nombre Unidad de Medida: </label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" autocomplete="off" required maxlength="40">
        
        <label for="textfield">* Abreviatura: </label>
        <input type="text" name="abreviatura" id="abreviatura" value="<?php echo $abreviatura; ?>" autocomplete="off" required maxlength="10">

        <label for="textfield">* Equivalente: </label>
        <input type="text" name="equivalente" id="equivalente" value="<?php echo $equivalente; ?>" autocomplete="off" required maxlength="50">
        <br>
        <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
        <?php if($boton=='Actualizar Unidad'){ ?> <a href="UnidadMedida.php" class="btn btn-large">Cancelar</a><?php }  ?>
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