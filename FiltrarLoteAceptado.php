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
    <tr class="success">
        <td colspan="9"><center><strong>Movimientos Autorizados</strong></center></td>
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
    </tr>
    </tr>
<?php
if($tipo_usu=="a"){
 if($IdLote==""){      
            $query2=mysql_query("SELECT * FROM movimientosxlote WHERE recibido=1");
      }else{
            $query2=mysql_query("SELECT * FROM movimientosxlote WHERE recibido=1 AND IdLote=$IdLote");
     }     
}else{
 if($IdLote==""){      
            $query2=mysql_query("SELECT * FROM movimientosxlote WHERE (IdSucSalida=$id_sucursal OR IdSucEntrada=$id_sucursal) AND recibido=1");
      }else{
            $query2=mysql_query("SELECT * FROM movimientosxlote WHERE (IdSucSalida=$id_sucursal OR IdSucEntrada=$id_sucursal) AND recibido=1 AND IdLote=$IdLote");
     }    

}  
    while($dato=mysql_fetch_array($query2)){
              $y=$y+1;  

              $Id           =$dato['Id'];
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
        <td><?php echo $dato['CantRecibida'] ?></td>
        <td width="200px"><?php echo $dato['FechaEntrada'] ?></td>
        <td>
           <strong>✓</strong>
        </td>
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