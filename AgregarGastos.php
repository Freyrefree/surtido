<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
        $sucursal = $_SESSION['sucursal'];
        //-------------------------------------------------------
        function generaid(){
            $can=mysql_query("SELECT MAX(id_gasto)as numero FROM gastos");
            if($dato=mysql_fetch_array($can)){
                $numero=$dato['numero']+1;
            } //genera codigo autimaticamente
            return $numero;
        }

        $id_gasto='';$id_camion='';$concepto='';$num_factura='';$fecha='';$total='';$iva='';$descripcion='';$nom_arch="";
        if(!empty($_GET['codigo'])){    
            $id_gasto=$_GET['codigo'];
            $can=mysql_query("SELECT * FROM gastos where id_gasto='$id_gasto'");
            if($dato=mysql_fetch_array($can)){

                $id_gasto=$dato['id_gasto'];$concepto=$dato['concepto'];$num_factura=$dato['numero_fact'];$fecha=$dato['fecha'];
                $total=$dato['total'];$iva=$dato['iva'];$descripcion=$dato['descripcion'];$nom_arch=$dato['documento'];
                $id_camion=$dato['camion'];
                $boton="Actualizar Gasto";
            }
        }else{
            $boton="Guardar Gasto";
            $id_gasto = generaid();
            $fecha=date("Y-m-d");
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Agregar Gasto</title>
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
    <style>
    input{
        text-transform:uppercase;
    }
    </style>
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
        //Mostrar automaticamente el iva al 16%
        //-------------------------------------------------------------------------------------------------------
        $(document).ready(function(){
                $('#total').keyup(function(event){
                  var valor = $('#total').val();
                  var iva = valor*0.16;
                  document.getElementById('iva').value =iva.toFixed(2);
                });
            });
        //--------------------------------------------------------------------------------------------------------
    </script>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
  <?php
    if(!empty($_POST['id']) and !empty($_POST['concepto']) and !empty($_POST['factura'])){// and !empty($_POST['tipo'])
        
        $id_gasto=$_POST['id'];$concepto=strtoupper($_POST['concepto']);$num_factura=$_POST['factura'];$fecha=$_POST['fecha'];
        $total=$_POST['total'];$iva=$_POST['iva'];$descripcion=strtoupper($_POST['descripcion']);
        $id_camion = $_POST['camion'];$id_suc = $_POST['sucursal'];
        $can=mysql_query("SELECT * FROM gastos where id_gasto='$id_gasto'");
        if($dato=mysql_fetch_array($can)){
            if($boton=='Actualizar Gasto'){
                $nombre_archivo == "";$nombres_archivos="";

                for($i=0;$i<count($_FILES["archivo"]["name"]);$i++)
                    {
                        /* Lectura del archivo */
                        $nombre_archivo = $_FILES['archivo']['name'][$i];
                        $tipo_archivo   = $_FILES['archivo']['type'][$i];
                        $tamano_archivo = $_FILES['archivo']['size'][$i];
                        $tmp_archivo    = $_FILES['archivo']['tmp_name'][$i];

                        if ($nombre_archivo != "" and !empty($id_gasto)) {
                        $nom_arch = $nombre_archivo;
                        //Guardar el archivo en la carpeta doc_gasto/id_gasto
                        $num_compra=$id_gasto;
                        if($tamano_archivo!=0){
                            $ruta_pancarta="doc_gasto/".$num_compra;
                            $archivador="doc_gasto/".$num_compra;
                            $dir_logo=$archivador."/".$nombre_archivo;
                            mkdir("doc_gasto/$num_compra",0700);
                            if(!move_uploaded_file($tmp_archivo,$dir_logo)) { $return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');}
                            if(!copy($dir_logo,$archivador."/".$nombre_archivo)){ 
                                if (count($_FILES["archivo"]["name"]) > $i) {
                                    if ($i>=1) {
                                        $nombres_archivos = $nombres_archivos.",".$nombre_archivo;
                                    }else{
                                        $nombres_archivos = $nombre_archivo;
                                    }
                                }else{
                                    $nombres_archivos=$nombre_archivo;
                                }
                            }
                        }
                    }
                    }
            $xSQL="UPDATE gastos SET    id_camion = '$id_camion',
                                        concepto='$concepto',
                                        numero_fact='$num_factura',
                                        fecha='$fecha',
                                        total='$total',
                                        iva='$iva',
                                        descripcion='$descripcion',
                                        documento='$nom_arch',
                                        id_sucursal = '$id_suc'
                                WHERE id_gasto='$nombres_archivos'";
                
                mysql_query($xSQL); 
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Gasto</strong> Actualizado con Exito</div>';
                }else{
                    echo ' <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>El numero de gasto le pertenece a '.$dato['id_gasto'].'</div>';
            }       
        }else{
                $nombre_archivo == "";$nombres_archivos="";
                for($i=0;$i<count($_FILES["archivo"]["name"]);$i++)
                    {
                        /* Lectura del archivo */
                        $nombre_archivo = $_FILES['archivo']['name'][$i];
                        $tipo_archivo   = $_FILES['archivo']['type'][$i];
                        $tamano_archivo = $_FILES['archivo']['size'][$i];
                        $tmp_archivo    = $_FILES['archivo']['tmp_name'][$i];

                        if ($nombre_archivo != "" and !empty($id_gasto)) {
                        $nom_arch = $nombre_archivo;
                        //Guardar el archivo en la carpeta doc_gasto/id_gasto
                        $num_compra=$id_gasto;
                        if($tamano_archivo!=0){
                            $ruta_pancarta="doc_gasto/".$num_compra;
                            $archivador="doc_gasto/".$num_compra;
                            $dir_logo=$archivador."/".$nombre_archivo;
                            mkdir("doc_gasto/$num_compra",0700);
                            if(!move_uploaded_file($tmp_archivo,$dir_logo)) { $return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');}
                            if(!copy($dir_logo,$archivador."/".$nombre_archivo)){ 
                                if (count($_FILES["archivo"]["name"]) > $i) {
                                    if ($i>=1) {
                                        $nombres_archivos = $nombres_archivos.",".$nombre_archivo;
                                    }else{
                                        $nombres_archivos = $nombre_archivo;
                                    }
                                }else{
                                    $nombres_archivos=$nombre_archivo;
                                }
                            }
                        }
                    }
                    }
                $sql = "INSERT INTO gastos (id_camion,concepto, numero_fact, fecha, total, iva, descripcion,documento,id_sucursal)
                         VALUES ('$id_camion','$concepto','$num_factura','$fecha','$total','$iva','$descripcion','$nombres_archivos','$id_suc')";
                mysql_query($sql);
                $id_gasto=''; $concepto='';$num_factura='';$fecha='';$total='';$iva='';$descripcion='';
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Gasto!</strong> Guardado con Exito</div>';
                    $id_gasto = generaid();
                  }
              }
    ?>
<div class="control-group info">
  <form name="form1" enctype="multipart/form-data" method="post" action="">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="3"><center><strong>! NUEVO GASTO ¡</strong></center></td> <? //=$sucursal ?>
  </tr>
  <tr>
    <td>
        <label for="textfield">* Identificador: </label>
        <input type="text" name="id" id="id" <?php if(!empty($id_gasto)){echo 'readonly';} ?> value="<?php echo $id_gasto; ?>">
        <label for="textfield">* Camion (Placa) / Otro: </label>
        <select name="camion" id="camion">
            <option value="0">Otro</option>
            <?php 
                $can=mysql_query("SELECT * FROM camion");
                while($dato=mysql_fetch_array($can)){
            ?>
              <option value="<?php echo $dato['id']; ?>" <?php if($prov==$dato['id']){ echo 'selected'; } ?>><?php echo $dato['placa']; ?></option>
            <?php } ?>
        </select>
        <label for="textfield">* Concepto: </label><input type="text" name="concepto" id="concepto" value="<?php echo $concepto; ?>" autocomplete="off" maxlength="30" required>
        <label for="textfield">* Número de Factura: </label><input type="text" name="factura" id="factura" value="<?php echo $num_factura; ?>" autocomplete="off" maxlength="30" required><br>
        <div class="input-prepend input-append">
            <label for="textfield">* Total: </label>
            <span class="add-on">$</span><input type="text" name="total" id="total" value="<?php echo $total; ?>" autocomplete="off" required><span class="add-on">.00</span>
        </div>
        <label for="textfield">* Sucursal: </label>
        <select name="sucursal" id="sucursal" required>
            <option value="">Selecciona sucursal</option>
            <?php 
                $can=mysql_query("SELECT * FROM empresa");
                while($dato=mysql_fetch_array($can)){
            ?>
              <option value="<?php echo $dato['id']; ?>" <?php if($prov==$dato['id']){ echo 'selected'; } ?>><?php echo $dato['empresa']; ?></option>
            <?php } ?>
        </select>
        <br>
        <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
        <?php if($boton=='Actualizar Gasto'){ ?> <a href="AgregarGastos.php" class="btn btn-large">Cancelar</a><?php }  ?>
    </td>
    <td>
        <label for="textfield">Fecha: </label><input type="date" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
        <br>
        <div class="input-prepend input-append">
            <label for="textfield">Importe de Iva: </label>
            <span class="add-on">$</span><input type="text" name="iva" id="iva" value="<?php echo $iva; ?>" autocomplete="off" required maxlength="100" readonly><span class="add-on">.00</span>
        </div>
        <label for="textfield">Descripcion: </label>
        <textarea name="descripcion" id="descripcion" cols="20" rows="10" value="" maxlength="300"><?php echo $descripcion; ?></textarea>
    </td>
    <td>
        <label for="textfield">Comprobantes Digitales: </label>
        <input type="file" multiple="true" id="archivo" name="archivo[]">
    </td>
  </tr>
</table>
</form>
</div>
</body>
</html>