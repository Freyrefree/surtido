<?php
require("php_conexion.php");
$n = $_REQUEST["n"];	
$IdSucursal = $_REQUEST["sucursal"];	

for($y=1;$y<=$n;$y++){
$cod = $_REQUEST["producto$y"];

    $cod = str_replace("_"," ", $cod);

if($_REQUEST["producto$y"]){

$query  = "SELECT * FROM producto WHERE (cod='$cod' OR nom='$cod' ) AND IdSucursal=$IdSucursal";

 $can=mysql_query("SELECT * FROM producto WHERE (cod='$cod' OR nom='$cod') AND id_sucursal=$IdSucursal");
          if($dato=mysql_fetch_array($can)){
             echo $Cantidad = $dato['cantidad'];
          }

$result = mysql_query($can);
$cuantos= mysql_num_rows($can);

        if($cuantos==0){
            echo "No hay productos";
        }
}        
}        
?>