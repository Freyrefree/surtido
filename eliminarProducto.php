<?php
session_start();
//error_reporting(E_ALL ^ E_DEPRECATED);
//error_reporting(0);
include("host.php");
include("funciones.php");
$array = array();
$usuario = $_SESSION['username'];
$id_sucursal = $_SESSION['id_sucursal'];
$nombreSucursal = $_SESSION['sucursal'];
$codigoProducto = $_POST['codigoProducto'];
$opcion = $_POST['opcion'];

if($opcion == 1)//para verificar si no hay existencias
{
    if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
    {
        $consulta = "SELECT * FROM producto WHERE cod = '$codigoProducto' AND id_sucursal = '$id_sucursal';";
        if ($paquete = consultar($con, $consulta)) 
        {
            $fila = mysqli_fetch_array($paquete);
            $estado = $fila['estado'];
            if (($estado == 's') || ($estado == "S")) { /// VALIDACICIÓN para saber si el estado del prodcto esta inactivo
                echo 2; // retorno si el producto está activo
            } elseif ($estado == 'n') {
                $consulta2 = "SELECT * FROM producto WHERE cod = '$codigoProducto' AND  cantidad > 0";// verificar si hay existencias en otras sucursales
                if($paquete = consultar($con,$consulta2)){
                    $codigoTabla = tabularProductoExistencia($paquete);
                     echo $codigoTabla;
                }else{
                    echo 1; // retorno si el producto no tiene existencias (Se puede Eliminar)
                }

            }
                //echo 1; // retorno para confirmar eliminacion
            
        }else{echo 0;} ///Sin resultados
    }else{echo 0;} ///error en conexion

}else if($opcion == 2)
{
    if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
    {
        $consulta = "DELETE FROM producto WHERE cod = '$codigoProducto'; ";
        if ($paquete = eliminar($con, $consulta)) 
        {
            //******Historial
            $consultalog="INSERT INTO productoseliminados(usuario,codigoProducto,identificador,fecha,lugardelete)VALUES
            ('$usuario','$codigoProducto','$codigoProducto',NOW(),'listado')";
            agregar($con,$consultalog);
            ///************* */

            echo 1;
        }else
        {echo 0;}
    }
    else{echo 0;}
}

?>