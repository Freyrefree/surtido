<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Movimientos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="ico/favicon.png">

<div id="modalDetalleMov" style="display:none;" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Detalle Movimiento</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

            <div id="alertas" ></div>
            </div>
            <div class="modal-footer">
            
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

</head>
<!-- Terminan los estilos -->

<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div align="center">

<table>
<thead>
    <th>
    No.
    </th>
    <th>
    Código de Producto
    </th>
    <th>
    Existencia
    </th>
    <th>
    Cantidad a mover
    </th>
    <th colspan="2">
    IMEI
    </th>
    <th colspan="2">
    ICCID
    </th>
    <!-- <th colspan="2"> -->
    <!-- ID Ficha -->
    <!-- </th> -->
</thead>
<tbody>
<?php
$n=$_REQUEST['NoProductos']; 
$SucursalEntrada=$_REQUEST['SucursalEntrada'];  
$IdMovimiento   =$_REQUEST['IdMovimiento'];   

echo"<form method='POST' action='' enctype='multipart/form-data' name='FormLote' id='FormLote'>";  
echo"<input type='hidden' name='NoProductos' id='NoProductos' value='$n'>";
echo"<input type='hidden' name='SucursalEntrada' id='SucursalEntrada' value='$SucursalEntrada'>";
echo"<input type='hidden' name='IdMovimiento' id='IdMovimiento' value='$IdMovimiento'>";
for($y=1;$y<=$n;$y++){
echo"<tr>";
echo"<td>";    
echo "$y";
echo"</td>";  
echo"<td>"; 
echo"<div class='ui-widget'>";
echo"<input type='text' name='producto".$y."' id='producto".$y."' required>";
echo"</div>";
echo"</td>"; 
echo"<td><center><div id='ajax$y' class='label label-warning' style='margin-top: -10px; float: left; padding: 7px;'></div></center>"; 
echo"<input type='hidden' name='existencia".$y."' id='existencia".$y."' required>";
echo"</td>"; 
echo"<td>"; 
echo"<input type='text' name='CantMover".$y."' id='CantMover".$y."' maxlength='11' pattern='[0-9]{0,11}' required>";
echo"</td>";
echo"<td>";
echo"<input type='checkbox' name='checkt$y' id='checkt$y' value='1' onchange='javascript:showContentt$y()'>";
echo"</td>"; 
echo"<td>"; 
echo"<div id='contentt$y' style='display: none;'>";
echo"<input type='text' name='IMEI".$y."' id='IMEI".$y."' minlength='14' maxlength='17' pattern='[0-9]{14,17}'>";
echo"</div>";
echo"</td>"; 
echo"<td>";
echo"<input type='checkbox' name='check2$y' id='check2$y' value='1' onchange='javascript:showContent2$y()'>";
echo"</td>"; 
echo"<td>"; 
echo"<div id='content2$y' style='display: none;'>";
echo"<input type='text' name='ICCID".$y."' id='ICCID".$y."' minlength='19'  pattern='[0-9A-Za-z]{19,20}'>";
echo"</div>";
echo"</td>";
//echo"<td>";
//echo"<input type='checkbox' name='check3$y' id='check3$y' value='1' onchange='javascript:showContent3$y()'>";
//echo"</td>"; 
//echo"<td>"; 
//echo"<div id='content3$y' style='display: none;'>";
//echo"<input type='text' name='IdFicha".$y."' id='IdFicha".$y."'>";
//echo"</div>";
//echo"</td>"; 
echo"</tr>";


echo 
"
<script type='text/javascript'>
    function showContentt$y() {
        
        element2 = document.getElementById('CantMover$y');
        //checkt = document.getElementById('checkt$y');
        if (checkt$y.checked) {
           
            $('#contentt$y').show();
            document.getElementById('IMEI$y').required = true;
            $( '#CantMover".$y."' ).val('1');
            element2.disabled = true;
        }
        else {
            $('#contentt$y').hide();
            document.getElementById('IMEI$y').required = false;
            element2.disabled = false;
        }
    }
</script>

<script type='text/javascript'>
    function showContent2$y() {
        element = document.getElementById('content2$y');
         element2 = document.getElementById('CantMover$y');
        //check = document.getElementById('check2$y');
        if (check2$y.checked) {
            element.style.display='block';
            document.getElementById('ICCID$y').required = true;
            $( '#CantMover".$y."' ).val('1');
            element2.disabled = true;
        }
        else {
            element.style.display='none';
            document.getElementById('ICCID$y').required = false;
            element2.disabled = false;
        }
    }
</script>

<script type='text/javascript'>
    function showContent3$y() {
        element = document.getElementById('content3$y');
        element2 = document.getElementById('CantMover$y');
        //check3 = document.getElementById('check3$y');
        if (check3$y.checked) {
            element.style.display='block';
            document.getElementById('IdFicha$y').required = true;
            $( '#CantMover".$y."' ).val('1');
            element2.disabled = true;
        }
        else {
            element.style.display='none';
            document.getElementById('IdFicha$y').required = false;
            element2.disabled = false;
        }
    }
</script>


<script>
$(function() {
    $( '#producto".$y."' ).autocomplete({
       source: 'SerchMovimientosxLote.php'
    });
});
</script>

<script type='text/javascript'>
$('#producto$y').blur(function(){
    var productosend =  encodeURIComponent($( '#producto".$y."').val());
    $('#ajax$y').load('ConsultaExistenciaLote.php?producto$y=' + productosend + '&sucursal=' + $id_sucursal + '&n=' + $n)
});
</script>

<script type='text/javascript'>
function ActualizaExist(){
    var productosend =  encodeURIComponent($( '#producto".$y."').val());
    $('#ajax$y').load('ConsultaExistenciaLote.php?producto$y=' + productosend + '&sucursal=' + $id_sucursal + '&n=' + $n)
};
</script>


";

}
?>
</table>
<div id="ajax"></div>
<input type="submit" value="Continuar" class="btn" onclick="ActualizaExist()" id="Continuar" name="Continuar">
</form>

<script type='text/javascript'>
// $(function (e) {
// 	$('#FormLote').submit(function (e) {
// 	  e.preventDefault()
//   $('#ajax').load('NuevoMovimientoLote3.php?' + $('#FormLote').serialize())
// 	})
// })




    
$('#FormLote').submit(function(e) {
    e.preventDefault();
    var data = $(this).serializeArray();
    //data.push({name: 'tag', value: 'login'});
    $("#alertas").html("");
    var elementos = "";
    var contador = 0;
    $.ajax({
        method: "POST",
        url: "NuevoMovimientoLote3.php",
        data: data,
        dataType: "json"
    })
    .done(function(respuesta) {
        //console.log(respuesta);
        $.each(respuesta, function(key, item) {
            contador++;
            elementos += contador +"-"+ item.respuestaAlert;
            //console.log(item.respuestaAlert);
        });
        $("#alertas").html(elementos);
        $("#modalDetalleMov").modal("show");
    });
});

</script>	
</div>
</body>
</html>