<?php
if (isset($_REQUEST['term'])){
    $term=$_REQUEST['term'];
    $return_arr = array();

    session_start();
    $id_sucursal = $_SESSION['id_sucursal'];

include('php_conexion.php'); 

        $sqle = mysql_query("SELECT * FROM producto WHERE (nom LIKE '%$term%' OR  cod LIKE '%$term%') AND id_sucursal=$id_sucursal ORDER BY nom ASC") or die(print("Error en el buscador de termino"));
        while($dat=mysql_fetch_array($sqle))
        {
			$nom    = $dat['nom'];
			$ResNom = str_replace(" ","_",$nom);
           $return_arr[] = $ResNom;
        }

    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
}
?>