<?php
 		session_start();    
   
    include("MPDF/mpdf.php");
    $mpdf=new mPDF('c','A4','','',15, 15, 15, 10, 15, 10);
    $mpdf->SetDisplayMode('fullpage');

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
    <td width="10"><img src="img/logoa.jpg" width="114" height="90" alt="" /></td>
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
    <td width="3%" bgcolor="#A4DBFF"><strong class="text">Cod</strong></td>   
    <td width="3%" bgcolor="#A4DBFF"><strong class="text">Nombre</strong></td>    


    <td width="3%" bgcolor="#A4DBFF"><strong class="text">Precio V</strong></td>
    </tr>';
    

  	$num=0;


    if ($id_comision == "Todos" && $sucursal == "Todos" && $coin == "") {
    //echo "sin producto, sin sucursal, sin termino";
      //$can=mysql_query("SELECT * FROM producto WHERE cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());
      $can=mysql_query("SELECT * FROM producto  ORDER BY id_sucursal") or die(mysql_error());//todos los productos
    }
    if ($id_comision == "Todos" && $sucursal == "Todos" && $coin != "") {
      echo "sin producto, sin sucursal, con termino";
      $can=mysql_query("SELECT * FROM producto WHERE (nom LIKE '%$coin%' OR marca like '%$coin%' OR modelo like '%$coin%' OR compania like '%$coin%' OR color like '%coin%' OR categoria like '%$coin%') AND cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());
    }

    if ($id_comision == "Todos" && $sucursal != "Todos" && $coin == "") {
    //echo "sin producto, con sucursal, sin termino";
      $can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$sucursal' AND (nom LIKE '%$coin%' OR marca like '%$coin%' OR modelo like '%$coin%' OR compania like '%$coin%' OR color like '%coin%' OR categoria like '%$coin%') AND cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());
    }

    if ($id_comision != "Todos" && $sucursal == "Todos" && $coin != "") {
    //echo "con producto, sin sucursal, con termino";
      $can=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND (nom LIKE '%$coin%' OR marca like '%$coin%' OR modelo like '%$coin%' OR compania like '%$coin%' OR color like '%coin%' OR categoria like '%$coin%') AND cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());

    }

    if ($id_comision != "Todos" && $sucursal == "Todos" && $coin == "") {
    //echo "con producto, sin sucursal, sin termino";
      $can=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());
    }

    if ($id_comision != "Todos" && $sucursal != "Todos" && $coin != "") {
    //echo "con producto, sucursal y con termino";
      $can=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND id_sucursal = '$sucursal' AND (nom LIKE '%$coin%' OR marca like '%$coin%' OR modelo like '%$coin%' OR compania like '%$coin%' OR color like '%coin%' OR categoria like '%$coin%') AND cantidad > 0 ORDER BY id_sucursal") or die("Error con producto sucursal y con termino");
    }

    if ($id_comision != "Todos" && $sucursal != "Todos" && $coin == "") {
    //echo "con producto, sucursal y sin termino";
      $can=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND id_sucursal = '$sucursal' ORDER BY id_sucursal") or die(mysql_error());
    }


    if ($id_comision == "Todos" && $sucursal != "Todos" && $coin != "") {
    //echo "sin producto, con sucursal, con termino";
      $can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$sucursal' AND (nom LIKE '%$coin%' OR marca like '%$coin%' OR modelo like '%$coin%' OR compania like '%$coin%' OR color like '%coin%' OR categoria like '%$coin%') AND cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());
    }

   

	
  while($dato=mysql_fetch_array($can))
    {	
    $num ++;	
		$codigo=$dato['cod']; 
    $cprov=$dato['prov'];
    $nombreprod = $dato['nom'];
    $costo=number_format($dato['costo'],2,",",".");
    $mayoreo = number_format($dato['mayor'],2,",",".");
    $precioventa = number_format($dato['venta'],2,",",".");
    $cantidad = $dato['cantidad'];

	   
    
$codigoHTML.='
  <tr> 
  <td bgcolor="'.$color.'"><span class="text">'.$codigo.'</span></td>  
  <td bgcolor="'.$color.'"><span class="text">'.$nombreprod.'</span></td>  
  
 
  <td bgcolor="'.$color.'"><span class="text">'.$precioventa.'</span></td>
  
  </tr>';
  
  }
  $codigoHTML.='
  </table>
  <div align="right"><span class="text">Registros Encontrados '.$num.'</span></div>
  </div>
  </body>
  </html>';

   $html = mb_convert_encoding($codigoHTML, 'UTF-8', 'UTF-8');
    //$mpdf->WriteHTML($html);
    //$mpdf->Output('Listado_Productos_'.$fech.'.pdf','D');


    $mpdf->WriteHTML($html);
         
$mpdf->Output('Listado_Productos_'.$fech.'.pdf','D');

?>