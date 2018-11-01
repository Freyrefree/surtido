<?php
function PDF($factura,$tipo,$ccpago,$rfc,$numerocel,$confirm){/*$id_reparacion,*/



    setlocale(LC_ALL,"es_ES");
 		session_start();
		/*require_once("dompdf/dompdf_config.inc.php");
    include('html2pdf/html2pdf.class.php');*/
    include("MPDF/mpdf.php");
    /*$mpdf = new mPDF('utf-8' , 'A4','', 15, 40, 15, 10, 15, 10);*/
    $mpdf = new mPDF('utf-8' , 'A4','', 1, 3, 136, 0, 1, 1);
		include('php_conexion.php');
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
    $Sucursal  =  $_SESSION['sucursal'];
    $id_sucursal = $_SESSION['id_sucursal'];
    
    //if ($_GET['factura']) {
    
    if ($factura) {
      //$factura = $_GET['factura'];
  		$can=mysql_query("SELECT * FROM factura where factura='$factura' AND id_sucursal = '$id_sucursal'");
        if($datos=mysql_fetch_array($can)){
        $cajera=$datos['cajera'];
      }
      $can=mysql_query("SELECT * FROM usuarios where usu='$cajera'"); 
        if($datos=mysql_fetch_array($can)){ 
        $cajero=$datos['nom'];
      }
      $can=mysql_query("SELECT * FROM empresa where id=1"); 
      if($dato=mysql_fetch_array($can)){
      $empresa=$dato['empresa'];    $direccion=$dato['direccion'];
      $telefono=$dato['tel1'];      $nit=$dato['nit'];
      $fecha=date("d-m-y H:i:s");   $pagina=$dato['web'];
      $tama=$dato['tamano'];
      }
      $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
      $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
      $hoy=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y');

      $dia=date("d");
      setlocale(LC_ALL,"es_ES");
      $mes=strtoupper(date("M"));
      $year=date("o");
      //$tipo =$_GET['tipo'];
      //$ccpago =$_GET['pago'];
      /*style="color:#00A4DF"*/
  		/*echo "<script>alert('$tipo')</script>";*/
          $codigoHTML='
          <html lang="en">
          <head>
            <meta charset="UTF-8">
            <title>nota</title>
            <style>
            table{
              border-collapse: collapse;
              border: 0px solid #0B2161;
              font-size: 9px;
              color:#0B2161;
            }
            .product{
              border: 1px solid #0B2161;
            }
            
            </style>
          </head>
          <body>
            <table class="nota" style="text-align: center; ">
          <tr>
            <td colspan="4" > <img src="img/1.jpg" alt="" height="17%" ></td>
          </tr>
          <tr>
            <td></td>
            <td colspan="2">
            <h5>Marco Antonio Treviño</h5>
            <p>R.F.C. AADL821219HJ9</p>
            <p>'.$direccion.'</p>
            <strong>TEL: '.$telefono.'</strong>
            </td>
            <td colspan="1">NOTA <p style="color:red">N° '.$factura.'</p></td>
          </tr>
          <tr>
            <td colspan="4" align="center"><span>SUCURSAL: '.$Sucursal.'</span></td>
          </tr>
          <tr>
            <td colspan="4" align="right">A. '.$hoy.'</td>
          </tr>';//style="border: white 1px solid;"estilo de la imgen del ticket
          //Av. Gustavo Baz Prada Sur No. 304 Col. Centro, Ixtlahuaca, Edo. Méx. C.P.: 50740
          //<h2>"SURTIDITOCELL"</h2><h5>TU DISTRIBUIDOR MAYORISTA</h5>
          if ($tipo == "CREDITO"){
            //$rfc = $_GET['rfc'];
            $query=mysql_query("SELECT * FROM cliente where rfc='$rfc'");
            while($dato=mysql_fetch_array($query)){
              $nomclient=$dato['empresa'];
              $dirclient=$dato['calle'].', N.ext.'.$dato['next'].', N.int.'.$dato['nint'].', Col. '.$dato['colonia'];
            }
          $codigoHTML.='
              <tr>
                <td colspan="4" align="left">
                  <p style="font-size:8px;">NOMBRE: '.$nomclient.'</p>
                  <p style="font-size:8px;">DIRECCION: '.$dirclient.'</p>
                </td>
              </tr>';
          }
          $codigoHTML.='
            <tr>
              <td class="product">CANT.</td>
              <td class="product">CONCEPTO</td>
              <td class="product">PRECIO<br>UNITARIO</td>
              <td class="product"> IMPORTE </td>
            </tr>';
            $numero=0;$valor=0;$importe=0;
            $can=mysql_query("SELECT * FROM detalle where factura='$factura' AND id_sucursal = '$id_sucursal'");
            while($dato=mysql_fetch_array($can)){
            $numero=$numero+1;
            $importe=$dato['cantidad']*$dato['valor'];
            $valor=$valor+$importe;
            $tipo=$dato['tipo'];

            $resto=$valor-$ccpago;
            if($resto<=0){
               $resto=0;
            }

            $cambio=$ccpago-$valor;
            if($cambio<=0){
               $cambio=0;
            }

            $valor=$valor+12;

            $codigoHTML.='
            <tr>
              <td class="product">'.$dato['cantidad'].'</td>
              <td class="product" align="left">'.$dato['nombre'].'</td>
              <td class="product" align="right">$ '.number_format($dato['valor'],2).'</td>
              <td class="product" align="right">$ '.number_format($importe,2).'</td>
            </tr>
            ';
              $importe=0; 
            }
            $codigoHTML.='
            <tr>
              <td class="product">1</td>
              <td class="product" align="left">Comisión</td>
              <td class="product" align="right">$ 12.00</td>
              <td class="product" align="right">$ 12.00</td>
            </tr>
              <tr>';
              if (!empty($numerocel)) {
                $codigoHTML.='
                  <td>Número</td><td>'.$numerocel.'</td>';
                $codigoHTML.='
                  <td>Código de Confirmación</td><td>'.$confirm.'</td></tr>';
              }else {
                $codigoHTML.='
                  <td></td><td></td>';
              }
            $codigoHTML.='
              <tr>
                <td></td><td></td>
                <td align="right"><b>TOTAL $</b></td>
                <td align="right"><b>'.number_format($valor,2).'</b></td>
              </tr>
               <tr>
                <td></td><td></td>
                <td align="right">EFECTIVO $</td>
                <td align="right">'.number_format($ccpago,2).'</td>
              </tr>';
                $codigoHTML.='
              <tr>
                <td colspan="4">
                <br>
                  <p>Le Atendio: '.$cajero.'</p>
                </td>
              </tr>
              <tr>
                <td colspan="4" align="justify">';
                
                if ($tipo == "CREDITO"){
                  $codigoHTML.='
                  <hr>
                    <p>NOTA:</p>
                    <p>El sistema de apartado es a 30 días.</p>
                    <p style="font-size:8px;">En caso de cancelación, reembolso, cambio de equipo o de no <br>
                        liquidar en la fecha pactada el ultimo pago. <br>
                        Se cobrara el 10 % adicional del valor total del costo el equipo.
                    </p>
                    <p><center>FIRMA DE CONFORMIDAD DEL CLIENTE</center></p><br>
                    <p><center>__________________________________________</center></p>
                    <p><center>HE LEIDO Y ACEPTO CADA UNA DE ESTAS CLAUSULAS</center></p>
                    <p style="font-size:6px;"><center>ACLARACIONES: 712 283 04 43 DE LUNES A DOMINGO</center></p>
                    <p style="font-size:6px;"><center>QUEJAS: 712 283 04 43 DE LUNES A VIERNES DE 9:00 AM A 6:00 PM</center></p>
                  </td>';
                }else {
                  if (!empty($numerocel)) {
                    $codigoHTML.='
                  <hr>
                    <p>NOTA:</p>
                    <p>Para cualquier aclaracion, favor de esperar de 1 a 24 horas. <br>
                    ya que es el tiempo que la compañía telefónica nos pide para revisar un folio para aclaración.</p>
                    <p>Conserve este ticket para cualquier aclaración.</p>
                    <p><center>Gracias por su compra</center></p>
                  </td>';
                  }else {
                    $codigoHTML.='
                    <hr>
                      <p>NOTA:</p>
                      <p>Una vez salida la mercancía no hay devoluciones.</p>
                      <p>Conserve este ticket para cualquier aclaración.</p>
                      <p><center>Gracias por su compra</center></p>
                    </td>';
                  }
                }
              $codigoHTML.='
              </tr>
            </table>
            </body>
            </html>
            ';
        $mpdf->WriteHTML($codigoHTML);
        //$mpdf->Output('Ticket_'.$factura.'.pdf','D');
        $mpdf->Output('Facturas/'.$factura."_".$id_sucursal.'.pdf');

    }
} 
?>