<?php	
session_start();	

// error_reporting(E_ALL & ~E_NOTICE);
//   ini_set('display_errors', 0);
//   ini_set('log_errors', 1);

 ini_set('max_execution_time', 0);
// ini_set("pcre.backtrack_limit", "9000000");
// ini_set('memory_limit', '8192M'); 


$tipoUsuario  = $_SESSION['tipo_usu'];

		
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>

<?php
$fecha_inicio = $_GET['fecha_ini11'];
if($fecha_inicio == "--")
{
$fecha_inicio = "";
}else{
$fecha_inicio = $fecha_inicio." 00:00:00";
}
$fecha_fin = $_GET['fecha_fin11'];
if($fecha_fin == "--")
{
$fecha_fin = "";
}else{
  $fecha_fin = $fecha_fin." 23:59:59";
}

###FECHA ENTRADA
$fecha_inicioen = ''; // $_POST['fechainicioen'];
if($fecha_inicioen == "--")
{
$fecha_inicioen = "";
}else{
$fecha_inicioen =''; //$fecha_inicioen." 00:00:00";
}

$fecha_finen = ''; //$_POST['fechafinen'];
if($fecha_finen == "--")
{
$fecha_finen = "";
}else{
  $fecha_finen = ''; //$fecha_finen." 23:59:59";
}


$cajero=$_GET['cajero'];
//$producto=$_POST['producto'];
$codigo = $_GET['codigo'];
$categoria = $_GET['categoria'];
$coincidencia = $_GET['coincidencia'];

if($cajero == "Todos"){
    $cajero = "";
}

$arrayQuery[0] = $fecha_inicio;
$arrayQuery[1] = $fecha_fin;
$arrayQuery[2] = $cajero;
$arrayQuery[3] = $codigo;
$arrayQuery[4] = $coincidencia;
$arrayQuery[5] = $categoria;

$rango_fecha = $fecha_inicio ." / " .$fecha_fin;

$arrayConsultas = crearConsulta($arrayQuery);

require_once '../mPDFv2/autoload.php';
//ini_set("memory_limit","4000M");
//ini_set ('memory_limit', '### M');

$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L']);
$codigoTabla = tabularPDFCorteVentas($arrayConsultas,$rango_fecha,$tipoUsuario,$mpdf);

$arr2 = str_split($codigoTabla, 1500);
$stylesheet = file_get_contents('../mpdfstyletables.css');

$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($codigoTabla, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output();


function crearConsulta($arrayQuery){

    $countArray = 0;
    $queryMas = "";

    foreach ($arrayQuery as &$valor) {
        

        if($countArray == 0){

            if($valor != ""){

                $queryMas.= " WHERE fecha_op BETWEEN '$valor' ";
            }else{
                $queryMas.= "";
            }

        }

        if($countArray == 1){

            if($valor != ""){

                $queryMas.= " AND '$valor' ";
            }else{
                $queryMas.= "";
            }

        }

        if($countArray == 2){

            if($valor != ""){
                if($queryMas != ""){

                    $queryMas.= " AND usu = '$valor' ";
                }else{
                    $queryMas.= " WHERE  usu = '$valor' ";
                }
            }else{
                $queryMas.= "";
            }

        }

        if($countArray == 3){

            if($valor != ""){
                if($queryMas != ""){

                    $queryMas.= " AND factura = '$valor' ";
                }else{
                    $queryMas.= " WHERE factura = '$valor' ";
                }
            }else{
                $queryMas.= "";
            }

        }

        if($countArray == 4){

            if($valor != ""){
                if($queryMas != ""){

                    $queryMas.= " AND nombre LIKE '%$valor%' ";
                }else{
                    $queryMas.= " WHERE nombre LIKE '%$valor%' ";
                }
            }else{
                $queryMas.= "";
            }

        }

        if($countArray == 5){

            if($valor != ""){
                if($queryMas != ""){

                    if($valor == "R"){
                        $queryMas.= " AND modulo = '$valor'";

                    }else if($valor == "CR"){
                        $queryMas.= " AND modulo = '$valor'";

                    }else{

                        $queryMas.= " AND (codigo IN(SELECT cod FROM producto WHERE id_comision='$valor')                    
                        OR codigo IN(SELECT codigo FROM compania_tl WHERE id_comision IN(SELECT id_comision FROM comision WHERE tipo='$valor'))) ";
                    }              

                }else{

                    if($valor == "R"){

                        $queryMas.= " WHERE modulo = '$valor'";

                    }else if($valor == "CR"){
                        $queryMas.= " WHERE modulo = '$valor'";

                    }else{
                        
                        $queryMas.= " WHERE (codigo IN(SELECT cod FROM producto WHERE id_comision='$valor')                    
                        OR codigo IN(SELECT codigo FROM compania_tl WHERE id_comision IN(SELECT id_comision FROM comision WHERE tipo='$valor'))) ";

                    }
                }
            }else{
                $queryMas.= "";
            }

        }



        $countArray++;
    }

    $consultaDetalle    = "SELECT * from detalle ".$queryMas;
    $consultaCantidad   = "SELECT SUM(cantidad)FROM detalle".$queryMas;
    $consultaImporte    = "SELECT SUM(importe)FROM detalle".$queryMas;

    $arrayConsultas[0] = $consultaDetalle;
    $arrayConsultas[1] = $consultaCantidad;
    $arrayConsultas[2] = $consultaImporte;


return $arrayConsultas;

}



    function tabularPDFCorteVentas($arrayConsultas,$rango_fecha,$tipoUsuario)
    {

        include("../host.php");
        include("../funciones.php");




        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) {

            $consultaDetalle = $arrayConsultas[0];
            $consultaCantidad = $arrayConsultas[1];
            $consultaImporte =  $arrayConsultas[2];



            if($can =  consultar($con,$consultaDetalle))
            {


                $canart         =   consultar($con,$consultaCantidad);
                $row            =   mysqli_fetch_array($canart);
                $cantidad_art   =   $row[0];
        
                $canimporte     =   consultar($con,$consultaImporte);
                $row1           =   mysqli_fetch_array($canimporte);
                $importe1       =   $row1[0];
    
    
                $codigohtml = '
                

                <table class="tblLisado">
                <tr>
                    
                    <th>Cantidad Articulos</th>
                    <th>Venta Total</th>
                    <th>Fecha Venta</th>
    
                </tr>
    
                <tr>
                    
                    <td>'.$cantidad_art.'</td>
                    <td>$'.number_format((float)$importe1, 2, '.', '').'</td>
                    <td>'.$rango_fecha.'</td>
    
                </tr>
    
                </table>
    
                <div id="divId">
                <br>
    
                <table class="tblLisado">
                    <thead>
                    <tr> 
                    
                        <th>No</th> 
                        <th>Factura</th> 
                        <th>Codigo</th> 
                        <th>Nombre</th>
    
                        <th>IMEI</th>
                        <th>Nom Chip</th>
                        <th>ICCID</th> 
                    
                        <th>Cantidad</th> 
                        <th>Valor</th> 
                        <th>Importe</th>
    
                        <th>Tipo Comision</th>
                        <th>% Comision</th>
                        <th>Total Comision</th>      
                        <th>Tipo Venta</th> 
    
                        <th>Fecha venta</th> 
                        <th>Usuario</th>
                        <th>Sucursal</th>';
    
                        if($tipoUsuario == 'a'){
    
                            $codigohtml.=
                            '<th>%Com Empresa</th>
                            <th>Total Comision</th>';
                        }
    
                        
    
                    $codigohtml.='</tr>
                    </thead>
                    <tbody>';
    
    
    
                    $contador = 0;
                    $total_comisiones = 0;
                    $totalComEmpresa = 0;
    
                    while ($dato = mysqli_fetch_array($can)) 
                    {
                        $contador++;
    
                        //......nombre sucursal inicio.........................................................
    
                        $factura = $dato['factura'];
                        $idsucursal=$dato['id_sucursal'];
    
                        if($idsucursal == ""){
                            $stop = $contador;
                        }
    
    
                        $querynombresucursal="SELECT empresa FROM empresa WHERE id = '$idsucursal'";
                        if($canempresa = consultar($con,$querynombresucursal)){
    
                            $dato2 = mysqli_fetch_array($canempresa);
                            $nombreempresa = $dato2['empresa'];
    
                        }else{
    
                            $nombreempresa = "";
                        }
    
                      
    
                           
                    
            
                        
    
                        //......nombre sucursal fin............................................................
    
                        if ($dato['tipo'] == 'CREDITO') {
                            $tipov = "Credito/Apartado";
                        } else if($dato['tipo'] == 'CONTADO') {
                            $tipov = "Contado";
                        } else if($dato['tipo'] == 'liberacion R'){
                            $tipov = "Reparación Liberada";
                        } else if($dato['tipo'] == 'refaccion R'){
                            $tipov = "Refaccion Reparación";
                        } else if($dato['tipo'] == 'abono R'){
                            $tipov = "Adelanto Reparacion";
                        } else if($dato['tipo'] == 'ABONO'){
                            $tipov = "Abono Apartado";
                        } else if($dato['tipo'] == 'mano R'){
                            $tipov = "Mano de Obra";
                        }else{
                            $tipov = "INDEFINIDO";
                        }
    
                        $precioU = $dato['valor'];
                        $precioU = number_format((float)$precioU, 2, '.', '');
                        $cantidad = $dato['cantidad'];
                        $id_producto = $dato['codigo'];
    
                        if(($dato['modulo'] != 'CR') && ($dato['modulo'] != 'R')){
    
                            $consultaProducto = "SELECT * FROM producto WHERE cod='$id_producto' LIMIT 1";
                            if($ejecutar2 = consultar($con,$consultaProducto)){
    
                                $dato2 = mysqli_fetch_array($ejecutar2);
    
                                $id_comision = $dato2['id_comision'];
                                $costo_producto = $dato2['costo'];
    
                                $consultaComision="SELECT * FROM comision WHERE id_comision = '$id_comision'";
                                $ejecutar3 = consultar($con,$consultaComision);
                                $dato3  =   mysqli_fetch_array($ejecutar3);
    
                            }
                        }
    
                        
    
    
    
                        //**************Comision mostrada en tabla*****************/
                        $tipo_comision = $dato['tipo_comision'];
                        if (($tipo_comision == "venta")) {
                            $tipo_comisionshow = "público";
                        } else if ($tipo_comision == "especial") {
                            $tipo_comisionshow = "especial";
                        } else if ($tipo_comision == "mayoreo") {
                            $tipo_comisionshow ="mayoreo";
                        }else if($tipo_comision == "reparacion"){
                            $tipo_comisionshow ="REPARACIÓN";
                        }else if($tipo_comision == "apartado"){
                            $tipo_comisionshow ="APARTADO";
                        }else if($tipo_comision == ""){
                            $tipo_comisionshow ="";
                        }
                        //************************************************************/
                        //**************************Tipo porcentaje de acuerdo al tipo de venta************************
                                                    
                        if (($tipo_comision == "venta")) {
                            $porcentaje_comision = $dato3['porcentaje'];
                        } else if ($tipo_comision == "especial") {
                            $porcentaje_comision = $dato3['porcentajeespecial'];
                        } else if ($tipo_comision == "mayoreo") {
                            $porcentaje_comision = $dato3['porcentajemayoreo'];
                        }else if($tipo_comision == "reparacion"){
    
                            $queryCom = "SELECT porcentaje FROM comision WHERE tipo = 'REPARACION'";
                            $ejecCom = consultar($con,$queryCom);
                            $datoCom  = mysqli_fetch_array($ejecCom);
                            $porcentaje_comision = $datoCom['porcentaje'];
                            $costo_producto = 0;
    
                            ## obtener precio unitario para comision del cajero ##
    
                            if($dato['tipo'] == 'liberacion R'){
                                $precioU = 0;
    
                                $finalReparacion = "SELECT comisionCajero FROM reparacion WHERE id_reparacion = '$factura'";
                                $paqueteRepa = consultar($con,$finalReparacion);
                                $datoRepa = mysqli_fetch_array($paqueteRepa);
                                $precioU = $datoRepa[0];
                            }
    
                        }else if($tipo_comision == "apartado"){
    
                            $queryCom = "SELECT porcentaje FROM comision WHERE tipo = 'APARTADO'";
                            $ejecCom = consultar($con,$queryCom);
                            $datoCom  = mysqli_fetch_array($ejecCom);
                            $porcentaje_comision = $datoCom['porcentaje'];
    
                            ///$costo_producto = 0;
    
                        
                           
                        }else if($tipo_comision == ""){
    
                          
                            $porcentaje_comision = 0;
                            $costo_producto = 0;
    
                        
                           
                        }
                        //************************************************************************************************
    
                        $esComision = $dato['esComision'];
                        if(($dato['esComision'] == 0) && ($dato['esComision'] != null) ){
    
                            $pro_comision    = "";
                            $comisionEmpresa = "";
    
                        }else{
    
                            if($precioU > 0){
    
                                if($tipo_comision == "apartado"){
    
                                    ## Obtener suma de comisiones de la tabla de creditoDetalle ##
                                    
                                    $pro_comision0 = 0;
                                    $comisionEmpresa0 = 0;
    
                                    $idCredito = $dato['factura'];
                                    $consultaCredito = "SELECT 
                                    cd.idCredito, 
                                    cd.idProducto,
                                    cd.precioUnitario,
                                    cd.cantidad,
                                    p.costo
                                    FROM creditodetalle cd INNER JOIN producto p ON cd.idProducto = p.cod
                                    WHERE idCredito = $idCredito GROUP BY p.cod";
    
                                    if($paqueteCr = consultar($con,$consultaCredito)){
                                        while($datCredito = mysqli_fetch_array($paqueteCr)){
    
                                            $precioU = $datCredito['precioUnitario'];
                                            $costo_producto = $datCredito['costo'];
                                            $cantidad = $datCredito['cantidad'];
    
                                            $pro_comision0 += (($precioU-$costo_producto)*($porcentaje_comision/100)*$cantidad);
                                            $comisionEmpresa0 += (($precioU-$costo_producto)*(2/100)*$cantidad);
    
                                        }
    
                                        $pro_comision = $pro_comision0;
                                        $comisionEmpresa = $comisionEmpresa0;
    
                                    }
    
    
                                }else{
    
                                    $pro_comision    = (($precioU-$costo_producto)*($porcentaje_comision/100)*$cantidad);
                                    $comisionEmpresa = (($precioU-$costo_producto)*(2/100)*$cantidad);
    
                                }
    
                                
    
                            }else{
    
                                $pro_comision    = "";
                                $comisionEmpresa = "";
    
                            }
    
                        }
    
                       
    
    
    
                        $pro_comision =number_format((float)$pro_comision, 2, '.', '');
                        $total_comisiones = $total_comisiones+$pro_comision;
                        $total_comisiones = number_format((float)$total_comisiones, 2, '.', '');
    
                        $totalComEmpresa = $totalComEmpresa + $comisionEmpresa;
                        $totalComEmpresa = number_format((float)$totalComEmpresa, 2, '.', '');
    
                
                        $codigohtml.='<tr>';
    
                            $codigohtml.='<td>'.$contador.'</td>';
                            $codigohtml.='<td>'.$dato['factura'].'</td>';
                            $codigohtml.='<td>'.$dato['codigo'].'</td> ';  
                            $codigohtml.='<td>'.saltoCadena($dato['nombre']).'</td>';
    
                            $codigohtml.='<td>'.$dato['IMEI'].'</td>';
                            $codigohtml.='<td>'.$dato['nombreChip'].'</td>';   
                            $codigohtml.='<td>'.$dato['ICCID'].'</td>';
                            
                            $codigohtml.='<td>'.$dato['cantidad'].'</td>';
                            $codigohtml.='<td>$ '.number_format((float)$dato['valor'], 2, '.', '').'</td>';
                            $codigohtml.='<td>$ '.number_format((float)$dato['importe'], 2, '.', '').'</td>';
    
                            $codigohtml.='<td>'.$tipo_comisionshow.'</td>';
                            
    
                            if ($tipoUsuario == 'a') {
                                $codigohtml.='<td>'.$porcentaje_comision.'%</td>';
                                
                            }else{
                                $codigohtml.='<td></td>';
                               
                            }
    
                            $codigohtml.='<td>$'.$pro_comision.'</td>';
    
                            $codigohtml.='<td>'.$tipov.'</td>';
                            $codigohtml.='<td>'.$dato['fecha_op'].'</td>'; 
                            $codigohtml.='<td>'.$dato['usu'].'</td>';
                            $codigohtml.='<td>'.$nombreempresa.'</td>';
    
                            if ($tipoUsuario == 'a') {
                                $codigohtml.='<td>2%</td>';
                                $codigohtml.='<td>$'.$comisionEmpresa.'</td>';
                            }
    
                        $codigohtml.='</tr>';

                        //$mpdf->WriteHTML($codigohtml);
                            
                    }


                    $codigohtml .= '<tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>TOTAL COMISIONES</td>
            <td colspan="5">$'.$total_comisiones.'</td>';

            if ($tipoUsuario == 'a') {
                $codigohtml .= '<td>TOTAL COMISION EMPRESA</td>
                <td>$'.$totalComEmpresa.'</td>';
            }


            $codigohtml .= '</tr>
            </tbody>

            </table>
            </div>
            <p>&nbsp;</p>
            </body>
            </html>';

            return $codigohtml;
            //$mpdf->WriteHTML($codigohtml);
            //$mpdf->Output();
            //return $mpdf;

        }


    }
    }
  
?>