<?php
 		session_start();
	//	require_once("dompdf/dompdf_config.inc.php");
		include('php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		$id_sucursal = $_SESSION['id_sucursal'];
		$id_comision = $_POST['producto'];
    $sucursal = $_POST['sucursal'];
    $coin = $_POST['coin'];

    /*$id_comision = "Todos";
    $sucursal = "Todos";*/

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
/*<tr>
    <td colspan="2" align="right" bgcolor="#FFFFCC"><a role="menuitem" tabindex="-1" href="PDFproducto.php" target="admin" ><img src="img/file_extension_pdf.png" width="32" height="32" boder ="0"  /></a></td>
  </tr>*/
$codigoHTML='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reporte</title>
<style type="text/css">
.text {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
body {
	background-color: #D7EBFF;
}

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
<table width="100%" border="0"  class="tabla" cellpading="0" cellspacing="0">
<caption class="text">
<strong>Listado de Productos</strong>
</caption>
  

</table><br />
<table width="100%" border="1"  class="tabla" cellpading="0" cellspacing="0">
  <tr>
    <td width="4%" bgcolor="#A4DBFF">&nbsp;</td>
    <td width="3%" bgcolor="#A4DBFF"><strong class="text">Codigo</strong></td>
    <td width="18%" bgcolor="#A4DBFF"><strong class="text">Nombre del Producto</strong></td>
    <td width="11%" bgcolor="#A4DBFF"><strong class="text">Proveedor</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Precio Costo</strong></td>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Precio Mayoreo</strong></td>
    <td width="9%" bgcolor="#A4DBFF"><strong class="text">Precio Venta</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Cant. Actual</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Cant. Minima</strong></td>
    <td width="9%" bgcolor="#A4DBFF"><strong class="text">Sucursal</strong></td>
    <td width="5%" bgcolor="#A4DBFF"><strong class="text">Faltantes</strong></td>
    <td width="5%" bgcolor="#A4DBFF"><strong class="text">Sobrantes</strong></td>
    </tr>';
    /*<td width="12%" bgcolor="#A4DBFF"><strong class="text">Cod. del Proveedor</strong></td>*/
  	$num=0;

    if ($id_comision == "Todos" && $sucursal == "Todos" && $coin == "") {
    //echo "sin producto, sin sucursal, sin termino";
      //$can=mysql_query("SELECT * FROM producto WHERE cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());
      $can=mysql_query("SELECT * FROM producto ORDER BY id_sucursal") or die(mysql_error());//todos los productos
    }

    if ($id_comision == "Todos" && $sucursal == "Todos" && $coin != "") {
      //echo "sin producto, sin sucursal, con termino";
      $can=mysql_query("SELECT * FROM producto WHERE (nom LIKE '%$coin%' OR marca like '%$coin%' OR modelo like '%$coin%' OR compania like '%$coin%' OR color like '%coin%' OR categoria like '%$coin%') AND cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());
    }

    if ($id_comision == "Todos" && $sucursal != "Todos" && $coin == "") {
    //echo "sin producto, con sucursal, sin termino";
      $can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$sucursal' ORDER BY id_sucursal") or die(mysql_error());
    }

    if ($id_comision == "Todos" && $sucursal != "Todos" && $coin != "") {
    //echo "sin producto, con sucursal, con termino";
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
      $can=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND id_sucursal = '$sucursal' AND (nom LIKE '%$coin%' OR marca like '%$coin%' OR modelo like '%$coin%' OR compania like '%$coin%' OR color like '%coin%' OR categoria like '%$coin%') AND cantidad > 0 ORDER BY id_sucursal") or die(mysql_error());
    }

    if ($id_comision != "Todos" && $sucursal != "Todos" && $coin == "") {
    //echo "con producto, sucursal y sin termino";
      $can=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND id_sucursal = '$sucursal' ORDER BY id_sucursal") or die(mysql_error());
    }

    /*if ($id_comision != "Todos" && $sucursal == "Todos") {
      $can=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND cantidad > 0 ORDER BY id_sucursal");
    }
    if ($id_comision != "Todos" && $sucursal != "Todos") {
      $can=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND id_sucursal = '$sucursal' AND cantidad > 0 ORDER BY id_sucursal");
    }*/

  	/*if ($id_comision == "Todos") {
  		$can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$id_sucursal'");
  	}else {
		$can=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_comision' AND id_sucursal = '$id_sucursal'");
  	}*/

	  while($dato=mysql_fetch_array($can)){
		$num=$num+1;
		$resto = $num%2; 
  		if ((!$resto==0)) { 
        	$color="#CCCCCC";
   		}else{ 
        	$color="#FFFFFF";
   		}
		$codigo=$dato['cod']; 

		$seccion=$dato['seccion']; 
		$cann=mysql_query("SELECT * FROM seccion where id=$seccion");	
		if($datos=mysql_fetch_array($cann)){	$n_seccion=$datos['nombre'];	}

    $id_suc=$dato['id_sucursal'];
    $cann=mysql_query("SELECT * FROM empresa where id=$id_suc");
    if($datos=mysql_fetch_array($cann)){  $suc=$datos['empresa'];  }

		if (file_exists("articulo/".$codigo.".jpg")){
			$img='articulo/'.$codigo.'.jpg';
		}else{ 
			$img='articulo/producto.png';
		}
$codigoHTML.='
  <tr>
    <td bgcolor="'.$color.'"><img src="'.$img.'" width="50" height="50"></td>
    <td bgcolor="'.$color.'"><center><span class="text">'.$dato['cod'].'</span></center></td>
    <td bgcolor="'.$color.'"><span class="text">'.utf8_encode($dato['nom']).'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['prov'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">$ '.number_format($dato['costo'],2,",",".").'</span></td>
    <td bgcolor="'.$color.'"><span class="text">$ '.number_format($dato['mayor'],2,",",".").'</span></td>
    <td bgcolor="'.$color.'"><span class="text">$ '.number_format($dato['venta'],2,",",".").'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['cantidad'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['minimo'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$suc.'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['faltantes'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['sobrantes'].'</span></td>
  </tr>';/*$n_seccion*/
  /*<td bgcolor="'.$color.'"><span class="text">'.$dato['cprov'].'</span></td>*/
  }
$codigoHTML.='
</table><br/>
<div align="right"><span class="text">Registros Encontrados '.$num.'</span></div>
</div>
</body>
</html>';
echo $codigoHTML;
//$codigoHTML=utf8_decode($codigoHTML);
//$dompdf=new DOMPDF();
//$dompdf->load_html($codigoHTML);
//ini_set("memory_limit","128M");
//$dompdf->render();
//$dompdf->stream("Listado_Productos_".$fech.".pdf");
?>