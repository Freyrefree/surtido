<?php
include('php_conexion.php');
$empresa=$_POST['empresa'];
$res=mysql_query("SELECT * from cliente where empresa='".$empresa."'");
$empresa2=mysql_result($res,0,'empresa');
$tel=mysql_result($res,0,'tel');
$cadena=explode(" ",$empresa2);
$fecha=mysql_result($res,0,'fecha');
echo '<label for="textfield">* Apellido Paterno: </label><input type="text" name="apat" id="apat" value="'.$cadena[1].'" autocomplete="off" maxlength="30" required>
        <label for="textfield">* Apellido Materno: </label><input type="text" name="amat" id="amat" value="'.$cadena[2].'">
        <label for="textfield">* Nombre: </label><input type="text" name="nom" id="nom" value="'.$cadena[0].'" autocomplete="off" maxlength="30" required>
        <label for="textfield">* Fecha de Nacimiento: </label><input type="date" value="'.$fecha.'" name="fechanac" id="fechanac"autocomplete="off" required>
      
        '; 
    
      echo'  
        <label for="textfield">* Telefono de Cliente: </label><input type="text" name="telefono" id="telefono" value="'.$tel.'" autocomplete="off" maxlength="10" pattern="[0-9]{10}" required>';
        
?>