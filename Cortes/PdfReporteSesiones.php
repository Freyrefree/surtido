<?php
 		session_start();
		/*require_once("dompdf/dompdf_config.inc.php");
    include('html2pdf/html2pdf.class.php');*/
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
    /*$producto=$_GET['producto'];
    $codigo = $_GET['codigo'];*/
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
<table width="100%" border="0" class="tabla" cellpading="0" cellspacing="0" style="font-size:10px">
  <tr>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Usuario</strong></td>
    <td width="19%" bgcolor="#A4DBFF"><strong class="text">Apertura</strong></td>
    <td width="11%" bgcolor="#A4DBFF"><strong class="text">Ventas</strong></td>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Corte de Caja</strong></td>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">En tienda</strong></td>
    <td width="12%" bgcolor="#A4DBFF"><strong class="text">Hora de Inicio</strong></td>
    <td width="12%" bgcolor="#A4DBFF"><strong class="text">Hora de Cierre</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Fecha</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Responsable</strong></td>
    </tr>';
 
  	$num=0;
    /*if ($cajero == 'Todos' && $producto == 'Todos' && empty($codigo)) {
      $can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu from detalle where fecha_op BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."'");
    }
        
    if ($cajero != 'Todos' && $producto != 'Todos' && !empty($codigo)) {
      $can=mysql_query( "SELECT  LTRIM(factura) AS factura,codigo,nombre,cantidad,valor,importe,tipo,fecha_op,usu from detalle where fecha_op BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."' AND usu='".$cajero."' AND nombre='".$producto."' and factura ='".$codigo."'"); 
    }*/

    if ($cajero != 'Todos') {
      $can=mysql_query("SELECT * from detalle_caja WHERE fecha BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."' AND autoriza='$cajero'");
    }

    if ($cajero == 'Todos') {
      $can=mysql_query( "SELECT * from detalle_caja WHERE fecha BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."'");
    }
  	/*$can=mysql_query("SELECT * FROM detalle order by nom");*/	
  	while($dato=mysql_fetch_array($can)){
		$ced = $dato['id_cajero'];
    $query=mysql_query("SELECT * FROM usuarios WHERE ced = '$ced'");
    if($row=mysql_fetch_array($query)){
      $usuario = $row['usu'];
    }
    $querys=mysql_query("SELECT * FROM caja WHERE id_cajero = '$ced'");
    if($rows=mysql_fetch_array($querys)){
      $cantidadcaja = $rows['apertura'];
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
    <td bgcolor="'.$color.'"><span class="text">'.$usuario.'</span></td>
    <td bgcolor="'.$color.'"><span class="text">$ '.number_format($dato['apertura'], 2, ',', ' ').'</span></td>
    <td bgcolor="'.$color.'"><span class="text">$ '.number_format($dato['ventas'], 2, ',', ' ').'</span></td>
    <td bgcolor="'.$color.'"><span class="text">$ '.number_format($dato['cierre'], 2, ',', ' ').'</span></td>
    <td bgcolor="'.$color.'"><span class="text">$ '.number_format($cantidadcaja, 2, ',', ' ').'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['horainicio'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['horacierre'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['fecha'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['autoriza'].'</span></td>
  </tr>';
  }
$codigoHTML.='
</table>
<div align="right"><span class="text">Registros Encontrados '.$num.'</span></div>
</div>
</body>
</html>';

      $mpdf->WriteHTML($codigoHTML);
      $mpdf->Output('ReprteSesiones'.$fech.'.pdf','D');
  
?>