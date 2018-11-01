<?php
if (isset($_REQUEST['term'])){
    $term=$_REQUEST['term'];
    $return_arr = array();

include('php_conexion.php'); 

        $sqle = mysql_query("SELECT * FROM cliente WHERE empresa 
        LIKE '%$term%' OR  
        cel LIKE '%$term%' OR  
        nom LIKE '%$term%'") or die(print("Error en el buscador de termino"));
        while($dat=mysql_fetch_array($sqle)){
              $return_arr[] = $dat['empresa'];;
        }

    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
}
?>