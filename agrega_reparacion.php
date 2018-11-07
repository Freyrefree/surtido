<?php
session_start();
//include('php_conexion.php');
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(0);
include("host.php");
include("funciones.php");
date_default_timezone_set("America/Mexico_City");

if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
{
    @mysqli_query($con, "SET NAMES 'utf8'");

    $id_sucursal = $_SESSION['id_sucursal'];
    $usu=$_SESSION['username'];

    $id_cliente = trim($_POST['UUIDcliente']);
    $agregaNuevo = trim(@$_POST['cb1']);

    $imei = trim($_POST['imei']);
    $marca = trim($_POST['marca']);
    $modelo = trim($_POST['modelo']);
    $color = trim($_POST['color']);
    $precio = trim($_POST['precio']);
    $motivo = trim($_POST['motivo']);
    $observacion = trim($_POST['observacion']);
    //$fecha_salida = trim($_POST['fecha']);
    $abono = trim($_POST['abono']);
   
    $chip = $_POST['chip'];
    $memoria = $_POST['memoria'];
    //$rfccurp = trim($_POST['rfccurp']);//
    $fecha_ingreso = trim($_POST['fechai']);

    $numer  = $_POST['numer'];
    $dh     = $_POST['dh'];

    ## Cálculo fecha Entrega ##
    $hoy = date("Y-m-d H:i:s");
    $fechaSalida = "";

    switch ($dh) 
    {
        case "minutos":
            $fechaSalida = date('Y-m-d H:i:s', strtotime($fechaSalida . ' +'.$numer.' minutes'));
            break;
        case "horas":
            $fechaSalida = date('Y-m-d H:i:s', strtotime($fechaSalida . ' +'.$numer.' hours'));
            break;
        case "dias":
            $fechaSalida = date('Y-m-d H:i:s', strtotime($fechaSalida . ' +'.$numer.' day'));
            break;
    }


    ########################3
  

    $nombreContacto = strtoupper($_POST['nom']);
    $apaternoContacto = strtoupper($_POST['apat']);
    $amaternoContacto = strtoupper($_POST['amat']);
    $nombreCompleto = $nombreContacto." ".$apaternoContacto." ".$amaternoContacto;
    $correoContacto = strtolower($_POST['correo']);
    $direccionContacto = strtolower($_POST['direccion']);
    $telefonoContacto = strtolower($_POST['telefono']);

    //**Diferencia de pago */
    $resto = ($precio - $abono);
    //***********************

    //******crea RFC*****************************************
    $paterno = strtoupper($_POST['apat']);
    $materno = strtoupper($_POST['apat']);
    $nombre  = strtoupper($_POST['nom']);
    $conso = array("B","C","D","F","G","H","J","K","L","M","N","Ñ","P","Q","R","S","T","V","W","X","Y","Z");
    if (in_array(substr($paterno, 1, 1), $conso)) {
        $consonante = substr($paterno, 0, 1);
        $vocal = substr($paterno, 2, 1);
        $paterno = $consonante.$vocal;
    }else {
        $paterno = substr($paterno, 0, 2);
    }
    $materno = substr($materno, 0, 1);
    $nombre  = substr($nombre , 0, 1);
    $first_part = $paterno.$materno.$nombre;
    $rfc = $first_part;

    //*******************************************************


    //**************** VERIFICAR SI SE DEBE AGREGAR NUEVO USUARIO*********************
    if($id_cliente == '' && $agregaNuevo != 1)
    {
        $agregaCliente = "INSERT INTO cliente_reparacion(rfc,nombre,ap,am,nombre_completo,direccion,correo,telefono)
        VALUES ('$rfc','$nombreContacto','$apaternoContacto','$amaternoContacto','$nombreCompleto','$direccionContacto',
        '$correoContacto','$telefonoContacto');";

        if($paquete = agregar($con,$agregaCliente))
        {
            $consulta4 = "SELECT * FROM cliente_reparacion WHERE rfc =
             '$rfc' AND nombre = '$nombreContacto' AND ap = '$apaternoContacto' AND am = '$amaternoContacto' AND correo = '$correoContacto' AND telefono = '$telefonoContacto' ";
            
            if ($paquete = consultar($con, $consulta4)) 
            {
                if ($fila = mysqli_fetch_array($paquete)) 
                {
                    $id_cliente = $fila['codigo'];
                }
            }                                
        }
        
    }
    //********************************************************************************


    $consulta = "SELECT * FROM comision WHERE nombre LIKE '%reparacion%' OR tipo LIKE '%REPARACION%'";
    if ($paquete = consultar($con,$consulta) )
    { 
        // Llamamos a una función que muestre esos datos
        if ($fila = mysqli_fetch_array($paquete)) 
        {
            $id_comision = $fila['id_comision'];
            
            $consulta2 = "INSERT INTO reparacion (id_sucursal,usuario,cod_cliente, imei,
            marca, modelo, color,precio,precio_inicial,abono,resto,motivo,observacion,fecha_ingreso,
            id_comision,estado,chip,memoria,costo,nombre_contacto,ap_contacto,
            am_contacto,telefono_contacto,rfc_curp_contacto, mano_obra,correo,direccion,fecha_salida)
           VALUES ('$id_sucursal','$usu','$id_cliente','$imei',
           '$marca','$modelo','$color','$precio','$precio','$abono','$resto','$motivo','$observacion',
           '$fecha_ingreso','$id_comision','0','$chip','$memoria','0',
           '$nombreContacto','$apaternoContacto','$amaternoContacto','$telefonoContacto','$rfc',
           '0','$correoContacto','$direccionContacto','$fechaSalida')";

            $id_reparacion = agregarReparacion($con,$consulta2);


            if($abono > 0){

                 ## SI el abono es diferente de 0 insertar en detalle ###

                ### CONSULTAR DATOS REPARACION ##
                $comisionCajero = $abono;

                $porcent = "SELECT porcentaje FROM comision WHERE tipo = 'REPARACION'";
                $paq = consultar($con,$porcent);
                $dato = mysqli_fetch_array($paq);
                $porcentaje = ($dato['porcentaje'] / 100);
                $totalComisionCajero = $comisionCajero * $porcentaje;

                $consultare = "UPDATE reparacion SET 
                comisionCajero      ='$comisionCajero',
                totalComisionCajero ='$totalComisionCajero'
                WHERE id_reparacion ='$id_reparacion'";
                if($paquetere = actualizar($con, $consultare)){

                    $consulta = "SELECT * FROM reparacion WHERE id_reparacion = '$id_reparacion'";
                    if ($paquete = consultar($con, $consulta)) {
                        $dato=mysqli_fetch_array($paquete);
                        $manoObra         = $dato['mano_obra'];
                        $idComision       = $dato['id_comision'];
                        $codigo_cliente   = $dato['cod_cliente'];
                        $nombreContacto   = $dato['nombre_contacto']." ".$dato['ap_contacto'];
                        $comisionCajero   = $dato['comisionCajero'];
                        $IMEI             = $dato['imei'];
    
                        $consultaInsert = "INSERT INTO detalle(factura,nombre,codigo,IMEI,cantidad,valor,
                        importe,modulo,fecha_op,usu,id_sucursal,tipo_comision,tipo,esComision) VALUES 
                        ('$id_reparacion','$nombreContacto','$codigo_cliente','$IMEI','1','$abono','$abono',
                        'R',NOW(),'$usu','$id_sucursal','reparacion','abono R',0)";
    
                        agregar($con,$consultaInsert);
    
                    }

                }
            }


            $tipo = "REPARACION";
            header('location:contado.php?id_reparacion='.$id_reparacion.'&tipo='.$tipo);


        }
    
    } 
}
else
{
    //echo "<p>Servicio interrumpido</p>";
}        

?>