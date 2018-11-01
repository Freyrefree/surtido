<?php
// include('php_conexion.php');
// $cadena = $_POST['empresa'];
// //$array = explode(",",$cadena);
// //$id_cliente = $array[0];
// //$nombre_completo = $array[1];

// $consulta = "SELECT * FROM cliente_reparacion WHERE nombre_completo='$cadena'";
// $res=mysql_query($consulta);
// $dato = mysql_fetch_array($res);

// echo '<label for="textfield">* Apellido Paterno: </label><input type="text" name="apat" id="apat" value="" autocomplete="off" maxlength="30" required>
//         <label for="textfield">* Apellido Materno: </label><input type="text" name="amat" id="amat" value="">
//         <label for="textfield">* Nombre: </label><input type="text" name="nom" id="nom" value="" autocomplete="off" maxlength="30" required>
//         <label for="textfield">* Fecha de Nacimiento: </label><input type="date" value="" name="fechanac" id="fechanac"autocomplete="off" required>
      
//         '; 
    
//       echo'  
//         <label for="textfield">* Telefono de Cliente: </label><input type="text" name="telefono" id="telefono" value="" autocomplete="off" maxlength="10" pattern="[0-9]{10}" required>';
include('php_conexion.php');
$cadena=$_POST['empresa'];
$array = explode(",",$cadena);
$id_cliente = $array[0];
$nombre_completo = $array[1];
$consulta = "SELECT * FROM cliente_reparacion WHERE nombre_completo='$nombre_completo' AND codigo = '$id_cliente'";
$res=mysql_query($consulta);
$dato = mysql_fetch_array($res);
$codigo = $dato ['codigo'];
$nombre = $dato['nombre'];
$ap = $dato['ap'];
$am = $dato['am'];
$direccion =$dato['direccion'];
$tel = $dato['telefono'];
$correo = $dato['correo'];

echo '<input style="display : none;" type="text" id="UUIDcliente" name ="UUIDcliente" value="'.$codigo.'">
<label id="lbl2" for="textfield">* Apellido Paterno: </label><input type="text" name="apat" id="apat" value="'.$ap.'" autocomplete="off" maxlength="30" readonly>
        <label id="lbl3" for="textfield">* Apellido Materno: </label><input type="text" name="amat" id="amat" value="'.$am.'" readonly>
        <label id="lbl4" for="textfield">* Nombre: </label><input type="text" name="nom" id="nom" value="'.$nombre.'" autocomplete="off" maxlength="30" readonly>
        <label id="lbl5" for="textfield">* Direccion: </label><input type="text" value="'.$direccion.'" name="direccion" id="direccion"autocomplete="off" readonly>
      
'; 
 echo'  
        <label id="lbl6" for="textfield">* Telefono Referencia: </label><input type="text" name="telefono" id="telefono" value="'.$tel.'" autocomplete="off" maxlength="10" pattern="[0-9]{10}" readonly>
        <label id="lbl7" for="textfield">* Correo Referencia: </label><input type="text" name="correo" id="correo" value="'.$correo.'" autocomplete="off" maxlength="10" readonly>';

    
       
        
?>