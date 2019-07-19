<?php
 		include_once 'APP/config.php';
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
        $id_sucursal = $_SESSION['id_sucursal'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='su' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
?>

<!DOCTYPE html>
<html lang="es">
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


  <!-- "DATA TABLE" -->
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
  <!-- ********* -->
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
											<p class="black font-weight-bold titulo text-center">LISTADO DE PRODUCTOS</p>
										</div>
									</div>

                  <div class="row">
                      <div class="col-md-3">
                        
                        <?php if($_SESSION['tipo_usu']=='a'){ ?>
                        <button type="button" class="btn btn-info" onClick="window.location='crear_producto.php'">Ingresar Nuevo</button>
                        <?php } ?> 
                      </div>

                      <div class="col-md-3">
                        <a href="ExcelProducto.php" class="green"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i>Reporte Excel Productos con Existencias</a>
                      </div>

                      <div class="col-md-3">                        
                        <a href="ExcelProductoGeneral.php" class="green"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i>Reporte Excel General</a>                   
                      </div>

                      <div class="col-md-3">                        
                        <a href="PDFproducto.php" class="red"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                        <i id="loading" class="fa fa-circle-o-notch fa-spin fa-2x fa-fw" style="color:#007bff; "></i>
                      </div>

                  </div>
                  
                  <br>

                  <div class="row">
                    <div class="col-md-12">



                     
                      <div id="tablaPrincipal" style="display:none;">
                        <table  class="table table-striped table-bordered dt-responsive nowrap exampleA" style="width:100%">
                          <?php
                          echo '<thead>
                          <tr>                                 
                                    <th>Imágen</th>
                                    <th>Codigo</th>
                                    <th>Nombre del Producto</th>
                                    <th>Existencia</th>    
                                    <th>Estado</th>';

                                    if($_SESSION['tipo_usu']=='a' )
                                    {
                                      echo '<th>Costo</th>
                                      <th>Venta Especial</th>
                                      <th>Venta Mayoreo</th>';
                                    }else if($_SESSION['tipo_usu']=='su'){
                                      echo '<th>Venta Especial</th>
                                      <th>Venta Mayoreo</th>';
                                    }else if($_SESSION['tipo_usu']=='te'){
                                      echo '<th>Precio Refacción</th>
                                      <th>Mano de Obra</th>';
                                    }

                                    if ($_SESSION['tipo_usu']=='te'){
                                    echo '<th>Público Sugerido</th>';
                                    }else{        
                                    echo '<th>Valor Venta</th>';
                                    }

                                    if($_SESSION['tipo_usu']=='a'){      
                                    echo '<th>Eliminar Producto</th>';      
                                    }
                              echo '</tr>';
                          echo '</thead>';
                          echo '<tbody>';

                          ?>
                          <?php 
                          if(empty($_POST['bus'])){
                            $can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' ORDER BY nom ASC");
                          }else{
                            $buscar=$_POST['bus'];
                            $can=mysql_query("SELECT * FROM producto where id_sucursal = '$id_sucursal' and 
                            (nom      LIKE '%$buscar%' or 
                            cantidad LIKE '%$buscar%' or 
                            cod      LIKE '%$buscar%' or 
                            fecha    LIKE '%$buscar%' or 
                            venta    LIKE '%$buscar%' or 
                            marca    LIKE '%$buscar%' or 
                            prov     LIKE '%$buscar%') ORDER BY nom ASC");
                          }	
                          while($dato=mysql_fetch_array($can))
                          {
                            $codigo = $dato['cod'];
                            $precioCosto = $dato['costo'];
                            $ventaMayoreo = $dato['mayor'];
                            $ventaEspecial = $dato['especial'];

                            if($dato['estado']=="n"){
                              $estado='<span  class="badge badge-danger">Inactivo</span>';
                            }else{
                              $estado='<span  class="badge badge-success">Activo</span>';
                            }

                            $action = '<span class="label label-primary">Contar</span>';
                            $codigoA = '<span class="label label-primary">'.$dato['cod'].'</span>';
                            $unidad=$dato['unidad'];
                            $que=mysql_query("SELECT * FROM unidad_medida where id=$unidad");   
                            if($datos=mysql_fetch_array($que)){
                              $n_unidad=$datos['abreviatura'];
                            }else {
                              $n_unidad = '';
                            }
                          ?>


                          <tr>
                            <td>
                              <?php
                              if (file_exists("articulo/".$codigo.".jpg")){
                              echo '<img src="articulo/'.$codigo.'.jpg" width="50" height="50">';
                              }else{ 
                              echo '<img src="articulo/producto.png" width="50" height="50">';
                              }
                              ?>
                            </td>

                            <?php if($dato['codigo'] != ""){  ?>
                            <td><?php echo $codigoA; ?></td>
                            <?php }else{ ?>
                            <td><a href="detallarInventario.php?codigo=<?php echo $dato['cod']; ?>"><?php echo $codigoA; ?> </a></td>
                            <?php } ?>

                            <td><a href="crear_producto.php?codigo=<?php echo $dato['cod']; ?>"><?php echo utf8_encode($dato['nom']); ?> </a></td>
                            <td>
                            <a onclick='plus("<?= $codigo; ?>");' role="button" class="btn btn-info" id="boton_filtro" name="boton_filtro"><?php echo $dato['cantidad']; ?></a>
                            </td>

                            <td><a href="php_estado_producto.php?id=<?php echo $dato['cod']; ?>"><?php echo $estado; ?></a></td>


                            <?php
                            if($_SESSION['tipo_usu']=='a'){
                              echo '<td>$ '.number_format($precioCosto,2,",",".").'</td>';
                              echo '<td>$ '.number_format($ventaEspecial,2,",",".").'</td>';
                              echo '<td>$ '.number_format($ventaMayoreo,2,",",".").'</td>';
                            }
                            else if($_SESSION['tipo_usu']=='su' || $_SESSION['tipo_usu']=='te'){
                              echo '<td>$ '.number_format($ventaEspecial,2,",",".").'</td>';
                              echo '<td>$ '.number_format($ventaMayoreo,2,",",".").'</td>';
                            }
                            ?>

                            <td>$ <?php echo number_format($dato['venta'],2,",","."); ?></td>
                            
                            <?php
                            if($_SESSION['tipo_usu']=='a')
                            {
                              echo "<td><a href='#' onclick='eliminarProducto(".'"'.$dato['cod'].'"'.")';> <span class='badge badge-danger'>Eliminar</span></a></td>";
                            } 
                            ?>

                          </tr>
                          <?php } ?>
                          </tbody>
                        </table>
                        </div>
                      
                      

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
<!-- ******************************************************************************************************************************* -->
<div id="mymodalmsg" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">DETALLE PRODUCTOS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <center><div id="modalmsg"></div></center>
        <center><div id="modalmsg2"></div></center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- ******************************************************************************************************************************* -->
<div id="modalConfirm2" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">DETALLE PRODUCTOS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <center><div id="msgmodalConfirm2"></div></center>
      </div>
      <div class="modal-footer">
        <button class="btn" id="btnEliminarProd" onclick="confirmEliminar(this.value)" data-dismiss="modal" aria-hidden="true">Aceptar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- ******************************************************************************************************************************* -->
<!-- ******************************************************************************************************************************* -->

<div id="modalRespuesta" class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">DETALLE PRODUCTOS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <center><div id="modalRespuestamsg"></div></center>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- ******************************************************************************************************************************* -->
<!-- -------------------------- modal Filtros ---------------------------------- -->
<div id="filtro" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">DETALLE PRODUCTOS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <input type="hidden" name="id_pro" id="id_pro">
      <div align="right" id="btnEliminardiv" style = "display:none;"><button type="button" class="btn btn-primary" id="btnSeleccionar"  onclick="eliminarCheck(this.value);"  >Eliminar</button></div>
      
      
      <div style="width: 100%; height: 250px; overflow-y: scroll;">
        <table width="80%" border="0" class="table" id="tablafiltro">
          <tr class="info">
            <td colspan="5"><center><strong>Listado de Productos</strong></center></td>
          </tr>
        </table>
      </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- ******************************************************************************************************************************* -->
<!--******************************************************************************************************************************** -->


<div id="modalConfirm" class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">DETALLE PRODUCTOS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <center><div id="modalConfirmmsg"></div></center>
        
      </div>
      <div class="modal-footer">
        <button type="button" id="btnEliminar" onclick="confirmarDelete(this.value)" class="btn btn-primary">Aceptar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--******************************************************************************************************************************** -->



<script>

$('#filtro').on('hidden.bs.modal', function () {
 location.reload();
})

function eliminarCheck(id_producto)
{
  //alert(id_producto);
  $("#btnEliminar").removeAttr("disabled","disabled");
  $("#btnEliminar").val(id_producto);
  $('#modalConfirmmsg').text("¿Desea Eliminar los Elementos Seleccionados?");
  
  $("#modalConfirm").modal("show");
}
function confirmarDelete(id_producto)
{
  $("#btnEliminar").attr("disabled","disabled");
  $("#modalConfirm").modal("hide");
  var contador = 0;
  var valor ='';
  var split = '';
  var codigo = '';
  var tipoProducto = '';
  $("#modalRespuestamsg").html("");
  var array = [];
  $("input:checkbox[name=checkidentificador]:checked").each(function()
  {
    valor = $(this).val();
    split = valor.split(",,");
    codigo = split[0];
    tipoProducto = split[1];
    array.push(codigo); //console.log(array);
  });
  var jsonString = JSON.stringify(array);
  
  $.ajax({
    method: "POST",
    url: "eliminarProductoModal.php",
    dataType: "json",
    data: {arraySeleccionados: jsonString,id_producto : id_producto, tipo_producto : tipoProducto}
    })
    .done(function(respuesta) {
      
      
    $("#filtro").modal("hide");


    });
   

    
    

}

function inputCheck() {
    var boton = document.getElementById("btnEliminardiv");
    if ($('input.pruebacheck').is(':checked')){
      boton.style.display = "block";
    } else {
      boton.style.display = "none";
    }
}

 function seleccionarTodos()
 {
    var checkBoxprincipal = document.getElementById("checkpivote");
    var boton = document.getElementById("btnEliminardiv");
  if (checkBoxprincipal.checked == true)
    {
      $('input.pruebacheck').prop('checked',true);
      boton.style.display = "block"; 
    } 
    else 
    {
      $('input.pruebacheck').prop('checked',false);
      boton.style.display = "none";      
    } 
 }
 //****************************** Función Eliminar Producto ***********************/
function eliminarProducto(codigoProducto){
  //alert(codigoProducto);
  $.ajax({
    method: "POST",
    url: "eliminarProducto.php",
    data: { codigoProducto: codigoProducto, opcion: 1 } //opcion para verificar el prodcuto en distintos módulos
    })
    .done(function(respuesta) {
        //alert(respuesta);
        if(respuesta == 2)
        {
            swal("¡Error!", "No se puede elimianr el producto, primero debe desactivarlo", "error");

        }else if(respuesta == 1){
            $("#msgmodalConfirm2").html("¿Está seguro que desea eliminar el producto?")
            $("#btnEliminarProd").val(codigoProducto);
                  
            $('#modalConfirm2').modal('show');

        }else if(respuesta != 1 || respuesta != 2){
            $("#modalmsg").html("No se puede eliminar, Existen sucursales que tienen existencias");
            $("#modalmsg2").html(respuesta);
            //tabla();
            $('#mymodalmsg').modal('show');
        }
    });


}

function confirmEliminar(codigoProducto){
  //alert(idProducto);
    $.ajax({
    method: "POST",
    url: "eliminarProducto.php",
    data: { codigoProducto: codigoProducto, opcion: 2 }
    })
    .done(function(respuesta) {
        //alert( "Data Saved: " + msg );
        if(respuesta == 1){
          location.href="producto.php";
        }
    });
}

function EliminardeLista(id,imei,iccid)
  {
    //alert(id);
    $.ajax({
    method: "POST",
    url: "DeleteIdentificador.php",
    data: { id: id, imei: imei, iccid: iccid}
  })
    .done(function(respuesta) {

      if(respuesta == 1)
      {
        
        plus(id);
        //location.reload();
      }

      
    });

  }

function upconteo(){
    var id = document.getElementById('id_pro').value
    var faltantes = document.getElementById('faltantes').value
    var sobrantes = document.getElementById('sobrantes').value
    var datos = "id="+id+"&faltantes="+faltantes+"&sobrantes="+sobrantes;
    $.ajax({
        type: "POST", 
        url: "ConteoProducto.php",
        data: datos,
        success: function(msg){
          $('#filtro').modal('toggle');
          document.getElementById('faltantes').value = "";
          document.getElementById('sobrantes').value = "";
          $("#divId").load(location.href + " #divId>*", "");
        }
    });
  }


  function plus(id) {
    var id_producto = id;
    var contar = 0;

      var tipo_usu = "<?= $_SESSION['tipo_usu']; ?>";
      document.getElementById('id_pro').value = id;
      //alert("identificador: "+id);
      var valores = "id="+id;
      $.ajax({
        url: "DetalleProducto.php", /* Llamamos a tu archivo */
        data: valores, /* Ponemos los parametros de ser necesarios */
        type: "POST",
        contentType: "application/x-www-form-urlencoded",
        dataType: "json",  /* Esto es lo que indica que la respuesta será un objeto JSon */
        success: function(data)
        {
            $("#tablafiltro").html('');
            if(data != null && $.isArray(data)){
              
                
                if (tipo_usu == 'a') {
                  $("#tablafiltro").append("<tr class='info'><td colspan='6'><center><strong>Listado de Productos</strong></center></td><tr>");
                  $("#tablafiltro").append("<tr><td width='3%'>No</td><td width='3%'>ID</td><td width='7%'>NOMBRE</td><td width='7%'>IMEI</td><td width='7%'>ICCID</td><td width='7%'>SELECCIONAR <input type='checkbox' id='checkpivote' name='checkpivote' onclick='seleccionarTodos();'></td></tr>");

                } else{
                  $("#tablafiltro").append("<tr class='info'><td colspan=4><center><strong>Listado de Productos</strong></center></td><tr>");
                  $("#tablafiltro").append("<tr><td width='3%'>No</td><td width='3%'>ID</td><td width='7%'>NOMBRE</td><td width='7%'>IMEI</td><td width='7%'>ICCID</td></tr>");
                }
                    
                
                $.each(data, function(index, value){
                  contar++;
                    //var evento="onclick='EliminardeLista(" +'"'+ value.id_articulo +'","'+ value.imei +'","'+ value.iccid +'")';
                    
                    //var evento="onclick='quitar(" +'"'+ value.id_articulo +'","'+ value.imei +'","'+ value.iccid +'","'+ value.ficha +'"'+ ")'";
                    //alert(evento);
                    if (tipo_usu == 'a')
                    {
                      $("#btnSeleccionar").val(id_producto);
                      if(value.imei == '-' && value.iccid == '-' && value.id_articulo != ''){
                        $("#tablafiltro").append("<tr><td>" +contar+ "</td><td>" + value.id_articulo + "</td><td>" + value.nombre + "</td><td>" + value.imei + "</td><td>" + value.iccid + "</td><td><div><input type='checkbox' class='pruebacheck' id='checkinput' name='checkidentificador' value='" + value.id_articulo +",,producto"+ "' onclick='inputCheck();'><br></div></td></tr>");
                        
                      }else if(value.imei == '-' && value.iccid != '-' && value.id_articulo != ''){
                        $("#tablafiltro").append("<tr><td>" +contar+ "</td><td>" + value.id_articulo + "</td><td>" + value.nombre + "</td><td>" + value.imei + "</td><td>" + value.iccid + "</td><td><div><input type='checkbox' class='pruebacheck' id='checkinput' name='checkidentificador' value='" + value.iccid +",,iccid"+ "' onclick='inputCheck();'><br></div></td></tr>");

                      }else if(value.imei != '-' && value.iccid == '-' && value.id_articulo != ''){
                        $("#tablafiltro").append("<tr><td>" +contar+ "</td><td>" + value.id_articulo + "</td><td>" + value.nombre + "</td><td>" + value.imei + "</td><td>" + value.iccid + "</td><td><div><input type='checkbox' class='pruebacheck' id='checkinput' name='checkidentificador' value='" + value.imei +",,imei"+ "' onclick='inputCheck();'><br></div></td></tr>");
                      }
                    }
                    else
                    {
                      $("#tablafiltro").append("<tr><td>" +contar+ "</td><td>" + value.id_articulo + "</td><td>" + value.nombre + "</td><td>" + value.imei + "</td><td>" + value.iccid + "</td></tr>");
                    }
                    
                    
                });
                //console.log(arraycheck)
            }
            // $('#filtro').modal({
            //   show: 'true'
            // });
            $("#filtro").modal("show");
        }
      });

  }

  function contar(id){
    document.getElementById('id_pro').value = id;
    $('#reportar').modal({
        show: 'true'
      });
  }

</script>


<script>

$(document).ready(function() {
 
  $("#tablaPrincipal").show()
  tabla();
  $("#loading").hide()

  
} );


function tabla(){

  $('.exampleA').DataTable({
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
