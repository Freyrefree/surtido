<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        $id_sucursal = $_SESSION['id_sucursal'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca')
        {
            header('location:error.php');
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Empleado</title>
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


    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="ico/favicon.png">
    <!-- SWAL -->
    <script src="js/sweetalert2.all.min.js"></script>
    <!--**-->

</head>
<!-- ***************************************************************************************************************************************** -->
<div id="mymodalmsg" class="modal hide fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
<div class="modal-dialog modal-sm">
    <div class="modal-content">
  <div class="modal-header" id="modalmsghead">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">Usuarios</h3>
  </div>
  <div class="modal-body">
    <center><div id="modalmsg"></div></center>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
  </div>
  </div>
</div>
<!-- ************************************************************************************************************ -->

<!-- ************************* -->
<div class="modal fade bd-example-modal-sm" id="modalConfirmarEliminar" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-header" id="modalConfirmarEliminarhead">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="">Usuarios</h3>
    </div>
    <div class="modal-body">
      <center><div id="msgmodalConfirmarEliminar"><div/></center>
    </div>
    <div class="modal-footer">
      <button class="btn" id="btnConfirmarusr" onclick="confirmar(this.value)" data-dismiss="modal" aria-hidden="true">Aceptar</button>
    </div>
    </div>
  </div>
</div>
<!-- ************************* -->
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<table width="100%" border="0">
  <tr>
    <td>
    <div class="btn-group" data-toggle="buttons-checkbox">
        <button type="button" class="btn btn-primary" onClick="window.location='PDFusuarios.php'">Reporte PDF</button>
        <button type="button" class="btn btn-primary" onClick="window.location='crear_empleado.php'">Ingresar Nuevo</button>
    </div>
    </td>
  </tr>
</table>
</div>
<div align="center">
<div id="tblUsuarios"></div>
</div>
</body>
</html>
<script type="text/javascript">

$(document).ready(function() {

     $.ajax({
    method: "POST",
    url: "listaUsuario.php",
    data: {}
    })
    .done(function(respuesta) {
        $("#tblUsuarios").html(respuesta);
    });

});

function eliminarUsuario(id)
{
    //alert(id);
    $.ajax({
    method: "POST",
    url: "eliminarUsuario.php",
    data: {id_usuario : id, opc: 1}
    })
    .done(function(respuesta) {
        //$("#tblUsuarios").html(respuesta);
        if(respuesta == 2)
        {
            swal("¡Error!", "No se puede Elimianr el Usuario, primero debe desactivarlo", "error");
        }else if(respuesta == 1){
            $("#msgmodalConfirmarEliminar").html("¿Está seguro que desea eliminar el usuario?")
            $("#btnConfirmarusr").val(id);
            $("#modalConfirmarEliminarhead").css({"background-color":"#d9534f","color":"white"});        
            $('#modalConfirmarEliminar').modal('show');
        }

    });

}
function confirmar(id)
{
  //alert(id);

  $.ajax({
    method: "POST",
    url: "eliminarUsuario.php",
    data: {id_usuario : id, opc: 2}
    })
    .done(function(respuesta) {
        //$("#tblUsuarios").html(respuesta);
        if(respuesta != 1)
        {
            $("#modalmsg").html("Error, intente mas tarde");
            $("#modalmsghead").css({"background-color":"#d9534f","color":"white"});
            $('#mymodalmsg').modal('show');
        }else{

            location.href="empleado.php";
        }

    });
}


</script>