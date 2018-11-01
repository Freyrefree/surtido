<?php
    session_start();
    error_reporting(E_ALL ^ E_DEPRECATED);
    error_reporting(0);
    include("host.php");
    include("funciones.php"); 
    $usu=$_SESSION['username'];
    $idSucursal = $_SESSION['id_sucursal'];


    ##DATOS POST####
    $idReparacion = trim($_POST['noReparacion']);
    $descripLi = $_POST['descripLi'];
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

                    $consultaInsert = "INSERT INTO detalle(factura,nombre,codigo,IMEI,cantidad,valor,
                    importe,modulo,fecha_op,usu,id_sucursal,tipo_comision,tipo) VALUES 
                    ('$idReparacion','$nombreContacto','$codigo_cliente','$IMEI','1','$comisionCajero','$comisionCajero',
                    'R',NOW(),'$usuarioEntrada','$idSucursalEntrada','reparacion','liberacion R')";

                    if($paquete = agregar($con,$consultaInsert)){


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

// function comisionTecnico($hostDB, $usuarioDB, $claveDB, $baseDB,$IdReparacion,$manoObra,$idSucursal,$comision){

//     $totalComision = 0;
//     $sumVenta = 0;
//     $masVenta = 0;
  
//     $sumEspecial = 0;
//     $masEspecial = 0;
//     $sumTipoPrecio=array();
  
//     $countArray = 0;
//     $contador = 0;
      
//     if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
//     {
  
//         $consulta1="SELECT * FROM reparacion_refaccion WHERE id_reparacion = '$IdReparacion'";
//         if ($paquete = consultar($con, $consulta1)) {
//             while ($fila=mysqli_fetch_array($paquete)) {
//                 $array[] = array(
//                 'id_producto' => $fila['id_producto']
//             );
//             }
//             $countArray = count($array);
  
//             foreach ($array as $row) 
//             {
  
  
//               $masVenta = $sumVenta;
//               $masEspecial = $sumEspecial;
//                 $idProducto = $row['id_producto'];
//                 $consulta2 = "SELECT * FROM producto WHERE cod = '$idProducto' AND id_sucursal = '$idSucursal'";
//                 if($paquete2 = consultar($con,$consulta2)){
    
//                     $fila = mysqli_fetch_array($paquete2);
//                     $precioVenta    = $fila['venta'];
//                     $sumVenta = $precioVenta + $masVenta;
  
//                     $precioEspecial = $fila['especial'];
//                     $sumEspecial = $precioEspecial + $masEspecial;
//                 }
  
                
//                 $contador++;
//                 if($contador == $countArray){
//                   $sumTipoPrecio[] = array('totalVentaPublico' => $sumVenta, 'totalVentaEspecial' => $sumEspecial);
//                 }
//             }
  
//             $totalVentaPublico  = $sumTipoPrecio[0]['totalVentaPublico'];
//             $totalVentaEspecial = $sumTipoPrecio[0]['totalVentaEspecial'];
  
//             $totalComision = (($totalVentaPublico) - ($totalVentaEspecial + $manoObra)) * ($comision);
//             if($totalComision < 0){
//               $totalComision = 0;
//             }
  
//         }
//     }
//     return $totalComision;
//   }
    
?>
