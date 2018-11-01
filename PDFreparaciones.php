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
    $datestart = $_POST['fi'];
    $datefinish = $_POST['ff'];
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
<title>Reaparaciones</title>
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
    <strong>Listado de Reparaciones</strong>
      <tr>
      <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
          <td colspan="10" style="text-align:center;"><strong>Listado de Reparaciones</strong></td>
        </tr>
      <tr>
      <td width="10"><img src="img/logoa.jpg" width="114" height=90 alt="" /></td>
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
        <td width="5%" bgcolor="#A4DBFF"><strong>ID</strong></td>
        <td width="7%" bgcolor="#A4DBFF"><strong>Garantia</strong></td>
        <td width="7%" bgcolor="#A4DBFF"><strong>Estado</strong></td>
        <td width="10%" bgcolor="#A4DBFF"><strong>Sucursal</strong></td>
        <td width="7%" bgcolor="#A4DBFF"><strong>Marca</strong></td>
        <td width="7%"  bgcolor="#A4DBFF"><strong>Modelo</strong></td>
        <td width="7%" bgcolor="#A4DBFF"><strong>Color</strong></td>
        <td width="7%" bgcolor="#A4DBFF"><strong>Nota</strong></td>
        <td width="6%" bgcolor="#A4DBFF"><strong>Precio</strong></td>
        <td width="6%" bgcolor="#A4DBFF"><strong>Inversion</strong></td>
        <td width="6%" bgcolor="#A4DBFF"><strong>Comision</strong></td>
        <td width="6%" bgcolor="#A4DBFF"><strong>Refaccion</strong></td>
        <td width="7%" bgcolor="#A4DBFF"><strong>Cajero</strong></td>
        <td width="7%" bgcolor="#A4DBFF"><strong>Tecnico</strong></td>
        <td width="7%" bgcolor="#A4DBFF"><strong>Mano obra</strong></td>
        <td width="7%" bgcolor="#A4DBFF"><strong>Comision</strong></td>
      </tr>';

        $num=0;
        $can=mysql_query("SELECT * FROM reparacion WHERE fecha_ingreso BETWEEN '$datestart' AND '$datefinish' ORDER BY id_reparacion ASC");
        while($dato=mysql_fetch_array($can)){
            $bandera = 0;
            $comisionmo = 0;
            $comisionmo = $dato['mano_obra'] * (10/100);
            $id_reparacion = $dato['id_reparacion'];
            $que=mysql_query("SELECT * FROM reparacion_refaccion WHERE id_reparacion = '$id_reparacion'");
            while($dat=mysql_fetch_array($que)){
              $bandera = 1;
              if($dato['estado']=='1'){
                $estado='Pendiente';
              }
              if ($dato['estado'] == '2') {
                $estado='Terminado';
              }
              if ($dato['estado'] == '3'){
                  $estado='Entregado';
              }
              if ($dato['estado'] == '4'){
                  $estado='Cancelado';
              }
              if ($dato['estado'] == '0'){
                  $estado='Espera';
              }
              if ($dato['garantia'] == 's') {
                $garantia = 'Garantia';
              }else{
                $garantia = '';
              }
              $id_suc = $dato['id_sucursal'];
              $con=mysql_query("SELECT * FROM empresa WHERE id = '$id_suc'");
              //echo "SELECT * FROM empresa WHERE id_sucursal = '$id_suc'";
              if($data=mysql_fetch_array($con)){
                  $sucursal=$data['empresa'];
              }
              $cod = $dat['id_producto'];
              $con2=mysql_query("SELECT * FROM producto WHERE cod = '$cod'");
              if($data2=mysql_fetch_array($con2)){
                  $refaccion=$data2['nom'];
              #obtener la comision de la refaccion
                  if ($dato['tipo_precio'] == "1") {
                    $precio = $data2['especial'];
                    $costo = $data2['costo'];
                    $utilidad = $precio-$data2['costo'];
                  }
                  if ($dato['tipo_precio'] == "2") {
                    $precio = $data2['mayor'];
                    $costo = $data2['costo'];
                    $utilidad = $precio-$data2['costo'];
                  }
                  if ($dato['tipo_precio'] == "3") {
                    $precio = $data2['venta'];
                    $costo = $data2['costo'];
                    $utilidad = $precio-$data2['costo'];
                  } 
                  $id_comision = $data2['id_comision'];
                  $cons=mysql_query("SELECT * FROM comision WHERE id_comision = '$id_comision'");
                  if($row=mysql_fetch_array($cons)){
                    $porcentaje = $row['porcentaje'];
                  }
                  $comision = $comision + ($utilidad*($porcentaje/100));
              #fin obtener la comision de la refaccion
              }
              //$comision = $dato['precio']-$dato['costo'];

              

              $num=$num+1;
              $resto = $num%2; 
              if (($resto==0)) { 
                $color="#CCCCCC"; 
              }else{ 
                $color="#FFFFFF";
              }         
              $codigoHTML.='
              <tr>
                <td bgcolor="'.$color.'">'.$dato['id_reparacion'].'</td>
                <td bgcolor="'.$color.'">'.$garantia.'</td>
                <td bgcolor="'.$color.'">'.$estado.'</td>
                <td bgcolor="'.$color.'">'.$sucursal.'</td>
                <td bgcolor="'.$color.'">'.$dato['marca'].'</td>
                <td bgcolor="'.$color.'">'.$dato['modelo'].'</td>
                <td bgcolor="'.$color.'">'.$dato['color'].'</td>
                <td bgcolor="'.$color.'">'.$dato['id_reparacion'].'</td>
                <td bgcolor="'.$color.'">'.$precio.'</td>
                <td bgcolor="'.$color.'">'.$dato['costo'].'</td>
                <td bgcolor="'.$color.'">'.$comision.'</td>
                <td bgcolor="'.$color.'">'.$refaccion.'</td>
                <td bgcolor="'.$color.'">'.$dato['usuario'].'</td>
                <td bgcolor="'.$color.'">'.$dato['tecnico'].'</td>

                <td bgcolor="'.$color.'">'.$dato['mano_obra'].'</td>
                <td bgcolor="'.$color.'">'.$comisionmo.'</td>

              </tr>';/*$dato['precio']*/
            }
                 if ($bandera == 0) {
                  if($dato['estado']=='1'){
                    $estado='Pendiente';
                  }
                  if ($dato['estado'] == '2') {
                    $estado='Terminado';
                  }
                  if ($dato['estado'] == '3'){
                      $estado='Entregado';
                  }
                  if ($dato['estado'] == '4'){
                      $estado='Cancelado';
                  }
                  if ($dato['estado'] == '0'){
                      $estado='Espera';
                  }
                  if ($dato['garantia'] == 's') {
                    $garantia = 'Garantia';
                  }else{
                    $garantia = '';
                  }
                  $id_suc = $dato['id_sucursal'];
                  $con=mysql_query("SELECT * FROM empresa WHERE id_sucursal = '$id_suc'");
                  if($data=mysql_fetch_array($con)){
                      $sucursal=$data['empresa'];
                  }
                  $cod = $dat['id_producto'];
                  $con2=mysql_query("SELECT * FROM producto WHERE cod = '$cod'");
                  if($data2=mysql_fetch_array($con2)){
                      $refaccion=$data2['nom'];
                  }
                  $id_comision = $dato['id_comision'];
                  $cons=mysql_query("SELECT * FROM comision WHERE id_comision = '$id_comision'");
                  if($row=mysql_fetch_array($cons)){
                    $porcentaje = $row['porcentaje'];
                  }
                  $comision = $dato['costo']*($porcentaje/100);
                  $num=$num+1;
                  $resto = $num%2; 
                  if (($resto==0)) { 
                    $color="#CCCCCC"; 
                  }else{ 
                    $color="#FFFFFF";
                  }         
                  $codigoHTML.='
                  <tr>
                    <td bgcolor="'.$color.'">'.$dato['id_reparacion'].'</td>
                    <td bgcolor="'.$color.'">'.$garantia.'</td>
                    <td bgcolor="'.$color.'">'.$estado.'</td>
                    <td bgcolor="'.$color.'">'.$sucursal.'</td>
                    <td bgcolor="'.$color.'">'.$dato['marca'].'</td>
                    <td bgcolor="'.$color.'">'.$dato['modelo'].'</td>
                    <td bgcolor="'.$color.'">'.$dato['color'].'</td>
                    <td bgcolor="'.$color.'">'.$dato['id_reparacion'].'</td>
                    <td bgcolor="'.$color.'">'.$dato['precio'].'</td>
                    <td bgcolor="'.$color.'">'.$dato['costo'].'</td>
                    <td bgcolor="'.$color.'">'.$comision.'</td>
                    <td bgcolor="'.$color.'">'.$refacc.'</td>
                    <td bgcolor="'.$color.'">'.$dato['usuario'].'</td>
                    <td bgcolor="'.$color.'">'.$dato['tecnico'].'</td>

                    <td bgcolor="'.$color.'">'.$dato['mano_obra'].'</td>
                    <td bgcolor="'.$color.'">'.$comisionmo.'</td>
                  </tr>';
                 }
              }
            
         /*.$dato['precio']-$dato['costo'].*/
  $codigoHTML.='
  </table><br />
<div align="right"><span class="text">Registros Encontrados '.$num.'</span></div>
</div>
</body>
</html>';
  
    $mpdf->WriteHTML($codigoHTML);  
      $mpdf->Output('Listado_Reparaciones_'.$fech.'.pdf','D');
?>