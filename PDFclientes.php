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
		/*$fecha=date('Ymd');*/
		$fech=date('d')."".$meses[date('n')-1]."".date('y');
		
		//Salida: Viernes 24 de Febrero del 2012
$codigoHTML='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Proveedores</title>
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
<div align="center" class="text">
    <table width="100%" border="0">
		  <tr>
			<strong>Listado de Clientes</strong>
			<td colspan="2">&nbsp;</td>
		  </tr>
		  <tr>
      		<td colspan="10" style="text-align:center;"><strong>Listado de Clientes</strong></td>
	  	  </tr>
		  <tr>
			<td width="10"><img src="img/Logoa.jpg" width="114" height="90" alt="" /></td>
			<td width="83%" colspan="2">
			  <div align="center">
				<span class="text">'.$empresa.' Nit. '.$nit.'</span><br />
				<span class="text">Ciudad: '.$ciudad.' Direccion: '.$direccion.' </span><br />
				<span class="text">TEL: '.$tel1.' TEL2: '.$tel2.'</span><br />
				<span class="text">Reporte Impreso el '.$hoy.' por '.$_SESSION['username'].'</span>
			  </div>
			</td>
		  </tr>
		</table><br />
    <table width="100%" border="0" class="tabla" cellpading="0" cellspacing="0">

      <tr>
        <td width="10%" bgcolor="#A4DBFF"><strong>RFC</strong></td>
        <td width="19%" bgcolor="#A4DBFF"><strong>Nombre Empresa</strong></td>
        <td width="20%" bgcolor="#A4DBFF"><strong>Contacto</strong></td>
        <td width="7%" bgcolor="#A4DBFF"><strong>Estado</strong></td>
        <td width="13%" bgcolor="#A4DBFF"><strong>Telefono</strong></td>
        <td width="14%" bgcolor="#A4DBFF"><strong>Celular</strong></td>
        <td width="20%" bgcolor="#A4DBFF"><strong>Correo</strong></td>
      </tr>';

		$num=0;
        $can=mysql_query("SELECT * FROM cliente ORDER BY nom");
        while($dato=mysql_fetch_array($can)){
            if($dato['estado']=="n"){
                $estado='Inactivo';
            }else{
                $estado='Activo';
            }
			
			$num=$num+1;
			$resto = $num%2; 
			if (($resto==0)) { 
				$color="#CCCCCC"; 
			}else{ 
				$color="#FFFFFF";
			} 				
  	  $codigoHTML.='
      <tr>
        <td bgcolor="'.$color.'">'.$dato['rfc'].'</td>
        <td bgcolor="'.$color.'">'.$dato['empresa'].'</td>
        <td bgcolor="'.$color.'">'.$dato['nom'].'</td>
        <td bgcolor="'.$color.'">'.$estado.'</td>
        <td bgcolor="'.$color.'">'.$dato['tel'].'</td>
        <td bgcolor="'.$color.'">'.$dato['cel'].'</td>
        <td bgcolor="'.$color.'">'.$dato['correo'].'</td>
      </tr>';
         }
	$codigoHTML.='
	</table><br />
<div align="right"><span class="text">Registros Encontrados '.$num.'</span></div>
</div>
</body>
</html>';
	
		$mpdf->WriteHTML($codigoHTML);  
    	$mpdf->Output('Listado_Clientes_'.$fech.'.pdf','D');
		/*try {
		    $pdf = new HTML2PDF('P', 'A4', 'es');
		    $pdf -> WriteHTML($codigoHTML);
		    $pdf -> output('Listado_Proveedores_'.$fecha.'.pdf','D');
		  } catch (Exception $e) {
		    echo $e;
		  }*/

	    /*$codigoHTML=utf8_decode($codigoHTML);
	    $dompdf=new DOMPDF();
	    $dompdf->load_html($codigoHTML);
	    ini_set("memory_limit","128M");
	    $dompdf->render();
	    $dompdf->stream("Listado_Proveedores_".$fecha.".pdf");*/

?>