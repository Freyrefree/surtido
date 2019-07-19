<?php
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
   
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liberar Reparacion</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="jsV2/jquery-3.1.1.js"></script>
    <script type="text/javascript" src="jsV2/tether.min.js"></script>
    <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- SWAL -->
        <script src="js/sweetalert2.all.min.js"></script>
    <!--**-->

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
											<p class="black font-weight-bold titulo text-center">LIBERAR REPARACIÓN</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            <button type="button" class="btn btn-info" onClick="window.location='nueva_reparacion.php'">Nueva Reparación</button>
                                        </div>

                                        <div class="col-md-3">                        
                                            <button type="button" class="btn btn-info" onClick="window.location='reparaciones.php'">Listado Reparaciones</button>
                                        </div>

                                        <div class="col-md-2">                        

                                        </div>
                                    </div>
                  
                                    <br>

									<div class="row">
										<div class="col-md-4">
                      
                                            <form method="POST" id="formLiberar" >

                                                <div class="form-group">
                                                    <label for="">Ingrese el Número de Reparación</label>
                                                    <input type="text" class="form-control" name="noReparacion" id="noReparacion" onkeypress="return isNumberKey(event)" required>
                                                </div>
                                                <button type="button" id="btnBuscar" onclick="buscaReparacion();" class="btn btn-primary">Buscar</button>

                                                    <div id="detalle" style="display:none">

                                                        <div class="form-group">
                                                            <label for="">Equipo</label>
                                                            <input class="form-control" type="text" id="equipo" name="equipo" readonly>                                                        
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Resto reparación</label>                                                  
                                                            <input type="number" class="form-control" name="resto" id="resto"  min="0" step="any" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="ccpago">Descripción Liberación</label>
                                                            <textarea class="form-control" name="descripLi" id="descripLi" rows="4" cols="10"></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Dinero Recibido</label>                                                        
                                                            <input type="number" class="form-control" name="dineroRecibo" id="dineroRecibo"  min="0" step="any" required>
                                                        </div>

                                                            <button type="submit" id="btnLiberar" class="btn btn-primary">Aceptar</button>
                                                            <button type="button" id="btnCancelar" onclick="cancelar();" class="btn btn-primary">Cancelar</button>

                                                    </div>

                                            </form>
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

</body>
</html>

<!-- ************** -->
<script>

function cancelar(){

    $("#btnBuscar").show();
    $("#detalle").hide();
    $('#noReparacion').prop('readonly', false);
    $("#dineroRecibo").val("");
    $("#descripLi").val("");
}

function buscaReparacion(){
    var noReparacion = $("#noReparacion").val();
    var longitud = 0;

    if(noReparacion != ""){

        $.ajax({
        method: "POST",
        url: "consultaReparacion.php",
        dataType: "json",
        data:{id:noReparacion}
        })
        .done(function(respuesta) {
            longitud = respuesta.length;
            //alert(longitud);
            if(longitud == 1)
            {
                
                $("#btnBuscar").hide();
                $('#noReparacion').prop('readonly', true);

                $.each(respuesta, function(key, item) {
                    $("#equipo").val(item.marca + " " +item.modelo);
                    $("#resto").val(item.resto);
                    $("#detalle").show();
                });

            }
            
        });

    }else{
        swal("Precaución", "Por favor ingrese el número de reparacion", "warning");
    }
}





$(document).ready(function() 
{
    $('#formLiberar').submit(function(e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        
        var dineroRecibo = $("#dineroRecibo").val();
        var resto = $("#resto").val();

        data.push({name: 'resto', value: resto});
        data.push({name: 'dineroRecibo', value: dineroRecibo});

        var id = $("#noReparacion").val();
        //alert(dineroRecibo +" " + id);
        $.ajax({
            method: "POST",
            url: "LiberarReparacionForm2.php",
            data: data
        })
        .done(function(respuesta) {
                if(respuesta == 1)
                {
                    //location.reload();
                    location.href = "cobroReparacionFinal.php?idReparacion="+id+"&dineroRecibo="+dineroRecibo;

                }else if(respuesta == 2){         
            
                    swal("Precaución", "Sólo el cajero o administrador puden liberar la reparación", "warning");		

                }else if(respuesta == 3){                
            
                    swal("¡ERROR!", "La reparación no está terminada", "error");	

                }else if(respuesta == 4){
                    swal("¡ERROR!", "No se pudo liberar la reparación", "error");

                }else if(respuesta == 5){
                    swal("¡ERROR!", "¡La reparación ya está liberada!", "error");

                }else if(respuesta == 6){
                    swal("¡ERROR!", "¡Intente de nuevo por favor la Sesion ha Caducado. Cierre el Sistema e Inicie de nuevo", "error");
               
                }else if(respuesta == 7){
                    swal("¡ERROR!", "El dinero recibido es menor al resto de la reparación", "error");
                }
            });
        
    })
});

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>
