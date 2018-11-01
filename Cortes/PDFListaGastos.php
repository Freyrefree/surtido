<?php
 		session_start();
    include("../MPDF/mpdf.php");
    $mpdf = new mPDF('utf-8' , 'A4','', 15, 15, 15, 10, 15, 10);
		include('../php_conexion.php');
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
    $id_sucursal = $_SESSION['id_sucursal'];
    //----------------------------------------------------------------
    $fecha_fin3=$_GET['fecha_fin11'];

    $fechaaumentada = date($fecha_fin3,strtotime("+1 day"));
    //echo $fechaaumentada;
    $fecha_fin3=date("Y-m-d",strtotime($fecha_fin3)+86400);
    //echo $siguiente;
    $fecha_ini3=$_GET['fecha_ini11'];
    
    //----------------------------------------------------------------
		$can=mysql_query("SELECT * FROM empresa where id='$id_sucursal'");
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
     <td colspan="10" style="text-align:center;"><strong>Lista de Gastos</strong></td>
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
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Identificador</strong></td>
    <td width="19%" bgcolor="#A4DBFF"><strong class="text">Concepto</strong></td>
    <td width="11%" bgcolor="#A4DBFF"><strong class="text">Factura</strong></td>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Fecha</strong></td>
    <td width="9%" bgcolor="#A4DBFF"><strong class="text">Importe</strong></td>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Iva</strong></td>
    <td width="15%" bgcolor="#A4DBFF"><strong class="text">Total + Iva</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Descripcion</strong></td>
    </tr>';
 
  	$num=0;
    $can=mysql_query( "SELECT  * from gastos where fecha BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."' AND id_sucursal = '$id_sucursal' ORDER BY fecha DESC");
  	while($dato=mysql_fetch_array($can)){
		$num=$num+1;
		$resto = $num%2; 
  		if ((!$resto==0)) { 
        	$color="#CCCCCC"; 
   		}else{ 
        	$color="#FFFFFF";
   		}
      $totalconiva = $dato['total']+$dato['iva'];
$codigoHTML.='
  <tr>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['id_gasto'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['concepto'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['numero_fact'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['fecha'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['total'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['iva'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$totalconiva.'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['descripcion'].'</span></td>
  </tr>';
  $SumaTotalImporte =$SumaTotalImporte+$dato['total'];
  $SumaTotalIva = $SumaTotalIva+$dato['iva'];
  $SumaTotalConIva = $SumaTotalImporte+$SumaTotalIva;
  }
$codigoHTML.='
  <tr>
    <td bgcolor="'.$color.'" colspan="8" align="center"><span class="text">Totales</span></td>
  </tr>
  <tr>
    <td bgcolor="'.$color.'" colspan="4"><span class="text"></span></td>
    <td bgcolor="'.$color.'"><span class="text">$'.$SumaTotalImporte.'</span></td>
    <td bgcolor="'.$color.'"><span class="text">$'.$SumaTotalIva.'</span></td>
    <td bgcolor="'.$color.'"><span class="text">$'.$SumaTotalConIva.'</span></td>
    <td bgcolor="'.$color.'"><span class="text"></span></td>
  </tr>
';
$codigoHTML.='
</table>
<div align="right"><span class="text">Gastos Encontrados '.$num.'</span></div>
</div>
</body>
</html>';

      $mpdf->WriteHTML($codigoHTML);
      $mpdf->Output('Lista_Gastos_'.$fech.'.pdf','D');
  
?>