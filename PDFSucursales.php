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

    $id_sucursal = $_SESSION['id_sucursal'];
    $id_comision = $_GET['producto'];
    $sucursal = $_GET['sucursal'];
    $coin = $_GET['coin'];

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
<strong>Listado de Productos</strong>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="10" style="text-align:center;"><strong>Listado de Sucursales</strong></td>
  </tr>
  <tr>
    <td width="10"><img src="img/logoa.jpg" width="114" height="90" alt="" /></td>
    <td width="83%" colspan="2">
      <div align="center">
        <span class="text">'.$empresa.'</span> <span class="text">Nit. '.$nit.'</span><br />
        <span class="text">Ciudad: '.$ciudad.' Direccion: '.$direccion.' </span><br />
        <span class="text">TEL: '.$tel1.' CEL: '.$tel2.'</span><br />
        <span class="text">Reporte Impreso el '.$hoy.' por '.$_SESSION['username'].'</span>
      </div>
    </td>
  </tr>
</table><br />
<table width="100%" border="0" class="tabla" cellpading="0" cellspacing="0">
  <tr>
    <td width="3%" bgcolor="#A4DBFF"><strong class="text">Codigo</strong></td>
    <td width="18%" bgcolor="#A4DBFF"><strong class="text">Nombre Empresa</strong></td>
    <td width="11%" bgcolor="#A4DBFF"><strong class="text">No. Int</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Dirección</strong></td>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Ciudad</strong></td>
    <td width="9%" bgcolor="#A4DBFF"><strong class="text">Telefono 1</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Telefono 2</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Web</strong></td>
    <td width="9%" bgcolor="#A4DBFF"><strong class="text">Correo</strong></td>
    </tr>'; 
    /*<td width="12%" bgcolor="#A4DBFF"><strong class="text">Cod. del Proveedor</strong></td>*/
  	$num=0;
    /*if ($id_comision == "Todos") {
      $can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$id_sucursal'");
    }else {
      $can=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND id_sucursal = '$id_sucursal'");
    }*/


	$can=mysql_query("SELECT * FROM empresa");
	while($dato=mysql_fetch_array($can)){	
		$num=$num+1;
		$resto = $num%2; 
  		if ((!$resto==0)) {
        	$color="#CCCCCC"; 
   		}else{ 
        	$color="#FFFFFF";
   		}
$codigoHTML.='
  <tr>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['id'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['empresa'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['nit'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['direccion'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['ciudad'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['tel1'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['tel2'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['web'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['correo'].'</span></td>
   
  </tr>';
  /*<td bgcolor="'.$color.'"><span class="text">'.$dato['cprov'].'</span></td>*/
  }
$codigoHTML.='
</table><br />
<div align="right"><span class="text">Registros Encontrados '.$num.'</span></div>
</div>
</body>
</html>';
    $mpdf->WriteHTML($codigoHTML);
    $mpdf->Output('Listado_Sucursales'.$fech.'.pdf','D');
/*try {
        $pdf = new HTML2PDF('P', 'A4', 'es');
        $pdf -> WriteHTML($codigoHTML);
        $pdf -> output('Listado_Productos_'.$fech.'.pdf','D');//D indica descarga del archivo
      } catch (Exception $e) {
        echo $e;
      }*/

/*$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Listado_Productos_".$fech.".pdf");*/

?>