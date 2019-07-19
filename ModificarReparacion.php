<?php
session_start();
include('php_conexion.php'); 
$usu=$_SESSION['username'];
$tipo_usu=$_SESSION['tipo_usu'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='te'){
   header('location:error.php');
}
$id_sucursal = $_SESSION['id_sucursal'];
$sucursal = $_SESSION['sucursal'];
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
            /* extra */
            input{
        
                text-transform:uppercase;
            }

        </style>


</head>
<?php include_once "layout.php"; ?>
<body>

<?php

$IdReparacion=$_GET['IdReparacion'];
$can=mysql_query("SELECT * FROM reparacion where id_reparacion='$IdReparacion'");

	 if($dato=mysql_fetch_array($can)){
        $IdReparacion		= $dato['id_reparacion'];
		$IMEI				= $dato['imei'];
		$Marca          	= $dato['marca'];
		$Modelo				= $dato['modelo'];
		$Color				= $dato['color'];
		$Presupuesto		= $dato['precio'];
        $SumCosto    		= $dato['CostoRefaccion'];
		$Abono 				= $dato['abono'];
        $Motivo         	= $dato['motivo'];
		$Observacion    	= $dato['observacion'];
		$FechaIngreso   	= $dato['fecha_ingreso'];
		$FechaSalida    	= $dato['fecha_salida'];
        $Costo            	= $dato['costo'];
		$Chip             	= $dato['chip']; 
		$Memoria          	= $dato['memoria']; 
		$NombreContacto   	= $dato['nombre_contacto']; 
		$TelefonoContacto 	= $dato['telefono_contacto'];
        $RFC_CURP 			= $dato['rfc_curp_contacto'];
        $ManoObra			= $dato['mano_obra'];
        $TipoPrecio			= $dato['tipo_precio'];
        $precioInicial      = $dato['precio_inicial'];
        $estado             = $dato['estado'];
        $total              = $dato['total'];
    }
    
    
    $can=mysql_query("SELECT SUM(Precio), SUM(CostoRefaccion) FROM reparacion_refaccion WHERE id_reparacion='$IdReparacion'") or die(print("Error al sumar precios"));
    if($dato=mysql_fetch_array($can)){
       $SumPrecio  = $dato['SUM(Precio)'];
       $SumCosto   = $dato['SUM(CostoRefaccion)'];
    }
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
											<p class="black font-weight-bold titulo text-center">REPARACIÓN<p>
										</div>
									</div>

                      <div class="row">
                          <div class="col-md-6">  
                        
                            <a href="reparaciones.php" class="btn btn-info">Lista Reparaciones</a>
                         
                          </div>

                          <div class="col-md-2">                        
                          
                          
                          </div>

                          <div class="col-md-4">

            
                            
                          </div>

                      </div>
                  
                  <br>

									<div class="row">
										<div class="col-md-12">

                    
<?php
                      $html='<div class="row">
                        <div class="col-md-3">
                            <label for="">ID</label>
                            <input class="form-control" type="text" name="IdReparacion" id="IdReparacion"  value="'.$IdReparacion.'" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="">IMEI</label>
						    <input class="form-control" type="text" name="IMEI" id="IMEI" value="'.$IMEI.'" autocomplete="off" maxlength="20" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="">Marca</label>
						    <input class="form-control" type="text" name="Marca" id="Marca" value="'.$Marca.'" autocomplete="off" maxlength="40" required="" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="">Modelo</label>
						    <input class="form-control" type="text" name="Modelo" id="Modelo" value="'.$Modelo.'" autocomplete="off" maxlength="40" required="" readonly>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-3">
                            <label for="">Color</label>
						    <input class="form-control" type="text" name="Color" id="Color" value="'.$Color.'" autocomplete="off" maxlength="30" required="" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="">Chip</label>
                            <input type="radio" name="Chip" id="Chip" value="si" > Si
                            <input type="radio" name="Chip" id="Chip" value="no" > No                        
                        </div>
                        <div class="col-md-3">
                            <label for="">Memoria</label>
                            <input type="radio" name="Memoria" id="Memoria" value="si"> Si
                            <input type="radio" name="Memoria" id="Memoria" value="no"> No                        
                        </div>
                        <div class="col-md-3">
                            <label for="">Nombre del Cliente</label>
						    <input class="form-control" type="text" name="NombreContacto" id="NombreContacto" value="'.$NombreContacto.'" autocomplete="off" maxlength="30" required="" readonly>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-3">
                            <label for="">Telefono de Cliente</label>
						    <input class="form-control" type="text" name="TelefonoContacto" id="TelefonoContacto" value="'.$TelefonoContacto.'" autocomplete="off" maxlength="10" pattern="[0-9]{10}" required="" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="">Motivo de Reparación</label>
                            <input class="form-control" type="text" name="Motivo" id="Motivo" value="'.$Motivo.'" autocomplete="off" maxlength="70" required="" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Anticipo</label>
                            <input class="form-control" type="number" step="any" name="Abono" id="Abono" value="'.$Abono.'" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Presupuesto Inicial</label>
                            <input class="form-control" type="text" name="Precio" id="Precio" value="'.$precioInicial.'" required readonly>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-3">
                            <label>Inversión Refacciones</label>
                            <input class="form-control" type="number" step="any" name="Inversion" id="Inversion" value="'.$SumPrecio.'" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Mano de obra</label>                    
                            <input class="form-control" type="number" step="any" name="ManoObra" id="ManoObra" value="'.$ManoObra.'" readonly>  
                        </div>
                        <div class="col-md-3">
                            <label>TOTAL</label>                       
                            <input class="form-control" type="number" step="any" name="total" id="total" value="'.$total.'" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Fecha de Ingreso</label>
                            <input class="form-control" type="date" name="FechaIngreso" id="FechaIngreso" value="'.$FechaIngreso.'" required="" readonly="">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-3">
                            <label for="">Observación</label>
                            <textarea class="form-control" name="Observacion" id="Observacion" cols="20" rows="10" value="" maxlength="300" readonly>'.$Observacion.'</textarea>
                        </div>
                        <div class="col-md-3">
                        
                        </div>
                        <div class="col-md-3">
                        
                        </div>
                        <div class="col-md-3"><br>';

                        if ($estado == 1) {
                             $html .= '<a href="GestionarHerramientas.php?IdReparacion='.$IdReparacion.'" class="btn btn-primary ">
                           Administrar Refacciones
                         </a>';
                         
                         }
                        
                        $html.='</div>
                      </div>';
                      echo $html;

                      ?>

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
$(document).ready(function() 
{
    var chip = "<?php echo $Chip; ?>";
    var memoria = "<?php echo $Memoria; ?>";

    if(chip == "si"){
        $('input[name="Chip"][value="si"]').attr('checked','checked');
    }else{
        $('input[name="Chip"][value="no"]').attr('checked','checked');
    }

    if(memoria == "si"){
        $('input[name="Memoria"][value="si"]').attr('checked','checked');
    }else{
        $('input[name="Memoria"][value="no"]').attr('checked','checked');
    }
   
});






</script>	
