<?php
     // session_start();
     include_once 'APP/config.php';
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

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Listado Reparaciones</title>


  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="jsV2/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="jsV2/tether.min.js"></script>
  <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


  <!-- "DATA TABLE" -->
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

  <!-- ********* -->

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

<script>
function detalleReparación(uid)
{
 
  
  $.ajax({
            type:'POST',
            url:'modalDetalleReparacion.php',
            dataType: "json",
            data:{id_reparacion : uid},
            success:function(data){                
              $("#tablaDetalleReparacion").html(data.html);
            }
        });

    // $("#modalDetalle").modal("show");
    $('#modalDetalle').modal('show')


}
</script>


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

<?php if (!empty($_GET['error'])) { ?>
<script>
  $(function() {
      $('#Cambio').modal('show');
      $('#error').text("Codigo del cliente no Valido");
  })
</script>
<?php } ?>


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
											<p class="black font-weight-bold titulo text-center">LISTADO DE REPARACIONES</p>
										</div>
									</div>

                  <div class="row">
                    <div class="col-md-3">                        
                        <button type="button" class="btn btn-info" onClick="window.location='nueva_reparacion.php'">Nueva Reparación</button>
                    </div>
                    <div class="col-md-3">                        
                      <button type="button" class="btn btn-success" onClick="window.location='liberarReparacionForm.php'">Liberar Reparación</button>
                    </div>

                    <div class="col-md-4">                        
                      <input type="text" class="form-control" id="criterio" name="criterio" placeholder="No Reparacion|Cliente|Cod Cliente|Teléfono.">
                    </div>

                    <div class="col-md-2">                        
                      <button class="btn btn-primary" onclick="listadoPrincipal();">Buscar</button>
                      <i id="loading" class="fa fa-circle-o-notch fa-spin fa-2x fa-fw" style="color:#007bff; display:none;"></i>                   
                    </div>
                  </div>
                  
                  <br>

									<div class="row">
										<div class="col-md-12">
                      <div id="divListaPrincipal"></div>
										</div>
									</div>

								</div>

							</div>

							<div class="col-md-12">
								
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


<!-- modal muestra cambio si lo hay -->
<!-- <div id="Cambio" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">ENTREGA REPARACION</h3>
  </div>
  <div class="modal-body">
      <p align="center" class="text-info"><strong>Estado</strong></p>
      <pre style="font-size:30px; text-align:center" id="cambioresto"><center id="error"></center></pre>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div> -->



<div class="modal fade" id="Cambio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="" >ENTREGA REPARACION</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p align="center" class="text-info"><strong>Estado</strong></p>
        <pre style="font-size:30px; text-align:center" id="cambioresto"><center id="error"></center></pre> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -- myCredito -->











<!--************************************ Modal mensajes  **************************************************************************-->

<!-- <div id="modalRespuestas" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
</div> -->





<div class="modal fade" id="modalRespuestas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="" >REPARACIONES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <center><div id="modalRespuestasmsg"></div></center>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<!-- ********************************************************************************************************************************-->
<!--************************************ Modal confirmar CANCELAR o ACEPTAR  ********************************************************-->
<!-- <div id="modalConfirmar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
</div> -->

<div class="modal fade" id="modalConfirmar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="" >REPARACIONES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <center><div id="modalConfirmarmsg"></div></center>

      </div>
      <div class="modal-footer">
        <button type="button" id="btnAceptar" onclick="confirmarCancelarRepa(this.value)" class="btn btn-primary">Aceptar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<!-- ******************************************************************************************************************************** -->
<!--************************************ Modal cloncluir reparación  ********************************************************-->
<!-- <div id="modalConcluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
</div> -->



<div class="modal fade" id="modalConcluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="" >REPARACIONES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <center><div id="modalConcluirmsg"></div></center>
        <br>
        <div id="modalConcluirEquipo"></div>

      </div>
      <div class="modal-footer">
        <button type="button" id="btnTerminar" onclick="reparacionTerminada(this.value)" class="btn btn-primary">Aceptar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- ******************************************************************************************************************************** -->
<!-- ******************************************************************************************************************************** -->
<!-- <div id="ModalLiberar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
</div> -->


<div class="modal fade" id="ModalLiberar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="" >REPARACIONES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- ******************************************************************************************************************************** -->

<!-- ********************* Modal Reingreso ************************** -->
<!-- <div id="Garantia" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
</div> -->






<div class="modal fade" id="Garantia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="" >REPARACIONES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- ************************************************************************************************** -->
<!--************************* Modal MyObservacion ************************************************** -->
<!-- <div id="Observacion" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
</div> -->


<div class="modal fade" id="Observacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="" >REPARACIONES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p align="center" class="text-info"><strong id="nom_telef"></strong></p>
          <div align="center">

              <label for="observacion" class="text-info"><strong>Escribe un comentario</strong></label>

              <div class="form-group">
                
                <textarea class="form-control" id="txtobservacion" name="txtobservacion" rows="3"></textarea>
              </div>

              <!-- <center><textarea name="txtobservacion" id="txtobservacion" cols="625" rows="8" value="" maxlength="380"></textarea></center>           -->
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" id="btnObservacion" onclick="agregarObservacion(this.value)" class="btn btn-primary">Aceptar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
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

<!--************** Modal detalle o ver más *******************************-->
<!-- <div id="modalDetalle" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
</div> -->

<div class="modal fade" id="modalDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="myModal" >DETALLE REPARACIÓN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="tablaDetalleReparacion"></div>     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
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
  $("#loading").show()
  var criterio = $("#criterio").val();

  $.ajax({
  method: "POST",
  url: "listaReparaciones.php",
  data: { criterio: criterio}
  })
  .done(function(respuesta) {

    $("#divListaPrincipal").html(respuesta);
    tabla();
    $("#loading").hide()

  });


}

//función para cargar datos desde el principio
$( document ).ready(function() {
  $("#loading").show()
  var criterio = $("#criterio").val();


  $.ajax({
  method: "POST",
  url: "listaReparaciones.php",
  data: { criterio: criterio}
  })
  .done(function(respuesta) {



    $("#divListaPrincipal").html(respuesta);
    tabla();

    $("#loading").hide()
    
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

<script>
function tabla(){

  $('#example').DataTable({
                "ordering": true,
                "language": {
                    "paginate": {
                        "previous": "<i class='mdi mdi-chevron-left'>",
                        "next": "<i class='mdi mdi-chevron-right'>"
                    }
                },
                language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
                },
               
            });

}
       
 </script>



     
<!--********************************************************************************************-->