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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Refacciones</title>


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
											<p class="black font-weight-bold titulo text-center">REFACCIONES
                      <div class="row">
                          <div class="col-md-6">  
                        
                            <?php echo "<a href='ModificarReparacion.php?IdReparacion=$IdReparacion' class='btn btn-info'>Regresar</a>" ?>
                         
                          </div>

                          <div class="col-md-2">                        
                          
                          
                          </div>

                          <div class="col-md-4">

            
                            
                          </div>

                      </div>
                  
                  <br>

									<div class="row">
										<div class="col-md-12">

                                        <div  class="row">
                                            <div class="col-md-3">

                                            <form name="formProd" id="formProd">

                                                <label for="">Categoría</label>
                                                <select class="form-control" name="categoria" id="categoria">
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

                                            </div>

                                            <div class="col-md-3">
                                                <label  for="">Producto</label>
                                                <select class="form-control" name="producto" id="producto">
                                                    <option value="ninguno" selected>Seleccione Producto </option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="">Tipo Precio</label>
                                                <select class="form-control" name="tipo" id="tipo" reqired>
                                                    <!-- <option value="">Selecciona el tipo de precio de refacción</option> -->
                                                    <!-- <option value="3">Precio Público</option> -->
                                                    <!-- <option value="2">Mayoreo</option>  -->
                                                    <option value="1" selected>Especial</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3"><br>
                                                <input type="hidden" name="IdReparacion" id="IdReparacion" value="<?php echo $IdReparacion ?>">
                                                <input type="submit"  value="Agregar Refacción" class="btn btn-success">  

                                            </form>
                                            </div>
                                        </div>
                                        <hr>
                                        

                                        <div  class="row">
                                        <?php

                                            $can=mysql_query("SELECT * FROM reparacion where id_reparacion='$IdReparacion'");

                                            if($dato=mysql_fetch_array($can)){
                                            $ManoObra			= $dato['mano_obra'];
                                            $precioInicial      = $dato['precio_inicial'];
                                            $anticipo           = $dato['abono'];
                                            $totalPublico       = $dato['total'];
                                            $comisionCajero     = $dato['comisionCajero'];
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
                                            ?>

<?php
                                            $html='<div class="col-md-3">
                                            <form id="costos">
                                                <label>Presupuesto Inicial</label>
                                                <input class="form-control" type="number" name="Precio" id="Precio" value="'.$precioInicial.'" min="'.$precioInicial.'" readonly>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Inversión</label>
                                                <input class="form-control" type="number" step="any" name="Inversion" id="Inversion" value="'.$SumPrecio.'"  readonly>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Mano de obra</label>
                                                <input class="form-control" type="number"  onkeyup="minInputPrecioPublico();" name="ManoObra" id="ManoObra" value="'.$ManoObra.'" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Cajero</label>
                                                <input class="form-control" type="number"  name="comisionCajero" id="comisionCajero" value="'.$comisionCajero.'" readonly>
                                            </div>
                                        </div>
                                        <div  class="row">
                                            <div class="col-md-3">
                                                <label>Anticipo</label>
                                                <input class="form-control" type="number" step="any" name="anticipo" id="anticipo" value="'.$anticipo.'" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Precio Público</label>
                                                <input class="form-control" type="number" onkeyup="comision();" name="totalPublico" min="'.$precioPublicotmp.'"  id="totalPublico" value="'.$totalPublico.'"  required>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="radio" name="estatus" value="2" checked>Concluir<br>
                                                <input type="radio" name="estatus" value="1">Pendiente<br>
                                            </div>
                                            <div class="col-md-3"><br>
                                            <button type="submit" class="btn btn-primary" >Continuar</button>
                                            </form>
                                            </div>
                                        </div>


                                        



                                        
                                        
                                        ';
                                        echo $html;
                                        
?>


										</div>
									</div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="DivRefacciones" style="display:inline"></div>                                    
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
                tabla();

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

<script>
$(document).ready(function() 
{


$("#costos").submit(function(e) {

    
e.preventDefault();

var id_reparacion = "<?php echo $IdReparacion; ?>";
var data = $(this).serialize() + "&IdReparacion=" + id_reparacion;
// var estatus = $("input[name=estatus]:checked", "#costos").val();
var estatus = $('input[name="estatus"]:checked').val();

// alert(estatus);

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
        title: "¿Está seguro que desa terminar la reparación?",
        text: "Ya no podrá agregar piezas o modificar mano de obra",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: "No"
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
                        title: "Terminado",
                        text: "La reparación ha cambiado a estatus Terminado",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1500,
                        }).then((result) => {
                        if (result.dismiss === swal.DismissReason.timer) {
                            window.location.href = "ModificarReparacion.php?IdReparacion="+id_reparacion;
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
                    window.location.href = "ModificarReparacion.php?IdReparacion="+id_reparacion;

                }else{
                    swal("Precaución", "Error, intente más tarde", "warning");
                }
            });
    }

// }

});

});
</script>