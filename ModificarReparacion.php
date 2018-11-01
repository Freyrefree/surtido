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
    <meta charset="utf-8">
    <title>Listado Producto</title>
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
	<script src="includes/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="includes/sweetalert/dist/sweetalert.css">


    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
    <style>

    input{
        
        text-transform:uppercase;
    }
    </style>	
</head>

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
    

    
    //$total = (($ManoObra + $SumPrecio));

    //$total =  $ManoPlusTotal + $Abono;
    //$totalmenosAnticipo = $total - $Abono;
  
    //if($Presupuesto==NULL || $Presupuesto==0 || $Presupuesto=="" || $Presupuesto<$ManoPlusTotal){
     //  $can=mysql_query("UPDATE reparacion SET 
      //  precio = '$ManoPlusTotal' 
      //  WHERE id_reparacion='$IdReparacion'") or die(print("Error al Actualizar"));
   // }//else if($Presupuesto==NULL || $Presupuesto==0 || $Presupuesto=="" || $Presupuesto>$ManoPlusTotal){
        //$ManoPlusTotal = $Presupuesto;
        //$ManoPlusTotal = $precioInicial;
        //$can=mysql_query("UPDATE reparacion SET 
        //precio              ='$precioInicial' 
        //WHERE id_reparacion='$IdReparacion'") or die(print("Error al Actualizar"));
       // $ManoPlusTotal = $precioInicial;
    //}   



$html =  '<body data-spy="scroll" data-target=".bs-docs-sidebar">
  <div class="control-group info">
    
        <table width="80%" border="0" class="table">
            <tbody>
                <tr>
                    <td>
                        <div class="btn-group" data-toggle="buttons-checkbox">
                        <a href="reparaciones.php"><button type="button"  class="btn btn-primary">Lista de Reparaciones</button></a>
                        </div>
                    </td>
                </tr>
                <tr class="info">
                    <td colspan="3"><center><strong>ENTRADA REPARACIONES</strong></center></td>
                </tr>
                <tr>
                    <td>
                        <label for="textfield">* ID: </label>
                        <input type="text" name="IdReparacion" id="IdReparacion"  value="'.$IdReparacion.'" readonly>
						
                        <label for="textfield">IMEI: </label>
						<input type="text" name="IMEI" id="IMEI" value="'.$IMEI.'" autocomplete="off" maxlength="20" readonly>
						
                        <label for="textfield">* Marca: </label>
						<input type="text" name="Marca" id="Marca" value="'.$Marca.'" autocomplete="off" maxlength="40" required="" readonly>
						
                        <label for="textfield">* Modelo: </label>
						<input type="text" name="Modelo" id="Modelo" value="'.$Modelo.'" autocomplete="off" maxlength="40" required="" readonly>
						
                        <label for="textfield">* Color: </label>
						<input type="text" name="Color" id="Color" value="'.$Color.'" autocomplete="off" maxlength="30" required="" readonly>
						
                        <label for="textfield">* Chip: </label>
                        <input type="radio" name="Chip" id="Chip" value="si" > Si
                        <input type="radio" name="Chip" id="Chip" value="no" > No
								

                        <label for="textfield">* Memoria: </label>
						
						<input type="radio" name="Memoria" id="Memoria" value="si"> Si
						<input type="radio" name="Memoria" id="Memoria" value="no"> No
							
                        
                        <label for="textfield">* Nombre del Cliente: </label>
							<input type="text" name="NombreContacto" id="NombreContacto" value="'.$NombreContacto.'" autocomplete="off" maxlength="30" required="" readonly>
                            <label for="textfield">* Telefono de Cliente: </label>
							<input type="text" name="TelefonoContacto" id="TelefonoContacto" value="'.$TelefonoContacto.'" autocomplete="off" maxlength="10" pattern="[0-9]{10}" required="" readonly>
                            <br>
                        
                    </td>
                    <td>
                        <label for="textfield">* Motivo de Reparación: </label>
                        <input type="text" name="Motivo" id="Motivo" value="'.$Motivo.'" autocomplete="off" maxlength="70" required="" readonly>
                        
                        <label>Anticipo:</label>
                        <div class="input-prepend input-append">
                            <span class="add-on">$</span>
                            <input type="number" step="any" name="Abono" id="Abono" value="'.$Abono.'" readonly>
                            <span class="add-on">.00</span>
                        </div>

                        <label>Presupuesto Inicial:</label>
                        <div class="input-prepend input-append">
                            <span class="add-on">$</span>
                            <input type="text" name="Precio" id="Precio" value="'.$precioInicial.'" required readonly>
                            <span class="add-on">.00</span>
                        </div>


                       
                        <label>* Inversión Refacciones</label>
                        <div class="input-prepend input-append">
                           <span class="add-on">$</span>
                           <input type="number" step="any" name="Inversion" id="Inversion" value="'.$SumPrecio.'" readonly>
                           <span class="add-on">.00</span>
                         </div>    
  
                        
                        <label>* Mano de obra:</label>
                        <div class="input-prepend input-append">
                           <span class="add-on">$</span>
                           <input type="number" step="any" name="ManoObra" id="ManoObra" value="'.$ManoObra.'" readonly>
                           <span class="add-on">.00</span>
                         </div>
                        

                         <label>* TOTAL:</label>
                        <div class="input-prepend input-append">
                           <span class="add-on">$</span>
                           <input type="number" step="any" name="total" id="total" value="'.$total.'" readonly>
                           <span class="add-on">.00</span>
                         </div>

                         <br>';

                         if ($estado == 1) {
                             $html .= '<a href="GestionarHerramientas.php?IdReparacion='.$IdReparacion.'" class="btn btn-primary btn-lg">
                           Administrar Refacciones
                         </a>';
                         
                         }

                       

         $html .= '</td>
                    <td>
                        <label>* Fecha de Ingreso: </label><input type="date" name="FechaIngreso" id="FechaIngreso" value="'.$FechaIngreso.'" required="" readonly="">
                        <!--<label>* Fecha Limite de Entrega: </label><input type="date" name="FechaSalida" id="FechaSalida" value="'.$FechaSalida.'" required="" readonly="">-->
                        <label for="textfield">Observación: </label>
                        <textarea name="Observacion" id="Observacion" cols="20" rows="10" value="" maxlength="300" readonly>'.$Observacion.'</textarea>
                    </td>
                </tr>
            </tbody>
        </table>
</div>
</body>
</html>';
echo $html;
?>


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
