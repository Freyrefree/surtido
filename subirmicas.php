<?php
$conexion = mysql_connect("localhost","root","");
mysql_select_db("tienda_surtidocell",$conexion);

include('Classes/PHPExcel.php');
include('Classes/PHPExcel/IOFactory.php');
ini_set('max_execution_time', 600); //300 seconds = 5 minutes


$objReader = new PHPExcel_Reader_Excel2007();
$objPHPExcel = $objReader->load("C:/Users/USER/Documents/cargamica2.xlsx");


$rows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
$objPHPExcel->setActiveSheetIndex(0);
$highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
//$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumm); //HORIZONTAL

//$array = createColumnsArray($highestColumm);
//$retornoLetras = letrasConFecha($array,$objPHPExcel);




$y=1;
$i=1; //Si existiera una fila con los títulos inicial $i=3
while($i <= $rows)
{
    $codigo_producto = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
    $nombre_producto = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();

    $sucursal6 = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
    if($sucursal6 == ''){$sucursal6 = 0;}

    $sucursal8 = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
    if($sucursal8 == ''){$sucursal8 = 0;}

    $sucursal4 = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
    if($sucursal4 == ''){$sucursal4 = 0;}

    $sucursal9 = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();
    if($sucursal9 == ''){$sucursal9 = 0;}

    $sucursal2 = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getValue();
    if($sucursal2 == ''){$sucursal2 = 0;}

    $sucursal3 = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getValue();
    if($sucursal3 == ''){$sucursal3 = 0;}

    $sucursal5 = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getValue();
    if($sucursal5 == ''){$sucursal5 = 0;}

    $sucursal7 = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getValue();
    if($sucursal7 == ''){$sucursal7 = 0;}

    $sucursal10 = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getValue();
    if($sucursal10 == ''){$sucursal10 = 0;}
    

    echo $codigo_producto.'_____'.$nombre_producto."<br/>";

    for($m=$y;$m <= 13;$m++)
    {
        $id_sucursal = $m;
        $consulta = "INSERT INTO producto(cod,nom,costo,mayor,venta,especial,cantidad,seccion,fecha,estado,id_comision,id_sucursal)VALUES
        ('$codigo_producto','$nombre_producto','6.5','14','59','11.5','0','1','2018-06-29','S','6',$id_sucursal);";

        if(mysql_query($consulta)){
            echo "ok<br/>";
        }
        //echo $consulta."<br>";

    }


        $consulta1 = "UPDATE producto SET cantidad = '$sucursal6' WHERE cod = '$codigo_producto' AND id_sucursal = '6'";
        $consulta2 = "UPDATE producto SET cantidad = '$sucursal8' WHERE cod = '$codigo_producto' AND id_sucursal = '8'";
        $consulta3 = "UPDATE producto SET cantidad = '$sucursal4' WHERE cod = '$codigo_producto' AND id_sucursal = '4'";
        $consulta4 = "UPDATE producto SET cantidad = '$sucursal9' WHERE cod = '$codigo_producto' AND id_sucursal = '9'";
        $consulta5 = "UPDATE producto SET cantidad = '$sucursal2' WHERE cod = '$codigo_producto' AND id_sucursal = '2'";
        $consulta6 = "UPDATE producto SET cantidad = '$sucursal3' WHERE cod = '$codigo_producto' AND id_sucursal = '3'";
        $consulta7 = "UPDATE producto SET cantidad = '$sucursal5' WHERE cod = '$codigo_producto' AND id_sucursal = '5'";
        $consulta8 = "UPDATE producto SET cantidad = '$sucursal7' WHERE cod = '$codigo_producto' AND id_sucursal = '7'";
        $consulta9 = "UPDATE producto SET cantidad = '$sucursal10' WHERE cod = '$codigo_producto' AND id_sucursal = '10'";

        if(mysql_query($consulta1) && mysql_query($consulta2) && mysql_query($consulta3) && mysql_query($consulta4) &&
         mysql_query($consulta5) && mysql_query($consulta6) && mysql_query($consulta7) && mysql_query($consulta8) && mysql_query($consulta9))
        {
            echo "editados<br/>";
        } 





    
    $i++;
}

?>