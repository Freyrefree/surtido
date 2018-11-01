<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        //-------------------------------------------------------
        function generaid(){
            $can=mysql_query("SELECT MAX(id)as numero FROM camion");
            if($dato=mysql_fetch_array($can)){
                $numero=$dato['numero']+1;
            } //genera codigo autimaticamente
            return $numero;
        }
        

        $id_camion=''; $marca='';$modelo='';$placa='';$descripcion='';$year='';
        if(!empty($_GET['codigo'])){    
            $id_camion=$_GET['codigo'];
            $can=mysql_query("SELECT * FROM camion where id='$id_camion'");
            if($dato=mysql_fetch_array($can)){
                $id_camion=$dato['id']; $marca=$dato['marca'];$modelo=$dato['modelo'];
                $placa=$dato['placa'];$descripcion=$dato['descripcion'];$year=$dato['year_mod'];
                $boton="Actualizar Camion";
            }
        }else{
            $boton="Guardar Camion";
            $id_camion = generaid();
            $fecha=date("Y-m-d");
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Agregar Camion</title>
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
    
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
  <?php
    if(!empty($_POST['id']) and !empty($_POST['placa'])){
        
        $id_camion=$_POST['id']; $marca=$_POST['marca'];$modelo=$_POST['modelo'];
        $placa=$_POST['placa'];$descripcion=$_POST['descripcion'];$year=$_POST['year'];

        $can=mysql_query("SELECT * FROM camion where id=$id_camion");
        if($dato=mysql_fetch_array($can)){
            if($boton=='Actualizar Camion'){
               $xSQL="UPDATE camion SET marca='$marca',
                                        modelo='$modelo',
                                        year_mod='$year',
                                        placa='$placa',
                                        descripcion='$descripcion'
                                WHERE id=$id_camion";
                
                mysql_query($xSQL); 
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Camion</strong> Actualizado con Exito</div>';
                }else{
                    echo ' <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>El numero de gasto le pertenece a '.$dato['id_gasto'].'</div>';
            }       
        }else{
                $sql = "INSERT INTO camion (marca, modelo,year_mod, placa, descripcion)
                         VALUES ('$marca','$modelo','$year','$placa','$descripcion')";
                mysql_query($sql);
                $id_camion=''; $marca='';$modelo='';$placa='';$descripcion='';$year='';
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Camion</strong> Guardado con Exito!</div>';
                    $id_camion = generaid();
                  }
              }
    ?>
<div class="control-group info">
  <form name="form1" enctype="multipart/form-data" method="post" action="">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="3"><center><strong>Registrar Nuevo Camion</strong></center></td>
  </tr>
  <tr>
    <td>
        <label for="textfield">* Identificador: </label>
        <input type="text" name="id" id="id" <?php if(!empty($id_camion)){echo 'readonly';} ?> value="<?php echo $id_camion; ?>">
        <label for="textfield">* Marca: </label><input type="text" name="marca" id="marca" value="<?php echo $marca; ?>" autocomplete="off" maxlength="30" required>
        <label for="textfield">* Modelo: </label><input type="text" name="modelo" id="modelo" value="<?php echo $modelo; ?>" autocomplete="off" maxlength="30" required><br>
        <label for="textfield">* Año: </label><input type="text" name="year" id="year" value="<?php echo $year; ?>" autocomplete="off" maxlength="5"><br>
        <label for="textfield">* No. Placa: </label><input type="text" name="placa" id="placa" value="<?php echo $placa; ?>" autocomplete="off" maxlength="30" required><br>
        <br>
        <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
        <?php if($boton=='Actualizar Gasto'){ ?> <a href="AgregarGastos.php" class="btn btn-large">Cancelar</a><?php }  ?>
    </td>
    <td>
        <label for="textfield">Descripcion: </label>
        <textarea name="descripcion" id="descripcion" cols="20" rows="10" value="" maxlength="300"><?php echo $descripcion; ?></textarea>
    </td>
  </tr>
</table>
</form>
</div>
</body>
</html>