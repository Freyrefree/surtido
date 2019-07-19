<?php

 		session_start();

    include('php_conexion.php'); 
    
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
    }
    
    $id_sucursal = $_SESSION['id_sucursal'];
    $can=mysql_query("SELECT * FROM empresa where id='$id_sucursal'");
    
		if($dato=mysql_fetch_array($can)){
			$empresa=$dato['empresa'];
			$nit=$dato['nit'];
			$direccion=$dato['direccion'];
			$ciudad=$dato['ciudad'];
			$tel1=$dato['tel1'];
			$tel2=$dato['tel2'];
			$web=$dato['web'];
			$correo=$dato['correo'];
    }
    
		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 		$hoy=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y');
    $fech=date("Ymd");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Reporte Estado Inventario</title>

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
											<p class="black font-weight-bold titulo text-center">REPORTE ESTADO INVENTARIO</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            
                                        </div>

                                        <div class="col-md-3">                        
                                            
                                        </div>

										                    <div class="col-md-3">                        
                                            
                                        </div>

                                        <div class="col-md-3">
											                  <a href="PDFestado_inventario.php" class="red"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
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




              <?php


$codigoHTML='



  <table id="exampleA" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">

  <thead>
          <tr>
            <th colspan="6"><center>Productos de Baja Existencia</center></th>
          </tr>
          <tr>
            <th>Codigo</th>
            <th>Descripcion del Producto</th>
            <th>Costo</div></th>
            <th>Venta a por Mayor</div></th>
            <th>Valor Venta</div></th>
            <th>Existencia></th>
          </tr>  </thead><tbody>
          ';
        
            $mensaje='no';$num=0;
            $can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$id_sucursal'");
            while($dato=mysql_fetch_array($can)){
                $cant=$dato['cantidad'];
                $minima=$dato['minimo'];
				$num++;
				$resto = $num%2; 
				if ((!$resto==0)) { 
					$color="#CCCCCC"; 
				}else{ 
					$color="#FFFFFF";
				}
                if($cant<=$minima){
                    $mensaje='si';
        
        $codigoHTML.='
          <tr>
            <td>'.$dato['cod'].'</td>
            <td>'.$dato['nom'].'</td>
            <td>$ '.number_format($dato['costo'],2,",",".").'</td>
            <td>$ '.number_format($dato['mayor'],2,",",".").'</td>
            <td>$ '.number_format($dato['venta'],2,",",".").'</td>
            <td>'.$cant.'</td>
          </tr>';
         }} 
		 $codigoHTML.='</tbody>
  </table>';
       
       if($mensaje=='no'){	$codigoHTML.='<div align="center">No existen articulos bajos de stock!</div>'; } 
	   $codigoHTML.='
	   

  <table id="exampleB" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
  <thead>
  <tr>
    <th colspan="7"><center>Listado y Totales de Productos</center></th>
  </tr>
  <tr>
    <th>Codigo</th>
    <th>Descripcion del Producto</th>
    <th>Costo</th>
    <th>Venta a por Mayor</th>
    <th>Valor Venta</th>
    <th>Existencia</th>
    <th>Valor Total</th>
  </tr>
</thead><tbody>';
        
            $mensaje2='no';$costo=0;$mayor=0;$venta=0;$art=0;$num=0;
            $can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$id_sucursal'");
            while($dato=mysql_fetch_array($can)){
                $cant=$dato['cantidad'];
                $minima=$dato['minimo'];
                $mensaje2='si';
                $art=$art+$cant;
                $costo=$costo+($dato['costo']*$dato['cantidad']);
                $mayor=$mayor+($dato['mayor']*$dato['cantidad']);
                /*$mayor+*/$venta=$venta+($dato['venta']*$dato['cantidad']);
                $sumproduct=$dato['venta']*$dato['cantidad'];
                if($cant<=$minima){
                    $cantidad=$cant;
                }else{
                    $cantidad=$cant;
                }
				
				$num++;
				$resto = $num%2; 
				if ((!$resto==0)) { 
					$color="#CCCCCC"; 
				}else{ 
					$color="#FFFFFF";
				}
        
        $codigoHTML.='
          <tr>
            <td>'.$dato['cod'].'</td>
            <td>'.$dato['nom'].'</td>
            <td>$ '.number_format($dato['costo'],2,",",".").'</td>
            <td>$ '.number_format($dato['mayor'],2,",",".").'</td>
            <td>$ '.number_format($dato['venta'],2,",",".").'</td>
            <td>'.$cantidad.'</td>
            <td>$ '.number_format($sumproduct,2,",",".").'</td>
          </tr>';
           }
           $codigoHTML.='</tbody></table>';


            if($mensaje2=='2'){
          $codigoHTML.='
          
            <div align="center">
              No hay artículos registrados actualmente.
            </div>';

          	}
			$codigoHTML.='
          <table class="table">
            <thead>
              <tr>
                <td colspan="2">Totales:</td>
                <td>$ '.number_format($costo,2,",",".").'</td>
                <td>$ '.number_format($mayor,2,",",".").'</td>
                <td>$ '.number_format($venta,2,",",".").'</td>
                <td>'.$art.'</td>
                <td>$ '.number_format($venta,2,",",".").'</td>
              </tr>
            </thead>
        </table>';

echo $codigoHTML;


?>



						
								
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

$(document).ready(function() {

  tabla();

});


function tabla(){

  $('#exampleA').DataTable({
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

