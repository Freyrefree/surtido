<?php
require("php_conexion.php");
	
$servicio = $_REQUEST["servicio"];	

if($Idsucursal=="Todos"){
	echo "Por favor, Seleccione una sucursal";
}else{

$can=mysql_query("SELECT * FROM pagoservicios WHERE CodigoProducto='$servicio'");
if($dato=mysql_fetch_array($can))
    {
        $NombreServicio = $dato['NombreServicio'];
        $MontoUnico     = $dato['MontoUnico'];
    }    
}

if($MontoUnico==NULL){
echo"
<div>
<label for='monto'>Monto</label>
<input type='number' step='any' name='MontoServicio' id='MontoServicio' size='20' style='font-family: Arial;  height:30px; font-size: 20pt;' maxlength='10' required autocomplete='off'>
</div>
";
}else{
echo "
<div>
<label for='monto'>Monto</label>
<input type='number' step='any' name='MontoServicio' id='MontoServicio' size='20' style='font-family: Arial;  height:30px; font-size: 20pt;' maxlength='10' autocomplete='off' value='$MontoUnico' disabled>
</div>
";   
}


?>

<div>
<label for="">Destino</label>
<input type="text" name="DestinoServicio" id="DestinoServicio" size="20" style="font-family: Arial;  height:30px; font-size: 20pt;" maxlength="20" required autocomplete="off">
</div>
<div>

<?php
if($NombreServicio=="Telmex" OR $NombreServicio=="Maxcom"){
echo"
<div>
<label for='extra'>DV</label>
<input type='text' name='CampoExtra' id='CampoExtra' size='20' style='font-family: Arial;  height:30px; font-size: 20pt;' maxlength='30' autocomplete='off' required>
</div>
";
}else{
echo "
<div>
<input type='hidden' name='CampoExtra' id='CampoExtra' size='20' style='font-family: Arial;  height:30px; font-size: 20pt;' maxlength='30' autocomplete='off'>
</div>
";    
}
?>