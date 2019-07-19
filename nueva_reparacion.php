<?php

include_once 'APP/config.php';
 //session_start();
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
<html lang="es">


<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="img/ICONO2.ico" type="image/vnd.microsoft.icon" />
<title>Nueva Entrada Reparacion</title>
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="jsV2/tether.min.js"></script>
<script src="jsV2/jquery-1.11.3.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


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

body{
        
        background: #F7D358;
}
.titulo{

        background: #e7e7e7;
        color: #F2F2F2;
}
.modal-header{

        background: #0275d8;
        color: #F2F2F2;
}
.listado-tareas {
        max-height: calc(50vh - 70px);
        overflow-y: auto;
}
.btn{
        border-radius: 0px;
}
.finish{
        text-decoration:line-through;
}
.dropdown-item{
        color: #E5E8E8;
}
.dropdown-item:hover{
        color:#F4F6F6;
}
.form-control{
        margin: 0px;
}
.black{
    color: black;
}
.red{
    color: red;
}
.green{
    color: green;
}

</style>


</head>

<?php include_once "layout.php"; ?>



<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block titulo"></div>
                <div class="card-block">
                    <div class="row">

                    <div class="col-md-12">
                    <br>

                        <div class="container">

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="black font-weight-bold titulo text-center">ENTRADA REPARACIONES</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-info" onClick="window.location='reparaciones.php'">Listado Reparaciones</button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-success" onClick="window.location='liberarReparacionForm.php'">Liberar Reparación</button>
                                </div>
                            </div>
                            <br>

                            <form name="form1" id="form1" enctype="multipart/form-data" method="post" action="agrega_reparacion.php">
                            <div class="row">

                            

                                <div class="col-md-3">

                                    <div class="form-group">
                                        <label for="">IMEI: </label>
                                        <input class="form-control form-control-sm" type="text" name="imei" id="imei" maxlength="15" >
                                    </div>

                                </div>

                                
                                <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">* Marca: </label>
                                    <input class="form-control form-control-sm" type="text" name="marca" id="marca"  autocomplete="off" maxlength="40" required>
                                </div>
                                </div>

                                <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">* Modelo: </label>
                                    <input class="form-control form-control-sm" type="text" name="modelo" id="modelo"  autocomplete="off" maxlength="40" required >
                                </div>
                                </div>

                                <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">* Color: </label>
                                    <input class="form-control form-control-sm" type="text" name="color" id="color"  autocomplete="off" maxlength="30" required >
                                </div>
                                </div>

                                <div class="col-md-3">
                                <div class="form-check">
                                    <label for="">* Chip: </label>
                                    <input type="radio" name="chip" id="chip" value="si" required> Si
                                    <input type="radio" name="chip" id="chip" value="no" > No
                                </div>
                                </div>

                                <div class="col-md-3">
                                <div class="form-check">
                                    <label for="">* Memoria:</label>
                                    <input type="radio" name="memoria" id="memoria" value="si" required> Si
                                    <input type="radio" name="memoria" id="memoria" value="no" > No
                                </div>
                                </div>


                                <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">* Motivo de Reparación:</label>
                                    <input class="form-control form-control-sm" type="text" name="motivo" id="motivo" value="<?php echo $motivo; ?>" autocomplete="off" maxlength="70" required>
                                </div>
                                </div>

                                <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">* Fecha de Ingreso: </label>
                                    <input class="form-control form-control-sm" type="date" name="fechai" id="fechai" value="<?php echo $fecha_ingreso; ?>"  required readonly>
                                </div>
                                </div>

                                <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">$ Presupuesto aproximado:</label>
                                    <input class="form-control form-control-sm" type="number" min="0" step="any" name="precio" id="precio">
                                </div>
                                </div>

                                <div class="col-md-3">
                                <div class="form-group">
                                    <label>$ Anticipo:</label>
                                    <input class="form-control form-control-sm" type="number" min="0" step="any" name="abono" id="abono" >
                                </div>
                                </div>

                                <div class="col-md-3">
                                <div class="form-group">
                                    <label>* Fecha Prometida de entrega: </label>
                                    <div class="input-prepend input-append">
                                        <input class="form-control form-control-sm" type="number" class="span1" min="1" max="99" name="numer" id="numer"  required>
                                        <span class="add-on">
                                            <select class="form-control form-control-sm" name="dh" id="dh" class="span1"  required>
                                            <option value="" selected>Tiempo</option>
                                            <option value="minutos">Minutos</option>
                                            <option value="horas">Horas</option>
                                            <option value="dias">Dias</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                </div>

                                <div class="col-md-3">
                                <div class="form-group">
                                    <label for="textfield">Observaciones: </label>
                                    <textarea class="form-control form-control-sm" name="observacion" id="observacion" cols="20" rows="5" value="" maxlength="300"></textarea>
                                </div>
                                </div>


                                <div class="col-md-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="cb1" name="cb1" value="1">
                                    <label class="form-check-label" for="exampleCheck1">Cliente Existente</label>
                                </div>
                                </div>



                                <div class="col-md-3">
                                <div class="form-group">
                                <label id="lbl1" for="">Cliente Existente en Catalogo: </label>
                                <input class="form-control form-control-sm" type="text" name="buscarBase" id="buscarBase">
                                </div>
                                </div>


                                <div class="col-md-6">

                                <div id='datosCliente'>

                                    <input style="display : none;" type="text" id="UUIDcliente" name ="UUIDcliente">

                                    <label id="lbl2" for="">* Apellido Paterno: </label>
                                    <input class="form-control form-control-sm" type="text" name="apat" id="apat" autocomplete="off" maxlength="30" required>

                                    <label id="lbl3" for="">* Apellido Materno: </label>
                                    <input class="form-control form-control-sm" type="text" name="amat" id="amat" autocomplete="off" maxlength="30" >

                                    <label id="lbl4" for="">* Nombre: </label>
                                    <input class="form-control form-control-sm" type="text" name="nom" id="nom"  autocomplete="off" maxlength="30" required>

                                    <label id="lbl5" for="">* Dirección: </label>
                                    <input class="form-control form-control-sm" type="text" name="direccion" id="direccion"  autocomplete="off">

                                    <label id="lbl6" for="">* Telefono de Referencia a 10 dígitos: </label>
                                    <input class="form-control form-control-sm" type="text" name="telefono" id="telefono"  autocomplete="off" maxlength="10" pattern="[0-9]{10}" required>
                                    
                                    <label id="lbl7" for="">* Correo Referencia: </label>
                                    <input class="form-control form-control-sm" type="email" name="correo" id="correo">

                                </div>
                                </div>


                               
                            </div>

                            <br>

                            <div class="row">

                            <div class="col-md-6"></div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <button id="btnPrimary" class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
                            </div>
                            </div>

                        
                        </div>
                        </form>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>


<script>

$('form').submit(function() {
  $(this).find("button[type='submit']").prop('disabled',true);
});

</script>


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