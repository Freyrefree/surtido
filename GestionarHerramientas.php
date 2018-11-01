<?php
session_start();
include('php_conexion.php'); 
$usu=$_SESSION['username'];
$tipo_usu=$_SESSION['tipo_usu'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
   header('location:error.php');
}
$id_sucursal = $_SESSION['id_sucursal'];
$sucursal = $_SESSION['sucursal'];


$IdReparacion = $_REQUEST['IdReparacion'];
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

        <!-- SWAL -->
        <script src="js/sweetalert2.all.min.js"></script>
        <!--**-->
    <style>

    input{
        
        text-transform:uppercase;
    }
    </style>	
</head>

<body data-spy="scroll" data-target=".bs-docs-sidebar">
  <div class="control-group info">
  <?php echo "<a href='ModificarReparacion.php?IdReparacion=$IdReparacion' class='btn btn-primary'>Regresar</a>" ?>

    <table>
    <form name="formProd" id="formProd">
        <tr>
            <td>      
                <select name="categoria" id="categoria">
                    <option value="ninguna" selected>Seleccione Categoría</option>
                    <?php
                    $can=mysql_query("SELECT DISTINCT categoria FROM producto WHERE id_comision=10 AND categoria <> '' ORDER BY categoria ASC");
                    while($dato=mysql_fetch_array($can)){

                        $Cate=$dato['categoria'];
                        $Categoria = str_replace(' ','_',$Cate);  

                    ?>
                    <?php echo "<option value='$Categoria'>"; ?><?php echo $Cate?></option>
                    <?php } ?>
                </select>
            </td>    
            <td>      
                <!-- <div id="ajax"></div> -->
                <select name="producto" id="producto">
                    <option value="ninguno" selected>Seleccione Producto </option>
                </select>
            </td>
            <td>         
                <select name="tipo" id="tipo" reqired>
                    <!-- <option value="">Selecciona el tipo de precio de refacción</option> -->
                    <!-- <option value="3">Precio Público</option> -->
                    <!-- <option value="2">Mayoreo</option>  -->
                    <option value="1" selected>Especial</option>
                </select>
                <input type="hidden" name="IdReparacion" id="IdReparacion" value="<?php echo $IdReparacion ?>">
                <input type="submit"  value="Agregar Refacción" class="btn">  
            </td>     
        </tr>
    </form>
        <tr>
            <td colspan="2">
            <?php

            $can=mysql_query("SELECT * FROM reparacion where id_reparacion='$IdReparacion'");

            if($dato=mysql_fetch_array($can)){
            $ManoObra			= $dato['mano_obra'];
            $precioInicial      =$dato['precio_inicial'];
            $anticipo           =$dato['abono'];
            $totalPublico       =$dato['total'];
            $comisionCajero     =$dato['comisionCajero'];
            }
            $can=mysql_query("SELECT SUM(Precio), SUM(CostoRefaccion) FROM reparacion_refaccion WHERE id_reparacion='$IdReparacion'") or die(print("Error al sumar precios"));
            if($dato=mysql_fetch_array($can)){
               $SumPrecio  = $dato['SUM(Precio)'];
            }

            //Precio Publico suma
            $arrayCodigosProdcuto;
            $i = 0;
            $mas = 0;
            $sum = 0;
            $consulta = "SELECT id_producto FROM reparacion_refaccion WHERE id_reparacion = '$IdReparacion'";
            $ejecuta = mysql_query($consulta);
            if(mysql_num_rows($ejecuta) > 0){
                while($fila = mysql_fetch_array($ejecuta))
                {
                    $arrayCodigosProdcuto[$i]=$fila['id_producto'];
                    $i++;
                }
                foreach ($arrayCodigosProdcuto as &$idProducto) {
                    $mas = $sum;
                    $consulta2 = "SELECT venta FROM producto WHERE cod = '$idProducto' AND id_sucursal = '$id_sucursal'";
                    $ejecuta2 = mysql_query($consulta2);
                    $dato = mysql_fetch_array($ejecuta2);

                    $precioVentaP = $dato['venta'];
                    $sum = $precioVentaP + $mas;
                }
                $precioPublico = $sum;

            }else{
                $precioPublico = 0;
            }


            


            
            $total = (($ManoObra + $SumPrecio));
            if($total > $precioInicial){
                $nuevoPresupuesto = $total;
            }else{
                $nuevoPresupuesto = "";
            }

            $precioPublicotmp = $SumPrecio + $ManoObra;



                    $html = '<form id="costos">
                    <label>Presupuesto Inicial:</label>
                
                    
                <input type="number" name="Precio" id="Precio" value="'.$precioInicial.'" min="'.$precioInicial.'" readonly>
                    
                <!--<label>Nuevo Presupuesto:</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" name="Precio2" id="Precio2" min="'.$precioInicial.'" value="'.$nuevoPresupuesto.'"  >
                    <span class="add-on">.00</span>
                </div>-->


                    <label>Inversión</label>
                    <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" step="any" name="Inversion" id="Inversion" value="'.$SumPrecio.'"  readonly>
                    <span class="add-on">.00</span>
                    </div>    
                    
                    <label>Mano de obra</label>
                    <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number"  onkeyup="minInputPrecioPublico();" name="ManoObra" id="ManoObra" value="'.$ManoObra.'" required>
                    <span class="add-on">.00</span>
                    </div>

                    <label>Cajero</label>
                    <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number"  name="comisionCajero" id="comisionCajero" value="'.$comisionCajero.'" readonly>
                    <span class="add-on">.00</span>
                    </div>

                    <label>Anticipo</label>
                    <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" step="any" name="anticipo" id="anticipo" value="'.$anticipo.'" readonly>
                    <span class="add-on">.00</span>
                    </div>

                    <!--<label>TOTAL:</label>
                    <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" step="any" name="total" id="total" value="'.$total.'"  readonly>
                    <span class="add-on">.00</span>
                    </div>-->

                    <label>Precio Público</label>
                    <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" onkeyup="comision();" name="totalPublico" min="'.$precioPublicotmp.'"  id="totalPublico" value="'.$totalPublico.'"  required>
                    <span class="add-on">.00</span>
                    </div>';

                    //$nota = '<p><span style="color:#FF0000">El total ha superado el presupuesto inicial,<br/>se ha tomado el valor total como nuevo presupuesto</span></p>';
                    //if($total >  $precioInicial){
                      //  $html.= $nota;
                   // }
                    $html .= '<br/>
                        <input type="radio" name="estatus" value="2" checked>Concluir<br>
                        <input type="radio" name="estatus" value="1">Pendiente<br>
                        <br/>
                        <button class="btn btn-large btn-primary" type="submit">Continuar</button>
                        </form>';
                     
                    
                    echo $html;


                    ?>
                                        
            </td>

            <td>
                <div id="DivRefacciones" style="display:inline"></div>                        
            </td>        
        </tr>    
    </table>
</body>
</html>		


<script type="text/javascript">
$(function () {
    $('#categoria').change(function ()
	{
        $('#ajax').load('ConsultaProducto.php?categoria=' + $(this).val())
 
	})
})
</script>

<script type="text/javascript">
$(document).ready(function() 
{
    $('#formProd').submit(function(e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        //data.push({name: 'tag', value: 'login'});
        $.ajax({
            method: "POST",
            url: "AgregarRefaccion.php",
            data: data
        })
        .done(function(respuesta) {
                if(respuesta == 1)
                {
                    location.reload();

                }else if(respuesta == 2)
                {         
            
                    swal("Precaución", "No hay existencias del producto", "warning");		

                }else if(respuesta == 3){                
            
                    swal("Precaución", "Por favor seleccione una categoria y un producto", "warning");	

                }else if(respuesta == 0){
                    swal("Precaución", "¡Error!", "warning");

                }
            });
        
    })
})

</script>
<script type="text/javascript">
$( document ).ready(function() {
    var id_reparacion = "<?php echo $IdReparacion ?>";
    //console.log( "ready!" );
    if(id_reparacion != '')
    {
        $.ajax({
        method: "POST",
        url: "listaRefacciones.php",
        data: { id_reparacion: id_reparacion }
        })
        .done(function(respuesta) {
            if(respuesta != 0 && respuesta != 2)
            {
                $("#DivRefacciones").html(respuesta);

            }else if(respuesta == 2)
            {
                $("#DivRefacciones").html("SIN REFACCIONES AGREGADAS");
            }
            
        });
    }
});


function quitarRefaccion(id,id_producto,id_reparacion)
{
swal({
title: '¿Está seguro que desea quitar la refacción?',
text: "La refacción se quitará de éste equipo",
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Si',
cancelButtonText: 'No'
}).then((result) => {
    if (result.value) {
        $.ajax({
        method: "POST",
        url: "QuitarRefaccion.php",
        data: { id: id, id_producto: id_producto, id_reparacion : id_reparacion }
        })
        .done(function(respuesta) {
            if(respuesta == 1)
            {
                let timerInterval
                swal({
                title: 'Terminado',
                text: "La refacción se ha removido correctamente",
                type: 'success',
                showConfirmButton: false,
                timer: 1500,
                }).then((result) => {
                if (result.dismiss === swal.DismissReason.timer) {
                    location.reload();
                }
                });

            }else if(respuesta == 0){
                swal("Error", "¡Por favor inténtelo más tarde!", "warning");
            }
        });

    }
});

}





$("#categoria").on("change", function() {
  var categoria = this.value;
  //alert(categoria);
  $("#producto").html("");
  $.ajax({
        method: "POST",
        url: "ConsultaProducto.php",
        dataType: "json",
        data:{categoria : categoria}
        }).done(function(respuesta) {
            $.each(respuesta, function(key, item) {
                $("#producto").append("<option value="+ item.codigo +">"+ item.nombreProducto +"</option>");
            });
        });
});

$(document).ready(function() 
{
   

        $('#costos').submit(function(e) {
        e.preventDefault();
        var id_reparacion = "<?php echo $IdReparacion; ?>";
        var data = $(this).serialize() + "&IdReparacion=" + id_reparacion;
        var estatus = $('input[name=estatus]:checked', '#costos').val();

        //verificar que el total no exeda el presupuesto inicial
        var inversion = $("#Inversion").val();
        inversion = parseFloat(inversion);
        var manoObra = $("#ManoObra").val();
        manoObra = parseFloat(manoObra);
        var total = $("#total").val();

        

        //var suma = inversion + manoObra;
        //alert(inversion +" "+manoObra + " " + total + " " + suma);
        //if(suma > total){
            //alert("ÑO");
            //swal("Precaución", "La inversión de refacciones mas mano de obra ha exedido el presupuesto inicial, Automáticamente se ha agregado un nuevo presupuesto y se ha actualizado el total", "warning");
            //$("#Precio2").val(suma);
            //$("#total").val(suma);
            

        //}else{

            if(estatus == 2) //estatus Para confirmar Término de reparacion
            {
                swal({
                title: '¿Está seguro que desa terminar la reparación?',
                text: "Ya no podrá agregar piezas o modificar mano de obra",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                        method: "POST",
                        url: "ModificarReparacion2.php",
                        data: data,
                        })
                        .done(function(respuesta) {

                            if(respuesta == 1)
                            {
                                let timerInterval
                                swal({
                                title: 'Terminado',
                                text: "La reparación ha cambiado a estatus Terminado",
                                type: 'success',
                                showConfirmButton: false,
                                timer: 1500,
                                }).then((result) => {
                                if (result.dismiss === swal.DismissReason.timer) {
                                    window.location.href = 'ModificarReparacion.php?IdReparacion='+id_reparacion;
                                }
                                });

                            }else{
                                swal("Precaución", "Error, intente más tarde", "warning");
                            }
                        });
                    }
                })
                
            }else if(estatus == 1){ //estatus para permanecer en estatus en proceso

                $.ajax({
                    method: "POST",
                    url: "ModificarReparacion2.php",
                    data: data,
                })
                .done(function(respuesta) {
                    //alert(respuesta);
                        if(respuesta == 1)
                        {
                            window.location.href = 'ModificarReparacion.php?IdReparacion='+id_reparacion;

                        }else{
                            swal("Precaución", "Error, intente más tarde", "warning");
                        }
                    });
            }

       // }

        });
    
});
</script>
<script>
    function minInputPrecioPublico(){
        
        var manoObra = $("#ManoObra").val();
        manoObra = parseFloat(manoObra);
        
        var inversion = $("#Inversion").val();
        inversion = parseFloat(inversion);

        if(inversion == "" || inversion  == 0 || isNaN(inversion)){
            var precioPublico = manoObra;

        }else if(manoObra == "" || manoObra  == 0 || isNaN(manoObra)){

            var precioPublico = inversion;
            //alert(manoObra);

        }else{
            var precioPublico = manoObra + inversion;
        }
        
        if(precioPublico > 0){
            $("#totalPublico").attr({"min" : precioPublico});
        }

    }

    function comision(){

        var totalPublico = $("#totalPublico").val();
        totalPublico = parseFloat(totalPublico);

        var manoObra = $("#ManoObra").val();
        if (manoObra == "" || manoObra  == 0 || isNaN(manoObra)) {
            manoObra = 0;

        }else{
            manoObra = parseFloat(manoObra);
        }
        
        var inversion = $("#Inversion").val();
        if (inversion == "" || inversion  == 0 || isNaN(inversion)) {
            inversion = 0;
            
        }else{
            inversion = parseFloat(inversion);
        }
        

        var cajero = totalPublico - (inversion + manoObra);
        //alert(cajero);
        console.log(cajero);

        if(cajero > 0){
            $("#comisionCajero").val(cajero);
        }else{
            $("#comisionCajero").val(0);
        }
        

        

    }

</script>	 