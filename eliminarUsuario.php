<?php
session_start();
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(0);
include("host.php");
include("funciones.php");

$id_usuario = $_POST['id_usuario'];
$opcion = $_POST['opc'];

if($opcion == 1)//para verificar si no hay existencias
{
    if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
    {
        $consulta = "SELECT * FROM usuarios WHERE ced = '$id_usuario'";
        if ($paquete = consultar($con, $consulta)) {
            $fila = mysqli_fetch_array($paquete);
            $estado = $fila['estado'];
            if ($estado == 's') {
                echo 2; // retorno si el usuario está activo
            } elseif ($estado == 'n') {
                echo 1; // retorno para confirmar eliminacion
            }
        }else
        {        
            echo 0; ///Sin resultados              
        }
    }
    else{echo 0;}

}else if($opcion == 2)
{
    if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
    {
        $consulta = "DELETE FROM usuarios WHERE ced = '$id_usuario'";
        if ($paquete = eliminar($con, $consulta)) 
        {
            echo 1;
        }else
        {echo 0;}
    }
    else{echo 0;}

}
?>