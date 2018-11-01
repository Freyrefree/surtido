<?php
include('php_conexion.php'); 

$IdSucursal = $_REQUEST["sucursal"];	
$Saldo = $_REQUEST["saldo"];	

if($IdSucursal==0){
	echo "Por favor, Seleccione una sucursal";
?>
<script type="text/javascript">
swal({
  title: "¡Precaución!",
  text: "Seleccione una sucursal por favor",
  type: "warning",
  confirmButtonText: "Aceptar"
});
</script>
<?php
}else{

$can=mysql_query("SELECT * FROM empresa WHERE id=$IdSucursal");
if($dato=mysql_fetch_array($can)){
     $Sucursal = $dato['empresa'];
}    

$query  = "INSERT INTO detallerecargassucursal (IdSucursal, Sucursal, Saldo, Fecha, Hora) VALUES($IdSucursal, '$Sucursal', $Saldo, CURDATE(), CURTIME())";
$result = mysql_query($query);   


$can=mysql_query("SELECT * FROM recargassucursal WHERE IdSucursal=$IdSucursal");
$cuantos= mysql_num_rows($can);
        	

        if($cuantos==0){

            $query  = "INSERT INTO recargassucursal (Sucursal, IdSucursal, Saldo) VALUES('$Sucursal', $IdSucursal, $Saldo)";
            $result = mysql_query($query);    

            if($IdSucursal!=1){

                $can=mysql_query("SELECT * FROM recargassucursal WHERE IdSucursal=1");
                $ExisteMatriz= mysql_num_rows($can);

                if($ExisteMatriz==0){
                    $query  = "INSERT INTO recargassucursal (Sucursal, IdSucursal, Saldo) VALUES('MATRIZ', 1, 0)";
                    $result = mysql_query($query);  
                }

                $query2  = "UPDATE recargassucursal SET saldo=saldo-$Saldo WHERE IdSucursal=1 or Sucursal='MATRIZ'";
                $result2 = mysql_query($query2);  
             }

        }else {

             $query  = "UPDATE recargassucursal SET saldo=saldo+$Saldo WHERE IdSucursal=$IdSucursal";
             $result = mysql_query($query);  
             if($IdSucursal!=1){
             $query2  = "UPDATE recargassucursal SET saldo=saldo-$Saldo WHERE IdSucursal=1 or Sucursal='MATRIZ'";
             $result2 = mysql_query($query2);  
             }

        }

//echo "$".$Saldo;
?>
<script type="text/javascript">
swal({
  title: "¡Hecho!",
  text: "Se ha agregado saldo a la sucursal",
  type: "success",
  confirmButtonText: "Aceptar"
});
</script>
<?php
}		
?>

<table width="80%" border="0" class="table">
<tbody>
    <tr class="info">
        <td colspan="7"><center><strong>Saldo Actual en Sucursales</strong></center></td>
    </tr>
    <tr>
        <th><strong>Codigo</strong></td>
        <th><strong>Sucursal</strong></td>
        <th><strong>Saldo</strong></td>
    </tr>
<?php
        $query2=mysql_query("SELECT * FROM recargassucursal");
        while($dato=mysql_fetch_array($query2)){
?>        
    <tr>
        <td><?php echo $dato['Id'] ?></td>
        <td><?php echo $dato['Sucursal'] ?></td>
        <td><?php echo "$".$dato['Saldo'] ?></td>
    </tr>
<?php    
        }
?>        
    </tbody>
</table>


