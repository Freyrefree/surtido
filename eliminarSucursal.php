<?php
session_start();
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(0);
include("host.php");
include("funciones.php");

$id_sucursal = $_POST['id_sucursal'];
$opcion = $_POST['opc'];

if($opcion == 1)//para verificar si no hay existencias
{
    if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
    {
        $consulta = "SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' AND cantidad > 0 ORDER BY nom ASC";
        if ($paquete = consultar($con, $consulta)) 
        {
            while($fila = mysqli_fetch_array($paquete))
            {
                $id_producto = $fila['cod'];
                $nom = $fila['nom'];
                $cantidad = $fila['cantidad'];

                $data[] = array(

                    'id_producto'        => $fila['id'],
                    'nombre_producto'    => utf8_encode($fila['nom']),
                    'cantidad'           => utf8_encode($fila['cantidad'])
                );
            }
            echo json_encode($data);  // caso cuando en la sucursal hay productos con existencias y no se podrá eliminar
        }
        else
        {        
            echo 1; ///Retono para confirmar Eliminacion              
        }
    }
    else{echo 0;}

}else if($opcion == 2)//Para confirmar eliminación
{
    if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
    {
        $consulta = "DELETE FROM empresa WHERE id = '$id_sucursal'";
        if($paquete = eliminar($con, $consulta))
        {
            echo 1; ///Sucursal Eliminada            
        }
    }
    else{echo 0;}

}
?>