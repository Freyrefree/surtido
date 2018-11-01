<?php
 		session_start();
		/*require_once("dompdf/dompdf_config.inc.php");
    include('html2pdf/html2pdf.class.php');*/
    $id_sucursal = $_SESSION['id_sucursal'];
    include("../MPDF/mpdf.php");
    $mpdf = new mPDF('utf-8' , 'A4','', 15, 15, 15, 10, 15, 10);
		include('../php_conexion.php');
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
    //----------------------------------------------------------------
    $fecha_fin3=$_GET['fecha_fin11'];

    $fechaaumentada = date($fecha_fin3,strtotime("+1 day"));
    //echo $fechaaumentada;
    $fecha_fin3=date("Y-m-d",strtotime($fecha_fin3)+86400);
    //echo $siguiente;
    $fecha_ini3=$_GET['fecha_ini11'];
    $cajero=$_GET['cajero'];
    $producto=$_GET['producto'];
    $codigo = $_GET['codigo'];
    $coincidencia = $_GET['coincidencia'];
    $categoria = $_GET['categoria'];
    //----------------------------------------------------------------
		$can=mysql_query("SELECT * FROM empresa WHERE id=1");
		if($dato=mysql_fetch_array($can)){
			$empresa=$dato['empresa'];
			$nit=$dato['nit'];
			$direccion=$dato['direccion'];
			$ciudad=$dato['ciudad'];
			$tel1=$dato['tel1'];
			$tel2=$dato['tel2'];
			$web=$dato['web'];
			$correo=$dato['correo'];
		}
		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 		$hoy=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y');
		$fech=date('d')."".$meses[date('n')-1]."".date('y');
		
		//Salida: Viernes 24 de Febrero del 2012

$codigoHTML='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reporte</title>
<style type="text/css">
.tabla {
 border: 1px solid #0B198C;
 border-width: 0 0 1px 1px;
}

.tabla td {
 border: 1px solid #0B198C;
 border-with: 0 0 1px 1px;
}

</style>
</head>

<body>
<div align="center">
<table width="100%" border="0">
<strong>Reporte de Ventas</strong>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
     <td colspan="10" style="text-align:center;"><strong>Corte de Ventas</strong></td>
  </tr>
  <tr>
    <td width="10"><img src="../img/logoa.jpg" width="114" height="90" alt="" /></td>
    <td width="83%" colspan="2">
      <div align="center">
        <span class="text">'.$empresa.' Nit. '.$nit.'</span><br />
        <span class="text">Ciudad: '.$ciudad.' Direccion: '.$direccion.' </span><br />
        <span class="text">TEL: '.$tel1.' TEL2: '.$tel2.'</span><br />
        <span class="text">Reporte Impreso el '.$hoy.' por '.$_SESSION['username'].'</span>
      </div>
    </td>
  </tr>
</table>
<table width="100%" border="0" class="tabla" cellpading="0" cellspacing="0">
  <tr>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Estado</strong></td>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Factura</strong></td>
    <td width="19%" bgcolor="#A4DBFF"><strong class="text">Codigo</strong></td>
    <td width="11%" bgcolor="#A4DBFF"><strong class="text">Nombre</strong></td>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Cantidad</strong></td>
    <td width="9%" bgcolor="#A4DBFF"><strong class="text">Valor</strong></td>
    <td width="16%" bgcolor="#A4DBFF"><strong class="text">Importe</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Tipo</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Fecha Venta</strong></td>
    <td width="9%" bgcolor="#A4DBFF"><strong class="text">Usuario</strong></td>
    <td width="9%" bgcolor="#A4DBFF"><strong class="text">Sucursal</strong></td>
    </tr>';

if($categoria!=""){

  	$num=0;

    if ($cajero == 'Todos' && $categoria != '' && empty($codigo)) {
      //$can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu FROM detalle WHERE fecha_op BETWEEN '$fecha_ini3' AND '$fecha_fin3' AND codigo='$producto'");
      $can=mysql_query( "SELECT * FROM detalle WHERE (codigo IN(SELECT cod FROM producto WHERE id_comision='$categoria')                    
                                               OR codigo IN(SELECT codigo FROM compania_tl WHERE id_comision IN(SELECT id_comision FROM comision WHERE tipo='$categoria'))) 
                                               AND fecha_op BETWEEN '$fecha_ini3' 
                                               AND '$fecha_fin3' 
                                                ORDER BY fecha_op");
    }

    if ($cajero != 'Todos' && $categoria != '' && empty($codigo)) {
      $can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu,garantia,id_sucursal FROM detalle WHERE fecha_op BETWEEN '$fecha_ini3' 
                                                                                                                                        AND '$fecha_fin3' 
                                                                                                                                        AND usu='$cajero' 
                                                                                                                                        AND (codigo IN(SELECT cod FROM producto WHERE id_comision='$categoria')                    
                                                                                                                                        OR codigo IN(SELECT codigo FROM compania_tl WHERE id_comision IN(SELECT id_comision FROM comision WHERE tipo='$categoria'))) 
                                                                                                                                        "); 
    }
    //-------------------------------con codigo------------------------------------------------
    //-----------------------------------------------------------------------------------------
  
    if ($cajero == 'Todos' && $categoria != '' && !empty($codigo)) {
      $can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu,garantia,id_sucursal FROM detalle WHERE fecha_op BETWEEN '$fecha_ini3' 
                                                                                                                                        AND '$fecha_fin3' 
                                                                                                                                        AND nombre='$producto' 
                                                                                                                                        AND factura ='$codigo' 
                                                                                                                                        ");
    }


    if ($cajero != 'Todos' && $categoria != '' && !empty($codigo)) {
      $can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu,garantia,id_sucursal FROM detalle WHERE fecha_op BETWEEN '$fecha_ini3' 
                                                                                                                                        AND '$fecha_fin3' 
                                                                                                                                        AND usu='$cajero' 
                                                                                                                                        AND (codigo IN(SELECT cod FROM producto WHERE id_comision='$categoria')                    
                                                                                                                                        OR codigo IN(SELECT codigo FROM compania_tl WHERE id_comision IN(SELECT id_comision FROM comision WHERE tipo='$categoria'))) 
                                                                                                                                        AND factura ='$codigo'  ORDER BY fecha_op"); 
     }
    //especial coincidencias
    if (!empty($coincidencia)) {
      $can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu,garantia,id_sucursal FROM detalle WHERE fecha_op BETWEEN '$fecha_ini3' AND '$fecha_fin3' AND nombre LIKE '%$coincidencia%' ");
    }

}       
 
 if($categoria==""){
  	$num=0;
    if ($cajero == 'Todos' && $producto == 'Todos' && empty($codigo)) {
      $can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu,garantia,id_sucursal FROM detalle WHERE fecha_op BETWEEN '$fecha_ini3' AND '$fecha_fin3''");
    }
    if ($cajero == 'Todos' && $producto != 'Todos' && empty($codigo)) {
      //$can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu FROM detalle WHERE fecha_op BETWEEN '$fecha_ini3' AND '$fecha_fin3' AND codigo='$producto'");
      $can=mysql_query( "SELECT * FROM detalle WHERE codigo = '$producto' AND fecha_op BETWEEN '$fecha_ini3' AND '$fecha_fin3'  ORDER BY fecha_op");
    }
    if ($cajero != 'Todos' && $producto == 'Todos' && empty($codigo)) {
      $can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu,garantia,id_sucursal FROM detalle WHERE fecha_op BETWEEN '$fecha_ini3' AND '$fecha_fin3' AND usu='$cajero' "); 
    }
    if ($cajero != 'Todos' && $producto != 'Todos' && empty($codigo)) {
      $can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu,garantia,id_sucursal FROM detalle WHERE fecha_op BETWEEN '$fecha_ini3' AND '$fecha_fin3' AND usu='$cajero' AND codigo='$producto' "); 
    }
    //-------------------------------con codigo------------------------------------------------
    //-----------------------------------------------------------------------------------------
    if ($cajero == 'Todos' && $producto == 'Todos' && !empty($codigo)) {
      $can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu,garantia,id_sucursal FROM detalle WHERE fecha_op BETWEEN '$fecha_ini3' AND '$fecha_fin3' AND factura ='$codigo' ");
    }
    if ($cajero == 'Todos' && $producto != 'Todos' && !empty($codigo)) {
      $can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu,garantia,id_sucursal FROM detalle WHERE fecha_op BETWEEN '$fecha_ini3' AND '$fecha_fin3' AND nombre='$producto' AND factura ='$codigo' ");
    }
    if ($cajero != 'Todos' && $producto == 'Todos' && !empty($codigo)) {
      $can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu,garantia,id_sucursal FROM detalle WHERE fecha_op BETWEEN '$fecha_ini3' AND '$fecha_fin3' AND usu='$cajero' AND factura ='$codigo'"); 
    }
    if ($cajero != 'Todos' && $producto != 'Todos' && !empty($codigo)) {
      $can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu,garantia,id_sucursal FROM detalle WHERE fecha_op BETWEEN '$fecha_ini3' AND '$fecha_fin3' AND usu='$cajero' AND codigo='$producto' AND factura ='$codigo'  ORDER BY fecha_op"); 
     }
    //especial coincidencias
    if (!empty($coincidencia)) {
      $can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu,garantia,id_sucursal FROM detalle WHERE fecha_op BETWEEN '$fecha_ini3' AND '$fecha_fin3' AND nombre LIKE '%$coincidencia%' ");
    }
}

    //fin especial coincidencias
  	/*$can=mysql_query("SELECT * FROM detalle order by nom");*/	
  	while($dato=mysql_fetch_array($can)){
        //......nombre sucursal inicio.........................................................
  $idsucursal=$dato['id_sucursal'];
  $querynombresucursal="SELECT empresa FROM empresa WHERE id = '$idsucursal'";
  $canempresa = mysql_query($querynombresucursal);
  $dato2 = mysql_fetch_array($canempresa);
  $nombreempresa = $dato2['empresa'];
  //......nombre sucursal fin.........................................................
		if ($dato['tipo'] == 'CREDITO') {
      $tipov = "Credito/Apartado";
    }else {
      $tipov = "Contado";
    }
		$num=$num+1;
		$resto = $num%2; 
  		if ((!$resto==0)) { 
        	$color="#CCCCCC"; 
   		}else{ 
        	$color="#FFFFFF";
   		}  
 
$codigoHTML.='
  <tr>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['garantia'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['factura'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['codigo'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['nombre'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['cantidad'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['valor'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['importe'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$tipov.'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['fecha_op'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['usu'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$nombreempresa.'</span></td>
  </tr>';
  }
$codigoHTML.='
</table>
<div align="right"><span class="text">Registros Encontrados '.$num.'</span></div>
</div>
</body>
</html>';

      $mpdf->WriteHTML($codigoHTML);
      $mpdf->Output('Reporte_Corte_'.$fech.'.pdf','D');
  
?>