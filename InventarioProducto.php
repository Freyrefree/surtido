<?php
		session_start();
		include('php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		include("MPDF/mpdf.php");
    	$mpdf=new mPDF('utf-8' , 'A4','', 15, 15, 15, 10, 15, 10);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Reporte Productos</title>

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
											<p class="black font-weight-bold titulo text-center">REPORTE PRODUCTOS</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3"> 
											<a href="#" onClick="pdfticketcorte();" class="red"><i class="fa fa-ticket fa-2x" aria-hidden="true"></i></a>
                                        </div>

                                        <div class="col-md-3">                        
											<a href="#" onClick="pdfcorte();" class="red"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                                        </div>

										<div class="col-md-3">                        
											<a href="#" onClick="excelcorte();" class="green"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></a>
                                        </div>

                                        <div class="col-md-3">
											
                                        </div>
                                    </div>
									<hr>

									<div class="row">
                                        <div class="col-md-3">

											<i class="fa fa-shopping-cart" aria-hidden="true"></i>
											<label for="" class="col-form-label">Tipo Producto</label>
											<select class="form-control" name="product" id="product">
											<option value="Todos" selected>TODOS </option>
											<?php 
												$can=mysql_query("SELECT * FROM comision WHERE tipo != 'REPARACION' AND tipo != 'RECARGA'");
												while($dato=mysql_fetch_array($can)){
											?>
											<option value="<?php echo $dato['id_comision']; ?>"><?php echo $dato['nombre']; ?></option>
											<?php } ?>
											</select>
										                       
                                            
                                        </div>
                                        <div class="col-md-3">
											<i class="fa fa-shopping-basket" aria-hidden="true"></i>
											<label for="" class="col-form-label">Sucursal/s</label>
											<select class="form-control" name="sucursal" id="sucursal">
												<option value="Todos" selected>TODOS </option>
												<?php 
													$can=mysql_query("SELECT id,empresa FROM empresa");
													while($dato=mysql_fetch_array($can)){
												?>
												<option value="<?php echo $dato['id']; ?>"><?php echo $dato['empresa']; ?></option>
												<?php } ?>
											</select>                       

                                        </div>

										<div class="col-md-3">
											<i class="fa fa-search" aria-hidden="true"></i>
											<label for="" class="col-form-label">Coincidencias</label>
											<input class="form-control" type="text" id="coin" name="coin">
                                        </div>

                                        <div class="col-md-3"><br>
											<button type="button" class="btn btn-primary" onClick="consultacortes();" >Consultar</button>
											
											
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

							<div id="recargado"></div>

							





<!-- <table class="table">
  <tr>
    <td>
	<p>
	<div id="recargado">
		<div id="TicketPdf" width="300px"></div>
	</div>
	</p>
	</td>
  </tr>
</table> -->


		


								
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>




	
</body>
</html>

<!--*************** Modal *********************************-->


<div id="myModal" class="modal">

  <div class="modal-content">
    <span class="close">&times;</span>
    <embed src="InventarioTicket/Listado_Productos.pdf?#zoom=50" width="100%" height="300" internalinstanceid="2" title>
  </div>

</div>

<!-- ****************************************************** -->


<script>


	function consultacortes(){
		var producto = document.getElementById("product").value;
		var sucursal = document.getElementById("sucursal").value;
		var coin = document.getElementById("coin").value;
		$.post("PDFproducto_p.php",
			   {producto: producto,
			   	sucursal: sucursal,
			   	coin: coin
			   },
			   function(data){		
	         $("#recargado").html(data);
			 tabla();
		});			
	}

	function pdfticketcorte(){
	var producto = document.getElementById("product").value;
	var sucursal = document.getElementById("sucursal").value;
	var coin = document.getElementById("coin").value;

var parametros = {
		   		producto: producto,
		   		sucursal: sucursal,
			   	coin: coin
        };
        //$.ajax({
              //  data:  parametros,
              //  url:   'PDFproductoSucursalTicket.php',
              //  type:  'post',
              ///  beforeSend: function () {
              //  },
               // success:  function (response) {
					window.location = 'PDFproductoSucursalTicket.php?producto='+producto+'&sucursal='+sucursal+'&coin='+coin;
					//modal.style.display = "block";
               // }
      //  });

	}

	function pdfcorte(){
	
	var producto = document.getElementById("product").value;
	var sucursal = document.getElementById("sucursal").value;
	var coin = document.getElementById("coin").value;
	var parametros = {
		   		producto: producto,
		   		sucursal: sucursal,
			   	coin: coin
        };
        $.ajax({
                data:  parametros,
                url:   'PDFproductoSucursal.php',//
                type:  'post',
                beforeSend: function () {
                },
                success:  function (response) {
					window.location = 'PDFproductoSucursal.php?producto='+producto+'&sucursal='+sucursal+'&coin='+coin;
                }
        });
	}
	
	function excelcorte(){
	
	var producto = document.getElementById("product").value;
	var sucursal = document.getElementById("sucursal").value;
	var coin = document.getElementById("coin").value;
	var parametros = {
		   		producto: producto,
		   		sucursal: sucursal,
			   	coin: coin
        };
        $.ajax({
                data:  parametros,
                url:   'ExcelProductoSucursal.php',
                type:  'post',
                beforeSend: function () {
                },
                success:  function (data) {
					window.location = 'ExcelProductoSucursal.php?producto='+producto+'&sucursal='+sucursal+'&coin='+coin;
                }
        });
	}
</script>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}









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



