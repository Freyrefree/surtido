<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        
        $id_sucursal=''; $sucursal='';$numint='';$direccion='';$ciudad='';$telefono='';$web='';$correo='';
        if(!empty($_GET['codigo'])){
            $id_sucursal=$_GET['codigo'];
            $can=mysql_query("SELECT * FROM empresa where id='$id_sucursal'");
            if($dato=mysql_fetch_array($can)){
                $id_sucursal=$dato['id']; $sucursal=$dato['empresa'];$numint=$dato['nit'];
                $direccion=$dato['direccion'];$ciudad=$dato['ciudad'];$telefono=$dato['tel1'];
                $web=$dato['web'];$correo=$dato['correo'];
                $boton="Actualizar Sucursal";
            }
        }else{
            $boton="Guardar Sucursal";
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Agregar Sucursal</title>
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
    .thumb{
             height: 140px;
             width: 240px;
             border: 1px solid #BDBDBD;
             margin: 5px 5px 0 0;
        }
    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
  <?php
    if(!empty($_POST['id'])){

        $id_sucursal=$_POST['id']; $sucursal=strtoupper($_POST['sucursal']);$numint=$_POST['numint'];
        $direccion=strtoupper($_POST['direccion']);$ciudad=strtoupper($_POST['ciudad']);$telefono=$_POST['telefono'];
        $web=$_POST['web'];$correo=$_POST['correo'];

        $can=mysql_query("SELECT * FROM empresa  where id=$id_sucursal");
        if($dato=mysql_fetch_array($can)){
            if($boton=='Actualizar Sucursal'){
               $xSQL="UPDATE empresa SET empresa='$sucursal',
                                        nit='$numint',
                                        direccion='$direccion',
                                        ciudad='$ciudad',
                                        tel1='$telefono',
                                        web='$web',
                                        correo='$correo'
                                WHERE id='$id_sucursal'";
                mysql_query($xSQL);
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Sucursal</strong> Actualizado con Exito</div>';
                          /*$id_sucursal='';*/ $sucursal='';$numint='';$direccion='';$ciudad='';$telefono='';$web='';$correo='';
                }else{
                    echo ' <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>Identificador Exitente '.$dato['id'].'</div>';
            }       
        }else{
            $sql = "INSERT INTO empresa (id, empresa,nit, direccion, ciudad, tel1, web, correo)
                     VALUES ($id_sucursal,'$sucursal','$numint','$direccion','$ciudad','$telefono','$web','$correo')";
            mysql_query($sql);
            /*$id_sucursal='';*/ $sucursal='';$numint='';$direccion='';$ciudad='';$telefono='';$web='';$correo='';
            echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                      <strong>Sucursal</strong> Guardado con Exito!</div>';
            
        }
        //----------------------------------------------------------------------------
        $extension = end(explode('.', $_FILES['files']['name']));
        $foto = $id_sucursal."."."jpg";
        $directorio = 'img'; //dirname('articulo'); // directorio de tu elección
        
        // almacenar imagen en el servidor
        move_uploaded_file($_FILES['files']['tmp_name'], $directorio.'/'.$foto);
        $minFoto = 'min_'.$foto;
        $resFoto = 'res_'.$foto;
        resizeImagen($directorio.'/', $foto, 65, 65,$minFoto,$extension);
        resizeImagen($directorio.'/', $foto, 500, 500,$resFoto,$extension);
        unlink($directorio.'/'.$foto);
        //---------------------------------------------------------------------------
    }
    ?>
<div class="control-group info">
  <form name="form1" enctype="multipart/form-data" method="post" action="">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="3"><center><strong>Registro Sucursal</strong></center></td>
  </tr>
  <tr>
    <td>
        <label for="textfield">* Identificador: </label>
        <input type="text" name="id" id="id" <?php if(!empty($id_sucursal)){echo 'readonly';} ?> value="<?php echo $id_sucursal; ?>" required>
        <label for="textfield">* Sucursal: </label><input type="text" name="sucursal" id="sucursal" value="<?php echo $sucursal; ?>" autocomplete="off" maxlength="40" required>
        <label for="textfield">* Direccion: </label><input type="text" name="direccion" id="direccion" value="<?php echo $direccion; ?>" autocomplete="off" maxlength="70" required><br>
        <label for="textfield">* Ciudad: </label><input type="text" name="ciudad" id="ciudad" value="<?php echo $ciudad; ?>" autocomplete="off" maxlength="30"><br>
        <label for="textfield">* N. Interior: </label><input type="text" name="numint" id="numint" value="<?php echo $numint; ?>" autocomplete="off" maxlength="6" required><br>
        <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
        <?php if($boton=='Actualizar Gasto'){ ?> <a href="AgregarGastos.php" class="btn btn-large">Cancelar</a><?php }  ?>
    </td>
    <td>
        <label for="textfield">* Telefono: </label><input type="text" name="telefono" id="telefono" value="<?php echo $telefono; ?>" autocomplete="off" maxlength="15" required><br>
        <label for="textfield">* Web: </label><input type="text" name="web" id="web" value="<?php echo $web; ?>" autocomplete="off" maxlength="50" required><br>
        <label for="textfield">* Correo: </label><input type="email" name="correo" id="correo" value="<?php echo $correo; ?>" autocomplete="off" maxlength="40" required><br>
        <?php if ($id_sucursal == "1") { ?>
        <label for="textfield">* Logo de Empresa: </label>
        <output id="list"></output><br>
        <input type="file" name="files" id="files">
        <?php } ?>
    </td>
  </tr>
</table>
</form>
</div>
<script>
          function archivo(evt) {
              var files = evt.target.files; // FileList object
              // Obtenemos la imagen del campo "file".
              for (var i = 0, f; f = files[i]; i++) {
                //Solo admitimos imágenes.
                if (!f.type.match('image.*')) {
                    continue;
                }
                var reader = new FileReader();
                reader.onload = (function(theFile) {
                    return function(e) {
                      // Insertamos la imagen
                     document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                    };
                })(f);
                reader.readAsDataURL(f);
              }
          }
          document.getElementById('files').addEventListener('change', archivo, false);
</script>
</body>
</html>