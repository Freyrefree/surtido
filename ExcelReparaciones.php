<?php
error_reporting(0);
session_start();
include('php_conexion.php'); 
$usu = $_SESSION['username'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
    header('location:error.php');
}
#datos recibidos para consulta
$datestart = $_REQUEST['fi2'];
$datefinish = $_REQUEST['ff2'];

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$hoy=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y');
    /*$fecha=date('Ymd');*/
$fech=date('d')."".$meses[date('n')-1]."".date('y');

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

        ->setCellValue('A2','ID')
        ->setCellValue('B2','Garantia')
        ->setCellValue('C2','Estado')
        ->setCellValue('D2','Sucursal')
        ->setCellValue('E2','Marca')
        ->setCellValue('F2','Modelo')
        ->setCellValue('G2','Color')
        ->setCellValue('H2','Nota')
        ->setCellValue('I2','Precio')
        ->setCellValue('J2','Inversion')
        ->setCellValue('K2','Comision')
        ->setCellValue('L2','Refaccion')
        ->setCellValue('M2','Cajero')
        ->setCellValue('N2','Técnico')
        ->setCellValue('O2','Mano Obra')
        ->setCellValue('P2','Comision')
        ->setCellValue('Q2','Utilidad Tienda')
        ->setCellValue('R2','Comisión de la venta');

        $i=3;
        set_time_limit(1000);
        

        $num=0;
        $can=mysql_query("SELECT * FROM reparacion WHERE fecha_ingreso BETWEEN '$datestart' AND '$datefinish' ORDER BY id_reparacion ASC");
        while($dato=mysql_fetch_array($can)){
            $bandera = 0;
            $comisionmo = 0;
            $comisionmo = $dato['mano_obra'] * (10/100);
            $id_reparacion = $dato['id_reparacion'];
            $que=mysql_query("SELECT * FROM reparacion_refaccion WHERE id_reparacion = '$id_reparacion'");
            if($dat=mysql_fetch_array($que)){
              $bandera = 1;
              if($dato['estado']=='1'){
                $estado='Pendiente';
              }
              if ($dato['estado'] == '2') {
                $estado='Terminado';
              }
              if ($dato['estado'] == '3'){
                  $estado='Entregado';
              }
              if ($dato['estado'] == '4'){
                  $estado='Cancelado';
              }
              if ($dato['estado'] == '0'){
                  $estado='Espera';
              }
              if ($dato['garantia'] == 's') {
                $garantia = 'Garantia';
              }else{
                $garantia = '';
              }
              $id_suc = $dato['id_sucursal'];
              $con=mysql_query("SELECT * FROM empresa WHERE id = '$id_suc'");
              //echo "SELECT * FROM empresa WHERE id_sucursal = '$id_suc'";
              if($data=mysql_fetch_array($con)){
                  $sucursal=$data['empresa'];
              }
              $cod = $dat['id_producto'];
              $con2=mysql_query("SELECT * FROM producto WHERE cod = '$cod'");
              if($data2=mysql_fetch_array($con2)){
                  $refaccion=$data2['nom'];
              #obtener la comision de la refaccion
                  if ($dat['TipoPrecio'] == "1") {
                    $precio = $data2['especial'];
                    $costo = $data2['costo'];
                    $utilidad = $precio-$data2['costo'];
                  }
                  if ($dat['TipoPrecio'] == "2") {
                    $precio = $data2['mayor'];
                    $costo = $data2['costo'];
                    $utilidad = $precio-$data2['costo'];
                  }
                  if ($dat['TipoPrecio'] == "3") {
                    $precio = $data2['venta'];
                    $costo = $data2['costo'];
                    $utilidad = $precio-$data2['costo'];
                  } 
                  $id_comision = $data2['id_comision'];
                  $cons=mysql_query("SELECT * FROM comision WHERE id_comision = '$id_comision'");
                  if($row=mysql_fetch_array($cons)){
                    $porcentaje = $row['porcentaje'];
                  }
                  $comision = $comision + ($utilidad*($porcentaje/100));
              #fin obtener la comision de la refaccion
              }
              //$comision = $dato['precio']-$dato['costo'];

              

              $num=$num+1;
              $resto = $num%2; 
              if (($resto==0)) { 
                $color="#CCCCCC"; 
              }else{ 
                $color="#FFFFFF";
              }     


            $Precio         =  $dato['precio'];
            $Costo          =  $dato['costo'];
            $CostoRefaccion =  $dato['CostoRefaccion'];

            $Ut1            =  $Precio - $Costo;
            $Ut2            =  $Costo  - $CostoRefaccion; 
            $UtilidadTienda =  $Ut1 - $Ut2;

            $Ut3 = $Ut1 * 0.10;

            $PersonaAcepta = $dato['usuario'];
          


            //echo "antes de agregar a excel: ".$total_comision."<br>";
            $objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('A'.$i,$dato['id_reparacion'])
            ->setCellValue('B'.$i,$garantia)
            ->setCellValue('C'.$i,$estado)
            ->setCellValue('D'.$i,$sucursal)
            ->setCellValue('E'.$i,$dato['marca'])
            ->setCellValue('F'.$i,$dato['modelo'])
            ->setCellValue('G'.$i,$dato['color'])
            ->setCellValue('H'.$i,$dato['id_reparacion'])
            ->setCellValue('I'.$i,$Precio)
            ->setCellValue('J'.$i,$dato['costo'])
            ->setCellValue('K'.$i,$comision)
            ->setCellValue('L'.$i,$refaccion)
            ->setCellValue('M'.$i,$dato['usuario'])
            ->setCellValue('N'.$i,$dato['tecnico'])
            ->setCellValue('O'.$i,$dato['mano_obra'])
            ->setCellValue('P'.$i,$comisionmo)
            ->setCellValue('Q'.$i,$UtilidadTienda)
            ->setCellValue('R'.$i,"para $PersonaAcepta $ $Ut3");
           
            $i++;
        }   
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
$namefile = "REPORTE_REPARACIONES".$_SESSION['username'].".xlsx";
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
$objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("N")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("P")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("Q")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("R")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

$objPHPExcel->getActiveSheet()->getStyle('A2:R2')->applyFromArray($styleArray);
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