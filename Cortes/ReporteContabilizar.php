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
if(!isset($datestart) or !isset($datefinish)){
    $datestart  = date("Y-m-d");
    $datefinish = date("Y-m-d");
}
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
<td colspan="2"><center><input type="submit" class="btn btn-lg btn-info" value="Mostrar reporte"></center></td>
<!-- <td><center><button type="button" class="btn btn-lg btn-success" onClick="GenerarExcel();" >Generar Excel</button></center></td> -->
</tr>
</form>

<table width="80%" border="0" class="table">
<tbody>
    <tr class="info">
        <td colspan="17"><center><strong>Reporte de Billetes y Monedas contabilizados</strong></center></td>
    </tr>
    <tr>
        <th><strong>Codigo</strong></th>
        <th><strong>Cajero</strong></th>
        <th><strong>Sucursal</strong></th>
        <th><strong>B. de $20</strong></th>
        <th><strong>B. de $50</strong></th>
        <th><strong>B. de $100</strong></th>
        <th><strong>B. de $200</strong></th>
        <th><strong>B. de $500</strong></th>
        <th><strong>B. de $1000</strong></th>
        <th><strong>M. de  $0.50</strong></th>
        <th><strong>M. de  $1</strong></th>
        <th><strong>M. de  $2</strong></th>
        <th><strong>M. de  $5</strong></th>
        <th><strong>M. de  $10</strong></th>
        <th><strong>M. de  $20</strong></th>
        <th width="7%"><strong>Fecha</strong></th>
        <th><strong>Hora de Cierre</strong></th>
    </tr>
<?php
        $query2=mysql_query("SELECT * FROM billetes_monedas WHERE Fecha BETWEEN '$datestart' AND '$datefinish'");
        while($dato=mysql_fetch_array($query2)){

                $IdCajero            = $dato['id_cajero'];
                $sucursal            = $dato['sucursal'];

            $query3=mysql_query("SELECT * FROM usuarios WHERE ced='$IdCajero'");
            if($dato3=mysql_fetch_array($query3)){

                $cajero          = $dato3['nom'];
            
            }

            $query4=mysql_query("SELECT * FROM empresa WHERE id='$IdSucursal'");
            if($dato4=mysql_fetch_array($query4)){

                $sucursal = $dato4['empresa'];
            
            }


?>        
    <tr>
        <td><?php echo $dato['id'] ?></td>
        <td><?php echo $cajero ?></td>
        <td><?php echo $sucursal ?></td>
        <td><?php echo $dato['b20'] ?></td>
        <td><?php echo $dato['b50'] ?></td>
        <td><?php echo $dato['b100'] ?></td>
        <td><?php echo $dato['b200'] ?></td>
        <td><?php echo $dato['b500'] ?></td>
        <td><?php echo $dato['b1000'] ?></td>
        <td><?php echo $dato['m050'] ?></td>
        <td><?php echo $dato['m1'] ?></td>
        <td><?php echo $dato['m2'] ?></td>
        <td><?php echo $dato['m5'] ?></td>
        <td><?php echo $dato['m10'] ?></td>
        <td><?php echo $dato['m20'] ?></td>
        <td><?php echo $dato['Fecha'] ?></td>
        <td><?php echo $dato['HoraCierre'] ?></td>
    </tr>
<?php   
        }
?>          
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