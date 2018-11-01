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
<a href="MovimientosAceptadosLote.php" class="btn btn-lg btn-success">Movimientos Autorizados</a>
<a href="MovimientosRechazadosLote.php" class="btn btn-lg btn-danger">Movimientos Rechazados</a>
<?php
 $rs = mysql_query("SELECT MAX(IdLote) AS id FROM movimientosxlote");
        if ($row = mysql_fetch_row($rs)) {
            $IdMovimiento = trim($row[0]);
        }else{
            $IdMovimiento = 1;
        }
        
// echo "<select name='FiltroLote' id='FiltroLote' class='btn'>";
// echo "<option value='' selected>Filtrar por No. Lote</option>";
// for($i=1;$i<=$IdMovimiento;$i++){

//      if($tipo_usu=="a"){
//             $query2=mysql_query("SELECT * FROM movimientosxlote WHERE IdLote=$i AND Recibido=0");
//         }else{
//             $query2=mysql_query("SELECT * FROM movimientosxlote WHERE IdLote=$i AND Recibido=0 AND (IdSucSalida='$id_sucursal' OR IdSucEntrada='$id_sucursal')") or die (print("Error al obtener No de lotes"));   
//         }

    
//     if($dato=mysql_fetch_array($query2)){ 
//        $LoteObtenido = $dato['IdLote']; 
//     }

//     //if($LoteObtenido==$i){
//      //   echo "<option value='$i'>$i</option>";
//    // } 
    
// }      
//echo "</select>";        
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
    <tr class="warning">
        <td colspan="11"><center><strong>Movimientos Pendientes</strong></center></td>
    </tr>
    <tr>
        <th><strong>No. Lote</strong></th>
        <th><strong>Sucursal Salida</strong></th>
        <th><strong>Sucursal Entrada</strong></th>
        <th><strong>Código producto</strong></th>
        <th><strong>Producto</strong></th>
        <th><strong>IMEI</strong></th>
        <th><strong>ICCID</strong></th>
        <th><strong>Cantidad</strong></th>
        <th><strong>Cantidad Recibida</strong></th>
        <th  width="200px"><strong>Fecha Salida</strong></th>
        <th  width="130px"><strong>Aceptar / Rechazar</strong></td>
    </tr>
<?php
        if($tipo_usu=="a"){
            $query2=mysql_query("SELECT * FROM movimientosxlote WHERE recibido=0");
        }else{
            $query2=mysql_query("SELECT * FROM movimientosxlote WHERE (IdSucSalida=$id_sucursal OR IdSucEntrada=$id_sucursal) AND recibido=0");
        }

        while($dato=mysql_fetch_array($query2)){
              $y=$y+1;  

              $Id           =$dato['Id'];
              $IdLote       =$dato['IdLote'];
              $IdSucSalida  =$dato['IdSucSalida'];
              $IdSucEntrada =$dato['IdSucEntrada'];
              $IdProducto   =$dato['IdProducto'];
              $IMEI         =$dato['IMEI'];
              $ICCID        =$dato['ICCID'];
              $IdFicha      =$dato['IdFicha'];

              $cantidad     = $dato['Cantidad'];

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
                 $NombreProducto= saltoCadena($DProduc['nom']);
              }     

?>        
    <tr>
        <td><?php echo $dato['IdLote'] ?></td>
        <td><?php echo $SucursalSalida ?></td>
        <td><?php echo $SucursalEntrada ?></td>
        <td><?php echo $dato['IdProducto'] ?></td>
        <td><?php echo $NombreProducto ?></td>
        <td><?php echo $IMEI ?></td>
        <td><?php echo $ICCID ?></td>
        <td><?php echo $dato['Cantidad'] ?></td>
        <td><?php echo"<input type='number' name='Aceptados$y' id='Aceptados$y' style='width: 90px;' min='0' value='$cantidad' readonly>" ?></td>
        <td width="200px"><?php echo $dato['FechaSalida'] ?></td>
        <td>
            <?php
            //$id_sucursal=$IdSucEntrada; //solo para pruebas
            if($IdSucEntrada==$id_sucursal){
               echo "
               <div id='ConfCheck$y'>
                ✓ <input type='checkbox' name='ChekRecib$y' id='ChekRecib$y' value='$IdProducto?$IMEI?$ICCID?$IdFicha?$IdLote'>
                X <input type='checkbox' name='CheckRechazar$y' id='CheckRechazar$y' value='$IdProducto?$IMEI?$ICCID?$IdFicha?$IdLote' data-target='#myModal'>
               </div>
                "; 
            } 
            ?>
        </td>
    </tr>
<?php    
echo"
<script>
$(function () {
	
    $('#CheckRechazar$y').change(function ()
	{  
       var Elemento$y = $('#CheckRechazar$y').val();
       var Aceptados$y = $('#Aceptados$y').val();
       $( '#ConfCheck$y' ).load('RechazaElementoLote.php?Elemento=' + Elemento$y + '&Aceptados='+ Aceptados$y);
	})
})
</script>

<script>
$(function () {
	
    $('#ChekRecib$y').change(function ()
	{  
       var Elemento$y = $('#ChekRecib$y').val();
       var Aceptados$y = $('#Aceptados$y').val();
       $( '#ConfCheck$y' ).load('MarcaElementoLote.php?Elemento=' + Elemento$y + '&Aceptados='+ Aceptados$y);
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
        $('#imprimeme').load('FiltrarLote.php?IdLote=' + this.options[this.selectedIndex].value)
 
	})
})
</script>

</div>
</body>
</html>

<?php
function saltoCadena($stirng){

    $nuevo_texto = wordwrap($stirng, 10,'@@', 1);
    $array = explode('@@',$nuevo_texto);
    $cadenaConfig = "";
  
    foreach($array as &$valor){
  
        $cadenaConfig.= $valor." <br>";
    }
  
    return $cadenaConfig;
  }

?>