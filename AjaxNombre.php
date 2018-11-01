<?php
session_start();
include('php_conexion.php'); 
$usu=$_SESSION['username'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
header('location:error.php');
}
    
echo $Client = $_REQUEST['client'];
//$Categoria = str_replace('_',' ',$Categoria);  

mysql_query("SELECT * FROM cliente WHERE empresa='$Client'");
    if($dato=mysql_fetch_array($can)){
    $cel=$dato['cel'];

echo"
<label for=''>Confirmar Numero Celular</label>
<input type='text' name='numero2' id='numero2' size='20' style='font-family: Arial;  height:30px; font-size: 20pt;' pattern='[0-9]{10}' maxlength='10' required autocomplete='off' value='$cel'>
";
    }
?>