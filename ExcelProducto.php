<?php
error_reporting(0);
session_start();
include('php_conexion.php');
include('funciones.php');
$usu = $_SESSION['username'];
if((!$_SESSION['tipo_usu']=='a') || (!$_SESSION['tipo_usu']=='su') || (!$_SESSION['tipo_usu']=='ca') || (!$_SESSION['tipo_usu']=='te')){
    header('location:error.php');
}

if ($_SESSION['tipo_usu']=='a') 
{
    #datos recibidos para consulta
    $id_sucursal = $_SESSION['id_sucursal'];

    $consultaSucursal = "SELECT empresa FROM empresa WHERE id = $id_sucursal";
    $ejecutar = mysql_query($consultaSucursal);
    if(mysql_num_rows($ejecutar) > 0){

        $dato = mysql_fetch_array($ejecutar);
        $nombreSucursal = $dato['empresa'];
    }





    $id_comision = $_REQUEST['producto'];
    $sucursal = $_REQUEST['sucursal'];
    $coin = $_REQUEST['coin'];

    #fin datos recibidos para consulta
    require_once 'phpexcel/PHPExcel.php';

    #creacion de excel con sus columnas
    $objPHPExcel = new PHPExcel();
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

        ->setCellValue('A2', 'Codigo'.$id_comision)
        ->setCellValue('B2', 'Nombre del Producto')
        ->setCellValue('C2', 'Estado')
        ->setCellValue('D2', 'Proveedor')
        ->setCellValue('E2', 'Existencia')
        ->setCellValue('F2', 'Costo')
        ->setCellValue('G2', 'Especial')
        ->setCellValue('H2', 'Mayoreo')
        ->setCellValue('I2', 'Público');

    $i=3;
    set_time_limit(1000);
        

    $can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' AND cantidad > 0 ORDER BY nom ASC") or die(mysql_error());

    while ($dato = mysql_fetch_array($can)) {
        $codigo=$dato['cod'];
        $cprov=$dato['prov'];
        $cann=mysql_query("SELECT * FROM proveedor where codigo=$cprov");
        if ($datos=mysql_fetch_array($cann)) {
            $n_prov=$datos['empresa'];
        }

        $seccion=$dato['seccion'];
        $cann=mysql_query("SELECT * FROM seccion where id=$seccion");
        if ($datos=mysql_fetch_array($cann)) {
            $n_seccion=$datos['nombre'];
        }

        if ($dato['estado']=="n") {
            $estado='Inactivo';
        } else {
            $estado='Activo';
        }

        //echo "antes de agregar a excel: ".$total_comision."<br>";
        $objPHPExcel->setActiveSheetIndex(0)

           
            ->setCellValueExplicit('A'.$i, $dato['cod'], PHPExcel_Cell_DataType::TYPE_STRING) // formato de cadena para que no se descomponga el código
            ->setCellValue('B'.$i, utf8_encode($dato['nom']))
            ->setCellValue('C'.$i, $estado)
            ->setCellValue('D'.$i, $n_prov)
            ->setCellValue('E'.$i, $dato['cantidad'])
            ->setCellValue('F'.$i, $dato['costo'])
            ->setCellValue('G'.$i, $dato['especial'])
            ->setCellValue('H'.$i, $dato['mayor'])
            ->setCellValue('I'.$i, $dato['venta']);
           

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
    $namefile = "REPORTE_PRODUCTOS".$_SESSION['username']."-".$nombreSucursal.".xlsx";
    $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);



    $objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->setTitle('REPORTE PRODUCTOS');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$namefile.'"');
    header('Cache-Control: max-age=0');

    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
    
}else if($_SESSION['tipo_usu']=='ca' || $_SESSION['tipo_usu']=='su' || $_SESSION['tipo_usu']=='te')
{
        #datos recibidos para consulta
        $id_sucursal = $_SESSION['id_sucursal'];

        $consultaSucursal = "SELECT empresa FROM empresa WHERE id = $id_sucursal";




        $id_comision = $_REQUEST['producto'];
        $sucursal = $_REQUEST['sucursal'];
        $coin = $_REQUEST['coin'];
    
        #fin datos recibidos para consulta
        require_once 'phpexcel/PHPExcel.php';
    
        #creacion de excel con sus columnas
        $objPHPExcel = new PHPExcel();
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
    
            ->setCellValue('A2', 'Codigo'.$id_comision)
            ->setCellValue('B2', 'Nombre del Producto')
            ->setCellValue('C2', 'Estado')
            ->setCellValue('D2', 'Proveedor')
            ->setCellValue('E2', 'Existencia')
            ->setCellValue('F2', 'Público');
    
        $i=3;
        set_time_limit(1000);
            
    
        $can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' AND cantidad > 0 ORDER BY nom ASC") or die(mysql_error());
    
        while ($dato = mysql_fetch_array($can)) {
            $codigo=$dato['cod'];
            $cprov=$dato['prov'];
            $cann=mysql_query("SELECT * FROM proveedor where codigo=$cprov");
            if ($datos=mysql_fetch_array($cann)) {
                $n_prov=$datos['empresa'];
            }
    
            $seccion=$dato['seccion'];
            $cann=mysql_query("SELECT * FROM seccion where id=$seccion");
            if ($datos=mysql_fetch_array($cann)) {
                $n_seccion=$datos['nombre'];
            }
    
            if ($dato['estado']=="n") {
                $estado='Inactivo';
            } else {
                $estado='Activo';
            }
    
            //echo "antes de agregar a excel: ".$total_comision."<br>";
            $objPHPExcel->setActiveSheetIndex(0)
    
               
                ->setCellValueExplicit('A'.$i, $dato['cod'], PHPExcel_Cell_DataType::TYPE_STRING) // formato de cadena para que no se descomponga el código
                ->setCellValue('B'.$i, utf8_encode($dato['nom']))
                ->setCellValue('C'.$i, $estado)
                ->setCellValue('D'.$i, $n_prov)
                ->setCellValue('E'.$i, $dato['cantidad'])
                ->setCellValue('F'.$i, $dato['venta']);
               
    
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
        $namefile = "REPORTE_PRODUCTOS".$_SESSION['username']."-".$nombreSucursal.".xlsx";
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
    
    
    
        $objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->setTitle('REPORTE PRODUCTOS');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$namefile.'"');
        header('Cache-Control: max-age=0');
    
        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

}

?> 