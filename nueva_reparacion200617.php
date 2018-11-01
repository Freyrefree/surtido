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
            $id_sucursal = $_SESSION['id_sucursal'];
            $can=mysql_query("SELECT MAX(id_reparacion)as numero FROM reparacion WHERE id_sucursal = '$id_sucursal'");
            if($dato=mysql_fetch_array($can)){
                $numero=$dato['numero']+1;
            } //genera codigo autimaticamente
            return $numero;
        }
        function generacodigo(){
            $codig = rand(1000, 1000000);
            $can=mysql_query("SELECT * FROM reparacion WHERE cod_cliente = '$codig'");
            if($dato=mysql_fetch_array($can)){
                generacodigo();
            }else{
                return $codig;
            }
        }
        $id_reparacion='';$imei='';$marca='';$modelo='';$color='';$precio='0';$abono = '0';
        $motivo='';$observacion='';$fecha_ingreso="";$fecha_salida="";$estatus="";
        $costo ='0';$chip = 'no'; $memoria = 'no'; $nombre_contacto = ''; $telefono_contacto = ''; $id_comision = '';
        $rfccurp ='';$mano_obra = '';$tipo_precio = '';$active = "";
        //-------------------------------------Obtencion Registro (Actualizacion)-----------------------------
        if(!empty($_GET['codigo'])){    
            $id_reparacion=$_GET['codigo'];
            $can=mysql_query("SELECT * FROM reparacion where id_reparacion='$id_reparacion'");
            if($dato=mysql_fetch_array($can)){
                $id_reparacion=$dato['id_reparacion'];$imei=$dato['imei'];$marca=$dato['marca'];$modelo=$dato['modelo'];$color=$dato['color'];$precio=$dato['precio'];$abono = $dato['abono'];
                $id_r = $dato['id_reparacion'];
                $motivo=$dato['motivo'];$observacion=$dato['observacion'];$fecha_ingreso=$dato['fecha_ingreso'];$fecha_salida=$dato['fecha_salida'];$estatus=$dato['estatus'];
                $costo =$dato['costo'];$chip = $dato['chip']; $memoria = $dato['chip']; $nombre_contacto = $dato['nombre_contacto']; $telefono_contacto = $dato['telefono_contacto'];
                $fecha_ingreso=$dato['fecha_ingreso'];
                $id_gasto=$dato['id_gasto'];$concepto=$dato['concepto'];$num_factura=$dato['numero_fact'];$fecha=$dato['fecha'];
                $total=$dato['total'];$iva=$dato['iva'];$descripcion=$dato['descripcion'];$nom_arch=$dato['documento'];
                $id_camion=$dato['camion'];
                $rfccurp = $dato['rfc_curp_contacto'];
                $cod_producto = $dato['id_producto'];
                $mano_obra = $dato['mano_obra'];
                $tipo_precio = $dato['tipo_precio'];
                $boton="Actualizar Reparacion";
                $active = $dato['id_reparacion'];
            }
        //----------------------------------------------------------------------------------------------------
        }else{
            $boton="Guardar Reparacion";
            $id_reparacion = generaid();
            $fecha_ingreso=date("Y-m-d");
            $fech = date("Y-m-d");
            $fecha_salida=strtotime ( '+30 day' , strtotime ( $fech ) ) ;
            $fecha_salida = date ( 'Y-m-d' , $fecha_salida );
        }
        //echo "uevo ingreso";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Nueva Entrada Reparacion</title>
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

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
        function VerProducto(categoria){
              $.getJSON('GetRefaccionName.php?categoria='+categoria,function(data){
                  $( "#producto" ).autocomplete({
                    source: data
                  });
              });
          }
          $(document).ready(function(){
            $('#producto').keyup(function(event){
            var categoria = $( "#categoria" ).val();
              VerProducto(categoria);
              });
          });
        function myFunction() {
            /*var x = document.getElementById("mySelect");
            var option = document.createElement("option");*/
            //datos del select producto (refaccion)
            /*var cod = document.getElementById("producto").value;*/
            var selected = document.getElementById("producto").value;
            var combo = document.getElementById("producto");
            /*var selected = combo.options[combo.selectedIndex].text;*/
            //fin datos del select producto (refaccion)
            /*option.text = selected;
            option.value = cod;
            x.add(option);*/
            
            //document.refacciones.textrefacciones.value +=selected;
            var valorInput = $("#textrefacciones").val();
            $("#textrefacciones").val(valorInput+selected+"\n");
            var tipo = $('input:radio[name=tprecio]:checked').val();
            var costo =  document.getElementById("costo").value;
            if (costo == "") {
                costo = "0";
            }
            $.ajax({ 
                type: "POST", 
                url: "ConsultaPrecio.php",
                data: "name="+selected+"&type="+tipo,
                success: function(msg){
                //valores resultantes de la consulta
                var precio = msg;
                var suma = parseInt(precio)+parseInt(costo);
                document.getElementById('costo').value = suma;
                document.getElementById('costo').text  = suma;
                document.getElementById("producto").value = '';
                //fin valores resultantes de la consulta
                } 
            });
            //$("#botonadd").attr("disabled","true");
            //$('#botonadd').attr('disabled','disabled');
        }
        $(document).ready(function(){
            $("#producto").change(function() {
                  //$("#botonadd").attr("disabled","false");
                  //$('#botonadd').attr('disabled','');
                  $('#botonadd').removeAttr('disabled');
            });
        });


        function CambioPrecio(){
            var tipo = $('input:radio[name=tprecio]:checked').val();
            var selected = document.getElementById("textrefacciones").value;
            $.ajax({ 
                type: "POST", 
                url: "CambiarValor.php",
                data: "name="+selected+"&type="+tipo,
                success: function(msg){
                //valores resultantes de la consulta
                alert(msg);
                var precio = msg;
                var suma = parseInt(precio);
                document.getElementById('costo').value = suma;
                document.getElementById('costo').text  = suma;
                //fin valores resultantes de la consulta
                } 
            });
        }
    </script>
    <style>

    input{
        
        text-transform:uppercase;
    }
    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<!-- code add and update product -->
  
<div class="control-group info">
  <form name="form1" enctype="multipart/form-data" method="post" action="GuardarReparacion.php">
<table width="80%" border="0" class="table">
<tr>
    <td>
        <div class="btn-group" data-toggle="buttons-checkbox">
        <!-- <button type="button" class="btn btn-primary" onClick="window.location='PDFusuarios.php'">Reporte PDF</button> -->
        <button type="button" class="btn btn-primary" onClick="window.location='reparaciones.php'">Lista de Reparaciones</button>
    </div>
    </td>
</tr>
  <tr class="info">
    <td colspan="3"><center><strong>ENTRADA REPARACIONES</strong></center></td>
  </tr>
  <tr>
    <td>
        <label for="textfield">* ID: </label>
        <input type="text" name="id" id="id" <?php if(!empty($id_reparacion)){echo 'readonly';} ?> value="<?php echo $id_reparacion; ?>">
        <label for="textfield">IMEI: </label><input type="text" name="imei" id="imei" value="<?php echo $imei; ?>" autocomplete="off" maxlength="20" <?php if (!empty($imei)) { echo 'readonly'; } ?>>
        <label for="textfield">* Marca: </label><input type="text" name="marca" id="marca" value="<?php echo $marca; ?>" autocomplete="off" maxlength="40" required <?php if (!empty($marca)) { echo 'readonly'; } ?>>
        <label for="textfield">* Modelo: </label><input type="text" name="modelo" id="modelo" value="<?php echo $modelo; ?>" autocomplete="off" maxlength="40" required <?php if (!empty($modelo)) { echo 'readonly'; } ?>>
        <label for="textfield">* Color: </label><input type="text" name="color" id="color" value="<?php echo $color; ?>" autocomplete="off" maxlength="30" required <?php if (!empty($color)) { echo 'readonly'; } ?>>
        <label for="textfield">* Chip: </label>
        <input type="radio" name="chip" id="chip" value="si" <?php if($chip=="si"){ echo 'checked'; } ?>> Si
        <input type="radio" name="chip" id="chip" value="no" <?php if($chip=="no"){ echo 'checked'; } ?>> No
        <label for="textfield">* Memoria: </label>
        <input type="radio" name="memoria" id="memoria" value="si" <?php if($memoria=="si"){ echo 'checked'; } ?>> Si
        <input type="radio" name="memoria" id="memoria" value="no" <?php if($memoria=="no"){ echo 'checked'; } ?>> No
        <br><br>
        <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
        <?php if($boton=='Actualizar Reparacion'){ ?> <a href="reparaciones.php" class="btn btn-large">Cancelar</a><?php }  ?>
    </td>
    <td>
        
        <label for="textfield">* Motivo de Reparación: </label>
        <input type="text" name="motivo" id="motivo" value="<?php echo $motivo; ?>" autocomplete="off" maxlength="70" required>
        <?php if ($_SESSION['tipo_usu']=='te' AND !empty($active)) {
            $cons =mysql_query("SELECT * FROM comision WHERE tipo LIKE '%REFACCION%'");
                if($row=mysql_fetch_array($cons)){
                    $id_comision = $row['id_comision'];
                }
            ?>
            <label>Categoria: </label>
            <select name="categoria" id="categoria">
            <?php
                $can=mysql_query("SELECT DISTINCT categoria FROM producto WHERE categoria != ''");
                while($dato=mysql_fetch_array($can)){
            ?>
              <option value="<?php echo $dato['categoria']; ?>"><?php echo $dato['categoria']; ?></option>
            <?php } ?>
            </select>
            <label>* Refaccion: </label>
            <div class="input-prepend input-append">
                  <input type="text" class="input" id="producto" name="producto" placeholder="Selecciona Refaccion" autocomplete="off"><!-- list="datalist1" -->
                  <!-- <datalist id="datalist1">
                  <?php
                  $cons=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND id_sucursal = '$id_sucursal' ");/*AND cantidad >= '1'*/
                  while($datas=mysql_fetch_array($cons)){
                    echo '<option value="'.$datas['nom'].'">';
                  }
                  ?>
                  </datalist> -->
                <!-- <select name="producto" id="producto" required>
                <option value="">Seleccionar refaccion</option>
                <?php
                $consu =mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND id_sucursal = '$id_sucursal' AND cantidad >= '1'");
                while($dato=mysql_fetch_array($consu)) { ?>
                  <option value="<?php echo $dato['cod']; ?>" <?php if($cod_producto==$dato['cod']){ echo 'selected'; } ?>><?php echo $dato['nom']; ?></option>
                <?php } ?>
                
                </select> -->
                <span class="add-on"><button type="button" style="margin-top:-5px; margin-left:-5px; margin-right:-5px" class="btn btn-primary" onclick="myFunction()"  id="botonadd">Add</button></span><!-- disabled="true" -->
            </div><br>

            <label>Uso Refacciones:</label>
            <form name="refacciones">
            <textarea name="textrefacciones" id="textrefacciones" cols="10" rows="4"></textarea>
            </form>
            <label for="textfield">* Precio: </label>
            <input type="radio" name="tprecio" id="tprecio" value="1" onclick="CambioPrecio();" <?php if($tipo_precio=="1"){ echo 'checked'; } ?> > Especial
            <input type="radio" name="tprecio" id="tprecio" value="2" onclick="CambioPrecio();" <?php if($tipo_precio=="2"){ echo 'checked'; } ?> checked > Mayoreo
            <input type="radio" name="tprecio" id="tprecio" value="3" onclick="CambioPrecio();" <?php if($tipo_precio=="3"){ echo 'checked'; } ?> > Publico
            <br><br>
            <label>* Costo de Inversion:</label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="costo" id="costo" value="<?php echo $costo; ?>">
                <span class="add-on">.00</span>
            </div>
            <label>* Mano de obra:</label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="mano" id="mano" value="<?php echo $mano_obra; ?>">
                <span class="add-on">.00</span>
            </div>

        <?php } ?>

        <label>Presupuesto aproximado:</label>
        <div class="input-prepend input-append">
            <span class="add-on">$</span>
            <input type="text" name="precio" id="precio" value="<?php echo $precio; ?>">
            <span class="add-on">.00</span>
        </div>
        <?php if (empty($active)) {  ?><!-- $_SESSION['tipo_usu'] != 'te' AND -->
        <label>Anticipo:</label>
        <div class="input-prepend input-append">
            <span class="add-on">$</span>
            <input type="text" name="abono" id="abono" value="<?php echo $abono; ?>" <?php if (!empty($abono)) { echo 'readonly'; } ?>>
            <span class="add-on">.00</span>
        </div>
        <label for="textfield">* Apellido Paterno: </label><input type="text" name="apat" id="apat" value="<?php echo $apaterno; ?>" autocomplete="off" maxlength="30" required>
        <label for="textfield">* Apellido Materno: </label><input type="text" name="amat" id="amat" value="<?php echo $amaterno; ?>" autocomplete="off" maxlength="30" required>
        <label for="textfield">* Nombre: </label><input type="text" name="nom" id="nom" value="<?php echo $amaterno; ?>" autocomplete="off" maxlength="30" required>
        <label for="textfield">* Fecha de Nacimiento: </label><input type="date" name="fechanac" id="fechanac" value="<?php echo $fechanac; ?>" autocomplete="off" maxlength="30" required>
        <!-- <label for="textfield">* RFC ó CURP de cliente: </label><input type="text" name="rfccurp" id="rfccurp" value="<?php echo $rfccurp; ?>" autocomplete="off" maxlength="30" required>         -->
        <?php } ?>
        <!-- <label for="textfield">* Nombre de Cliente: </label><input type="text" name="nombre" id="nombre" value="<?php echo $nombre_contacto; ?>" autocomplete="off" maxlength="30" required> -->
        <label for="textfield">* Telefono de Cliente: </label><input type="text" name="telefono" id="telefono" value="<?php echo $telefono_contacto; ?>" autocomplete="off" maxlength="30" required>
    </td>
    <td>
        <!-- <?php if (empty($modelo)) { echo 'readonly'; } ?> -->
        <?php if ($_SESSION['tipo_usu']=='te') {  ?>
        <label>* Fecha de Ingreso: </label><input type="date" name="fechai" id="fechai" value="<?php echo $fecha_ingreso; ?>" required readonly>
        <?php } ?>
        <label>* Fecha Limite de Entrega: </label><input type="date" name="fecha" id="fecha" value="<?php echo $fecha_salida; ?>" required readonly>
        <?php if ($id_r=='') {  ?>
        <label>* Fecha Prometida de entrega: </label>
        <div class="input-prepend input-append">
            <input type="number" class="span1" min="0" max="99" name="numer" id="numer" value="<?php echo $_SESSION['ddes']; ?>">
            <span class="add-on">
                <select name="dh" id="dh" class="span1" style="margin-top:-5px; margin-left:-5px; margin-right:-5px">
                    <option value="minutos">Minutos</option>
                    <option value="horas">Horas</option>
                    <option value="dias">Dias</option>
                </select>
            </span>
        </div>
        <?php } ?>
        <label for="textfield">Observación: </label>
        <textarea name="observacion" id="observacion" cols="20" rows="10" value="" maxlength="300"><?php echo $observacion; ?></textarea>
    </td>
  </tr>
</table>
</form>
</div>
</body>
</html>

<!-- <?php
    if(!empty($_POST['id'])){// and !empty($_POST['tipo'])
        $id_reparacion=$_POST['id'];$imei=$_POST['imei'];$marca=$_POST['marca'];$modelo=$_POST['modelo'];
        $color=$_POST['color'];$precio=$_POST['precio'];$motivo=$_POST['motivo'];
        $observacion = $_POST['observacion'];$fecha_salida = $_POST['fecha'];$abono=$_POST['abono'];
        $cod_cliente = generacodigo();
        $costo=$_POST['costo'];$chip=$_POST['chip'];$memoria=$_POST['memoria'];$nombre_contacto=$_POST['nombre']; $telefono_contacto=$_POST['telefono'];
        $rfccurp = $_POST['rfccurp'];
        //------------------------pendiente actualizacion reparacion----------------
        $can=mysql_query("SELECT * FROM gastos where id_gasto='$id_gasto'");
        if($dato=mysql_fetch_array($can)){
            if($boton=='Actualizar Gasto'){
            $xSQL="UPDATE gastos SET    id_camion = '$id_camion',
                                        concepto='$concepto',
                                        numero_fact='$num_factura',
                                        fecha='$fecha',
                                        total='$total',
                                        iva='$iva',
                                        descripcion='$descripcion',
                                        documento='$nom_arch',
                                        id_sucursal = '$id_sucursal'
                                WHERE id_gasto='$nombres_archivos'";
                
                mysql_query($xSQL); 
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Gasto</strong> Actualizado con Exito</div>';

                }else{
                    echo ' <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>El numero de gasto le pertenece a '.$dato['id_gasto'].'</div>';
            }

        //--------------------------------------------------------------------------
        }else{
                $cons =mysql_query("SELECT * FROM comision WHERE nombre LIKE '%reparacion%' OR tipo LIKE '%REPARACION%'");
                if($row=mysql_fetch_array($cons)){
                    $id_comision = $row['id_comision'];
                }
                $sql = "INSERT INTO reparacion (id_reparacion,id_sucursal,usuario,cod_cliente, imei, marca, modelo, color, precio,abono,motivo,observacion,fecha_ingreso,fecha_salida,id_comision,estado,chip,memoria,costo,nombre_contacto,telefono_contacto,rfc_curp_contacto)
                         VALUES ('$id_reparacion','$id_sucursal','$usu','$cod_cliente','$imei','$marca','$modelo','$color','$precio',$abono,'$motivo','$observacion','$fecha_ingreso','$fecha_salida','$id_comision','1','$chip','$memoria','$costo','$nombre_contacto','$telefono_contacto','$rfccurp')";
                         //echo $sql;
                $resp =  mysql_query($sql);
                $tipo = "REPARACION";
                if ($resp == 1){
                    header('location:contado.php?id_reparacion='.$id_reparacion.'&tipo='.$tipo);
                }
                $id_reparacion='';$imei='';$marca='';$modelo='';$color='';$precio='';
                $motivo='';$observacion='';$fecha_ingreso="";$fecha_salida="";$estatus="";
                $costo ='';$chip = ''; $memoria = ''; $nombre_contacto = ''; $telefono_contacto = '';$id_comision = '';$rfccurp='';
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Entrada Reparacion!</strong> Registrado con Exito.</div>';
                    //$id_gasto = generaid();
                    $id_reparacion = generaid();
                  }
              }
    ?> -->