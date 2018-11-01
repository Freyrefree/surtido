<?php
 		session_start();
		/*require_once("dompdf/dompdf_config.inc.php");
    include('html2pdf/html2pdf.class.php');*/
    include("MPDF/mpdf.php");
    $mpdf=new mPDF('utf-8' , 'A4','', 15, 15, 15, 10, 15, 10);
		include('php_conexion.php');
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
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
		$datestart = $_GET['inicio'];
    $dateend = $_GET['fin'];
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
<strong>Listado de Compras/Cliente</strong>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
     <td colspan="10" style="text-align:center;"><strong>Listado de Entradas</strong></td>
  </tr>
  <tr>
    <td width="10"><img src="img/logoa.jpg" width="20%" alt="" /></td>
    <td width="83%" colspan="2">
      <div align="center">
        <span class="text"> Sucursal: '.$empresa.', NO. '.$nit.'</span><br />
        <span class="text">Ciudad: '.$ciudad.' Direccion: '.$direccion.' </span><br />
        <span class="text">TEL: '.$tel1.' TEL2: '.$tel2.'</span><br />
        <span class="text">RANGO DE FECHAS: '.$datestart.' AL: '.$dateend.'</span><br />
        <span class="text">Reporte Impreso el '.$hoy.' por '.$_SESSION['username'].'</span>
      </div>
    </td>
  </tr>
</table>
<table width="100%" border="0" class="tabla" cellpading="0" cellspacing="0">
  <tr>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">ID</strong></td>
    <td width="19%" bgcolor="#A4DBFF"><strong class="text">Producto</strong></td>
    <td width="11%" bgcolor="#A4DBFF"><strong class="text">Num. Remision</strong></td>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Cantidad</strong></td>
    <td width="9%" bgcolor="#A4DBFF"><strong class="text">Costo</strong></td>
    <td width="16%" bgcolor="#A4DBFF"><strong class="text">fecha</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Comprobante</strong></td>
    </tr>';
 
  	$num=0;
    if (empty($datestart) or empty($dateend)) {
	     $can=mysql_query("SELECT * FROM compras ORDER BY fecha");
    }else {
      $can=mysql_query("SELECT * FROM compras where fecha BETWEEN '".$datestart."' AND '".$dateend."'");
    }
	while($dato=mysql_fetch_array($can)){
    if($dato['dir_file']!=""){
        //esta parte pendiente
        $estado='<span class="label label-success">Documento</span>';
    }else{
        $estado='<span class="label label-alert">No Documento</span>';
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
    <td bgcolor="'.$color.'"><span class="text">'.$dato['id_compra'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['nom_producto'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['num_remision'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['cantidad'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.number_format($dato['costo'],2,",",".").'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['fecha'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$estado.'</span></td>
  </tr>';
  }
$codigoHTML.='
</table>
<div align="right"><span class="text">Registros Encontrados '.$num.'</span></div>
</div>
</body>
</html>';

    $mpdf->WriteHTML($codigoHTML);  
    $mpdf->Output('Listado_Compras_'.$fech.'.pdf','D');
  /*try {
    $pdf = new HTML2PDF('P', 'A4', 'es');
    $pdf -> WriteHTML($codigoHTML);
    $pdf -> output('Listado_Usuarios_'.$fech.'.pdf','D');
  } catch (Exception $e) {
    echo $e;
  }*/
  
/*$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Listado_Clientes_".$fech.".pdf");*/

?>