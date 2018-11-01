<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
    $id_sucursal = $_SESSION['id_sucursal'];
    
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
        if (!empty($_GET['id'])) {
            $identificador = $_GET['id'];
            /*echo "el valor obtenido es ".$identificador;*/
        }
   
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>Liberar Reparacion</title>
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
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <!-- MODAL LOAD -->
    <script src="js/jquery.loadingModal.min.js" type="text/javascript"></script>		
    <link href="css/jquery.loadingModal.css" rel="stylesheet" type="text/css"/>
	<!--  -->

    <!-- SWAL -->
    <script src="js/sweetalert2.all.min.js"></script>
    <!--**-->

</head>
<body>
<center>
    <form method="POST" id="formLiberar" >
        
        <label for="">Ingrese el Número de Reparación</label>
        <input type="text" name="noReparacion" id="noReparacion" onkeypress="return isNumberKey(event)" required>
        <br/>
        <button type="button" id="btnBuscar" onclick="buscaReparacion();" class="btn btn-primary">Buscar</button>

        <div id="detalle" style="display:none">

            <label for="" class="col-form-label">Equipo</label>
            <input type="text" id="equipo" name="equipo" readonly>


            <label for="">Resto reparación</label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="number" name="resto" id="resto"  min="0" step="any" readonly>
            </div>

            <label for="ccpago">Descripción Liberación</label>
            <textarea name="descripLi" id="descripLi" rows="4" cols="10"></textarea>

            <label for="">Dinero Recibido</label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="number" name="dineroRecibo" id="dineroRecibo"  min="0" step="any" required>
            </div>

            <br/>
            <button type="submit" id="btnLiberar" class="btn btn-primary">Aceptar</button>
            <button type="button" id="btnCancelar" onclick="cancelar();" class="btn btn-primary">Cancelar</button>

        </div>

    </form>
</center>
</body>
</html>




<!-- ************** -->
<script>

function cancelar(){

    $("#btnBuscar").show();
    $("#detalle").hide();
    $('#noReparacion').prop('readonly', false);
    $("#dineroRecibo").val("");
    $("#descripLi").val("");
}

function buscaReparacion(){
    var noReparacion = $("#noReparacion").val();
    var longitud = 0;

    if(noReparacion != ""){

        $.ajax({
        method: "POST",
        url: "consultaReparacion.php",
        dataType: "json",
        data:{id:noReparacion}
        })
        .done(function(respuesta) {
            longitud = respuesta.length;
            //alert(longitud);
            if(longitud == 1)
            {
                
                $("#btnBuscar").hide();
                $('#noReparacion').prop('readonly', true);

                $.each(respuesta, function(key, item) {
                    $("#equipo").val(item.marca + " " +item.modelo);
                    $("#resto").val(item.resto);
                    $("#detalle").show();
                });

            }
            
        });

    }else{
        swal("Precaución", "Por favor ingrese el número de reparacion", "warning");
    }
}





$(document).ready(function() 
{
    $('#formLiberar').submit(function(e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        //data.push({name: 'tag', value: 'login'});
        var dineroRecibo = $("#dineroRecibo").val();
        var id = $("#noReparacion").val();
        //alert(dineroRecibo +" " + id);
        $.ajax({
            method: "POST",
            url: "LiberarReparacionForm2.php",
            data: data
        })
        .done(function(respuesta) {
                if(respuesta == 1)
                {
                    //location.reload();
                    location.href = "cobroReparacionFinal.php?idReparacion="+id+"&dineroRecibo="+dineroRecibo;

                }else if(respuesta == 2){         
            
                    swal("Precaución", "Sólo el cajero o administrador puden liberar la reparación", "warning");		

                }else if(respuesta == 3){                
            
                    swal("¡ERROR!", "La reparación no está terminada", "error");	

                }else if(respuesta == 4){
                    swal("¡ERROR!", "No se pudo liberar la reparación", "error");

                }else if(respuesta == 5){
                    swal("¡ERROR!", "¡La reparación ya está liberada!", "error");
                }
            });
        
    })
});

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>
<!-- ************** -->