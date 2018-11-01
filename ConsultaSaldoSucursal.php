<?php
require("php_conexion.php");

$IdSucursal = $_REQUEST["sucursal"];	

$query  = "SELECT * FROM recargassucursal WHERE IdSucursal=$IdSucursal";

 $can=mysql_query("SELECT * FROM recargassucursal WHERE IdSucursal=$IdSucursal");
          if($dato=mysql_fetch_array($can)){
             echo "$". $Saldo = $dato['Saldo'];
          }

$result = mysql_query($can);
$cuantos= mysql_num_rows($can);

        if($cuantos==0){
            echo "No se ha asignado saldo aún";
        }
?>