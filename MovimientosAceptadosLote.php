<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
        $y=0;
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
    <!-- <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> -->
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

    <!-- MODAL LOAD -->
		<script src="js/jquery.loadingModal.min.js" type="text/javascript"></script>		
		<link href="css/jquery.loadingModal.css" rel="stylesheet" type="text/css"/>
	<!--  -->

    <!-- Date Picker -->
    <link rel="stylesheet" href="cortes/themes/base/jquery.ui.all.css">
    <script src="cortes/ui/jquery.ui.core.js"></script>	
	<script src="cortes/ui/jquery.ui.datepicker.js"></script>
    <link rel="stylesheet" href="cortes/demos/demos.css">
    
    <script>
    $(function() {
            $( "#fechainicio" ).datepicker({
                defaultDate: "",
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                }
            });
            $( "#fechafin" ).datepicker({
                defaultDate: "",
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                }
            });
        });
    </script>
  <!-- Date Picker -->   
</head>

<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div align="center">
<a href="NuevoMovimientoLote.php" class="btn btn-lg btn-info">Nuevo Movimiento</a>
<a href="MovimientosLote.php" class="btn btn-lg btn-warning">Movimientos Pendientes</a>
<a href="MovimientosRechazadosLote.php" class="btn btn-lg btn-danger">Movimientos Rechazados</a>

<br><br>
<table class="table">
<tr class="success">
    <td>        
        Desde<input type="text" id="fechainicio" name="fechainicio" value=""/>        
        Hasta<input type="text" id="fechafin" name="fechafin" value=""/>

        <select name="tipo" id="tipo">
            <option value="0">Selecciona Una Opción</option>
            <option value="1">Telefonía</option>
            <option value="2">Accesorios</option>
        </select>
        <button onclick="consultarMA2();" type="button" class="btn btn-primary">Consultar</button>
    </td>
</tr>
</table>

<div id="imprimeme"></div>

    <button onclick="imprimir();" class="btn">
    Imprimir
    </button>

    <script type="text/javascript">
        function imprimir(){
        var objeto=document.getElementById('imprimeme');  //obtenemos el objeto a imprimir
        var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
        ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
        ventana.document.close();  //cerramos el documento
        ventana.print();  //imprimimos la ventana
        ventana.close();  //cerramos la ventana
        }

        function consultarMA2()
        {
            var fecha_ini = document.getElementById("fechainicio").value;
            var mes = fecha_ini.substring(0,2);
            var dia = fecha_ini.substring(3,5);
            var ano = fecha_ini.substring(6,10);
            var divide = "-";
            var fecha_i = ano + divide +  mes + divide + dia;
            
            var fecha_fin = document.getElementById("fechafin").value;	
            var mes1 = fecha_fin.substring(0,2);
            var dia1 = fecha_fin.substring(3,5);
            var ano1 = fecha_fin.substring(6,10);
            var divide1 = "-";
            var fecha_f = ano1 + divide1 +  mes1 + divide1 + dia1;

            var tipo = document.getElementById("tipo").value;


            $('body').loadingModal({text: 'Showing loader animations...', 'animation': 'wanderingCubes'});
			$('body').loadingModal('text', 'Consultando');
			$('body').loadingModal('animation', 'foldingCube');
			$('body').loadingModal('color', '#000');
			$('body').loadingModal('backgroundColor', '#F7D358');
			$('body').loadingModal('opacity', '0.9');
			$('body').loadingModal('show');
            $.ajax({
                method: "POST",
                url: "MovimientosAceptadosLote2.php",
                data: {fechainicio: fecha_i, fechafin: fecha_f, tipo: tipo}
                })
                .done(function(respuesta) 
                {
                    $('body').loadingModal('hide');
					$('body').loadingModal('destroy');
                    $("#imprimeme").html(respuesta);
                });
        }
    </script>

</div>
</body>
</html>