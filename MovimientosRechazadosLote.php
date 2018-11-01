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
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div align="center">
<a href="NuevoMovimientoLote.php" class="btn btn-lg btn-info">Nuevo Movimiento</a>
<a href="MovimientosLote.php" class="btn btn-lg btn-warning">Movimientos Pendientes</a>
<a href="MovimientosAceptadosLote.php" class="btn btn-lg btn-success">Movimientos Autorizados</a>
<?php
 $rs = mysql_query("SELECT MAX(IdLote) AS id FROM movimientosxlote");
        if ($row = mysql_fetch_row($rs)) {
            $IdMovimiento = trim($row[0]);
        }else{
            $IdMovimiento = 1;
        }
        
      
?>

<div id="imprimeme">
<table class="table">
<style>
input[type="checkbox"]{
width: 30px; /*Desired width*/
height: 30px; /*Desired height*/
cursor: pointer;
-moz-appearance: none;
}

td { 
    vertical-align:middle;
    text-align: center;
}
</style>

<tbody>
    <tr class="error">
        <td colspan="10"><center><strong>Movimientos Rechazados</strong></center></td>
    </tr>
    <tr>
        <th><strong>No. Lote</strong></td>
        <th><strong>Sucursal Salida</strong></td>
        <th><strong>Sucursal Entrada</strong></td>
        <th><strong>Código producto</strong></td>
        <th><strong>Producto</strong></td>
        <th><strong>Cantidad Enviada</strong></td>
        <th><strong>Cantidad Recibida</strong></td>
        <th><strong width="200px">Fecha Entrada</strong></td>
        <th><strong>Recibido</strong></td>
        <th><strong>Razón del Rechazo</strong></td>
    </tr>
    </tr>
<?php
        if($tipo_usu=="a"){
            $query2=mysql_query("SELECT * FROM movimientosxlote WHERE recibido=2 ORDER BY FechaEntrada DESC");
        }else{
            $query2=mysql_query("SELECT * FROM movimientosxlote WHERE (IdSucSalida=$id_sucursal OR IdSucEntrada=$id_sucursal) AND recibido=2 ORDER BY FechaEntrada DESC");
        }
        
        while($dato=mysql_fetch_array($query2)){
              $y=$y+1;  

              $Id           =$dato['Id'];
              $IdSucSalida  =$dato['IdSucSalida'];
              $IdSucEntrada =$dato['IdSucEntrada'];
              $IdProducto   =$dato['IdProducto'];
              $IMEI         =$dato['IMEI'];
              $ICCID        =$dato['ICCID'];
              $IdFciha      =$dato['IdFciha'];

              $QSucSal=mysql_query("SELECT * FROM empresa WHERE id=$IdSucSalida");
              if($DSucSal=mysql_fetch_array($QSucSal)){
                 $SucursalSalida=$DSucSal['empresa'];
              }

              $QSucEnt=mysql_query("SELECT * FROM empresa WHERE id=$IdSucEntrada");
              if($DSucEnt=mysql_fetch_array($QSucEnt)){
                 $SucursalEntrada=$DSucEnt['empresa'];     
              }

              $QProduc=mysql_query("SELECT * FROM producto WHERE cod='$IdProducto'"); 
              if($DProduc=mysql_fetch_array($QProduc)){
                 $NombreProducto=$DProduc['nom'];
              }     

?>        
    <tr>
        <td><?php echo $dato['IdLote'] ?></td>
        <td><?php echo $SucursalSalida ?></td>
        <td><?php echo $SucursalEntrada ?></td>
        <td><?php echo $dato['IdProducto'] ?></td>
        <td><?php echo $NombreProducto ?></td>
        <td><?php echo $dato['Cantidad'] ?></td>
        <td><?php echo $dato['CantRecibida'] ?></td>
        <td width="200px"><?php echo $dato['FechaEntrada'] ?></td>
        <td><strong>X</strong></td>
        <td><?php echo $dato['RazonRechazo'] ?></td>
    </tr>
<?php    
echo"
<script>
$(function () {
	
    $('#ChekRecib$y').change(function ()
	{  
       $( '#ConfCheck$y' ).load( 'MarcaElementoLote.php?Elemento='+$(this).val()); 
	})
})
</script>
";
}
?>        
    </tbody>


</table>
</div>

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

$(function () {
	
    $('#FiltroLote').change(function ()
	{
        $('#imprimeme').load('FiltrarLoteRechazado.php?IdLote=' + this.options[this.selectedIndex].value)
 
	})
})
</script>

</div>
</body>
</html>