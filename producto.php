<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
        $id_sucursal = $_SESSION['id_sucursal'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='su' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
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

    <!-- SWAL -->
    <script src="js/sweetalert2.all.min.js"></script>
    <!--**-->
    <script>
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
                  $('#filtro').modal({
                    show: 'true'
                  });
              }
            });

        }
        function contar(id){
          document.getElementById('id_pro').value = id;
          $('#reportar').modal({
              show: 'true'
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
    </script>


    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
<style>
    .modal-admin{
      margin-left: -500px;
      width:950px;
    }
</style>
<!-- ***************************************************************************************************************************************** -->
<div id="mymodalmsg" class="modal hide fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
<div class="modal-dialog modal-sm">
    <div class="modal-content">
  <div class="modal-header" id="modalmsghead">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">DETALLE PRODUCTOS</h3>

  </div>
  <div class="modal-body">
    <center><div id="modalmsg"></div></center>
    <center><div id="modalmsg2"></div></center>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
  </div>
  </div>
</div>
<!-- ************************************************************************************************************ -->
<!-- ************************* -->
<div class="modal fade bd-example-modal-sm" id="modalConfirm2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-header" id="modalConfirm2head">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="">DETALLE PRODUCTOS</h3>
    </div>
    <div class="modal-body">
      <center><div id="msgmodalConfirm2"><div/></center>
    </div>
    <div class="modal-footer">
      <button class="btn" id="btnEliminarProd" onclick="confirmEliminar(this.value)" data-dismiss="modal" aria-hidden="true">Aceptar</button>
    </div>
    </div>
  </div>
</div>
<!-- ************************* -->
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<table width="100%" border="0">
  <tr>
    <td>
    <div class="btn-group" data-toggle="buttons-checkbox">
        <button type="button" class="btn btn-primary" onClick="window.location='PDFproducto.php'">Reporte PDF</button>
        <button type="button" class="btn btn-primary" onClick="window.location='ExcelProducto.php'">Reporte Excel Productos con Existencias</button>
        <button type="button" class="btn btn-primary" onClick="window.location='ExcelProductoGeneral.php'">Reporte Excel General</button>
        <?php if($_SESSION['tipo_usu']=='a'){ ?>
        <button type="button" class="btn btn-primary" onClick="window.location='crear_producto.php'">Ingresar Nuevo</button>
        <?php } ?>
    </div>
    </td>
    <td>
    <div align="right">
    <form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
      <div class="input-append">
             <input name="bus" type="text" class="span2" size="60" list="characters" placeholder="Buscar">
              <datalist id="characters">
                <?php
                  $buscar=$_POST['bus'];
                  $can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' ORDER BY nom ASC ");
                  while($dato=mysql_fetch_array($can)){
                      echo '<option value="'.$dato['nom'].'">';
                      echo '<option value="'.$dato['cod'].'">';
                      echo '<option value="'.$dato['cprov'].'"';
                  }
                ?>
            </datalist>
            <button class="btn" type="submit">Buscar!</button>
      </div>
    </form>
    </div>
    </td>
  </tr>
</table>
</div>
<div align="center" id="divId">
<table width="100%" border="0" class="table">
  <tr class="info">
<?php
if($_SESSION['tipo_usu']=='a' ){ 
    echo '<td colspan="10"><center><strong>Listado de Productos</strong></center></td>';
}else if($_SESSION['tipo_usu']=='su'){
  echo '<td colspan="8"><center><strong>Listado de Productos</strong></center></td>';
}else if($_SESSION['tipo_usu']=='te'){
  echo '<td colspan="8"><center><strong>Listado de Productos</strong></center></td>';
}
else{
  echo '<td colspan="6"><center><strong>Listado de Productos</strong></center></td>';
}
  echo '</tr>
  <tr>
    <td width="6%"><strong>Imágen</strong></td>
    <td width="5%"><strong>Codigo</strong></td>
    <td width="26%"><strong>Nombre del Producto</strong></td>
    <td width="15%"><strong>Existencia</strong></td>    
    <td width="7%"><strong>Estado</strong></td>';
    if($_SESSION['tipo_usu']=='a' )
    {
      echo '<td width="10%"><strong>Costo</strong></td>
            <td width="10%"><strong>Venta Especial</strong></td>
            <td width="10%"><strong>Venta Mayoreo</strong></td>';
    }else if($_SESSION['tipo_usu']=='su'){
      echo '<td width="10%"><strong>Venta Especial</strong></td>
            <td width="10%"><strong>Venta Mayoreo</strong></td>';
    }else if($_SESSION['tipo_usu']=='te'){
      echo '<td width="10%"><strong>Precio Refacción</strong></td>
            <td width="10%"><strong>Mano de Obra</strong></td>';
    }
    if ($_SESSION['tipo_usu']=='te'){
      echo '<td width="10%"><strong>Público Sugerido</strong></td>';
    }else{        
    echo '<td width="10%"><strong>Valor Venta</strong></td>';
    }
    if($_SESSION['tipo_usu']=='a'){      
      echo '<td width="10%"><strong>Eliminar Producto</strong></td>';      
    }
    

 echo '</tr>';

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
	while($dato=mysql_fetch_array($can)){
    $codigo = $dato['cod'];
    $precioCosto = $dato['costo'];
    $ventaMayoreo = $dato['mayor'];
    $ventaEspecial = $dato['especial'];

        if($dato['estado']=="n"){
            $estado='<span class="label label-important">Inactivo</span>';
        }else{
            $estado='<span class="label label-success">Activo</span>';
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
    <!--<td><?php //echo $dato['cod']; ?></td>-->
    <?php if($dato['codigo'] != ""){  ?>
      <td><?php echo $codigoA; ?></td>
    <?php }else{ ?> <!-- opcion detallar inventario-->
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
   echo "<td><a href='#' onclick='eliminarProducto(".'"'.$dato['cod'].'"'.")';> <span class='label label-important'>Eliminar</span></a></td>";
} 
?>
    
    <!-- <td>
    <a href="#" onclick="contar('<?= $codigo; ?>');" role="button" id="boton_filtro" name="boton_filtro"><?php echo $action; ?></a>
    </td> -->
    </tr>
    <?php } ?>
</table>
</div>
<!-- -------------------------- modal Filtros ---------------------------------- -->
<div id="filtro" class="modal hide fade modal-admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">DETALLE PRODUCTOS</h3>
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
    <button class="btn"  data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>
<!--*********************************************************************************** -->
<div id="modalConfirm" class="modal hide fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
<div class="modal-dialog modal-sm">
    <div class="modal-content">
  <div class="modal-header" id="modalConfirmhead">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">Detalle Productos</h3>
  </div>
  <div class="modal-body">
    <center><div id="modalConfirmmsg"></div></center>
  </div>
  <div class="modal-footer">
    <button type="button" id="btnEliminar" onclick="confirmarDelete(this.value)" class="btn btn-primary">Aceptar</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
  </div>
  </div>
</div>

<!-- ************************************************************************************** -->
<div id="modalRespuesta" class="modal hide fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
<div class="modal-dialog modal-sm">
    <div class="modal-content">
  <div class="modal-header" id="modalRespuestahead">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">Detalle Productos</h3>
  </div>
  <div class="modal-body">
  <style type="text/css">
        #detalleeliminados {
          font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        #detalleeliminados td, #detalleeliminados th {
          border: 1px solid #ddd;
          padding: 8px;
        }

        #detalleeliminados td.a {
          padding-top: 5px;
          padding-bottom: 5px;
          text-align: left;
          background-color: #F7D358;
          color: #000000;
        }

        
        #detalleeliminados th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #F7D358;
          color: #000000;
        }
      </style>
    <center><div id="modalRespuestamsg"></div></center>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
  </div>
  </div>
</div>


<script type="text/javascript">
$('#filtro').on('hidden.bs.modal', function () {
 location.reload();
})

function eliminarCheck(id_producto)
{
  //alert(id_producto);
  $("#btnEliminar").removeAttr("disabled","disabled");
  $("#btnEliminar").val(id_producto);
  $('#modalConfirmmsg').text("¿Desea Eliminar los Elementos Seleccionados?");
  $("#modalConfirmhead").css({"background-color":"#db3236","color":"white"});
  $("#modalConfirm").modal("show");
}
function confirmarDelete(id_producto)
{
  $("#btnEliminar").attr("disabled","disabled");
  var contador = 0;
  var valor ='';
  var split = '';
  var codigo = '';
  var tipoProducto = '';
  $("#modalRespuestamsg").html("");
  var table = "<table id='detalleeliminados'><tr><th>No</th><th>IDENTIFICADOR</th><th>RESULTADO</th></tr>";
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
      $("#modalConfirm").modal("hide");
      
     $.each(respuesta, function(key, item) {
       contador++;
       table += "<tr><td>"+ contador +"</td><td>"+ item.identificador +"</td><td>"+ item.respuesta +"</td></tr>";
        
    });
      $("#modalRespuestamsg").html(table);
      $("#modalRespuestahead").css({"background-color":"#428bca","color":"white"});
      $('#modalRespuesta').modal('show');
      plus(id_producto);
      
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
            $("#modalConfirm2head").css({"background-color":"#d9534f","color":"white"});        
            $('#modalConfirm2').modal('show');

        }else if(respuesta != 1 || respuesta != 2){
            $("#modalmsg").html("No se puede eliminar, Existen sucursales que tienen existencias");
            $("#modalmsg2").html(respuesta);
            $("#modalmsghead").css({"background-color":"#d9534f","color":"white"});
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

 //********************************************************************************/
</script>
</body>
</html>