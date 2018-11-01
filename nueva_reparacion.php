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

//-------------------------------------Obtencion Registro (Actualizacion)-----------------------------
      
            $boton="Guardar Reparacion";
            $fecha_ingreso=date("Y-m-d");
            $fech = date("Y-m-d");
            //$fecha_salida=strtotime ( '+30 day' , strtotime ( $fech ) ) ;
            //$fecha_salida = date ( 'Y-m-d' , $fecha_salida );

        

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
    <!-- <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> -->
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
  <form name="form1" enctype="multipart/form-data" method="post" action="agrega_reparacion.php">
<table width="80%" border="0" class="table">
<tr>
    <td>
        <div class="btn-group" data-toggle="buttons-checkbox">
        <!-- <button type="button" class="btn btn-primary" onClick="window.location='PDFusuarios.php'">Reporte PDF</button> -->
        <button type="button" class="btn btn-primary" onClick="window.location='reparaciones.php'">Consulta Reparaciones</button>
    </div>
    </td>
</tr>
  <tr class="info">
    <td colspan="3"><center><strong>ENTRADA REPARACIONES</strong></center></td>
  </tr>
  <tr>
    <td>
        <label for="textfield">IMEI: </label><input type="text" name="imei" id="imei" maxlength="15" >
        <label for="textfield">* Marca: </label><input type="text" name="marca" id="marca"  autocomplete="off" maxlength="40" required >
        <label for="textfield">* Modelo: </label><input type="text" name="modelo" id="modelo"  autocomplete="off" maxlength="40" required >
        <label for="textfield">* Color: </label><input type="text" name="color" id="color"  autocomplete="off" maxlength="30" required >
        <label for="textfield">* Chip: </label>
        <input type="radio" name="chip" id="chip" value="si" required> Si
        <input type="radio" name="chip" id="chip" value="no" > No
        <label for="textfield">* Memoria: </label>
        <input type="radio" name="memoria" id="memoria" value="si" required> Si
        <input type="radio" name="memoria" id="memoria" value="no" > No
        <br><br>
        <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>

    </td>
    <td>
        
        <label for="textfield">* Motivo de Reparación: </label>
        <input type="text" name="motivo" id="motivo" value="<?php echo $motivo; ?>" autocomplete="off" maxlength="70" required>

        <label>Presupuesto aproximado:</label>
        <div class="input-prepend input-append">
            <span class="add-on">$</span>
            <input type="number" min="0" step="any" name="precio" id="precio">
            <span class="add-on">.00</span>
        </div>
       
        <label>Anticipo:</label>
        <div class="input-prepend input-append">
            <span class="add-on">$</span>
            <input type="number" min="0" step="any" name="abono" id="abono" >
            <span class="add-on">.00</span>
        </div>
        
            <label><input type="checkbox" id="cb1" name="cb1" value="1">Cliente Existente</label>
        
        <label id="lbl1" for="textfield">Buscar Cliente Existente en Catalogo: </label><input type="text" name="buscarBase" id="buscarBase">
       <div id='datosCliente'>
       <input style="display : none;" type="text" id="UUIDcliente" name ="UUIDcliente"> 

        <label id="lbl2" for="textfield">* Apellido Paterno: </label><input type="text" name="apat" id="apat" autocomplete="off" maxlength="30" required>
        <label id="lbl3" for="textfield">* Apellido Materno: </label><input type="text" name="amat" id="amat" autocomplete="off" maxlength="30" >
        <label id="lbl4" for="textfield">* Nombre: </label><input type="text" name="nom" id="nom"  autocomplete="off" maxlength="30" required>
    
        <label id="lbl5" for="textfield">* Dirección: </label><input type="text" name="direccion" id="direccion"  autocomplete="off">
        <label id="lbl6" for="textfield">* Telefono de Referencia a 10 dígitos: </label><input type="text" name="telefono" id="telefono"  autocomplete="off" maxlength="10" pattern="[0-9]{10}" required>
        <label id="lbl7" for="textfield">* Correo Referencia: </label><input type="email" name="correo" id="correo">

        </div>
    </td>
    <td>
  
        
        <label>* Fecha de Ingreso: </label><input type="date" name="fechai" id="fechai" value="<?php echo $fecha_ingreso; ?>"  required readonly>
        
         <label>* Fecha Prometida de entrega: </label>
         <div class="input-prepend input-append">
            <input type="number" class="span1" min="1" max="99" name="numer" id="numer"  required>
            <span class="add-on">
                <select name="dh" id="dh" class="span1" style="margin-top:-5px; margin-left:-5px; margin-right:-5px" required>
                    <option value="" selected>Tiempo</option>
                    <option value="minutos">Minutos</option>
                    <option value="horas">Horas</option>
                    <option value="dias">Dias</option>
                </select>
            </span>
         </div>   

        <!-- <label>* Fecha Limite de Entrega: </label><input type="date" name="fecha" id="fecha"  value="<?php echo $fecha_salida; ?>" required readonly> -->
        <label for="textfield">Observaciones: </label>
        <textarea name="observacion" id="observacion" cols="20" rows="10" value="" maxlength="300"></textarea>
        
    </td>
  </tr>
</table>
</form>
</div>
</body>
</html>


<script>         
$( "#buscarBase" ).autocomplete({
/*data*/
source: 'cliente_reparacion.php',
});
              
        

$("#buscarBase").change(function(){
    $.ajax({
                        url: "cliente_reparacion_datos.php",
                        type: "POST",
                        dataType: "html",
                        data: "empresa=" + $("#buscarBase").val(),
                        success:  function (response) {
                            $("#datosCliente").html(response);
                        }
                    });
    

});

$(function () {
    $('#cb1').change(function () {
        if ($('#cb1').is(':checked')) {
            $('#lbl1').show();
            $('#buscarBase').show();

           
            $('#lbl2').hide();
            $('#lbl3').hide();
            $('#lbl4').hide();
            $('#lbl5').hide();
            $('#lbl6').hide();
            $('#lbl7').hide();

            $('#apat').hide();
            $('#amat').hide();
            $('#nom').hide();
            $('#direccion').hide();
            $('#correo').hide();
            $('#telefono').hide();



            $('#buscarBase').val('');
            $('#apat').val('');
            $('#amat').val('');
            $('#nom').val('');
            $('#direccion').val('');
            $('#correo').val('');
            $('#telefono').val('');
            $('#UUIDcliente').val('');

           

            
        } else {
            $('#lbl1').hide();
            $('#buscarBase').hide();
            
            $('#lbl2').show();
            $('#lbl3').show();
            $('#lbl4').show();
            $('#lbl5').show();
            $('#lbl6').show();
            $('#lbl7').show();

            $('#apat').show();
            $('#amat').show();
            $('#nom').show();
            $('#direccion').show();
            $('#correo').show();
            $('#telefono').show();

            $('#buscarBase').val('');
            $('#apat').val('');
            $('#amat').val('');
            $('#nom').val('');
            $('#direccion').val('');
            $('#correo').val('');
            $('#telefono').val('');
            $('#UUIDcliente').val('');

            $('#apat').attr('readonly', false);
            $('#amat').attr('readonly', false);
            $('#nom').attr('readonly', false);
            $('#direccion').attr('readonly', false);
            $('#correo').attr('readonly', false);
            $('#telefono').attr('readonly', false);


        }
    }).change();
});

$(document).ready(function() {
    $('#lbl1').hide();
    $('#buscarBase').hide();
   
});

</script>