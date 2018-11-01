<?php
 		session_start();
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
    
    //----------------------------------------------------------------
		$can=mysql_query("SELECT * FROM empresa where id=1");
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
     <td colspan="10" style="text-align:center;"><strong>Reporte de Ventas a credito</strong></td>
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
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">ID</strong></td>
    <td width="19%" bgcolor="#A4DBFF"><strong class="text">Factura</strong></td>
    <td width="11%" bgcolor="#A4DBFF"><strong class="text">RFC Cliente</strong></td>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Importe</strong></td>
    <td width="9%" bgcolor="#A4DBFF"><strong class="text">Adelanto</strong></td>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Restante</strong></td>
    <td width="15%" bgcolor="#A4DBFF"><strong class="text">Fecha Venta</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Fecha Limite</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Estatus</strong></td>
    </tr>';
 
  	$pendiente=0;$pagado=0;
    $can=mysql_query( "SELECT  * from credito where fecha_venta BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."' ORDER BY fecha_venta DESC");
  	while($dato=mysql_fetch_array($can)){
		$resto = $num%2; 
  		if ((!$resto==0)) { 
        	$color="#CCCCCC"; 
   		}else{ 
        	$color="#FFFFFF";
   		}
      if ($dato['estatus'] == 1) {
      $estatus = "Pagado";
      $pagado++;
    }else {
      $estatus = "Pendiente";
      $pendiente++;
    }
$codigoHTML.='
  <tr>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['id'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['id_factura'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['rfc_cliente'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['total'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['adelanto'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['resto'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['fecha_venta'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['fecha_pago'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$estatus.'</span></td>
  </tr>';
  $SumaTotalImporte =$SumaTotalImporte+$dato['total'];
  $SumaTotalAdelanto = $SumaTotalAdelanto+$dato['adelanto'];
  $SumaTotalResto = $SumaTotalResto+$dato['resto'];
  }
$codigoHTML.='
  <tr>
    <td bgcolor="'.$color.'" colspan="9" align="center"><span class="text">Totales</span></td>
  </tr>
  <tr>
    <td bgcolor="'.$color.'" colspan="3"><span class="text"></span></td>
    <td bgcolor="'.$color.'"><span class="text">$'.$SumaTotalImporte.'</span></td>
    <td bgcolor="'.$color.'"><span class="text">$'.$SumaTotalAdelanto.'</span></td>
    <td bgcolor="'.$color.'"><span class="text">$'.$SumaTotalResto.'</span></td>
    <td bgcolor="'.$color.'" colspan="3"><span class="text"></span></td>
  </tr>
';
$codigoHTML.='
</table>
<div align="right"><span class="text">Ventas a credito Pagadas '.$pagado.'</span></div>
<div align="right"><span class="text">Ventas a credito Pendientes '.$pendiente.'</span></div>
</div>
</body>
</html>';

      $mpdf->WriteHTML($codigoHTML);
      $mpdf->Output('Reporte_Ventas_Credito_'.$fech.'.pdf','D');
  
?>