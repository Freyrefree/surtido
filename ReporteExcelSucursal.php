<?php
error_reporting(0);
session_start();
include('php_conexion.php'); 
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
    header('location:error.php');
}
$id_sucursal = $_SESSION['id_sucursal'];
$Sucursal = $_SESSION['sucursal'];
$usu = $_SESSION['username'];
require_once 'phpexcel/PHPExcel.php';

#datos fechas de reporte
    $datestart = $_GET['fi'];
    $datefinish = $_GET['ff'];
#fin dartos fechas de reporte

#creacion de excel con sus columnas
   $objPHPExcel = new PHPExcel();
   /*$objPHPExcel = PHPExcel_IOFactory::load("Report.xlsx");*/
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("Aiko.com.mx")
        ->setLastModifiedBy("Aiko.com.mx")
        ->setTitle("Emitir Reporte ventas")
        ->setSubject("Reporte")
        ->setDescription("Documento generado para informacion")
        ->setKeywords("Aiko.com.mx reportes")
        ->setCategory("Reporte");    
 
   //valores de la tabla (titulo de las columnas)
   $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A2','TIPO VENTA')
        ->setCellValue('B2','SUCURSAL')
        ->setCellValue('C2','VENDEDOR')
        ->setCellValue('D2','NUM.')
        ->setCellValue('E2','VTA.')
        ->setCellValue('F2','UTL. OBTENIDA')
        ->setCellValue('G2','%.')
        ->setCellValue('H2','COM. OBTENIDA')
        ->setCellValue('I2','UTL. TIENDA')
        ->setCellValue('J2','GTOS. TIENDA');
#fin creacion de excel con sus columnas
$i = 3;
$j = $i;
$k = 0;
##### llenado del excel
//estilo de la tabla en excel
$styleColumna = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'rotation' => 90,
        'startcolor' => array(
            'argb' => 'E1EBE2',
        ),
        'endcolor' => array(
            'argb' => 'FFFFFFFF',
        ),
    ),
);
$QueryComision=mysql_query("SELECT * FROM comision WHERE tipo != 'RECARGA'");
while($row = mysql_fetch_array($QueryComision)) {
    $id_comision=$row['id_comision'];
    $QueryEmpresa=mysql_query("SELECT * FROM empresa WHERE id = '$id_sucursal'");
    while($row2 = mysql_fetch_array($QueryEmpresa)) {
        $id_sucursal = $row2['id'];
        $empresa = $row2['empresa'];
        $QueryEmpleado=mysql_query("SELECT * FROM usuarios WHERE id_sucursal = '$id_sucursal' OR tipo = 'a'");
        while($row3 = mysql_fetch_array($QueryEmpleado)) {
            //obtiene cantidad de ventas
            $usuario = $row3['usu'];
            $query2=mysql_query(
                "SELECT COUNT(detalle.cantidad) AS cantidad
                 FROM detalle, producto 
                 WHERE detalle.fecha_op BETWEEN '$datestart' AND '$datefinish' AND detalle.codigo = producto.cod AND detalle.id_sucursal = '$id_sucursal' AND producto.id_sucursal = '$id_sucursal' AND producto.id_comision = '$id_comision' AND detalle.usu = '$usuario'");
            while($dato2=mysql_fetch_array($query2)){
                $cantidad_ventas_tipo = $dato2['cantidad'];
            }
            $query3=mysql_query(
                "SELECT SUM(detalle.importe) AS total
                 FROM detalle, producto 
                 WHERE detalle.fecha_op BETWEEN '$datestart' AND '$datefinish' AND detalle.codigo = producto.cod AND detalle.id_sucursal = '$id_sucursal' AND producto.id_sucursal = '$id_sucursal' AND producto.id_comision = '$id_comision' AND detalle.usu = '$usuario'");
            while($dato3=mysql_fetch_array($query3)){
                $total_importe = $dato3['total'];
            }

        #valores de raparaciones obtener datos
            $queryc=mysql_query("SELECT * FROM reparacion WHERE id_comision = '$id_comision'");
            if($dat=mysql_fetch_array($queryc)){
                $query4=mysql_query(
                "SELECT COUNT(id_reparacion) AS cantidad, SUM(precio) AS total
                 FROM reparacion 
                 WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND estado = '3' AND id_sucursal = '$id_sucursal' AND id_comision = '$id_comision' AND usuario = '$usuario'");
                while($dato4=mysql_fetch_array($query4)){
                    $total_importe = $dato4['total'];
                    $cantidad_ventas_tipo = $dato4['cantidad'];
                }
            }
        #

            //comision obtenida de cada empleado
            //$total_comision = $total_importe * ($row['porcentaje'] / 100);
            //----------------------------------
        $porcentaje = $row['porcentaje'];
        #obtener la utilidad de VENTAS de cada empleado con respecto al tipo de producto
            $query4=mysql_query("SELECT * FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' AND usu = '$usuario' AND id_sucursal = '$id_sucursal'");
            while($dato4=mysql_fetch_array($query4)){
                $codigo = $dato4['codigo'];
                $query5=mysql_query("SELECT * FROM producto WHERE cod = '$codigo' AND id_comision = '$id_comision' AND id_sucursal = '$id_sucursal'");
                while($dato5=mysql_fetch_array($query5)){
                    $utilidad = $utilidad + ($dato5['venta'] - $dato5['costo']);
                    $total_comision = $total_comision + ($dato5['venta'] - $dato5['costo'])*($porcentaje /100);
                }
            }
        #

        #obtener la utilidad de REPARACIONES de cada empleado con respecto al tipo de producto
            $query4=mysql_query("SELECT * FROM reparacion WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND usuario = '$usuario' AND id_sucursal = '$id_sucursal' AND estado = '3' AND id_comision = '$id_comision'");
            while($dato4=mysql_fetch_array($query4)){
                $utilidad = $utilidad + ($dato4['precio'] - $dato4['costo']);
                $total_comision = $total_comision + ($dato4['precio'] -$dato4['costo'])*($porcentaje /100);
            }
        #

        	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i,$row['tipo'])
            ->setCellValue('B'.$i,$row2['empresa'])
            ->setCellValue('C'.$i,$row3['usu'])
            ->setCellValue('D'.$i,$cantidad_ventas_tipo)
            ->setCellValue('E'.$i,"$ ".number_format($total_importe,2))
            ->setCellValue('F'.$i,"$ ".number_format($utilidad,2))
            ->setCellValue('G'.$i,$row['porcentaje']." %")
            ->setCellValue('H'.$i,"$ ".number_format($total_comision,2))
            ->setCellValue('I'.$i,"$ ".number_format($utilidad-$total_comision,2));
        	$i++;
            
            $totales_numero   = $totales_numero   + $cantidad_ventas_tipo;
            $totales_ventas   = $totales_ventas   + $total_importe;
            $totales_utilidad = $totales_utilidad + $utilidad;
            $totales_comision = $totales_comision + $total_comision;
            $utilidad = 0;
            $total_comision = 0;
        }//fin while empleado
    }//fin while empresa
    $i++;
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i,"")
            ->setCellValue('B'.$i,"")
            ->setCellValue('C'.$i,"")
            ->setCellValue('D'.$i,"")
            ->setCellValue('E'.$i,"")
            ->setCellValue('F'.$i,"")
            ->setCellValue('G'.$i,"")
            ->setCellValue('H'.$i,"")
            ->setCellValue('I'.$i,"");
    /*$i++;
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i,"TOTALES")
            ->setCellValue('B'.$i,"-")
            ->setCellValue('C'.$i,"-")
            ->setCellValue('D'.$i,$totales_numero)
            ->setCellValue('E'.$i,"$ ".number_format($totales_ventas,2))
            ->setCellValue('F'.$i,"$ ".number_format($totales_utilidad,2))
            ->setCellValue('G'.$i,"-")
            ->setCellValue('H'.$i,$totales_comision);
*/
    $k = $i - 2;
    $rango = 'A'.$j.':A'.$k;
    $objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleColumna);
    $j = $i;
    $totales_numero   = 0;
    $totales_ventas   = 0;
    $totales_utilidad = 0;
    $totales_comision = 0;
}//fin while tipo venta (comisiones)
#agregar calculo de gastos
//obtener la cantidad de gastos de la fecha requerida

$quer1=mysql_query("SELECT SUM(total) AS total FROM gastos WHERE fecha BETWEEN '$datestart' AND '$datefinish' AND id_sucursal = '$id_sucursal'");
            while($row4=mysql_fetch_array($quer1)){
                $total_gasto = $row4['total'];
            }
//fin obtener la cantidad de gastos de la fecha requerida
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i,"GASTOS")
            ->setCellValue('B'.$i,$empresa)
            ->setCellValue('C'.$i,"-")
            ->setCellValue('D'.$i,"-")
            ->setCellValue('E'.$i,"-")
            ->setCellValue('F'.$i,"-")
            ->setCellValue('G'.$i,"-")
            ->setCellValue('H'.$i,"-")
            ->setCellValue('I'.$i,"-")
            ->setCellValue('J'.$i,"$ ".number_format($total_gasto,2));
#fin agregar calculo de gastos
//estilo de la tabla en excel
$styleArray = array(
    'font' => array(
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'rotation' => 90,
        'startcolor' => array(
            'argb' => 'E1EBE2',
        ),
        'endcolor' => array(
            'argb' => 'FFFFFFFF',
        ),
    ),
);
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->setTitle('REPORTE VENTAS');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ReporteSucursal'.$Sucursal.'Ventas.xlsx"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
/*$excel->close();*/
/*echo "Los datos se han grabado con &eacute;xito.";*/
?> 