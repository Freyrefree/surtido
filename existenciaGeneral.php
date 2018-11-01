<?php
 		session_start();
		include('php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a'){
			header('location:error.php');
		}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TABLA REPORTES</title>
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

   

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css"/>
    

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>

    <script src="js/datatable/dataTables.colResize.js"></script>

     <!-- MODAL LOAD -->
		<script src="js/jquery.loadingModal.min.js" type="text/javascript"></script>		
		<link href="css/jquery.loadingModal.css" rel="stylesheet" type="text/css"/>
	<!--  -->



</head>
<body>
<table class="table">
<tr class="success">
    <td>        
        <button onclick="consultarExistencia();" type="button" class="btn btn-primary">Consultar Existencia General</button>
    </td>
</tr>
</table>
<br/>
<div id="informacion"></div>
</body>
</html>

<script type="text/javascript">
function consultarExistencia()
{
    $('body').loadingModal({text: 'Showing loader animations...', 'animation': 'wanderingCubes'});
    $('body').loadingModal('text', 'Consultando');
    $('body').loadingModal('animation', 'foldingCube');
    $('body').loadingModal('color', '#000');
    $('body').loadingModal('backgroundColor', '#F7D358');
    $('body').loadingModal('opacity', '0.9');
    $('body').loadingModal('show');
    $.ajax({
    method: "POST",
    url: "existenciaGeneral2.php",
    data: {}
    })
    .done(function(respuesta) {
        //alert( "Data Saved: " + msg );
        $('body').loadingModal('hide');
		$('body').loadingModal('destroy');
        $("#informacion").html(respuesta);
        dataTable();
    });
}
</script>
<script type="text/javascript">
    // function dataTable(){
        
    // $('#example').DataTable( {
    //     dom: 'Zlfrtip',
    //     dom: 'Bfrtip',
    //     buttons: [
    //         //'copyHtml5',
    //         'excelHtml5',
    //         //'csvHtml5',
    //         //'pdfHtml5'
    //     ]
    // } );

    // }
</script> 
<script type="text/javascript">

    function dataTable(){
    $('#example').DataTable( {
        "iDisplayLength": 25,
        responsive: true,
        dom: 'Bfrtip',
        
        
        buttons: [
            //'copy',
            // 'csv',
            'excel',
            // 'pdf',
            // 'print'
        ]
    } );
    }

</script> 