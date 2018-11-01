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
    $sucursal = $_SESSION['sucursal'];
    $usuario = $_GET['usuario'];
    $datestart = $_GET['fi'];
    $datefinish = $_GET['ff'];
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
        ->setCellValue('F2','COM. ASIG.')
        ->setCellValue('G2','UTL. OBTENIDA')
        ->setCellValue('H2','%.')
        ->setCellValue('I2','COM. OBTENIDA')
        ->setCellValue('J2','UTL. TIENDA');
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
$QueryComision=mysql_query("SELECT * FROM comision WHERE tipo = 'RECARGA'");
while($row = mysql_fetch_array($QueryComision)) {
    $contador = 0;
    $id_comision=$row['id_comision'];
    $QueryEmpresa=mysql_query("SELECT * FROM empresa");
    while($row2 = mysql_fetch_array($QueryEmpresa)) {
        $id_sucursal = $row2['id'];

        $QueryEmpleado=mysql_query("SELECT * FROM usuarios WHERE id_sucursal = '$id_sucursal' OR tipo = 'a'");
        while($row3 = mysql_fetch_array($QueryEmpleado)) {
            //obtiene cantidad de ventas
            $usuario = $row3['usu'];
            $query2=mysql_query(
                "SELECT COUNT(detalle.cantidad) AS cantidad
                 FROM detalle, compania_tl
                 WHERE detalle.fecha_op BETWEEN '$datestart' AND '$datefinish' AND detalle.codigo = compania_tl.codigo AND detalle.id_sucursal = '$id_sucursal' AND compania_tl.id_comision = '$id_comision' AND detalle.usu = '$usuario'");
            while($dato2=mysql_fetch_array($query2)){
                $cantidad_ventas_tipo = $dato2['cantidad'];
            }

            $query3=mysql_query(
                "SELECT SUM(detalle.importe) AS total
                 FROM detalle, compania_tl 
                 WHERE detalle.fecha_op BETWEEN '$datestart' AND '$datefinish' AND detalle.codigo = compania_tl.codigo AND detalle.id_sucursal = '$id_sucursal' AND compania_tl.id_comision = '$id_comision' AND detalle.usu = '$usuario'");
            while($dato3=mysql_fetch_array($query3)){
                $total_importe = $dato3['total'];
            }

        #utilidad y comisiones
            $porcentaje = $row['porcentaje'];
            $query4=mysql_query("SELECT * FROM compania_tl WHERE id_comision = '$id_comision'");
            while($dato4=mysql_fetch_array($query4)){
                $com_asig = $dato4['com_asig'];
            }
            $utilidad = ($total_importe * $com_asig) - $total_importe;
            $total_comision = $utilidad * ($porcentaje /100);

        #fin utilidad y comisiones
            
            //echo "antes de agregar a excel: ".$total_comision."<br>";
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i,$row['nombre'])
            ->setCellValue('B'.$i,$row2['empresa'])
            ->setCellValue('C'.$i,$usuario)
            ->setCellValue('D'.$i,$cantidad_ventas_tipo)
            ->setCellValue('E'.$i,"$ ".number_format($total_importe,2))
            ->setCellValue('F'.$i,"$ ".number_format($com_asig,2))
            ->setCellValue('G'.$i,"$ ".number_format($utilidad,2))
            ->setCellValue('H'.$i,$row['porcentaje']." %")
            ->setCellValue('I'.$i,"$ ".number_format($total_comision,2))
            ->setCellValue('J'.$i,"$ ".number_format($utilidad-$total_comision,2));
            $i++;
        $totales_numero   = $totales_numero   + $cantidad_ventas_tipo;
        $totales_ventas   = $totales_ventas   + $total_importe;
        $totales_utilidad = $totales_utilidad + $utilidad;
        $totales_comision = $totales_comision + $total_comision;
        
        $utilidad = 0;
        $total_comision = 0;
    
    //$i++;
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i,"TOTALES")
            ->setCellValue('B'.$i,"--")
            ->setCellValue('C'.$i,"--")
            ->setCellValue('D'.$i,$totales_numero)
            ->setCellValue('E'.$i,"$ ".number_format($totales_ventas,2))
            ->setCellValue('F'.$i,"--")
            ->setCellValue('G'.$i,"$ ".number_format($totales_utilidad,2))
            ->setCellValue('H'.$i,"--%")
            ->setCellValue('I'.$i,"$ ".number_format($totales_comision,2))
            ->setCellValue('J'.$i,"$ ".number_format($totales_utilidad-$totales_comision,2));

    
    $k = $i;
    $rango = 'A'.$j.':A'.$k;
    $objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleColumna);
    $j = $i;
/*$totales_numero   = 0;
$totales_ventas   = 0;
$totales_utilidad = 0;
$totales_comision = 0;*/
}
}
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
    $totales_numero   = 0;
    $totales_ventas   = 0;
    $totales_utilidad = 0;
    $totales_comision = 0;
}//fin while tipo venta (comisiones)

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
$namefile = "ReporteRecargasGeneral.xlsx";
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
$objPHPExcel->getActiveSheet()->setTitle('REPORTE RECARGAS');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$namefile.'"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
/*$excel->close();*/
/*echo "Los datos se han grabado con &eacute;xito.";*/
?> 