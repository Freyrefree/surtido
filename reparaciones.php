<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
    $id_sucursal = $_SESSION['id_sucursal'];
    
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
        if (!empty($_GET['id'])) {
            $identificador = $_GET['id'];
            /*echo "el valor obtenido es ".$identificador;*/
        }
    $fechay=date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado Reparaciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
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

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <!-- MODAL LOAD -->
		  <script src="js/jquery.loadingModal.min.js" type="text/javascript"></script>		
		  <link href="css/jquery.loadingModal.css" rel="stylesheet" type="text/css"/>
	  <!--  -->



    <?php if (!empty($_GET['error'])) { 
        ?>
     <script>
            $(function() {
                $('#Cambio').modal('show');
                $('#error').text("Codigo del cliente no Valido");
            })
     </script>
     <?php } ?>
    <script>      
        

        function cambiofecha(id){
        $.ajax({
            type: "POST", 
            url: "PostLiberacion.php",
            data: "id="+id,
            success: function(msg){
            var valores = msg.split(",");
            $("#nom_tel").text("Telefono "+valores[0]);
            document.getElementById('fecha').value = valores[1];
            document.getElementById('id_rep').value = id;
            $('#Apertura').modal('show');
            }
        }); 
        }
        function aceptar(){
            $('#Cambio').modal('hide');
        }
    </script>

</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<table width="100%" >
  <tr>
    <td>
      <div class="btn-group" data-toggle="buttons-checkbox">
      <button type="button" class="btn btn-primary" onClick="window.location='nueva_reparacion.php'">Nuevo</button>
      </div>
    </td>
    <td>
      <!-- <div>    
        <div class="input-append">
        <select name="estatus" id="estatus">
          <option value="9" selected="true">Por estatus</option>
          <option value="0">Espera</option>
          <option value="1">Pendiente</option>
          <option value="2">Terminado</option>
          <option value="3">Entregado</option>
        </select>        
        </div>      
      </div> -->
      <div class="form-group">            
        <input type="text" class="form-control" id="criterio" name="criterio" placeholder="No Reparacion|Cliente|Cod Cliente|Teléfono.">
        <small id="fileHelp" class="form-text text-muted"></small>
        <button class="btn" onclick="listadoPrincipal();">Buscar</button>
      </div>
    </td>
  </tr>
</table>

<div id="divListaPrincipal"></div>
</div>


<!-- modal muestra cambio si lo hay -->
<div id="Cambio" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">ENTREGA REPARACION</h3>
  </div>
  <div class="modal-body">
      <p align="center" class="text-info"><strong>Estado</strong></p>
      <pre style="font-size:30px; text-align:center" id="cambioresto"><center id="error"></center></pre>
      <!-- <center>
        <input type="submit" onclick="aceptar()" class="btn btn-success" name="button" id="button" value="Aceptar"/>
      </center> -->
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
<!-- Modal -- myCredito -->
<!--************************************ Modal mensajes  **************************************************************************-->
<div id="modalRespuestas" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-header" id="modalRespuestashead">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">REPARACIONES</h3>
  </div>
  <div class="modal-body">
    <center><div id="modalRespuestasmsg"></div></center>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>
<!-- ********************************************************************************************************************************-->
<!--************************************ Modal confirmar CANCELAR o ACEPTAR  ********************************************************-->
<div id="modalConfirmar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">REPARACIONES</h3>
  </div>
  <div class="modal-body">
    <center><div id="modalConfirmarmsg"></div></center>
  </div>
  <div class="modal-footer">
    <button type="button" id="btnAceptar" onclick="confirmarCancelarRepa(this.value)" class="btn btn-primary">Aceptar</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
  </div>
</div>
<!-- ******************************************************************************************************************************** -->
<!--************************************ Modal cloncluir reparación  ********************************************************-->
<div id="modalConcluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-header">
  

    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">REPARACIONES</h3>
  </div>
  <div class="modal-body">
  

      <center><div id="modalConcluirmsg"></div></center>
      <br>
      <div id="modalConcluirEquipo"></div>
  
  </div>
  <div class="modal-footer">
    <button type="button" id="btnTerminar" onclick="reparacionTerminada(this.value)" class="btn btn-primary">Aceptar</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
  </div>
</div>
<!-- ******************************************************************************************************************************** -->
<!-- ******************************************************************************************************************************** -->
<div id="ModalLiberar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">REPARACIONES</h3>
  </div>
  <div class="modal-body">
      <p align="center" class="text-info"><strong id="nom_tel"></strong></p>
        <div align="center">
        <p align="center" class="text-info"><strong>Liberar Reparación</strong></p>
                  
        <label for="ccpago">Ingrese la Fecha de Entrega</label>
          <input type="date" name="fechaliberar" id="fechaliberar">
            <label for="ccpago">Confirme el número de reparación</label>
            <input type="text" name="codigo_client" id="codigo_client"><br>
            <label for="ccpago">Resto reparación</label>
            <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" name="resto" id="resto"  min="0" step="any" required="" autofocus="" readonly>
            </div>
            <label for="ccpago">Dinero Recibido</label>
            <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" name="dineroRecibo" id="dineroRecibo" autocomplete="on" min="0" step="any" required autofocus>
            </div>

            <label for="ccpago">Descripción Liberación</label>
            <textarea name="descripLi" id="descripLi" rows="4" cols="10"></textarea>
            


        </div>
  </div>
  <div class="modal-footer">
  <button type="button" id="btnLiberar" onclick="liberarReparacionfinal(this.value)" class="btn btn-primary">Aceptar</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>
<!-- ******************************************************************************************************************************** -->

<!-- ********************* Modal Reingreso ************************** -->
<div id="Garantia" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="">REPARACIONES</h4>
  </div>
  <div class="modal-body">
      <p align="center" class="text-info"><strong id="nom_telef"></strong></p>
        <div align="center">
            <label for="" class="text-info"><strong>Motivo de Reingreso</strong></label>
            <center><textarea name="observacionReingreso" id="observacionReingreso" cols="425" rows="8" maxlength="380"></textarea></center>
        </div>
  </div>
  <div class="modal-footer">
    <button type="button" id="btnReingreso" onclick="reingresoReparacionEnviar(this.value)" class="btn btn-primary">Aceptar</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>
<!-- ************************************************************************************************** -->
<!--************************* Modal MyObservacion ************************************************** -->
<div id="Observacion" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <center><h4 id="">OBSERVACION</h4></center>
  </div>
  <div class="modal-body">
      <p align="center" class="text-info"><strong id="nom_telef"></strong></p>
        <div align="center">
            <label for="observacion" class="text-info"><strong>Escribe un comentario</strong></label>
            <center><textarea name="txtobservacion" id="txtobservacion" cols="625" rows="8" value="" maxlength="380"></textarea></center>          
        </div>
  </div>
  <div class="modal-footer">
    <button type="button" id="btnObservacion" onclick="agregarObservacion(this.value)" class="btn btn-primary">Aceptar</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>
<!-- ************************************************************************************************** -->
</body>
</html>

<script>
$(function () {
    $('#ff').change(function ()
	{  
      $("#ff2").val($("#ff").val());
	})
})
</script>

<script>
$(function () {
    $('#fi').change(function ()
	{  
      $("#fi2").val($("#fi").val());
	})
})
</script>
<!--*********************************************************************-->
<script type="text/javascript">
function detalleReparación(uid)
{
  //alert(uid);
  
  $.ajax({
            type:'POST',
            url:'modalDetalleReparacion.php',
            dataType: "json",
            data:{id_reparacion : uid},
            success:function(data){                
              $("#tablaDetalleReparacion").html(data.html);
            }
        });

    $("#modalDetalle").modal("show");


}
</script>
<!--************** Modal detalle o ver más *******************************-->
<div id="modalDetalle" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">DETALLE REPARACIÓN</h3>
  </div>
  <div class="modal-body">
  <div id="tablaDetalleReparacion"></div>     
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>
<!-- ****************************************************************************************************** -->

<!--*************************************************************************************************-->
<script type="text/javascript">
function aceptarCancelarRepa(id_reparacion,confirmar)
{
  var valorBtn = id_reparacion+","+confirmar;
  if(confirmar  == "si")
  {
    $('#btnAceptar').val(valorBtn);
    $('#modalConfirmarmsg').text("¿Desea aceptar la reparación?");
    $("#modalConfirmar").modal("show");
  }
  else if(confirmar == "no")
  {
    $('#btnAceptar').val(valorBtn);
    $('#modalConfirmarmsg').text("¿Desea cancelar la reparación?");
    $("#modalConfirmar").modal("show");
  }
  
}

function confirmarCancelarRepa(valores)
{  
  var array = valores.split(',');
  var id_reparacion = array[0];
  var confirmar = array[1];
  var tipousuario = "<?php echo $_SESSION['tipo_usu'] ?>";
  if(tipousuario == 'te' || tipousuario == 'a')
  {      
    if(id_reparacion != '' && confirmar != '')
    {
      location.href = "AceptarCancelarReparacion.php?id="+id_reparacion+"&act="+confirmar;
    }
  }else
  {
    $("#modalConfirmar").modal("hide");
    $("#modalRespuestashead").css({"background-color":"#db3236","color":"white"});
    $("#modalRespuestasmsg").text("Sólo el Técnico o Administrador pueden aceptar o cancelar la reparación");
    $("#modalRespuestas").modal("show");
  }
}


function enviar(id)
{
  $.ajax({
        type:'POST',
        url:'PostLiberacion.php',
        dataType: "json",
        data:{id : id},
        success:function(data){
          $('#btnTerminar').val(id);                
          $('#modalConcluirmsg').text("¿Desea Concluir la Reparación?");
          $('#modalConcluirEquipo').html(data.tblliberar);
          $("#modalConcluir").modal("show");
        }
    });
}
function reparacionTerminada(id)
{
  var tipousuario = "<?php echo $_SESSION['tipo_usu'] ?>";
  if(tipousuario == 'te' || tipousuario == 'a')
  {      
    if(id != '')
    {
      location.href = "ReparacionLista.php?id_repa="+id;
    }
  }else{
    $("#modalConcluir").modal("hide");
    $("#modalRespuestashead").css({"background-color":"#db3236","color":"white"});
    $("#modalRespuestasmsg").text("Sólo el Técnico o Administrador pueden concluir una reparación");
    $("#modalRespuestas").modal("show");
  }
}

function liberarReparacion(id)
{
  $.ajax({
    method: "POST",
    url: "consultaReparacion.php",
    dataType: "json",
    data:{id:id}
    })
    .done(function(respuesta) {
     
        $.each(respuesta, function(key, item) {
            //alert(item.resto);
            $("#resto").val(item.resto);
            $("#btnLiberar").val(id);
            $("#ModalLiberar").modal("show");
        });
    });
}

function liberarReparacionfinal(id)
{
  var tipousuario = "<?php echo $_SESSION['tipo_usu'] ?>";
  if(tipousuario == 'ca' || tipousuario == 'a')
  {
    
    var fechaLiberacion =  $("#fechaliberar").val();
    var rfcCliente = $("#codigo_client").val();

    var restoReparacion = $("#resto").val();
    var restoReparacion =parseFloat(restoReparacion);
    var dineroRecibo =  $("#dineroRecibo").val();
    var dineroRecibo = parseFloat(dineroRecibo);

    var descripLi = $("#descripLi").val();
    //alert(dineroRecibo);

    if(fechaLiberacion == '')
    {
      $("#fechaliberar").css("border-color", "red");
    }else if(rfcCliente == ''){
      $("#codigo_client").css("border-color", "red");
    }else if(dineroRecibo == ''){
      $("#dineroRecibo").css("border-color", "red");
    }else if(dineroRecibo < restoReparacion){
      //alert(dineroRecibo+"--"+restoReparacion);
      $("#dineroRecibo").css("border-color", "red");
    }else{
      $.ajax({
        method: "POST",
        url: "LiberarReparacion.php",
        data: { codigo_client: rfcCliente, fecha: fechaLiberacion, id_rep : id, descripLi : descripLi}
      })
        .done(function(respuesta) {
          if(respuesta == 0)
          {
            $("#ModalLiberar").modal("hide");
            $("#modalRespuestashead").css({"background-color":"#db3236","color":"white"});
            $("#modalRespuestasmsg").text("Datos Incorrectos, verifique el Número de Reparación, RFC o Código de Cliente");
            $("#modalRespuestas").modal("show");          
          }else if(respuesta == 2)
          {
            $("#ModalLiberar").modal("hide");
            $("#modalRespuestashead").css({"background-color":"#db3236","font-weight":"bold","color":"white"});
            $("#modalRespuestasmsg").text("Error, intente de nuevo");
            $("#modalRespuestas").modal("show"); 
          }else if(respuesta == 1)
          {
            //location.href = "reparaciones.php";
            location.href = "cobroReparacionFinal.php?idReparacion="+id+"&dineroRecibo="+dineroRecibo;
          }        
      });
    }
  }else{

    $("#ModalLiberar").modal("hide");
    $("#modalRespuestashead").css({"background-color":"#db3236","color":"white"});
    $("#modalRespuestasmsg").text("Sólo el Cajero o Administrador pueden concluir una reparación");
    $("#modalRespuestas").modal("show");

  }

}
function reingresoReparacion(id)
{
  $.ajax({
        type:'POST',
        url:'estadoReingreso.php',
        dataType: "json",
        data:{id_reparacion : id},
        success:function(data)
        {
          //////////////
          if(data.estado == 3)
          {
            $("#btnReingreso").val(id);
            $('#Garantia').modal('show');
          }         
        }
    });

}
function reingresoReparacionEnviar(id)
{
  var observacioReingreso = $("#observacionReingreso").val();
  if(observacioReingreso == "")
  {
    $("#observacionReingreso").css("border-color", "red");    
  }else
  {
    $.ajax({
    method: "POST",
    url: "Garantia.php",
    data: { id_repar: id, observacion: observacioReingreso }
    })
    .done(function(respuesta) {
      if(respuesta == 1)
      {
        location.href = "reparaciones.php";
      }else{
          $('#Garantia').modal('hide');
          $("#modalRespuestashead").css({"background-color":"#db3236","font-weight":"bold","color":"white"});
          $("#modalRespuestasmsg").text("Error, intente de nuevo");
          $("#modalRespuestas").modal("show"); 
      }
    });
  }

}

function listadoPrincipal()
{
  var criterio = $("#criterio").val();
  $('body').loadingModal({text: 'Showing loader animations...', 'animation': 'wanderingCubes'});
  $('body').loadingModal('text', 'Consultando');
  $('body').loadingModal('animation', 'foldingCube');
  $('body').loadingModal('color', '#000');
  $('body').loadingModal('backgroundColor', '#F7D358');
  $('body').loadingModal('opacity', '0.9');
  $('body').loadingModal('show');
  $.ajax({
  method: "POST",
  url: "listaReparaciones.php",
  data: { criterio: criterio}
  })
  .done(function(respuesta) {
    $('body').loadingModal('hide');
		$('body').loadingModal('destroy');
    $("#divListaPrincipal").html(respuesta) 
  });


}

//función para cargar datos desde el principio
$( document ).ready(function() {
  var criterio = $("#criterio").val();

  $('body').loadingModal({text: 'Showing loader animations...', 'animation': 'wanderingCubes'});
  $('body').loadingModal('text', 'Consultando');
  $('body').loadingModal('animation', 'foldingCube');
  $('body').loadingModal('color', '#000');
  $('body').loadingModal('backgroundColor', '#F7D358');
  $('body').loadingModal('opacity', '0.9');
  $('body').loadingModal('show');
  $.ajax({
  method: "POST",
  url: "listaReparaciones.php",
  data: { criterio: criterio}
  })
  .done(function(respuesta) {
    $('body').loadingModal('hide');
		$('body').loadingModal('destroy');
    $("#divListaPrincipal").html(respuesta) 
  });
});
///***********************************************
function observacion(id)
{  
  $("#btnObservacion").val(id)
  $('#Observacion').modal('show');
}

function agregarObservacion(id)
{
  var observacion = $("#txtobservacion").val();
  if( observacion == "")
  {
    $("#txtobservacion").css("border-color", "red");
  }else{
    //alert(observacion);
      $.ajax({
      method: "POST",
      url: "registraObservacion.php",
      data: { observacion: observacion , id_reparacion : id}
      })
      .done(function(respuesta) {
        if(respuesta == 1)
        {
          location.href = "reparaciones.php";
        }
        else if(respuesta == 0)
        {
          $('#Observacion').modal('hide');
          $("#modalRespuestashead").css({"background-color":"#db3236","font-weight":"bold","color":"white"});
          $("#modalRespuestasmsg").text("Error, intente de nuevo");
          $("#modalRespuestas").modal("show");          
        }else if(respuesta == 2)
        {
          $('#Observacion').modal('hide');
          $("#modalRespuestashead").css({"background-color":"#db3236","font-weight":"bold","color":"white"});
          $("#modalRespuestasmsg").text("Error, intente de nuevo");
          $("#modalRespuestas").modal("show");          
        }
      });
  }       
}


</script>



     
<!--********************************************************************************************-->