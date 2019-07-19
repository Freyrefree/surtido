<?php
session_start();
include('php_conexion.php'); 
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
 header('location:error.php');
}
include_once 'app/config.php';

include_once 'Modelos/Caja_tmp.php'; #Modelo Caja_Tmp
$Caja_tmp = new Caja_tmp();


//obtener el nombre de la persona
$usuario=$_SESSION['username'];
$usuarioSession=$_SESSION['username'];

if(isset($_SESSION['username'])){
  $CountSesion = $_SESSION['CountSesion'] = $_SESSION['CountSesion'] + 1;
}

$id_sucursal = $_SESSION['id_sucursal'];
$Sucursal = $_SESSION['sucursal'];
$answer = "";
$fecha=date("Y-m-d");
$hora = date("g:i");
$_SESSION['ddes'] = $_GET['ddes'];
$_SESSION['descuento'] = $_GET['ddes'];
$tipo_comision = $_SESSION['tventa'];

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="../img/ICONO2.ico" type="image/vnd.microsoft.icon" />
<title>Inicio</title>
<meta http-equiv="X-UA-Compatible" content="ie=edge">



    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="jsV2/jquery-3.1.1.js"></script>

    <script type="text/javascript" src="jsV2/tether.min.js"></script>
    <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script type="text/javascript" src="jsV2/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>






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


<?php

    $cans=mysql_query("SELECT * FROM usuarios where usu='$usuario'");
    if($datos=mysql_fetch_array($cans)){
      $nombre_usu=$datos['nom'];$ced = $datos['ced'];
    }
    if(!empty($_POST['tmp_cantidad']) and !empty($_POST['tmp_nombre']) and !empty($_POST['tmp_valor'])){  
      $tmp_cantidad=$_POST['tmp_cantidad'];
      $tmp_nombre=$_POST['tmp_nombre'];$tmp_valor=$_POST['tmp_valor'];$fechay=date("Y-m-d");

      $tmp_importe=$tmp_cantidad*$tmp_valor;
      srand(time());
      $numero_aleatorio = rand(1,10000);
      $numero_aleatorio = $numero_aleatorio."PC";
      $sql="INSERT INTO caja_tmp (cod, nom, venta, cant, importe, exitencia, usu,tipo_comision) VALUES  ('$numero_aleatorio','$tmp_nombre','$tmp_valor','$tmp_cantidad','$tmp_importe','$tmp_cantidad','$usuario','$tipo_comision')";
      mysql_query($sql);
    }
        $botoninicio = "Apertura";
        $botonfinal = "Cierre";
       
        $sqle = mysql_query("SELECT * FROM caja WHERE id_cajero='$ced'");
        if($dat=mysql_fetch_array($sqle)){


          $estado=$dat['estado'];
          if ($estado == 1) {
            $botoninicio = $dat['horainicio'];
            $botonfinal = "Cerrar";
          }else {
            $botonfinal = "Cierre";
            $botoninicio = "Apertura";
          }

          //$dinerocaja = $dat['cantidad']; //dinero en caja para apertura
          $dinerocaja = $dat['apertura']+$dat['cantidad']; //dinero en caja para apertura

          //-----------------apertura de caja cuando ya existe el registro------------------------------------------
          if (!empty($_POST['apertura']) || !empty($_POST['tcaja']) || !empty($_POST['inicio']) && $CountSesion==1) {
              $apertura = $_POST['apertura'];

              if ($estado == 0){
                  /*echo "<script>alert('entra al if de estado == 0');</script>";*/
                  $cantidad = $dinerocaja+$apertura;
                  /*echo $cantidad;*/

                  $sqla = "UPDATE caja set estado='1',horainicio='$hora', apertura='$cantidad', cantidad='0' WHERE id_cajero='$ced'";/*,horainicio='$hora'*/
                  mysql_query($sqla);
                  $botoninicio = $dat['horainicio'];
                  $botonfinal = "Cerrar";

                  //$dinerocaja = $cantidad;
                  $sqle = mysql_query("SELECT * FROM caja WHERE id_cajero='$ced'");
                  if($dat=mysql_fetch_array($sqle))
                    $botoninicio=$dat['horainicio'];
              }
            
          }
          }else{
            $dinerocaja = $apertura = $_POST['apertura'];
          }

            // suma lo que estaba en la caja
           if (!empty($_POST['apertura']) || !empty($_POST['tcaja']) || !empty($_POST['inicio']) && $estado==1) {

                $sqle = mysql_query("SELECT * FROM caja WHERE id_cajero='$ced'");
                if($dat=mysql_fetch_array($sqle)){

                    $dinerocaja = $dat['apertura']+$dat['cantidad'];  
                    $estado = $dat['estado'];  
                   
                }   
                $botoninicio=$dat['horainicio'];       
            }

                //apertura de caja cuando no existe el registro 
                $ConCaja=mysql_num_rows($sqle);
                if (!empty($_POST['inicio']) && $ConCaja==0) {
                    $inic = $_POST['apertura'];
                    $sqlc = "INSERT INTO caja (id_cajero, apertura, estado, horainicio)/*, horainicio*/
                    VALUES ('$ced','$inic','1', '$hora')";/*,'$hora'*/
                    mysql_query($sqlc);
                    $botoninicio=$hora;
                    $sqle = mysql_query("SELECT * FROM caja WHERE id_cajero='$ced'");
                    if($dat=mysql_fetch_array($sqle)){
                       $estado = $dat['estado'];  
                    }
                }   

               



if($estado==1){   

  include("ModalMovimientos.php");          

  if($_SESSION['tipo_usu']=='te'){
    include("ModalReparaciones.php"); 
  }

}

?>

<!-- ********************************************************** SCRIPTS ********************************************************************** -->
<script>
      function identifis(){
        var ValorComision = $("#comision").val();
        $("#iccid").css({"visibility": "hidden","display": "none"});
        $("#imei").css({"visibility": "hidden","display": "none"});
        $("#indenti").css({"visibility": "hidden","display": "none"}); 
        $("#imei").removeAttr("required");
        $("#iccid").removeAttr("required");
        $("#lcheckbox").css({"visibility": "hidden","display": "none"});

        if (ValorComision == "REFACCION") {
          $("#codigo").show();
          $("#iccid2").hide();
          $("#submitChips").hide();

        }else if (ValorComision == "ACCESORIO") {
          $("#codigo").show();
          $("#iccid2").hide();
          $("#submitChips").hide();
          $('#iccid2').removeAttr('required');
          $('#indenti').removeAttr('required');

        }else if (ValorComision == "TELEFONO") {
          $("#codigo").show();
          $("#submitChips").hide();
          $("#iccid2").hide();
          $('#iccid2').removeAttr('required');
          $('#indenti').removeAttr('required');
          $("#imei").css({"visibility": "visible","display": "block"});
          $("#imei").attr("required","true");
          $("#iccid").css({"visibility": "visible","display": "block"});
          $("#iccid").attr("required","true");
          $("#indenti").css({"visibility": "hidden","display": "none"});
          $("#lcheckbox").css({"visibility": "visible","display": "inline"});
          
        }else if (ValorComision == "CHIP") {
          $("#iccid2").show();
          $("#iccid2").css({"visibility": "visible","display": "block"});
          $("#iccid2").attr("required","true");
          $("#indenti").css({"visibility": "hidden","display": "none"});
          $("#imei").css({"visibility": "hidden","display": "none"});
          $("#codigo").hide();
          $("#submitChips").show();

         }else if (ValorComision == "FICHA") {
          $("#codigo").show();
          $("#submitChips").hide();
          $("#indenti").css({"visibility": "visible","display": "block"});
          $("#indenti").attr("required","true");
          $("#iccid2").css({"visibility": "hidden","display": "none"});
          $("#imei").css({"visibility": "hidden","display": "none"});

        }else if(ValorComision == ""){
          $("#submitChips").hide();


        }
        $("#codigo").attr("readonly", false);
      }
</script>
<script>


$(document).ready(function () {
$("#buttonContado").click(function () {
    setTimeout(function () { disableButton(); }, 0);
});

function disableButton() {
    $("#buttonContado").prop('disabled', true);
}
});

</script>

<script>
    $(document).ready(function(){
     

    $.ajax({
    method: "POST",
    url: "Vigencia.php",
    dataType: "json",
    }).done(function(respuesta) {
         //alert(respuesta);
         console.log(respuesta);

        if(respuesta[0] == 2){

          if(respuesta[1] != 0){
            var msg = '<strong> ['+respuesta[1]+'] días habiles </strong>';
          }else{
            var msg = '<strong> sólo el día de hoy </strong>'
          }

          $("#mensajePago").html('<p>Le comunicamos que la vigencia del servicio está próximo a expirar, quedando '+msg+', de manera que lo invitamos a realizar su pago para continuar con el servicio.</p>');
          $('#modalID').show();
          $('#modalAviso').modal('show');

          
        }else if(respuesta[0] == 0){

           window.location.href = "mensajePago.php";
        }

    });

    });
    </script>
    
    <script>
      /*var bandera = false;
      function  hola(){
      alert("hola")
      }*/
      
      

      function window_apertura(){
         var href = $('#boton_apertura').attr('value');
        if(href=='Apertura'){
            /*$('#Apertura').modal({
                    show: 'true'
                  });*/
            $( "#boton_apertura" ).click();
        }else{
          $("#contenido").show();
        }
      }

      function nuevo(){
        var valor = document.getElementById('client').value;
        if (valor == "nuevo") {
            document.location.href="crear_clientes.php";
        }
      }
      $(document).ready(function(){
        $('#search').keyup(function(event){
          filtrar()
          });
      });
      
      function filtrar(){
        //antes obtener los valores d e los select
        
        var valor = document.getElementById("search").value
        //var id_marca = document.getElementById("marca").value
        var tipoproducto = document.getElementById("comisiont").value
        //alert("tipo: "+tipoproducto);
        /*var id_modelo = document.getElementById("modelo").value*/
        /*alert("si llega a la funcion filtrar");*/
        //var tipoproducto = $('input:radio[name=optipo]:checked').val();
        /*var valores = "id_marca="+id_marca+"&tipo="+tipoproducto+"&valor="+valor;*/
        var valores = "";
        if (document.getElementById('precios').checked)
        {
          valores = "tipo="+tipoproducto+"&valor="+valor+"&p=p";
        }else{
          valores = "tipo="+tipoproducto+"&valor="+valor;
        }
        //alert(valores);
        $.ajax({
              url: "Filtro.php", /* Llamamos a tu archivo */
              data: valores, /* Ponemos los parametros de ser necesarios */
              type: "POST",
              contentType: "application/x-www-form-urlencoded",
              dataType: "json",  /* Esto es lo que indica que la respuesta serÃ¡ un objeto JSon */
              success: function(data){
                  /* Supongamos que #contenido es el tbody de tu tabla */
                  /* Inicializamos tu tabla */
                //data = $.parseJSON(data);
                  $("#tablafiltro").html('');
                  /* Vemos que la respuesta no este vacÃ­a y sea una arreglo */
                  if(data != null && $.isArray(data)){
                      $("#tablafiltro").append("<tr class='info'><td colspan='8'><center><strong>Productos/Accesorios</strong></center></td><tr>");
                      $("#tablafiltro").append("<tr><td width='3%'>ID</td><td width='7%'>Nombre</td><td width='7%'>Precio</td><td width='7%'>Marca</td><td width='7%'>Modelo</td><td width='7%'>Cantidad</td><td width='7%'>Sucursal</td><td width='7%'>Add</td></tr>");
                      /* Recorremos tu respuesta con each */
                      $.each(data, function(index, value){
                          /* Vamos agregando a nuestra tabla las filas necesarias */
                          //alert(value.nombre);

                                                                                                                                                                                                                    /*<a href='VentasCredito.php' role='button' class='btn btn-primary credito'> </a><i class=' icon-shopping-cart'></i>*/
                          $("#tablafiltro").append("<tr><td>" + value.id_articulo + "</td><td>" + value.nombre + "</td><td> $" + value.precio + "</td><td>" + value.marca + "</td><td>"  + value.modelo + "</td><td>" + value.cantidad + "</td><td>" + value.sucursal + "</td><td><a href='caja.php?codigo=" + value.id_articulo + "' role='button' class='btn btn-primary credito'><i class='fa fa-shopping-cart' aria-hidden='true'></i></a></td></tr>");
                      });
                  }
              }
          });
      }
      $(document).ready(function(){
      $("#compania").change(function() {
          $('option', '#montor').remove();
          //alert('getdenominacion.php?codigo='+$("#compania").val())
          $("#montor").empty();
          $.getJSON('getdenominacion.php?codigo='+$("#compania").val(),function(data){
              //console.log(JSON.stringify(data));
              $.each(data, function(k,v){
                  $("#montor").append("<option value="+k+"> $"+v+".00</option>");
              });
              $("#montor").removeAttr("disabled");
          });
      });
      });

      $(document).ready(function(){
      $("#paquete").change(function() {
          $('option', '#MontoPaquete').remove();
          //alert('GetDenominacionPaquete.php?codigo='+$("#paquete").val());
          $("#MontoPaquete").empty();
          $.getJSON('GetDenominacionPaquete.php?codigo='+$("#paquete").val(),function(data){
              //console.log(JSON.stringify(data));
              $.each(data, function(k,v){
                  $("#MontoPaquete").append("<option value="+k+"> $"+v+"</option>");
              }).removeAttr("disabled");
          });
      });
      });

      //----------------------buscar el producto para su venta
      function VerProducto(){
          $("#characters").empty();
          var dataList = document.querySelector('#characters');
          var cont = 0;

          $.getJSON('GetProductoName.php?letras='+$("#codigo").val()+'&tipo='+$("#comision").val(),function(data){
              //console.log(JSON.stringify(data));
              $( "#codigo" ).autocomplete({
                /*data*/
                source: data
              });
              //$.each(data, function(k,v){#
                /*var option = document.createElement('option');
                option.value = k;
                dataList.appendChild(option);*/
                //alert(k);
                //$("#characters").append("<option value='"+k+"'>"); //append#
              //});/*.removeAttr("disabled")*/#
              //alert(cont);
          });
      }
      $(document).ready(function(){
        $('#codigo').keyup(function(event){
          VerProducto();
          });
      });
      //---------------------fin buscar el producto para su venta

      $(document).ready(function(){

        $("#iccid").css({"visibility": "hidden","display": "none"});
        $("#imei").css({"visibility": "hidden","display": "none"});
        $("#indenti").css({"visibility": "hidden","display": "none"});

        var ans = "<?= $answer; ?>"
        if (ans == "1") {
          $('#respuesta').modal({
              show: 'true'
          }); 
        }
      });

       function servicios(){
        var IdCajero        = document.getElementById("IdCajero").value;//cajero
        var servicio        = document.getElementById("servicio").value;//compania
        var MontoServicio   = document.getElementById("MontoServicio").value;//monto de recarga DestinoServicio
        var DestinoServicio = document.getElementById("DestinoServicio").value;//monto de recarga DestinoServicio
        var CampoExtra      = document.getElementById("CampoExtra").value;//monto de recarga DestinoServicio


        if (servicio == "" || MontoServicio == "" || DestinoServicio == "") {
          //alert("Se debe elegir una compania y un monto");
          $("#msgerrorServicio").text("Debe seleccionar un servicio y especificar un monto y un destino");
        }else{
          if (MontoServicio=="") {
            //alert("Debes ingresar un numero");
            $("#msgerrorServicio").text("Debes ingresar un numero");
          }else{
            if (isNaN(MontoServicio)){
              $("#msgerrorServicio").text("Los datos numericos son incorrectos");
            }else{
              if (MontoServicio != "" ) {
                  window.location = 'CobrarServicios.php?servicio='+servicio+'&MontoServicio='+MontoServicio+'&DestinoServicio='+DestinoServicio+'&CampoExtra='+CampoExtra+'&IdCajero='+IdCajero;
                  //alert('CobrarRecarga.php?compania='+compania+'&monto='+monto+'&numero='+numero1);
              }else{
                  //alert("Los numero no coinciden");
                  $("#msgerrorServiciomsgerror").text("Error en monto");
              }
            }
          }
        }
      } 
        //CobrarServicios.php

        function paquete(){
        var IdCajero        = document.getElementById("IdCajero").value;//cajero
        var paquete         = document.getElementById("paquete").value;//compania
        var MontoPaquete    = document.getElementById("MontoPaquete").value;//monto de recarga

        var numero1 = document.getElementById("numero").value;//monto de recarga
        var numero2 = document.getElementById("numero1").value;//monto de recarga
        if (paquete == "" || MontoPaquete == "") {
          //alert("Se debe elegir una compania y un monto");
          $("#msgerror").text("Se debe elegir un paquete y un monto");
        }else{
          if (numero1=="" && numero2=="") {
            //alert("Debes ingresar un numero");
            $("#msgerror").text("Debes ingresar un numero");
          }else{
            if (isNaN(numero1) || isNaN(numero2)){
              $("#msgerror").text("Los datos numericos son incorrectos");
            }else{
              if (numero1 == numero2 ) {
                  window.location = 'CobrarRecarga.php?compania='+paquete+'&monto='+MontoPaquete+'&numero='+numero1+'&IdCajero='+IdCajero;
                  //alert('CobrarRecarga.php?compania='+compania+'&monto='+monto+'&numero='+numero1);
              }else{
                  //alert("Los numero no coinciden");
                  $("#msgerror").text("Los numeros no coinciden");
              }
            }
          }
        }
        //CobrarRecarga.php
      }

      function recarga(){
        var IdCajero = document.getElementById("IdCajero").value;//cajero
        var compania = document.getElementById("compania").value;//compania
        var monto    = document.getElementById("montor").value;//monto de recarga

        var numero1 = document.getElementById("numeror").value;//monto de recarga
        var numero2 = document.getElementById("numeror1").value;//monto de recarga
        alert(IdCajero);
        if (compania == "" || monto == "") {
          alert("Se debe elegir una compania y un monto");
          //$("#msgerror").text("Se debe elegir una compania y un monto");
        }else{
          
          if (numero1=="" && numero2=="") {
            alert("Debes ingresar un numero");
            //$("#msgerror").text("Debes ingresar un numero");
          }else{
            if (isNaN(numero1) || isNaN(numero2)){
              alert("Los datos numericos son incorrectos");
              //$("#msgerror").text("Los datos numericos son incorrectos");
            }else{
              if (numero1 == numero2 ) {
                  
                  window.location = 'CobrarRecarga.php?compania='+compania+'&monto='+monto+'&numero='+numero1+'&IdCajero='+IdCajero;
                  //alert('CobrarRecarga.php?compania='+compania+'&monto='+monto+'&numero='+numero1);
              }else{
                  alert("Los numero no coinciden");
                  //$("#msgerror").text("Los numeros no coinciden");
              }
            }
          }
        }
        //CobrarRecarga.php
      }


      $(document).ready(function(){  
  
          $("#checkbox").click(function() {  
              if($("#checkbox").is(':checked')) {  
                  $("#iccid").removeAttr("required");
              }else {  
                  $("#iccid").attr("required","true");
              }  
          });  
        
      });
  </script>


<script>

  
      function ventaChips()
      {
        var iccid = $("#iccid2").val();

        //alert(iccid);
        if(iccid != ""){

          var elementos = "";
          $("#detalleCaja").html("");
          $.ajax({
              method: "POST",
              url: "ventaChips.php",
              dataType: "json",
              data: {iccid: iccid}
          })
          .done(function(respuesta) {

            $.each(respuesta, function(key, item) {

              elementos += item.estatus;
              
            });
            
            $("#detalleCaja").html(elementos);

            $("#modalDetalle").modal("show");
              });

        }
        
      }
    


// $('#modalDetalle').on('hidden.bs.modal', function () {
//  location.reload();
// })

// $('#modalDetalle').on('hide', function() {
// window.location.reload();
// });

// $('#modalDetalle').on('hidden.bs.modal', function () {
//  location.reload();
// });

function cerrarModal(){

  window.location.reload();

}



</script>


<script>

// $('#formCreditoApartado').submit(function(e) {
//     e.preventDefault();
//     var data = $(this).serializeArray();
//     //data.push({name: 'tag', value: 'login'});
//     $.ajax({
//         method: "POST",
//         url: "CreditoApartado.php",
//         data: data
//     })//.done(function(respuesta) {
//             //if(respuesta == 1)
//             //{

                           
//             //}
            
//         });
    
// });

</script>

<script>

function formCheck(cb) {
  //display("Clicked, new value = " + cb.checked);
  if(cb.checked){

    $(".nuevoCSelect" ).hide()
    .removeAttr('required');

    $(".nuevoCliente" ).show()
    .attr('required','required');


  }else{

    $(".nuevoCSelect" ).show().
    attr('required','required');

    $(".nuevoCliente" ).hide().
    removeAttr('required');

  }
}


    function minInput(){

      $("#ccpago2").removeAttr("max");

        var denominacion = $("#denominacion").val();
        denominacion = parseFloat(denominacion);
        
        var ccpago = $("#ccpago2").val();
        ccpago = parseFloat(ccpago);

        //alert(ccpago);




        
        if(denominacion < ccpago){
          //alert("ño");
            $("#ccpago2").attr({"max" : denominacion});
        }else{
          $("#ccpago2").removeAttr("max");
          
        }

    }

</script>

<!-- ********************************************************** SCRIPTS ********************************************************************** -->



</head>
<body>

	<?php include_once "layout.php"; ?>

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
                                            <p class="black font-weight-bold titulo text-center">CAJA</p>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <!-- <div class="col-md-3">
                                        </div> -->

                                        <div class="col-md-12">
                                        
                                            <a class="btn btn-danger credito" href="CancelarVenta.php" role="button">Cancelar Venta</a>
                                            <a class="btn btn-success" href="nueva_reparacion.php" role="button"  >Reparaciones</a>
                                            <a class="btn btn-warning credito" href="ModuloGarantia.php" role="button"  >Garantía</a>

                                            <a class="btn btn-success" href="#Recarga" role="button"  data-toggle="modal" id="boton_filtro" name="boton_filtro" value='filtros' >TAE</a>
                                             
                                            <a class="btn btn-primary" href="#filtro" role="button"  data-toggle="modal" id="boton_filtro" name="boton_filtro" value='filtros' > Busqueda </a>
                                            <a class="btn btn-info" href="#Apertura" role="button"  data-toggle="modal" id="boton_apertura" name="boton_apertura" value='<?php echo "$botoninicio"; ?>' ><?php echo "$botoninicio"; ?> </a><!--  <i class="icon-time icon-white"></i>  -->
                                            <a class="btn btn-warning" href="CierreCaja.php" role="button" ><?php echo "$botonfinal"; ?></a><!--  <i class="icon-lock icon-white"></i>  -->

                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-3">

                                        <div class="form-group">

                                        <label for="" class="col-form-label" ><strong>Tipo Producto:</strong></label>
                                            <select class="form-control form-control-sm" name="comision" id="comision" class="comision" required onchange="identifis();">
                                                <option value = "">Elige una opcion</option>
                                                <?php
                                                    $can=mysql_query("SELECT * FROM comision WHERE tipo != 'RECARGA' AND tipo != 'REPARACION' AND tipo != 'FICHA' AND tipo != 'APARTADO'" );
                                                    while($dato=mysql_fetch_array($can)){ ?>
                                                    <option value="<?php echo $dato['tipo']; ?>" ><?php echo $dato['nombre']; ?></option>
                                                <?php } ?>
                                            </select>
                                        <label for="" style="visibility:hidden;display:none" id="lcheckbox"><input type="checkbox" id="checkbox" >Sin SIM</label>

                                        </div>
                                        
                                            <form name="form1" id="formChip" method="post" action="caja.php">
                                                
                                                <div class="form-group">
                                                    <input class="form-control form-control-sm"  type="text" name="imei" id="imei" placeholder="IMEI" ><!-- style="display:none;visibility:hidden;" -->
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control form-control-sm" type="text"  name="iccid" id="iccid" placeholder="ICCID">
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" style="display:none;"  name="iccid2" id="iccid2" placeholder="ICCID" rows="4"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control form-control-sm" type="text" name="indenti" id="indenti" placeholder="IDENTIFICADOR FICHA">
                                                </div>
                                                <div class="form-group">


                                                    <input class="form-control form-control-sm" type="text" autofocus class="input-xlarge" id="codigo" name="codigo"  placeholder="Codigo de barra o Nombre del producto" autocomplete="off" readonly="true">
                                                </div>
                                                    <button type="submit" style="visibility:hidden;">agregar</button>
                                                    <button id="submitChips" type="button" class="btn btn-success" onclick="ventaChips();" style="display:none;">Agregar</button>
                                            </form>



                                            <!-- ****************************************************************************** -->
                                            <?php
      if(!empty($_POST['codigo']) OR !empty($_GET['codigo']) OR !empty($_POST['imei']) OR !empty($_POST['iccid']) OR !empty($_POST['indenti'])){
    #obtencion de codigo a partir de indentificador
      if(!empty($_POST['imei']) OR !empty($_POST['iccid']) OR !empty($_POST['indenti'])){

        #******************CHIPS****************
        if (!empty($_POST['iccid'])) {
          $viccid = $_POST['iccid'];
          $query1 = "SELECT * FROM codigo_producto WHERE identificador = '$viccid'";
          $con2=($query1);
          if($row2=mysql_fetch_array($con2)){
            $codigo = $row2['id_producto'];
          }
        }
        #****************************************
        if (!empty($_POST['imei'])) {
          $vimei = $_POST['imei'];
          $con1=mysql_query("SELECT * FROM codigo_producto WHERE identificador = '$vimei'");
          if($row1=mysql_fetch_array($con1)){
            $codigo = $row1['id_producto'];
          }
        }
        if (!empty($_POST['indenti'])) {
          $videnti = $_POST['indenti'];
          $con3=mysql_query("SELECT * FROM codigo_producto WHERE identificador = '$videnti'");
          if($row3=mysql_fetch_array($con3)){
            $codigo = $row3['id_producto'];
          }
        }
        //echo "codigo: ".$codigo;
      }else {
        if (!empty($_GET['codigo'])) {
          $codigo = $_GET['codigo'];
        }else {
          $codigo=$_POST['codigo'];
        }
      }
    #fin obtencion de codigo a partir de indentificador
      $nom_usu=$_SESSION['username'];
      $imei = trim($_POST['imei']);
      $iccid = trim($_POST['iccid']);
      $identi = $_POST['indenti'];
      //echo "imei: ".$imei;

      //ProductoNormal($codigo,$nom_usu);

 if($iccid != "" || $imei !="")
 {
    $consultaTemp = "SELECT * FROM caja_tmp where (cod='$codigo' or nom='$codigo') and usu='$nom_usu'";
    $can=mysql_query($consultaTemp);
    if($dato=mysql_fetch_array($can) && $iccid == "" && $imei == "")
    //if($dato=mysql_fetch_array($can))
    {
      //-------------------------------------------
      

        if (($dato['exitencia']-$dato['cant'])>0) 
        {
            $acant=$dato['cant']+1;
            $dcodigo=$dato['cod'];
            //----------------------------------------
            $ventapublico=$dato['venta'];            
            if($dato['cant']>=5-1)
            {
              $id_sucu=$_SESSION['id_sucursal'];
              $consulta = "SELECT mayor FROM producto WHERE cod = '$dcodigo' AND id_sucursal = '$id_sucu'";
              $execquery=mysql_query($consulta);
              $dato=mysql_fetch_array($execquery);
              $preciomayoreo=$dato['mayor'];
              $aventa=($preciomayoreo*$acant);
              $ventapublico=$preciomayoreo;

            }else{
            $aventa=$dato['venta']*$acant;
            }
            //-------------------------------------------------
            //*************************************************************************************************************************
            if($iccid == ""){
/********Sólo productos Normales******** */
            $sql="UPDATE caja_tmp SET venta='$ventapublico', importe='$aventa', cant='$acant',tipo_comision='$tipo_comision' WHERE cod='$dcodigo'";mysql_query($sql);
            }
            //*************************************************************************************************************************
        }else 
        {
              //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>No hay exitencia del producto</strong></div>';

              //echo '<div class="alert alert-danger" role="alert">This is a danger alert—check it out!</div>';

              echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>No hay exitencia del producto</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>';
        }
      //}else{
      //  echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>El ICCID o IMEI ya está en el carrito, Verifique la Información</strong></div>';
      //}
      //-------------------------------------------
    }else
    {
      $query2 = "SELECT * FROM producto where id_sucursal = '$id_sucursal' AND (cod='$codigo' or nom='$codigo')";
        $cans=mysql_query($query2);
        if($datos=mysql_fetch_array($cans)){
          $cod=$datos['cod'];
        #ver que tipo de venta es
          if($_SESSION['tventa']=="venta"){
          $importe=$datos['venta']; $venta=$datos['venta'];
          }else{
            if ($_SESSION['tventa']=="mayoreo") {
              $importe=$datos['mayor']; $venta=$datos['mayor'];
            }else {
              $importe=$datos['especial'];  $venta=$datos['especial'];
            }
          }
        #fin ver que tipo de venta es
        #obtener tipo de producto
          $comision = $datos['id_comision'];
          $quer=mysql_query("SELECT * FROM comision where id_comision = '$comision'");
          if($row=mysql_fetch_array($quer)){
            $tipo_pro = $row['tipo'];
          }
        #fin obtener tipo de producto
        #verificar si existe el identificador
          if ($tipo_pro == "TELEFONO" OR $tipo_pro == "FICHA" OR $tipo_pro == "CHIP") {
              $bim = 0; $bic = 0; $bid = 0;
              $bt = 0; $bc = 0; $bf = 0;
              $que1=mysql_query("SELECT * FROM codigo_producto WHERE identificador = '$imei' AND id_producto = '$cod' AND estado = 's'");
              if($rows1=mysql_fetch_array($que1)){
                $bim = 1;
              }
              $que2=mysql_query("SELECT * FROM codigo_producto WHERE identificador = '$iccid' AND id_producto = '$cod' AND estado = 's'");
              if($rows2=mysql_fetch_array($que2)){
                $bic = 1;
              }
              $que3=mysql_query("SELECT * FROM codigo_producto WHERE identificador = '$identi' AND id_producto = '$cod' AND estado = 's'");
              if($rows3=mysql_fetch_array($que3)){
                $bid = 1;
              }
          #venta telefono
            if ($tipo_pro == "TELEFONO") {
              if ($bim == 1 && $bic == 1 && !empty($bic)) {
                //guardar el registro
                $bt = 1;
              }else {
                if (!empty($bic)) {
                  //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>IMEI ó ICCID no existe</strong></div>';
                  echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>IMEI ó ICCID no existe.</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';

                }else {
                  if ($bim == 1) {
                    $bt = 1;
                  }else {
                    //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>IMEI no existe</strong></div>';

                    echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>IMEI no existe.</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                  }
                }
              }
            }
          #fin venta telefono
            
        #fin verificar si existe el identificador
            if ($bt == 1 OR $bc == 1 OR $bf == 1) {
              if ($datos['cantidad'] < 1) {
                //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>No hay existencia del producto</strong></div>';
                echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>No hay existencia del producto.</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
              }else {

                //verificar si el ICCID existe en la base de datos por sucursal

                if($iccid != '')
                {
                  $query3 = "SELECT * FROM codigo_producto WHERE identificador = '$iccid' AND id_sucursal = '$id_sucursal'";
                  $ejecutarq3 = mysql_query($query3);
                  if (mysql_num_rows($ejecutarq3) > 0) 
                  {
  
                    //*****************OBTENER nombre del producto (CHIP) por su ICCID**************
                      $consultaICCID="SELECT id_producto FROM codigo_producto WHERE identificador = '$iccid';";
                      $ejecutar = mysql_query($consultaICCID);
                      $dato =mysql_fetch_array($ejecutar);
                      $id_producto = $dato['id_producto'];
  
                      $consultaNomProducto ="SELECT nom FROM producto WHERE cod = '$id_producto' LIMIT 1;";
                      $ejecutar = mysql_query($consultaNomProducto);
                      $dato =mysql_fetch_array($ejecutar);
                      $nombre_productochip = $dato['nom'];
                      //******************************************************************************/
  
                               
                
                  
                      $cod=$datos['cod'];
                      $nom=$datos['nom'];
                      $cant="1";
                      $exitencia=$datos['cantidad'];
                      $usu=$_SESSION['username'];
        
                      //consultas para validar si los iccid o imei no se repitan en caja_temp VER PROCESO TMP
                      $cuantosTmp = 0;
                      $cuantosTmp2 = 0;
  
                      if ($imei != '') {
                          $consultaTemp = "SELECT * FROM caja_tmp WHERE imei = '$imei'";
                          $ejecutarTmp = mysql_query($consultaTemp);
                          $cuantosTmp=mysql_num_rows($ejecutarTmp);
                      }
  
                      if ($iccid != '') {
                          $consultaTemp2 = "SELECT * FROM caja_tmp WHERE iccid = '$iccid'";
                          $ejecutarTmp2 = mysql_query($consultaTemp2);
                          $cuantosTmp2=mysql_num_rows($ejecutarTmp2);
                      }
                      //***************************************************************************************/
  
                      
                      if ($cuantosTmp == 0 && $cuantosTmp2 == 0) { //--> PROCESO TMP
                          $sql="INSERT INTO caja_tmp (cod, nom, venta, cant, importe, exitencia, usu,imei,iccid,n_ficha,nombre_chip,tipo_comision) VALUES ('$cod','$nom','$venta','$cant','$importe','$exitencia','$usu','$imei','$iccid','$identi','$nombre_productochip','$tipo_comision')";
                          mysql_query($sql);
                      } else {
                          //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>El ICCID o IMEI ya está en el carrito, Verifique la Información</strong></div>';
                          echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>El ICCID o IMEI ya está en el carrito, Verifique la Información.</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>';
                      }
  
                  }else{
  
                    //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>El ICCID no existe en la sucursal, Verifique la Información</strong></div>';

                    echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>El ICCID no existe en la sucursal, Verifique la Información.</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                  
                  }
                  //**********************************************************************

                }else{
                         
                      $cod=$datos['cod'];
                      $nom=$datos['nom'];
                      $cant="1";
                      $exitencia=$datos['cantidad'];
                      $usu=$_SESSION['username'];
        
                      //consultas para validar si los iccid o imei no se repitan en caja_temp VER PROCESO TMP
                      $cuantosTmp = 0;
                      $cuantosTmp2 = 0;
  
                      if ($imei != '') {
                          $consultaTemp = "SELECT * FROM caja_tmp WHERE imei = '$imei'";
                          $ejecutarTmp = mysql_query($consultaTemp);
                          $cuantosTmp=mysql_num_rows($ejecutarTmp);
                      }
  
                      if ($iccid != '') {
                          $consultaTemp2 = "SELECT * FROM caja_tmp WHERE iccid = '$iccid'";
                          $ejecutarTmp2 = mysql_query($consultaTemp2);
                          $cuantosTmp2=mysql_num_rows($ejecutarTmp2);
                      }
                      //***************************************************************************************/
  
                      
                      if ($cuantosTmp == 0 && $cuantosTmp2 == 0) { //--> PROCESO TMP
                          $sql="INSERT INTO caja_tmp (cod, nom, venta, cant, importe, exitencia, usu,imei,iccid,n_ficha,nombre_chip,tipo_comision) VALUES ('$cod','$nom','$venta','$cant','$importe','$exitencia','$usu','$imei','$iccid','$identi','$nombre_productochip','$tipo_comision')";
                          mysql_query($sql);
                      } else {
                          //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>El ICCID o IMEI ya está en el carrito, Verifique la Información</strong></div>';
                          echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>El ICCID o IMEI ya está en el carrito, Verifique la Información.</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>';
                      }
  


                }




              }
            }
          }else {
            if ($datos['cantidad'] < 1) {
              //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>No hay existencia del producto</strong></div>';
              echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>No hay existencia del producto.</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>';
            }else {
      

              if (empty($imei) && empty($iccid) && empty($identi)) 
              {
                $cod=$datos['cod'];$nom=$datos['nom'];$cant="1";$exitencia=$datos['cantidad'];$usu=$_SESSION['username'];

                $sql="INSERT INTO caja_tmp (cod, nom, venta, cant, importe, exitencia, usu,tipo_comision) VALUES ('$cod','$nom','$venta','$cant','$importe','$exitencia','$usu','$tipo_comision')";
                mysql_query($sql);
              } 
      

            }
          }
        }else{
          //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>Producto no encontrado en la base de datos<br><a href="#mydatos" role="button" class="btn btn-success" data-toggle="modal">Crear Nuevo Producto </a></strong></div>';
          echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>Producto no encontrado en la base de datos.</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>';
        }
    }
    //****************************************************************************************************************************************************************
  }else if($iccid == "" || $imei ==""){

    $consultaTemp = "SELECT * FROM caja_tmp where (cod='$codigo' or nom='$codigo') and usu='$nom_usu'";
    $can=mysql_query($consultaTemp);
    if($dato=mysql_fetch_array($can))
    //if($dato=mysql_fetch_array($can))
    {
      //-------------------------------------------

        if (($dato['exitencia']-$dato['cant'])>0) 
        {
            $acant=$dato['cant']+1;
            $dcodigo=$dato['cod'];
            //----------------------------------------
            $ventapublico=$dato['venta'];            
            if($dato['cant']>=5-1)
            {
              $id_sucu=$_SESSION['id_sucursal'];
              $consulta = "SELECT mayor FROM producto WHERE cod = '$dcodigo' AND id_sucursal = '$id_sucu'";
              $execquery=mysql_query($consulta);
              $dato=mysql_fetch_array($execquery);
              $preciomayoreo=$dato['mayor'];
              $aventa=($preciomayoreo*$acant);
              $ventapublico=$preciomayoreo;

            }else{
            $aventa=$dato['venta']*$acant;
            }
            //-------------------------------------------------
            //*************************************************************************************************************************
            if($iccid == ""){
/********Sólo productos Normales******** */
            $sql="UPDATE caja_tmp Set venta='$ventapublico', importe='$aventa', cant='$acant',tipo_comision='$tipo_comision' WHERE cod='$dcodigo'";mysql_query($sql);
            }
            //*************************************************************************************************************************
        }else 
        {
              //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>No hay exitencia del producto</strong></div>';
              echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>No hay exitencia del producto.</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>';
        }
      //}
      //-------------------------------------------
    }else
    {
        $cans=mysql_query("SELECT * FROM producto where id_sucursal = '$id_sucursal' AND (cod='$codigo' or nom='$codigo')");
        if($datos=mysql_fetch_array($cans)){
          $cod=$datos['cod'];
        #ver que tipo de venta es
          if($_SESSION['tventa']=="venta"){
          $importe=$datos['venta']; $venta=$datos['venta'];
          }else{
            if ($_SESSION['tventa']=="mayoreo") {
              $importe=$datos['mayor']; $venta=$datos['mayor'];
            }else {
              $importe=$datos['especial'];  $venta=$datos['especial'];
            }
          }
        #fin ver que tipo de venta es
        #obtener tipo de producto
          $comision = $datos['id_comision'];
          $quer=mysql_query("SELECT * FROM comision where id_comision = '$comision'");
          if($row=mysql_fetch_array($quer)){
            $tipo_pro = $row['tipo'];
          }
        #fin obtener tipo de producto
        #verificar si existe el identificador
          if ($tipo_pro == "TELEFONO" OR $tipo_pro == "FICHA" OR $tipo_pro == "CHIP") {
              $bim = 0; $bic = 0; $bid = 0;
              $bt = 0; $bc = 0; $bf = 0;
              $que1=mysql_query("SELECT * FROM codigo_producto WHERE identificador = '$imei' AND id_producto = '$cod' AND estado = 's'");
              if($rows1=mysql_fetch_array($que1)){
                $bim = 1;
              }
              $que2=mysql_query("SELECT * FROM codigo_producto WHERE identificador = '$iccid' AND id_producto = '$cod' AND estado = 's'");
              if($rows2=mysql_fetch_array($que2)){
                $bic = 1;
              }
              $que3=mysql_query("SELECT * FROM codigo_producto WHERE identificador = '$identi' AND id_producto = '$cod' AND estado = 's'");
              if($rows3=mysql_fetch_array($que3)){
                $bid = 1;
              }
          #venta telefono
            if ($tipo_pro == "TELEFONO") {
              if ($bim == 1 && $bic == 1 && !empty($bic)) {
                //guardar el registro
                $bt = 1;
              }else {
                if (!empty($bic)) {
                  //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>IMEI ó ICCID no existe</strong></div>';
                  echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>IMEI ó ICCID no existe.</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>';
                }else {
                  if ($bim == 1) {
                    $bt = 1;
                  }else {
                    //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>IMEI no existe</strong></div>';
                    echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>IMEI no existe.</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                  }
                }
              }
            }
          #fin venta telefono
            if ($tipo_pro == "CHIP") {
              if ($bic == 1) {
                //guardar el registro
                $bc = 1;
              }else {
                //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>ICCID no existe</strong></div>';
                echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>ICCID no existe.</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
              }
            }
            if ($tipo_pro == "FICHA") {
              if ($bid == 1) {
                //guardar el registro
                $bf = 1;
              }else {
                //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>IDENTIFICADOR no existe</strong></div>';
                echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>IDENTIFICADOR no existe.</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
              }
            }
        #fin verificar si existe el identificador
            if ($bt == 1 OR $bc == 1 OR $bf == 1) {
              if ($datos['cantidad'] < 1) {
                //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>No hay existencia del producto</strong></div>';
                echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>No hay existencia del producto.</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
              }else {
              //*****************OBTENER nombre del producto (CHIP) por su ICCID**************                
              $consultaICCID="SELECT id_producto FROM codigo_producto WHERE identificador = '$iccid';";
              $ejecutar = mysql_query($consultaICCID);
              $dato =mysql_fetch_array($ejecutar);
              $id_producto = $dato['id_producto'];

              $consultaNomProducto ="SELECT nom FROM producto WHERE cod = '$id_producto' LIMIT 1;";
              $ejecutar = mysql_query($consultaNomProducto);
              $dato =mysql_fetch_array($ejecutar);
              $nombre_productochip = $dato['nom'];
              //******************************************************************************/
                $cod=$datos['cod'];$nom=$datos['nom'];$cant="1";$exitencia=$datos['cantidad'];$usu=$_SESSION['username'];
                $sql="INSERT INTO caja_tmp (cod, nom, venta, cant, importe, exitencia, usu,imei,iccid,n_ficha,nombre_chip,tipo_comision) VALUES ('$cod','$nom','$venta','$cant','$importe','$exitencia','$usu','$imei','$iccid','$identi','$nombre_productochip','$tipo_comision')";
                mysql_query($sql);
              }
            }
          }else {
            if ($datos['cantidad'] < 1) {
              //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>No hay existencia del producto</strong></div>';
              echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>No hay existencia del producto.</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
            }else {
              if (empty($imei) && empty($iccid) && empty($identi)) {
                $cod=$datos['cod'];$nom=$datos['nom'];$cant="1";$exitencia=$datos['cantidad'];$usu=$_SESSION['username'];

                $sql="INSERT INTO caja_tmp (cod, nom, venta, cant, importe, exitencia, usu,tipo_comision) VALUES ('$cod','$nom','$venta','$cant','$importe','$exitencia','$usu','$tipo_comision')";
                mysql_query($sql);
              } 
            }
          }
        }else{
          //echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>Producto no encontrado en la base de datos<br><a href="#mydatos" role="button" class="btn btn-success" data-toggle="modal">Crear Nuevo Producto </a></strong></div>';
          echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Producto no encontrado en la base de datos.</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        }
    }



  }




    }
    ?>
                                            <!-- ****************************************************************************** -->



                                        </div>

                                        

                                        <div class="col-md-4">
                                            <!-- <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Nombre del Cajero/a :</h5>
                                                    <p class="card-text"><?php echo $nombre_usu; ?></p>
                                                </div>
                                            </div> -->

                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title">Tipo de Venta:</h6>
                                                    <br>
                                                    <?php   
                                                    if(!empty($_SESSION['tventa'])){if($_SESSION['tventa']=='venta'){$vboton="btn btn-primary btn-sm";
                                                    }else{$vboton="btn";}if($_SESSION['tventa']=='mayoreo'){$mboton="btn btn-primary btn-sm";
                                                    }else{$mboton="btn";}if($_SESSION['tventa']=='especial'){$eboton="btn btn-primary btn-sm";
                                                    }else{$eboton="btn";}}else{$_SESSION['venta'];  $vboton="btn btn-primary btn-sm";}
                                                    ?>
                                                    <button type="button"  class="<?php echo $vboton; ?> btn-sm" onClick="window.location='php_caja.php?tventa=venta'">Publico</button>
                                                    <button type="button"  class="<?php echo $mboton; ?> btn-sm" onClick="window.location='php_caja.php?tventa=mayoreo'">Mayoreo</button>
                                                    <button type="button" class="<?php echo $eboton; ?> btn-sm" onClick="window.location='php_caja.php?tventa=especial'">Especial</button>
                                                </div>
                                        </div>


                                        </div>
                                        <div class="col-md-3">



                                        
</div>
                                        <div class="col-md-2"></div>
                                                                                                                                          
                                    </div>
                                </div>
                            </div>


                            <?php
$Caja_tmp->set('usu',$usuarioSession);
$respuesta = $Caja_tmp->obtieneAllProdByUsu();
                            if($respuesta){

                                ?>
                            <div class="col-md-12">
                              <table class="table">
                              <tr>
                                <td><strong>Codigo</strong></td>
                                <td><strong>Descripcion del Producto</strong></td>
                                <td><strong>ICCID</strong></td>
                                <td><strong>IMEI</strong></td>
                                <td><strong>Valor Unitario</strong></td>
                                <td><strong>Cant.</strong></td>
                                <td><strong>Importe</strong></td>
                                <td><strong>Existencia</strong></td>
                                <td><strong>Eliminar</strong></td>
                              </tr>

                              <?php
                              $na=0;
                              $can=mysql_query("SELECT * FROM caja_tmp where usu='$usuarioSession'");
                              while($dato=mysql_fetch_array($can))
                              { $na=$na+$dato['cant']; ?>

                                <tr>
                                  <td><?php echo $dato['cod']; ?>&nbsp;<?php echo '<img src="articulo/'.$dato['cod'].'.jpg" WIDTH=35 HEIGHT=12>'; ?></td>
                                  <td><?php echo $dato['nom']; ?></td>
                                  <td><?php echo $dato['iccid']; ?></td>
                                  <td><?php echo $dato['imei']; ?></td>
                                  <td><div align="">$ <?php echo number_format($dato['venta'],2,",","."); ?></div></td>
                                  <!-- <td><div align=""><a href="caja.php?id=<?php echo $dato['cod'].'&ddes='.$_SESSION['ddes']; ?>">$ <?php echo number_format($dato['venta'],2,",","."); ?></a></div></td> -->
                                  <td><a href="caja.php?idd=<?php echo $dato['cod'].'&ddes='.$_SESSION['ddes']; ?>"><?php echo $dato['cant']; ?></a></td>
                                  <td><strong>$ <?php echo number_format($dato['importe'],2,",","."); ?></strong></td>
                                  <td>
                                    <?php 
                                    if(($dato['exitencia']-$dato['cant'])>0){
                                    echo $dato['exitencia']-$dato['cant'];
                                    }else{
                                    echo 0;
                                    }
                                    ?>
                                  </td>
                                  <td> 
                                    <button type="button" class="btn btn-danger" onClick="window.location='php_eliminar_caja.php?id=<?php echo $dato['cod']; ?>'"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                  </td>
                                </tr>
                              <?php                               
                              } 
                              ?>
                              </table>
                            </div>
                               <?php }?>
                            
                              




<?php if(!empty($_GET['id'])){ ?>

<!-- <form name="form2" method="get" action="php_caja_act.php">
  <input type="hidden" name="xcodigo" id="xcodigo" value="<?php echo $_GET['id'] ?>">
  Nuevo Precio o % Descuento: <input type="text" name="xdes" id="xdes" value="0" autocomplete="off">
  [ <input type="radio" name="tipo" id="optionsRadios1" value="p" checked>Descuento % ]
  [ <input type="radio" name="tipo" id="optionsRadios1" value="d" checked>Nuevo Precio $ ]
  <button type="submit" class="btn btn-success">Procesar</button>  
</form> -->

<?php } ?>


<?php if(!empty($_GET['idd'])){ ?>

<form name="form2" method="get" action="php_procesar_caja.php">
  <input type="hidden" name="xcodigo" id="xcodigo" value="<?php echo $_GET['idd'] ?>">
  Cantidad: <input type="text" name="cantidad" id="cantidad" value="0" autocomplete="off">
  <button type="submit" class="btn btn-success">Procesar</button>  
</form>

<?php } ?>

<br>

<div class="row">

  <div class="col-md-12">

    <div class="container">

      <div class="row">

        <div class="col-md-4">

          <strong>
          <div class="card">
          <div class="card-body">

          <?php echo $na; ?> Articulos en venta
          </div>
          </div>
          </strong>

        </div>

        <div class="col-md-4">

          <?php
            if($_GET['ddes']>=0){
            $_SESSION['ddes']=$_GET['ddes'];  
            }
          ?>
          <form name="form3" method="get" action="caja.php">
          
            <div class="form-group">
              <label for="">Descuento al Neto</label>
              <div class="input-group input-group-sm mb-3">
                <input type="number" class="form-control" aria-describedby="inputGroup-sizing-sm" min="0" max="99" name="ddes" id="ddes" value="<?php echo $_SESSION['ddes']; ?>">
                <div class="input-group-append">
                  <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-percent" aria-hidden="true"></i></span>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-info">Aplicar Descuento</button>

          </form>

        </div>

        <div class="col-md-4">
          <strong> 

          <div class="card">
          <div class="card-body">
          Neto: <?php 
            $can=mysql_query("SELECT SUM(importe) as neto FROM caja_tmp where usu='$usuarioSession'");
            if($dato=mysql_fetch_array($can))
            {
              $NETO=$dato['neto']-($dato['neto']*$_SESSION['ddes']/100);
              $_SESSION['neto']=$NETO;
              echo '$ '.number_format($_SESSION['neto'],2,",",".");
            }?>
          </div>
          </div>


          </strong>
        </div>

      </div>

      <br>
      <div class="row">

        <div class="col-md-12">

          <div class="card">
            <div class="card-body">

              <?php if($NETO<>0){ ?>

                  <div align="center">
                  <a href="#myContado" role="button" class="btn btn-success" data-toggle="modal"><i class="fa fa-shopping-cart" aria-hidden="true"></i> V. Contado</a>
                  <a href="#myCredito" role="button" class="btn btn-success" data-toggle="modal"><i class="fa fa-shopping-cart" aria-hidden="true"></i> V. Apdo. / Cto.</a>
                  </div>

              <?php } ?>
            </div>
          </div>

        </div>
      </div>





    </div>
  </div>
</div>




                            

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>


<!--**************************************** Modal ******************************************************* -->


<div class="modal fade" id="myContado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >COBRAR AL CONTADO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p align="center" class="text-info"><strong>Total Cobrar</strong></p>
        <pre style="font-size:30px"><center><?php echo '$ '.number_format($_SESSION['neto'],2,",","."); ?></center></pre>
        <p align="center" class="text-info"><strong>Forma de Pago "Contado"</strong></p>

        <div align="center">
          <form id="form1Contado" name="contado" method="get" action="CobrarContado.php">
            <p>
            <table border="0" width="100%">
              <tr>
              <td align="right" width="20%">Tranferencia:</td><td align="left" class="td1"><input type="radio" name="fpago" id="fpago" value="Transferencia" class="td1"> </td>
              <td align="right" width="20%">Tarjeta:</td><td align="left" class="td1"><input type="radio" name="fpago" id="fpago" value="cheque" class="td1"> </td>
              <td align="right" width="20%">Efectivo:</td><td align="left" class="td1"><input type="radio" name="fpago" id="fpago" value="Efectivo" class="td1" checked=""> </td>
              <td align="right" width="20%">Otro:</td><td align="left" class="td1"><input type="radio" name="fpago" id="fpago" value="Otro" class="td1"></td>
              </tr>
            </table> 
            </p>    
            <label for="ccpago">Dinero Recibido</label>
            <input type="hidden" name="tpagar" id="tpagar" value="<?php echo $_SESSION['neto']; ?>">
            <div class="input-prepend input-append">
              <span class="add-on">$</span>
              <input type="number" name="ccpago" id="ccpago" autocomplete="on" min="0" step="any" required autofocus/>
              <span class="add-on">.00</span>
            </div><br>
            <input type="hidden" name="tipocompra" id="tipocompra" value="CONTADO">
            <input type="submit" class="btn btn-success buttonContado" name="button" id="buttonContado" value="Cobrar Dinero Recibido" />
          </form>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>


<!-- ************************************************+ -->



<!--**************************************** Modal -- Credito ************************************** -->

<div class="modal fade" id="myCredito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >SISTEMA CREDITO / APARTADO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">



      <p align="center" class="text-info"><strong>Total Cobrar</strong></p>
      <pre style="font-size:20px"><center><?php echo '$ '.number_format($_SESSION['neto'],2,",","."); ?></center></pre>
    <!-- <p align="center" class="text-info"><strong>Forma de Pago "Credito"</strong></p> -->
        <div align="center">
        
          <form id="formCreditoApartado" name="formCreditoApartado" method="POST" action="CreditoApartado.php">
          <!-- <p align="center" class="text-info"><strong>Fecha Limite de Pago</strong></p> -->
          <label for="fecha" class="text-info"><strong>Fecha Limite Pago: </strong>
          <input type="date" name="fecha" id="fecha"  value="<?php echo $fecha; ?>" required>
          </label>

              <label>
                <input type="checkbox" onclick='formCheck(this);' class="input" name="checkCliente" value="1">Cliente Nuevo
              <label>

              <label align="center"  class="text-info nuevoCSelect"><strong>Cliente Existente</strong>
                  <input type="text" class="input nuevoCSelect" id="client" name="client" list="datalist1" placeholder="Nombre del Cliente" autocomplete="off" required>
                  <datalist id="datalist1">
                  <?php
                  $cons=mysql_query("SELECT * FROM cliente where estatus='s'");
                  while($datas=mysql_fetch_array($cons)){
                    echo '<option value="'.$datas['codigo'].'||'.$datas['empresa'].'">';
                  }
                  ?>
                  </datalist>
              </label>              
              
                <label style="display:none;" align="center" class="text-info nuevoCliente"><strong>Nuevo Cliente:</strong>
                  <input type="text" class="input nuevoCliente" id="nombreCliente" name="nombreCliente"  placeholder="Nombre">
                </label>
           
              
              <label style="display:none;" align="center" class="text-info nuevoCliente"><strong>Apellido Paterno:</strong>
                <input type="text" class="input nuevoCliente" id="appCliente" name="appCliente"  placeholder="Apellido Paterno">
              </label>

              <label style="display:none;" align="center" class="text-info nuevoCliente"><strong>Apellido Materno:</strong>
                <input type="text" class="input nuevoCliente" id="apmCliente" name="apmCliente"  placeholder="Apellido Materno">
              </label>
             
              <label style="display:none;" align="center" class="text-info nuevoCliente"><strong>Teléfono:</strong>
                <input type="text" class="input nuevoCliente" id="telCliente" name="telCliente"  placeholder="Telefono">
              </label>
            
              <label style="display:none;" align="center" class="text-info nuevoCliente"><strong>correo:</strong>
                <input type="text" class="input nuevoCliente" id="emailCliente" name="emailCliente"  placeholder="Correo">
              </label>
              


                <label for="fecha" class="text-info"><strong>Tipo del Sistema:</strong>
                  <select name="tipsis" id="tipsis" required><!--  onchange="location = this.value" -->
                  <option value="1">Apartado</option>
                  <option value="2">Credito</option>
                </select>
                </label>

                 <p>
                  <table border="0" width="100%">
                  <tr>
                    <!-- <td align="right" width="20%">Tranferencia:</td><td align="left" class="td1"><input type="radio" name="fpago" id="fpago" value="Transferencia" class="td1"> </td> -->
                    <!-- <td align="right" width="20%">Tarjeta:</td><td align="left" class="td1"><input type="radio" name="fpago" id="fpago" value="cheque" class="td1"> </td> -->
                    <td align="right" width="20%">Efectivo:</td><td align="left" class="td1"><input type="radio" name="fpago" id="fpago" value="Efectivo" class="td1" checked="true"> </td>
                    <!-- <td align="right" width="20%">Otro:</td><td align="left" class="td1"><input type="radio" name="fpago" id="fpago" value="Otro" class="td1"></td> -->
                  </tr>
                   </table>
                  </p>

                  <label for="">Dinero Recibido</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" name="denominacion"  step="any" id="denominacion" min="0" autocomplete="on" required/>
                    <span class="add-on">.00</span>
                </div>



                <label for="ccpago">Abona a Cuenta</label>
                <input type="hidden" name="tpagar" id="tpagar" value="<?php echo $_SESSION['neto']; ?>">
                <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" name="ccpago2" onkeyup="minInput();" step="any" id="ccpago2" min="0" autocomplete="on" required/>
                    <span class="add-on">.00</span>
                </div><br>
                <input type="hidden" name="tipocompra" id="tipocompra" value="CREDITO">
                <input type="submit" class="btn btn-success" name="button" id="button" value="Cobrar Dinero Recibido" />
          </form>
        </div>


        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>


<!-- *************************************************************************************************************************** -->


<!--*************************************************** modal apertura de caja *************************************************-->

<div class="modal fade" id="Apertura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >APERTURA DE CAJA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


      
      <p align="center" class="text-info"><strong>Cantidad existente</strong></p>
        <div align="center">
          <form id="form1" name="inicio" method="post" action="caja.php" min="0">
                <div>
                  <input type="text" name="tcaja" id="tcaja" value="<?php echo $dinerocaja; ?>" readonly>
                </div>
                <?php if(!$estado==1){ ?>
                <label for="ccpago">Entrada de efectivo</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" name="apertura" id="apertura" min="0" step="any" autocomplete="on" value="0.00" required/>
                </div><br>
                <input type="hidden" name="inicio" id="inicio" value="1" readonly>
                <input type="submit" class="btn btn-success" name="button" id="button" value="Aceptar" />
                <?php } ?>  
          </form>
        </div>


        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<!-- --------------------------******************************************** ---------------------------------- -->
<!-- -------------------------- modal Filtros ---------------------------------- -->

<div class="modal fade" id="filtro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >BUSQUEDA PRODUCTOS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


      
      <label for="" style="padding-left: 5px;"><input type="checkbox" name="precios" id="precios"><strong>$</strong> Precios</label>
          <select name="comisiont" id="comisiont">
            <option value="0">TODOS</option>
            <?php
                $can=mysql_query("SELECT DISTINCT tipo, id_comision FROM comision WHERE tipo != 'REPARACION' AND tipo != 'RECARGA' ORDER BY nombre");
                while($dato=mysql_fetch_array($can)){ ?>
                <option value="<?php echo $dato['id_comision']; ?>"><?php echo $dato['tipo']; ?></option>
            <?php } ?>
          </select>

          <input type="text" name="search" id="search" placeholder="Buscar...">

      
        <button type="button" onclick="filtrar();" class="btn btn-default">VER</button>
     
      <div style="width: 100%; height: 250px; overflow-y: scroll;">
        <table width="80%" border="0" class="table" id="tablafiltro">
          <tr class="info">
            <td colspan="4"><center><strong>Productos/Accesorios</strong></center></td>
          </tr>
         
        </table>
      </div>


        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>


<!-- -------------------------- *************************************** ---------------------------------- -->

<!-- -------------------------- modal recarga ---------------------------------- -->

<div class="modal fade" id="Recarga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >TAE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


      <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Paquetes</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Recargas</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Servicios</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                <div class="form-group">
                  <label for="">Paquete</label>
                    <select class="form-control" name="paquete" id="paquete" autofocus required>
                    <option value="">Paquete</option>
                        <?php
                        $consul=mysql_query("SELECT * FROM compania_tl WHERE codigo!='TLM' AND codigo!='MUL' AND tipo!='RECARGA'");
                        while($dato=mysql_fetch_array($consul)){
                        ?>
                        <option value="<?php echo $dato['codigo']; ?>"><?php echo $dato['nombre']; ?></option>
                        <?php } ?>
                    </select>
                  </div>
                  <option value="">Monto</option>
                

                <?php echo "<input type='hidden' step='any' name='IdCajero' id='IdCajero' min='0' autocomplete='off' value='$ced'>"; ?>
                
                <select class="form-control" name="MontoPaquete" id="MontoPaquete" required>
                </select>

                <br>
                
                <div class="form-group">
                <label for="">Numero Celular</label>
                  <input class="form-control" type="text" name="numero" id="numero" size="20"  maxlength="10" required autocomplete="off">
                </div>

                <div class="form-group">
                <label for="">Confirmar Numero Celular</label>
                  <input class="form-control" type="text" name="numero1" id="numero1" size="20" maxlength="10" required autocomplete="off">
                </div>

                <p id="msgerror" style="color:red;"></p>
              <button type="button" class="btn btn-primary" onclick="paquete();"> Cobrar</button>
   
  
  
  
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

              <div class="form-group">
                  <label for="">Compañía</label>
                  <select class="form-control" name="compania" id="compania" autofocus required>
                    <option value="">Compañia</option>
                    <?php
                    $consul=mysql_query("SELECT * FROM compania_tl WHERE codigo!='TLM' AND codigo!='MUL' AND tipo!='DATOS'");
                    while($dato=mysql_fetch_array($consul)){
                    ?>
                    <option value="<?php echo $dato['codigo']; ?>"><?php echo $dato['nombre']; ?></option>
                    <?php } ?>
                  </select>
                </div>


                <option value="">Monto</option>

                <?php echo "<input type='hidden' step='any' name='IdCajero' id='IdCajero' min='0' autocomplete='off' value='$ced'>"; ?>
                <select class="form-control" name="montor" id="montor" required>
                </select>
                <br>

                <div class="form-group">
                <label for="">Numero Celular</label>
                  <input class="form-control" type="text" name="numeror" id="numeror" size="20"  maxlength="10" required autocomplete="off">
                </div>

                <div class="form-group">
                <label for="">Confirmar Numero Celular</label>
                  <input class="form-control" type="text" name="numeror1" id="numeror1" size="20"  maxlength="10" required autocomplete="off">
                </div>

                <p id="msgerror" style="color:red;"></p>
              <button type="button" class="btn btn-primary" onclick="recarga();"> Cobrar</button>
              
         



  </div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">


            <h5>Por el pago de este servico se cobrará 12 pesos de comisión</h5>
            <br>
          
               <?php echo "<input type='hidden' step='any' name='IdCajero' id='IdCajero' autocomplete='off' value='$ced'>"; ?>

                <select class="form-control" name="servicio" id="servicio" autofocus required>
                  <option value="">Servicio</option>
                  <?php
                  $consul=mysql_query("SELECT * FROM pagoservicios");
                  while($dato=mysql_fetch_array($consul)){
                  ?>
                  <option value="<?php echo $dato['CodigoProducto']; ?>"><?php echo $dato['NombreServicio']; ?></option>
                  <?php } ?>
                </select>

                <br>
                <div id="Servicio2"></div>
                <p id="msgerrorServicio" style="color:red;"></p>
       
              <button type="button" class="btn btn-primary" onclick="servicios();"> Cobrar</button>
             
  
  </div>
</div>








        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>



<!-- -------------------------- *************************************** ---------------------------------- -->

<!-- <div id="modalDetalle" style="display:none;" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalle Caja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div id="detalleCaja" ></div>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div> -->


<div data-keyboard="false" data-backdrop="static" id="modalDetalle" class="modal fade"  style="display:none;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Detalle Caja</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
          <!-- <span aria-hidden="true">&times;</span> -->
        </button>
      </div>
      <div class="modal-body">


      <div id="detalleCaja" ></div>


        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cerrarModal();" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>



<!-- ---------------------------------- modal respuesta --------------------------------------- -->
<div class="modal fade" id="respuesta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >ALERTA CORTE DE CAJA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p align="center" class="text-info"><strong>El usuario es incorrecto ó no cuenta con los permisos necesarios</strong></p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<!-- -------------------------- *************************************** ---------------------------------- -->




<script type="text/javascript">
$(function () {
	
    $('#servicio').change(function ()
	{
        $('#Servicio2').load('Servicios2.php?servicio=' + this.options[this.selectedIndex].value)
 
	})
})


$(function () {
	
    $('#servicio').keyup(function ()
	{
        $('#Servicio2').load('servicios.php?servicio=' + this.options[this.selectedIndex].value)
 
	})
})
</script>

<script>
// show the modal onload
$('#ModMovimientos').modal({
    show: true
});
</script>
<?php
function ProductoNormal()
{
  $can=mysql_query("SELECT * FROM caja_tmp where (cod='$codigo' or nom='$codigo') and usu='$nom_usu'");
  if($dato=mysql_fetch_array($can) && $iccid == "")
  //if($dato=mysql_fetch_array($can))
  {
    //-------------------------------------------
    if (($dato['exitencia']-$dato['cant'])>0) {
        $acant=$dato['cant']+1;
        $dcodigo=$dato['cod'];
        //----------------------------------------
        $ventapublico=$dato['venta'];            
        if($dato['cant']>=5-1)
        {
          $id_sucu=$_SESSION['id_sucursal'];
          $consulta = "SELECT mayor FROM producto WHERE cod = '$dcodigo' AND id_sucursal = '$id_sucu'";
          $execquery=mysql_query($consulta);
          $dato=mysql_fetch_array($execquery);
          $preciomayoreo=$dato['mayor'];
          $aventa=($preciomayoreo*$acant);
          $ventapublico=$preciomayoreo;

        }else{
        $aventa=$dato['venta']*$acant;
        }
        //-------------------------------------------------
        //*************************************************************************************************************************
        $sql="UPDATE caja_tmp Set venta='$ventapublico', importe='$aventa', cant='$acant',tipo_comision='$tipo_comision' WHERE cod='$dcodigo'";mysql_query($sql); 
        //*************************************************************************************************************************
    }else {
          echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>No hay exitencia del producto</strong></div>';
        }
    //-------------------------------------------
  }else
  {
      $cans=mysql_query("SELECT * FROM producto where id_sucursal = '$id_sucursal' AND (cod='$codigo' or nom='$codigo')");
      if($datos=mysql_fetch_array($cans)){
        $cod=$datos['cod'];
      #ver que tipo de venta es
        if($_SESSION['tventa']=="venta"){
        $importe=$datos['venta']; $venta=$datos['venta'];
        }else{
          if ($_SESSION['tventa']=="mayoreo") {
            $importe=$datos['mayor']; $venta=$datos['mayor'];
          }else {
            $importe=$datos['especial'];  $venta=$datos['especial'];
          }
        }
      #fin ver que tipo de venta es
      #obtener tipo de producto
        $comision = $datos['id_comision'];
        $quer=mysql_query("SELECT * FROM comision where id_comision = '$comision'");
        if($row=mysql_fetch_array($quer)){
          $tipo_pro = $row['tipo'];
        }
      #fin obtener tipo de producto
      #verificar si existe el identificador
        if ($tipo_pro == "TELEFONO" OR $tipo_pro == "FICHA" OR $tipo_pro == "CHIP") {
            $bim = 0; $bic = 0; $bid = 0;
            $bt = 0; $bc = 0; $bf = 0;
            $que1=mysql_query("SELECT * FROM codigo_producto WHERE identificador = '$imei' AND id_producto = '$cod' AND estado = 's'");
            if($rows1=mysql_fetch_array($que1)){
              $bim = 1;
            }
            $que2=mysql_query("SELECT * FROM codigo_producto WHERE identificador = '$iccid' AND id_producto = '$cod' AND estado = 's'");
            if($rows2=mysql_fetch_array($que2)){
              $bic = 1;
            }
            $que3=mysql_query("SELECT * FROM codigo_producto WHERE identificador = '$identi' AND id_producto = '$cod' AND estado = 's'");
            if($rows3=mysql_fetch_array($que3)){
              $bid = 1;
            }
        #venta telefono
          if ($tipo_pro == "TELEFONO") {
            if ($bim == 1 && $bic == 1 && !empty($bic)) {
              //guardar el registro
              $bt = 1;
            }else {
              if (!empty($bic)) {
                echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>IMEI ó ICCID no existe</strong></div>';
              }else {
                if ($bim == 1) {
                  $bt = 1;
                }else {
                  echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>IMEI no existe</strong></div>';
                }
              }
            }
          }
        #fin venta telefono
          if ($tipo_pro == "CHIP") {
            if ($bic == 1) {
              //guardar el registro
              $bc = 1;
            }else {
              echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>ICCID no existe</strong></div>';
            }
          }
          if ($tipo_pro == "FICHA") {
            if ($bid == 1) {
              //guardar el registro
              $bf = 1;
            }else {
              echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>IDENTIFICADOR no existe</strong></div>';
            }
          }
      #fin verificar si existe el identificador
          if ($bt == 1 OR $bc == 1 OR $bf == 1) {
            if ($datos['cantidad'] < 1) {
              echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>No hay existencia del producto</strong></div>';
            }else {
            //*****************OBTENER nombre del producto (CHIP) por su ICCID**************                
            $consultaICCID="SELECT id_producto FROM codigo_producto WHERE identificador = '$iccid';";
            $ejecutar = mysql_query($consultaICCID);
            $dato =mysql_fetch_array($ejecutar);
            $id_producto = $dato['id_producto'];

            $consultaNomProducto ="SELECT nom FROM producto WHERE cod = '$id_producto' LIMIT 1;";
            $ejecutar = mysql_query($consultaNomProducto);
            $dato =mysql_fetch_array($ejecutar);
            $nombre_productochip = $dato['nom'];
            //******************************************************************************/
              $cod=$datos['cod'];$nom=$datos['nom'];$cant="1";$exitencia=$datos['cantidad'];$usu=$_SESSION['username'];
              $sql="INSERT INTO caja_tmp (cod, nom, venta, cant, importe, exitencia, usu,imei,iccid,n_ficha,nombre_chip,tipo_comision) VALUES ('$cod','$nom','$venta','$cant','$importe','$exitencia','$usu','$imei','$iccid','$identi','$nombre_productochip','$tipo_comision')";
              mysql_query($sql);
            }
          }
        }else {
          if ($datos['cantidad'] < 1) {
            echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>No hay existencia del producto</strong></div>';
          }else {
            if (empty($imei) && empty($iccid) && empty($identi)) {
              $cod=$datos['cod'];$nom=$datos['nom'];$cant="1";$exitencia=$datos['cantidad'];$usu=$_SESSION['username'];

              $sql="INSERT INTO caja_tmp (cod, nom, venta, cant, importe, exitencia, usu,tipo_comision) VALUES ('$cod','$nom','$venta','$cant','$importe','$exitencia','$usu','$tipo_comision')";
              mysql_query($sql);
             } 
          }
        }
      }else{
        echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">X</button><strong>Producto no encontrado en la base de datos<br><a href="#mydatos" role="button" class="btn btn-success" data-toggle="modal">Crear Nuevo Producto </a></strong></div>';
      }
  }

}
?>








<div style="display: none" id="modalID">
<div  class="modal" id="modalAviso" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">RECORDATORIO DE PAGO</h5>
          </div>
          <div class="modal-body">

            <p><strong>Estimado Usuario, </strong></p>
            <div id="mensajePago" align="justify"></div>
          
              <div align="right">
              <img  src="img/personaje-09.png">
              </div>

              <!-- height="42" width="42" -->
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">cerrar</button>
          </div>
        </div>
      </div>
    </div>
</div>




