<?php
error_reporting(0);
session_start();
include('php_conexion.php'); 
$usu = $_SESSION['username'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
    header('location:error.php');
}
#datos recibidos para consulta    
    $datestart = $_GET['fi'];
    $datefinish = $_GET['ff'];
    //echo $datestart."-".$datefinish."<br>";
#fin datos recibidos para consulta
$namefile = "Comisiones.xlsx";

include('phpexcel/PHPExcel.php');

$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()
        ->setCreator("Aiko.com.mx")
        ->setLastModifiedBy("Aiko.com.mx")
        ->setTitle("Reporte Comisiones")
        ->setSubject("Reporte")
        ->setDescription("Documento generado para información")
        ->setKeywords("Aiko.com.mx reportes")
        ->setCategory("Reporte");

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

$objPHPExcel->getActiveSheet()->setTitle('Reporte Comisiones');

$objPHPExcel->getActiveSheet()
        ->setCellValue('A1','NO')
        ->setCellValue('B1','CÓDIGO')
        ->setCellValue('C1','NOMBRE')
        ->setCellValue('D1','CANTIDAD')
        ->setCellValue('E1','TIPO PRODUCTO')
        ->setCellValue('F1','TIPO VENTA')
        ->setCellValue('G1','% COMISIÓN')
        ->setCellValue('H1','PRECIO U')
        ->setCellValue('I1','TOTAL COMISIÓN')
        ->setCellValue('J1','USUARIO');



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


$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
//$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);

$ultimaColumna = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();//Obtiene última letra activa
$encabezados = 'A1:'.$ultimaColumna.'1';
$objPHPExcel->getActiveSheet()->getStyle($encabezados)->applyFromArray($styleColumna);

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
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$ultimaColumna.'1')->applyFromArray($styleArray);



$row = 2;
$consulta = "SELECT * FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish'";
$ejecutar = mysql_query($consulta);
while($dato = mysql_fetch_array($ejecutar))
{

    $id_producto = $dato['codigo'];
    $precioU = $dato['valor'];
    $cantidad = $dato['cantidad'];
    $tipo_comision = $dato['tipo_comision'];
    $nombre_usuario =$dato['usu'];
    $precioU = number_format($precioU, 2, '.', '');

//**************Comision mostrada en tabla*****************/
    $tipo_comision = $dato['tipo_comision'];
    if(($tipo_comision == "venta"))
    {
        $tipo_comisionshow = "público";
    }else if($tipo_comision == "especial")
    {
       $tipo_comisionshow = "especial";
    }else if($tipo_comision == "mayoreo" )
    {
        $tipo_comisionshow ="mayoreo";
    }
//************************************************************/
    
    $consultaProducto = "SELECT * FROM producto WHERE cod='$id_producto' LIMIT 1";
    $ejecutar2 = mysql_query($consultaProducto);
    $dato2 = mysql_fetch_array($ejecutar2);
    $id_comision = $dato2['id_comision'];
    $costo_producto = $dato2['costo'];

    $consultaComision="SELECT * FROM comision WHERE id_comision = '$id_comision'";
    $ejecutar3 = mysql_query($consultaComision);
    $dato3=mysql_fetch_array($ejecutar3);    
    $tipo_producto = $dato3['tipo'];
    $porcentaje_comision = $dato3['porcentaje'];

    //**************************Tipo porcentaje de acuerdo al tipo de venta************************
                                    
    if(($tipo_comision == "venta"))
    {
        $porcentaje_comision = $dato3['porcentaje'];
    }else if($tipo_comision == "especial")
    {
        $porcentaje_comision = $dato3['porcentajeespecial'];
    }else if($tipo_comision == "mayoreo" )
    {
        $porcentaje_comision = $dato3['porcentajemayoreo'];
    }
    //************************************************************************************************

    $pro_comision = (($precioU-$costo_producto)*($porcentaje_comision/100)*$cantidad);
    $pro_comision =number_format($pro_comision, 2, '.', '');
    $total_comisiones = $total_comisiones+$pro_comision;
    $total_comisiones = number_format($total_comisiones, 2, '.', '');

    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $row-1);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row, $id_producto, PHPExcel_Cell_DataType::TYPE_STRING);//Formato General
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dato['nombre']);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dato['cantidad']);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $tipo_producto);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $tipo_comisionshow);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, "%".$porcentaje_comision);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $precioU);
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $pro_comision);
    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $nombre_usuario);
    $row++;
}
$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, "TOTAL");
$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $total_comisiones);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$namefile.'"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?> 