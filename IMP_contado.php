<?php
function PDF($factura,$tipo,$ccpago,$rfc,$numerocel,$confirm,$iccid,$nombrecliente){/*$id_reparacion,*/


    setlocale(LC_ALL,"es_ES");
     session_start();
     		
    include("MPDF/mpdf.php");   
    $mpdf = new mPDF('utf-8' , 'A8','', 0, 0, 5,0, 0, 0);
		include('php_conexion.php');
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
    $Sucursal  =  $_SESSION['sucursal'];
    $id_sucursal = $_SESSION['id_sucursal'];
    
    //if ($_GET['factura']) {
    
    if ($factura) {
      
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


          $codigoHTML='
          <html lang="es">
          <head>
            <meta charset="UTF-8">
            <title>nota</title>
            <style>

              table{
                border-collapse: collapse;
                border: 0px solid #000000;
                font-family: Arial Black Header;
                text-align: justify;
                color:#000000;
                
                
              }
              .product{
                border: 1px solid #000000;
              }

              .nota1{

                font-size:9px;
                width: 100%;
              }

              .nota2{

                font-size:9px;
                width: 100%;
              }

              .nota3{

                font-size:8px;
                width: 100%;
              }

              
            
            </style>
          </head>
          <body>
         
          <table class="nota1">
            
              <tr>
                <td colspan="2"> <img src="img/1.jpg" alt=""  ></td>
              </tr>

              <tr>
                <td align="left">
                <p>R.F.C. AADL821219KJ9</p>
                <p>'.$direccion.'</p>
                </td>
                <td align="right">NOTA <p><strong>N° '.$factura.'</strong></p></td>
              </tr>

              <tr>
                <td colspan="2" align="center"><span>SUCURSAL: '.$Sucursal.'</span></td>
              </tr>
              <tr>
                <td colspan="2" align="right">A. '.$hoy.'</td>
              </tr>
            
          </table>';

          if ($tipo == "CREDITO"){            
            $query=mysql_query("SELECT * FROM cliente where rfc='$rfc'");
            while($dato=mysql_fetch_array($query)){
              $nomclient=$dato['empresa'];
              $dirclient=$dato['calle'].', N.ext.'.$dato['next'].', N.int.'.$dato['nint'].', Col. '.$dato['colonia'];
            }
          $codigoHTML.='
          <table class = "nota">
              <tr>
                <td colspan="4" align="left">
                  <p >NOMBRE: '.$nomclient.'</p>
                  <p >DIRECCION: '.$dirclient.'</p>
                </td>
              </tr>
          </table>';
          }


          $codigoHTML.='
          <table>
            <tr>
              <td class="product">CA</td>
              <td class="product">ARTICULO</td>
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

              ## Poner ICCID e IMMEI según el caso ##

              $iccid = $dato['ICCID'];
              $imei  = $dato['IMEI'];

              if($iccid != ""){
                $addICCID = " <br> ICCID: ".saltoCadena($iccid);
              }else{
                $addICCID = "";
              }

              if($imei != ""){
                $addIMEI = " <br> IMEI: ".saltoCadena($imei);
              }else{                
                $addIMEI = "";
              }


              ########################################

              $codigoHTML.='
              <tr>
                <td class="product" >'.$dato['cantidad'].'</td>
                <td class="product" align="left">'.saltoCadena($dato['nombre']).$addICCID.$addIMEI.'</td>
                <td class="product" align="right">$ '.number_format($dato['valor'],2).'</td>
                <td class="product" align="right">$ '.number_format($importe,2).'</td>
              </tr>
              ';
                $importe=0; 
            }

            $codigoHTML.='</table>';
            
            $codigoHTML.='
            <br>
            <table class="nota2">

              <tr>
                <td align="right" ><b>TOTAL $</b></td>
                <td align="right" ><b>'.number_format($valor,2).'</b></td>
              </tr>

               <tr>
                <td align="right" >EFECTIVO $</td>
                <td align="right" >'.number_format($ccpago,2).'</td>
              </tr>
              <tr>';

                if ($tipo == "CREDITO") {
                  $codigoHTML.='
                  <td align="right" >RESTO $</td>
                  <td align="right" >'.number_format(($valor-$ccpago),2).'</td>';
                }else {
                  $codigoHTML.='
                  <td align="right" >CAMBIO $</td>
                  <td align="right" >'.number_format(($ccpago-$valor),2).'</td>';
                }

                $codigoHTML.='</tr></table>';

              $codigoHTML.='
              <br>
              <table class="nota3">
              <br>
              <tr>
                <td>
                  <p>Le Atendio: '.$cajero.'</p>
                </td>
              </tr>
              <tr>
                <td>';
                
                if ($tipo == "CREDITO"){
                  $codigoHTML.='
                  
                    <p>NOTA:</p>
                    <p>El sistema de apartado es a 30 días.</p>
                    <p >En caso de cancelación, reembolso, cambio de equipo o de no <br>
                        liquidar en la fecha pactada el ultimo pago. <br>
                        Se cobrara el 10 % adicional del valor total del costo el equipo.
                    </p>
                    <p><center>FIRMA DE CONFORMIDAD DEL CLIENTE</center></p><br>
                    <p><center>__________________________________________</center></p>
                    <p><center>HE LEIDO Y ACEPTO CADA UNA DE ESTAS CLAUSULAS</center></p>
                    <p style="font-size:6px;"><center>ACLARACIONES: 712 140 59 07 DE LUNES A DOMINGO</center></p>
                    <p style="font-size:6px;"><center>QUEJAS: 712 140 59 07 DE LUNES A VIERNES DE 9:00 AM A 6:00 PM</center></p>
                  </td>';

                }else {
                  if (!empty($numerocel)) {
                    $codigoHTML.='
                  
                    <p>NOTA:</p>
                    <p>Para cualquier aclaracion, favor de esperar de 1 a 24 horas,
                    ya que es el tiempo que la compañía telefónica nos pide para revisar un folio para aclaración.
                    Conserve este ticket para cualquier aclaración.</p>
                    <p><center>Gracias por su compra</center></p>
                    <p><center>Quejas: 712 140 59 07</center></p>
                  </td>';
                  }else {
                    $codigoHTML.='
                    <hr>
                      <p>NOTA:</p>
                      <p>Conserve este ticket para cualquier aclaración.</p>
                      <p><center>Gracias por su compra</center></p>
                      <p><center>Quejas: 712 140 59 07</center></p>
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
        $mpdf->Output('Facturas/'.$factura."_".$id_sucursal.'.pdf');

    }
}


function saltoCadena($stirng){

  $nuevo_texto = wordwrap($stirng, 10,'@@', 1);
  $array = explode('@@',$nuevo_texto);
  $cadenaConfig = "";

  foreach($array as &$valor){

      $cadenaConfig.= $valor." <br>";

  }

  return $cadenaConfig;

}
?>