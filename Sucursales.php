<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Listado Sucursales</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="jsV2/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="jsV2/tether.min.js"></script>
  <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <!-- DATA TABLE -->
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
											<p class="black font-weight-bold titulo text-center">SUCURSALES</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            <button type="button" class="btn btn-info" onClick="window.location='AgregarSucursal.php'">Nueva Sucursal</button>
                                        </div>

                                        <div class="col-md-3">                        
                                            
                                        </div>
                                        <div class="col-md-3">                        
                                            
                                        </div>

                                        <div class="col-md-3">

                      

                                        </div>
                                    </div>
<hr>
                                    <div class="row">
                                      <div class="col-md-12">

                                      <div id="tablaSucursales"></div>
                                                      
                                      </div>
                                    </div>
                  
                                    <br>

									<div class="row">
										<div class="col-md-12">
                      

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



<!-- ***************************************************************************************************************************************** -->


<div id="modalExistencias" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle Productos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="modalExistenciasmsgg"></div>
        <div id="modalExistenciasmsg"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>

<!-- ************************************************************************************************************ -->
<!-- ************************* -->

<div id="modalConfirmar" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle Productos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="msgConfirmar"></div>      
      </div>
      <div class="modal-footer">
        <button class="btn" id="btnConfirmar" onclick="confirmar(this.value)" data-dismiss="modal" aria-hidden="true">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<!-- ************************* -->


<script type="text/javascript">
$(document).ready(function(){

  $.ajax({
      method:"POST",
      url:"listaSucursales.php",
      data: {}
    }).done(function(respuesta){
      $("#tablaSucursales").html(respuesta);
      tabla();
    })

});

function eliminarSucursal(id)
{
  var contador = 0;
  var table = "<table id='exampleB' class='table table-striped table-bordered dt-responsive nowrap' style='width:100%'><thead><tr><th>Codigo Producto</th><th>Nombre Producto</th><th>Existencias</th></tr></thead><tbody>";
  //alert(id)'
  $.ajax({
      method:"POST",
      url:"eliminarSucursal.php",
      dataType: "json",      
      data: {id_sucursal : id , opc : 1},
    }).done(function(respuesta){
      if(respuesta != 1)
      {

        $.each(respuesta, function(key, item) {
        contador++;
        table += "<tr><td>"+ item.id_producto +"</td><td>"+ item.nombre_producto +"</td><td>"+ item.cantidad +"</td></tr>";
        });
        table += "</tbody></table>";

        $("#modalExistenciasmsgg").html("No se puede eliminar, hay productos con existencias en esa sucursal. Se presentan a continuación:");
        $("#modalExistenciasmsg").html(table);
        tablaB();
        
        $('#modalExistencias').modal('show');
      }else{
        //alert(respuesta);
        $("#msgConfirmar").html("¿Está seguro que desea eliminar la sucursal?")
        $("#btnConfirmar").val(id);
              
        $('#modalConfirmar').modal('show');
      }

    })
}
function confirmar(id)
{
  //alert(id);
  $.ajax({
    method: "POST",
    url: "eliminarSucursal.php",
    data: { id_sucursal : id, opc : 2 }
    }).done(function(respuesta) {
        //alert( "Data Saved: " + msg );
        if(respuesta == 1)
        {
          location.href = "Sucursales.php";
        }
    });
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


function tablaB(){

$('#exampleB').DataTable({
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