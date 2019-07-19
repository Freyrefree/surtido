<?php
    session_start();
    error_reporting(E_ALL ^ E_DEPRECATED);
    error_reporting(0);
    include("host.php");
    include("funciones.php");
    
if(isset($_SESSION['id_sucursal'])){

    $usu = $_SESSION['username'];
    $idSucursal = $_SESSION['id_sucursal'];


    ##DATOS POST####
    $idReparacion = trim($_POST['noReparacion']);
    $descripLi = $_POST['descripLi'];

    $dineroRecibo = $_POST['dineroRecibo'];
    $resto = $_POST['resto'];

    if($dineroRecibo < $resto)
    {
        echo 7; // Error dinero recibido
        exit;
    }


    ##############

if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
{
    //Sólo puede liberar el cajero
    if (($_SESSION['tipo_usu']=='ca') || ($_SESSION['tipo_usu']=='a') || ($_SESSION['tipo_usu']=='te') || ($_SESSION['tipo_usu']=='su') ) 
    {
        $consulta = "SELECT * FROM reparacion WHERE  id_reparacion = '$idReparacion'";
        if ($paquete = consultar($con, $consulta)) 
        {
            $fila = mysqli_fetch_array($paquete);
            $usuarioEntrada = $fila['usuario'];
            $idSucursalEntrada = $fila['id_sucursal'];

            $estado     = $fila['estado'];
            $manoObra   = $fila['mano_obra'];
            $idComision = $fila['id_comision'];

            $codigo_cliente   = $fila['cod_cliente'];
            $nombreContacto   = $fila['nombre_contacto']." ".$fila['ap_contacto'];
            $comisionCajero   = $fila['comisionCajero'];
            $IMEI             = $fila['imei'];
            $precioFinal      = $fila['precio'];
            $adelanto         = $fila['abono'];

            if($precioFinal == $adelanto){

                $precioFinal = $adelanto;

            }else{
                
                $precioFinal = $precioFinal - $adelanto;
            }
               
            
            ## Cosulta comision
            $consultaComision="SELECT porcentaje FROM comision WHERE id_comision = '$idComision'";
            if($paqueteCom = consultar($con,$consultaComision)){
            $datoCom=mysqli_fetch_array($paqueteCom);
            $comision = (($datoCom['porcentaje']) / 100);
            }
            ####################
            
            if($estado == 2){
                
                $consulta2 = "UPDATE reparacion SET estado='3',
                descripLiberacion = '$descripLi',
                fecha_salida    =NOW()
                WHERE id_reparacion = '$idReparacion'";
                if ($paquete = actualizar($con, $consulta2)) {

                    ## validar si existe un abono. Si existe sólo se actualizará, de lo contrario será un nuevo registro en la tabla detalle

                    $existReparacion = "SELECT * FROM detalle WHERE factura = '$idReparacion' AND tipo = 'abono R'";
                    if($paquete = consultar($con,$existReparacion)){

                        $consultaDetalle = "UPDATE detalle SET 
                        nombre      ='$nombreContacto',
                        codigo      ='$codigo_cliente',
                        IMEI        ='$IMEI',
                        cantidad    ='1',
                        valor       =$precioFinal,
                        importe     =$precioFinal,
                        modulo      ='R',
                        fecha_op    =NOW(),
                        usu         ='$usuarioEntrada',
                        id_sucursal ='$idSucursalEntrada',
                        tipo_comision='reparacion',
                        tipo        ='liberacion R',
                        esComision   =null
                        WHERE factura = '$idReparacion' AND tipo = 'abono R'";


                    }else{

                        

                        $consultaDetalle = "INSERT INTO detalle(factura,nombre,codigo,IMEI,cantidad,valor,
                        importe,modulo,fecha_op,usu,id_sucursal,tipo_comision,tipo) VALUES 
                        ('$idReparacion','$nombreContacto','$codigo_cliente','$IMEI','1','$precioFinal','$precioFinal',
                        'R',NOW(),'$usuarioEntrada','$idSucursalEntrada','reparacion','liberacion R')";

                    }



                    if($paquete = agregar($con,$consultaDetalle)){


            ################# Insertar refacciones en detalle con perfil administrador y en matriz ##########################

            $usuarioAdmin = "SELECT usu FROM usuarios WHERE id_sucursal = 1";
            $paqueteAdmin = consultar($con,$usuarioAdmin);
            $datoAdmin    = mysqli_fetch_array($paqueteAdmin);
            $usuarioAdmin = $datoAdmin['usu'];

            $consultaRefaccion = "SELECT  *  FROM reparacion_refaccion WHERE id_reparacion = '$idReparacion'";
            if($paqueteRefa = consultar($con,$consultaRefaccion)){

              while($datoRefa = mysqli_fetch_array($paqueteRefa)){

                $idRepaRefa   = $datoRefa['id'];
                $idProductoR  = $datoRefa['id_producto'];
                $precioProd   = $datoRefa['Precio'];
                $nomProducto  = $datoRefa['NomProducto'];

                $factura = $idReparacion."-R-".$idRepaRefa;


                $consultaVenta = "INSERT INTO detalle(
                  factura,
                  codigo,
                  nombre,
                  cantidad,
                  valor,
                  importe,
                  tipo,
                  fecha_op,
                  usu,
                  id_sucursal,
                  tipo_comision) 
                  VALUES
                  (
                  '$factura',
                  '$idProductoR',
                  '$nomProducto',
                  '1',
                  '$precioProd',
                  '$precioProd',
                  'refaccion R',
                  NOW(),
                  '$usuarioAdmin',
                  '1',
                  'especial'
                  )";

                  $paquete = agregar($con,$consultaVenta);

              }

            }
            ####################################################################################################

            ################## INSERTAR VALOR DE MANO DE OBRA EN TABLA DETALLE PARA EL TÉCINO ##################

            $consultaTecnico = "SELECT r.mano_obra AS mano_obra,
            r.tecnico AS tecnico,
            u.id_sucursal AS id_sucursal
            FROM reparacion r
            INNER JOIN usuarios u ON r.tecnico = u.usu
            WHERE id_reparacion = '$idReparacion'";

            $paqueteTecnico = consultar($con,$consultaTecnico);
            $datoTec = mysqli_fetch_array($paqueteTecnico);
            $manoObraTec  = $datoTec['mano_obra'];
            $usuarioTec   = $datoTec['tecnico'];
            $idSucurTec   = $datoTec['id_sucursal'];

           
            $consultaVentaT = "INSERT INTO detalle(
              factura,
              cantidad,
              valor,
              importe,
              tipo,
              fecha_op,
              usu,
              id_sucursal,
              tipo_comision,
              modulo) 
              VALUES
              (
              '$idReparacion-R-MO',
              '1',
              '$manoObraTec',
              '$manoObraTec',
              'mano R',
              NOW(),
              '$usuarioTec',
              '$idSucurTec',
              'reparacion',
              'R'
              );";

              $paquete = agregar($con,$consultaVentaT);




                        echo 1;
                    }
                    
                } else {
                    echo 4; //error en la actualización
                }

            }else if($estado == 3){
                echo 5;
            }else{
                echo 3; //error cuando la reparacion no es estado terminado
            }            
        } 

    }else{
        echo 2;//error cuando no es cajero o admin 
    }
    
}

}else{
    echo 6; //Error Sesion 
}

    


    
?>
