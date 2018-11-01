<?php
 		session_start();
		//require_once("dompdf/dompdf_config.inc.php");
		include('php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		$id_sucursal = $_SESSION['id_sucursal'];
		$can=mysql_query("SELECT * FROM empresa where id=$id_sucursal");
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
<table width="100%" border="0" class="tabla" cellpading="0" cellspacing="0">
<caption class="text"><strong>Listado de Usuarios/Empleados</strong></caption>
  <tr>
    <td colspan="2" align="right" bgcolor="#FFFFCC"><a role="menuitem" tabindex="-1" href="PDFusuarios.php" target="admin" ><img src="img/file_extension_pdf.png" width="32" height="32" boder ="0"  /></a></td>
  </tr>
  
</table><br />
<table width="100%" border="0" class="tabla" cellpading="0" cellspacing="0">
  <tr>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Documento</strong></td>
    <td width="19%" bgcolor="#A4DBFF"><strong class="text">Nombre y Apellido</strong></td>
    <td width="11%" bgcolor="#A4DBFF"><strong class="text">Telefono</strong></td>
    <td width="10%" bgcolor="#A4DBFF"><strong class="text">Celular</strong></td>
    <td width="9%" bgcolor="#A4DBFF"><strong class="text">Ciudad</strong></td>
    <td width="16%" bgcolor="#A4DBFF"><strong class="text">Direccion</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Usuario</strong></td>
    <td width="8%" bgcolor="#A4DBFF"><strong class="text">Estado</strong></td>
    <td width="9%" bgcolor="#A4DBFF"><strong class="text">Tipo</strong></td>
    </tr>';
 
  	$num=0;
	$can=mysql_query("SELECT * FROM usuarios WHERE id_sucursal = '$id_sucursal' order by nom");
	while($dato=mysql_fetch_array($can)){
		if($dato['tipo']=='a'){ 
			$clase='Administrador'; 
		}
	    if($dato['tipo']=='ca'){
				$clase='Cajero';
			}
	    if ($dato['tipo'] == 'te') {
				$clase='Tecnico';
			}
	    if ($dato['tipo'] == 'su') {
	      $clase='Supervisor';
	    }
		if($dato['estado']=="n"){
			$estado='Inactivo';
		}else{
			$estado='Activo';
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
    <td bgcolor="'.$color.'"><span class="text">'.$dato['ced'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['nom'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['tel'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['cel'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['ciudad'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['dir'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$dato['usu'].'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$estado.'</span></td>
    <td bgcolor="'.$color.'"><span class="text">'.$clase.'</span></td>
  </tr>';
  }
$codigoHTML.='
</table><br />
<div align="right"><span class="text">Registros Encontrados '.$num.'</span></div>
</div>
</body>
</html>
';
echo $codigoHTML;
//$codigoHTML=utf8_decode($codigoHTML);
//$dompdf=new DOMPDF();
//$dompdf->load_html($codigoHTML);
//ini_set("memory_limit","128M");
//$dompdf->render();
//$dompdf->stream("Listado_Clientes_".$fech.".pdf");

?>