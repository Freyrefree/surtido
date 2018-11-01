<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];

        $IdLote=$_REQUEST['IdLote'];
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
        <td colspan="9"><center><strong>Movimientos Pendientes</strong></center></td>
    </tr>
    <tr>
        <th><strong>No. Lote</strong></th>
        <th><strong>Sucursal Salida</strong></th>
        <th><strong>Sucursal Entrada</strong></th>
        <th><strong>Código producto</strong></th>
        <th><strong>Producto</strong></th>
        <th><strong>Cantidad</strong></th>
        <th><strong>Cantidad Recibida</strong></th>
        <th width="200px"><strong>Fecha Salida</strong></th>
        <th  width="130px"><strong>Aceptar / Rechazar</strong></td>
    </tr>
<?php
  if($IdLote==""){      
        $query2=mysql_query("SELECT * FROM movimientosxlote WHERE (IdSucSalida=$id_sucursal OR IdSucEntrada=$id_sucursal) AND recibido=0");
  }else{
        $query2=mysql_query("SELECT * FROM movimientosxlote WHERE (IdSucSalida=$id_sucursal OR IdSucEntrada=$id_sucursal) AND recibido=0 AND IdLote=$IdLote");
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
        <td><?php echo"<input type='number' name='Aceptados$y' id='Aceptados$y' style='width: 90px;' min='0'>" ?></td>
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