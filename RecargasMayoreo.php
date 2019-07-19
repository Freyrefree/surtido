<?php
         // session_start();
        include_once 'APP/config.php';
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		$id_sucursal = $_SESSION['id_sucursal'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado Producto</title>


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

    <!--********************** Autocomplete **********************-->
    <script src="js/jquery.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
    <!-- ******************************************************** -->

    


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
<?php
    // consulta el saldo virtual de la sucursal  
        $sqle = mysql_query("SELECT * FROM recargassucursal WHERE IdSucursal='$id_sucursal'") or die(print"Error en consulta de saldo virtual".mysql_error());
        if($dat=mysql_fetch_array($sqle)){
                $SaldoVirtual=$dat['Saldo'];
        }
    // fin de consulta el saldo virtual de la sucursal    
?>

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
											<p class="black font-weight-bold titulo text-center">RECARGAS MAYOREO</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-6">                        

                                        </div>

                                        <div class="col-md-4">                        

                                        </div>

                                        <div class="col-md-2">                        
                
                                        </div>
                                    </div>
                  
                                    <br>

									<div class="row">
										<div class="col-md-4">


                                            
                                                
                                                        <h3>Saldo disponible: <?php echo $SaldoVirtual ?></h3>
                                                    <br>
                                                    <form class="form-horizontal" action="CobrarRecargaMayoreo.php" method="POST" name="RecargaMayoreo" id="RecargaMayoreo" target="_self"> 
                                                            
                                                        <div class="form-group">
                                                            <label for="">Compañia</label>
                                                            <select class="form-control" name="compania" id="compania" autofocus required>
                                                                <option value="Telcel">Telcel</option>
                                                                <option value="Multirecargas">Multirecargas</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Monto</label>
                                                            <input type="text" class="form-control" id="monto" name="monto" size="20" style="font-family: Arial;  height:30px; font-size: 20pt;" maxlength="10" required autocomplete="off" required>    
                                                        </div>

                                                        <br>
                                                        
                                                        <div class="ui-widget">
                                                            <div class="form-group">
                                                                <label for="">Cliente</label>
                                                                <?php echo "<input type='hidden' step='any' name='IdCajero' id='IdCajero' autocomplete='off' value='$ced'>"; ?>
                                                                <input type="text" class="form-control" class="client" id="client" name="client" placeholder="Nombre del Cliente" size="20" style="font-family: Arial;  height:30px; font-size: 20pt;" maxlength="10" autocomplete="off" required>
                                                            </div>
                                                        </div>

                                                        <p id="msgerror" style="color:red;"></p>
                                                        <button type="submit" class="btn btn-primary" name="EnviarRecarga" id="EnviarRecarga"> Cobrar</button>

                                                    </form>
                                            
                                            

										</div>

                                        <div class="col-md-8">
                                        <div id="ajax"></div>
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




<script type="text/javascript">
// $(function (e) {
// 	$('#RecargaMayoreo').submit(function (e) {
// 	  e.preventDefault()
//   $('#ajax').load('CobrarRecargaMayoreo.php?' + $('#RecargaMayoreo').serialize())
// 	})
// })
</script>	



<script>
$(function() {
    $( "#client" ).autocomplete({
       source: 'search.php',
       //change: function (event, ui) { 
       //$('#ConfNum').load('AjaxNombre.php?client=' + $("#client").val())
       //}
    });
});
</script>

<!--
<script>
   $(document).ready(function(){
      $("#compania").change(function() {
          $('option', '#monto').remove();
          //alert('getdenominacion.php?codigo='+$("#compania").val())
          $("#monto").empty();
          $.getJSON('GetDenominacionMasiva.php?codigo='+$("#compania").val(),function(data){
              //console.log(JSON.stringify(data));
              $.each(data, function(k,v){
                  $("#monto").append("<option value="+k+"> $"+v+".00</option>");
              }).removeAttr("disabled");
          });
      });
      });
</script>	  
-->