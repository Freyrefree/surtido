<?php
error_reporting(0);
session_start();
include('php_conexion.php'); 
$usu = $_SESSION['username'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
    header('location:error.php');
}
#datos recibidos para consulta
$datestart = $_REQUEST['datestart'];
$datefinish = $_REQUEST['datefinish'];

    //$usuario = $_GET['usuario'];
    //$datestart = $_GET['fi'];
    //$datefinish = $_GET['ff'];
    //echo $datestart."-".$datefinish."<br>";
#fin datos recibidos para consulta
require_once 'phpexcel/PHPExcel.php';

#creacion de excel con sus columnas
   $objPHPExcel = new PHPExcel();
   /*$objPHPExcel = PHPExcel_IOFactory::load("Report.xlsx");*/
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("Aiko.com.mx")
        ->setLastModifiedBy("Aiko.com.mx")
        ->setTitle("Saldo para Recargas en Sucursales")
        ->setSubject("Reporte")
        ->setDescription("Documento generado para informacion")
        ->setKeywords("Aiko.com.mx reportes")
        ->setCategory("Reporte");
 
   //valores de la tabla (titulo de las columnas)
   $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('A2','Codigo')
        ->setCellValue('B2','Sucursal')
        ->setCellValue('C2','Saldo')
        ->setCellValue('D2','Fecha')
        ->setCellValue('E2','Hora');

        $i=3;
        set_time_limit(1000);
        

        $can=mysql_query("SELECT * FROM detallerecargassucursal WHERE Fecha BETWEEN '$datestart' AND '$datefinish'") or die(mysql_error());

        while($dato = mysql_fetch_array($can)) {

            //echo "antes de agregar a excel: ".$total_comision."<br>";
            $objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('A'.$i,$dato['Id'])
            ->setCellValue('B'.$i,$dato['Sucursal'])
            ->setCellValue('C'.$i,$dato['Saldo'])
            ->setCellValue('D'.$i,$dato['Fecha'])
            ->setCellValue('E'.$i,$dato['Hora']);
            
           $Saldo = $Saldo + $dato['Saldo'];
           $i++;    


           $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i,"Total Saldo Movido")
            ->setCellValue('B'.$i,"--")
            ->setCellValue('C'.$i,"$Saldo")
            ->setCellValue('D'.$i,"--")
            ->setCellValue('E'.$i,"--");

            
        }   




#fin creacion de excel con sus columnas
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
$namefile = "REPORTE_SALDOXSUCURSAL".$_SESSION['username'].".xlsx";
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->setTitle('REPORTE SALDO VIRTUAL');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$namefile.'"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;

/*$excel->close();*/
/*echo "Los datos se han grabado con &eacute;xito.";*/
?> 