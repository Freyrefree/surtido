<?php
        session_start();
        include('php_conexion.php'); 
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
        $usu = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cancelar Venta</title>
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
    <script src="js/jquery-barcode.js"></script>
    <script src="js/html2canvas.js"></script>
    <script src="js/jspdf.debug.js"></script>


    
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
    <style>
     .Saldos{
            background-color: #8acae8;
        }

        .codebar{
            border: 1px;
            border-style: solid;
            border-color: #000;
            margin-left: 30px;
            margin-bottom: 0px;
            margin-right: 10px;
            padding: 5px;
        }
        .hr{
            /* background: blue; */
            margin-bottom: -20px;
        }
        .thumb{
             height: 140px;
             width: 200px;
             border: 1px solid #000;
             margin: 5px 5px 0 0;
        }
        .panel-compra{
            padding-left: 10px;
            padding-top: 10px;
          border-style: solid;
          border-color: #BDBDBD;
          border-top-width: 1px;
          border-right-width: 1px;
          border-bottom-width: 1px;
          border-left-width: 1px;

        }
        /* .incd{
            margin-top: 20px;
        } */
    </style>
</head>
<!-- fin de los estilos -->
<?php 
$datestart  = $_POST['inicio'];
$datefinish = $_POST['fin'];
 ?>

<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div align="center">

<form name="f1" id="f1" action="" method="post" enctype="multipart/form-data">
<table>
<tr>
<td>Fecha Inicial<br><input type="date" name="inicio" id="inicio" value="<?php echo $datestart ?>"  required></td>
<td>Fecha Final<br><input type="date" name="fin" id="fin" value="<?php echo $datefinish ?>" required></td>
</tr>
<tr>
<td><center><input type="submit" class="btn btn-lg btn-info" value="Mostrar reporte"></center></td>
<td><center><button type="button" class="btn btn-lg btn-success" onClick="GenerarExcel();" >Generar Excel</button></center></td>
</tr>
</form>

<table width="80%" border="0" class="table">
<tbody>
    <tr class="info">
        <td colspan="7"><center><strong>Reporte de movimientos de saldo para recargas</strong></center></td>
    </tr>
    <tr>
        <th><strong>Codigo</strong></td>
        <th><strong>Sucursal</strong></td>
        <th><strong>Saldo</strong></td>
        <th><strong>Fecha</strong></td>
        <th><strong>Hora</strong></td>
    </tr>
<?php
        $query2=mysql_query("SELECT * FROM detallerecargassucursal WHERE Fecha BETWEEN '$datestart' AND '$datefinish'");
        while($dato=mysql_fetch_array($query2)){
?>        
    <tr>
        <td><?php echo $dato['Id'] ?></td>
        <td><?php echo $dato['Sucursal'] ?></td>
        <td><?php echo $dato['Saldo'] ?></td>
        <td><?php echo $dato['Fecha'] ?></td>
        <td><?php echo $dato['Hora'] ?></td>
    </tr>
<?php   
         $SumSaldo = $SumSaldo + $dato['Saldo'];
        }
?>          
        <th class="Saldos">Suma de saldos movidos</td>
        <th class="Saldos"></td>
        <td class="Saldos" colspan="3"><?php echo $SumSaldo ?></td>
    </tbody>


</table>
</div>
</body>
</html>

<script>
	function GenerarExcel(){
	var datestart = document.getElementById("inicio").value;
	var datefinish = document.getElementById("fin").value;;
	var parametros = {
		   		datestart: datestart,
		   		datefinish: datefinish
        };
        $.ajax({
                data:  parametros,
                url:   'ExcelSaldoVirtual.php',
                type:  'post',
                beforeSend: function () {
                },
                success:  function (data) {
					window.location = 'ExcelSaldoVirtual.php?datestart='+datestart+'&datefinish='+datefinish;
                }
        });
	}
</script>