<?php
error_reporting(0);
session_start();
include('php_conexion.php'); 
$usu = $_SESSION['username'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
    header('location:error.php');
}
#datos recibidos para consulta
    $id_sucursal = $_SESSION['id_sucursal'];
    $id_comision = $_REQUEST['producto'];
    $sucursal = $_REQUEST['sucursal'];
    $coin = $_REQUEST['coin'];

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
        ->setTitle("Listado de productos")
        ->setSubject("Reporte")
        ->setDescription("Documento generado para informacion")
        ->setKeywords("Aiko.com.mx reportes")
        ->setCategory("Reporte");
 
   //valores de la tabla (titulo de las columnas)
   $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('A2','Codigo'.$id_comision)
        ->setCellValue('B2','Nombre del Producto')
        ->setCellValue('C2','Proveedor')
        ->setCellValue('D2','Precio Costo')
        ->setCellValue('E2','Precio Mayoreo')
        ->setCellValue('F2','Precio Venta')
        ->setCellValue('G2','Cant. Actual')
        ->setCellValue('H2','Cant. Minima')
        ->setCellValue('I2','Sucursal')
        ->setCellValue('J2','Faltante')
        ->setCellValue('K2','Sobrante');

        $i=3;
        set_time_limit(1000);
        
    if ($id_comision == "Todos" && $sucursal == "Todos" && $coin == "") {
    //echo "sin producto, sin sucursal, sin termino";

      //$can=mysql_query("SELECT * FROM producto WHERE cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());
      $can=mysql_query("SELECT * FROM producto ORDER BY id_sucursal") or die(mysql_error());//todos los productos
      
    }
    

    if ($id_comision == "Todos" && $sucursal == "Todos" && $coin != "") {
      echo "sin producto, sin sucursal, con termino";
      $can=mysql_query("SELECT * FROM producto WHERE (nom LIKE '%$coin%' OR marca like '%$coin%' OR modelo like '%$coin%' OR compania like '%$coin%' OR color like '%coin%' OR categoria like '%$coin%') AND cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());
    }

    if ($id_comision == "Todos" && $sucursal != "Todos" && $coin == "") {
    //echo "sin producto, con sucursal, sin termino";
      $can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$sucursal' AND (nom LIKE '%$coin%' OR marca like '%$coin%' OR modelo like '%$coin%' OR compania like '%$coin%' OR color like '%coin%' OR categoria like '%$coin%') AND cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());
    }

    if ($id_comision != "Todos" && $sucursal == "Todos" && $coin != "") {
    //echo "con producto, sin sucursal, con termino";
      $can=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND (nom LIKE '%$coin%' OR marca like '%$coin%' OR modelo like '%$coin%' OR compania like '%$coin%' OR color like '%coin%' OR categoria like '%$coin%') AND cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());

    }

    if ($id_comision != "Todos" && $sucursal == "Todos" && $coin == "") {
    //echo "con producto, sin sucursal, sin termino";
      $can=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());
    }

    if ($id_comision != "Todos" && $sucursal != "Todos" && $coin == "") {
    //echo "con producto, sucursal y sin termino";
      $can=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND id_sucursal = '$sucursal' ORDER BY id_sucursal") or die(mysql_error());
    }

    if ($id_comision == "Todos" && $sucursal != "Todos" && $coin != "") {
    //echo "sin producto, con sucursal, con termino";
      $can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$sucursal' AND (nom LIKE '%$coin%' OR marca like '%$coin%' OR modelo like '%$coin%' OR compania like '%$coin%' OR color like '%coin%' OR categoria like '%$coin%') AND cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());
    }

    if ($id_comision != "Todos" && $sucursal != "Todos" && $coin != "") {
    //echo "con producto, sucursal y con termino";
      $can=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND id_sucursal = '$sucursal' AND (nom LIKE '%$coin%' OR marca like '%$coin%' OR modelo like '%$coin%' OR compania like '%$coin%' OR color like '%coin%' OR categoria like '%$coin%') AND cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());
    }


        while($dato = mysql_fetch_array($can)) {
        $codigo=$dato['cod']; 

        $NomSucursal=$dato['id_sucursal']; 
        $cann=mysql_query("SELECT * FROM empresa where id=$NomSucursal");   
        if($datos=mysql_fetch_array($cann)){    $NomSucursal=$datos['empresa'];    }

            //echo "antes de agregar a excel: ".$total_comision."<br>";
            $objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('A'.$i,$dato['cod'])
            ->setCellValue('B'.$i,utf8_encode($dato['nom']))
            ->setCellValue('C'.$i,$dato['prov'])
            ->setCellValue('D'.$i,"$ ".number_format($dato['costo'],2))
            ->setCellValue('E'.$i,"$ ".number_format($dato['mayor'],2))
            ->setCellValue('F'.$i,"$ ".number_format($dato['venta'],2))
            ->setCellValue('G'.$i,$dato['cantidad'])
            ->setCellValue('H'.$i,$dato['minimo'])
            ->setCellValue('I'.$i,$NomSucursal)
            ->setCellValue('J'.$i,$dato['faltantes'])
            ->setCellValue('K'.$i,$dato['sobrates']);
           

            $i++;
            $total_costo = $total_costo+$dato['costo'];
            $total_mayoreo = $total_mayoreo +$dato['mayor'];
            $total_venta = $total_venta +$dato['venta'];
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
$total_costo;
$total_mayoreo;
$total_venta;

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
$namefile = "REPORTE_PRODUCTOS".$_SESSION['username'].".xlsx";
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
$objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->setTitle('REPORTE PRODUCTOS');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$namefile.'"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;

/*$excel->close();*/
/*echo "Los datos se han grabado con &eacute;xito.";*/
?> 