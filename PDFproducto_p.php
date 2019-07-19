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
$codigoHTML='<table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
<thead>
  <tr>
    <th>&nbsp;</th>
    <th>Codigo</th>
    <th>Nombre del Producto</th>
    <th>Proveedor</th>
    <th>Precio Costo</th>
    <th>Precio Mayoreo</th>
    <th>Precio Venta</th>
    <th>Cant. Actual</th>
    <th>Cant. Minima</th>
    <th>Sucursal</th>
    <th>Faltantes</th>
    <th>Sobrantes</th>
    </tr>
</thead><tbody>';
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
    <td><img src="'.$img.'" width="50" height="50"></td>
    <td>'.$dato['cod'].'</td>
    <td>'.utf8_encode($dato['nom']).'</td>
    <td>'.$dato['prov'].'</td>
    <td>$ '.number_format($dato['costo'],2,",",".").'</td>
    <td>$ '.number_format($dato['mayor'],2,",",".").'</td>
    <td>$ '.number_format($dato['venta'],2,",",".").'</td>
    <td>'.$dato['cantidad'].'</td>
    <td>'.$dato['minimo'].'</td>
    <td>'.$suc.'</td>
    <td>'.$dato['faltantes'].'</td>
    <td>'.$dato['sobrantes'].'</td>
  </tr>';
  }
$codigoHTML.='</tbody>
</table>';
echo $codigoHTML;

?>