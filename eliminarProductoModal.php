<?php
session_start();
include("host.php");
include("funciones.php");
$id_sucursal = $_SESSION['id_sucursal'];
if(!$_SESSION['tipo_usu']=='a'){
    header('location:error.php');
}
else
{
    $usuario = $_SESSION['username'];



   // $data = $_POST['arraySeleccionados'];
    $data = json_decode(stripslashes($_POST['arraySeleccionados']));
    $id_producto = trim($_POST['id_producto']);
    $arrayreturn = array();
    $tipo_producto = trim($_POST['tipo_producto']);

    if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
    {
        if (($tipo_producto == 'imei') || ($tipo_producto == 'iccid')) 
        {
            foreach ($data as $identificador) {
                //verificar si existe en base de datos
                $consulta3 = "SELECT * FROM codigo_producto WHERE identificador = '$identificador';";
                if (($paquete = consultar($con, $consulta3))) {
                    $consulta = "DELETE FROM codigo_producto WHERE identificador='$identificador';";
                    if (($paquete = eliminar($con, $consulta))) {
                        $consulta2 = "UPDATE producto SET cantidad = (cantidad-1) WHERE cod = '$id_producto' AND id_sucursal = '$id_sucursal';";
                        if ($paquete = actualizar($con, $consulta2)) {
                            //******Historial
                            $consultalog="INSERT INTO productoseliminados(usuario,codigoProducto,identificador,fecha,lugardelete)VALUES
                            ('$usuario','$id_producto','$identificador',NOW(),'modalcheck')";
                            agregar($con,$consultalog);
                            ///************* */

                            $arrayreturn[] = array('identificador' => $identificador, 'respuesta' => "ELIMINADO");
                        } else {
                            $arrayreturn[] = array('identificador' => $identificador, 'respuesta' => "NO SE PUDO ELIMINAR");
                        }
                    } else {
                    }
                } else {
                    $arrayreturn[] = array('identificador' => $identificador, 'respuesta' => "YA SE ENCUENTRA ELIMINADO");
                }
            }
        
            echo json_encode($arrayreturn);
        }else{
            foreach ($data as $identificador) {
                //verificar si existe en base de datos
                $consulta3 = "SELECT * FROM producto WHERE cod = '$identificador' AND id_sucursal = '$id_sucursal';";
                if (($paquete = consultar($con, $consulta3))) {
                        $consulta2 = "UPDATE producto SET cantidad = (cantidad-1) WHERE cod = '$identificador' AND id_sucursal = '$id_sucursal';";
                        if ($paquete = actualizar($con, $consulta2)) {
                            //******Historial
                            $consultalog="INSERT INTO productoseliminados(usuario,codigoProducto,identificador,fecha,lugardelete)VALUES
                            ('$usuario','$id_producto','$identificador',NOW(),'modalcheck')";
                            agregar($con,$consultalog);
                            ///************* */
                            $arrayreturn[] = array('identificador' => $identificador, 'respuesta' => "ELIMINADO");
                        } else {
                            $arrayreturn[] = array('identificador' => $identificador, 'respuesta' => "NO SE PUDO ELIMINAR");
                        }
                } else {
                    $arrayreturn[] = array('identificador' => $identificador, 'respuesta' => "YA SE ENCUENTRA ELIMINADO");
                }
            }
        
            echo json_encode($arrayreturn);

        }
    }
    else
    {}    
}


?>