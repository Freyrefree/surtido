<?php
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
    if ($_GET['factura']) {
      $factura = $_GET['factura'];
  		$can=mysql_query("SELECT * FROM factura where factura='$factura'"); 
        if($datos=mysql_fetch_array($can)){ 
        $cajera=$datos['cajera'];
      }
      $can=mysql_query("SELECT * FROM usuarios where usu='$cajera'"); 
        if($datos=mysql_fetch_array($can)){ 
        $cajero=$datos['nom'];
      }
      $dia=date("d");
      setlocale(LC_ALL,"es_ES");
      $mes=strtoupper(date("M"));
      $year=date("o");
      $tipo =$_GET['tipo'];
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
              font-size: 10px;
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
            <td colspan="4" ><h4>FERRETERIA</h4><h2>"EL JEFE"</h2></td>
          </tr>
          <tr>
            <td><img src="img/Logoa.png" alt="" height="10%" style="border: white 1px solid;"></td>
            <td colspan="2">
            <h4>JUAN CARLOS TORIBIO ROMERO</h4>
            <p>R.F.C. TORJ860317NF5</p>
            <p>GUSTAVO VICENCIO 27-A COLONIA CENTRO XONACATLAN MÈX.</p>
            <strong>TEL (722) 2477820</strong>
            </td>
            <td colspan="1">NOTA <p style="color:red">N° '.$factura.'</p></td>
          </tr>
          <tr>
            <td colspan="4" align="right">XONACATLAN, MÈX. A. '.$dia.' DE '.$mes.' DEL '.$year.'</td>
          </tr>';
          if ($tipo == "CREDITO"){
            $rfc = $_GET['rfc'];
            $query=mysql_query("SELECT * FROM cliente where rfc='$rfc'");
            while($dato=mysql_fetch_array($query)){
              $nomclient=$dato['nom'];
              $dirclient=$dato['calle'].', N.ext.'.$dato['next'].', N.int.'.$dato['nint'].', Col. '.$dato['colonia'].', '.$dato['municipio'].', '.$dato['estado'];
            }
          $codigoHTML.='
              <tr>
                <td colspan="4" align="left">
                  <p>NOMBRE: '.$nomclient.'</p>
                  <p>DIRECCION: '.$dirclient.'</p>
                </td>
              </tr>';
          }
          $codigoHTML.='
            <tr>
              <td class="product">CANT.</td>
              <td class="product">ARTICULO</td>
              <td class="product">PRECIO<br>UNITARIO</td>
              <td class="product"> IMPORTE </td>
            </tr>';
            $numero=0;$valor=0;$importe=0;
            $can=mysql_query("SELECT * FROM detalle where factura='$factura'"); 
            while($dato=mysql_fetch_array($can)){
            $numero=$numero+1;
            $importe=$dato['cantidad']*$dato['valor'];
            $valor=$valor+$importe;
            $tipo=$dato['tipo'];

            $codigoHTML.='
            <tr>
              <td class="product">'.$dato['cantidad'].'</td>
              <td class="product">'.$dato['nombre'].'</td>
              <td class="product" align="left">$ '.number_format($dato['valor'],2,",",".").'</td>
              <td class="product" align="left">$ '.number_format($importe,2,",",".").'</td>
            </tr>
            ';
              $importe=0; 
            }
            $codigoHTML.='
              <tr>
                <td></td><td></td>
                <td class="product">TOTAL $</td>
                <td class="product">'.number_format($valor,2,",",".").'</td>
              </tr>
              <tr>
                <td colspan="4">
                <br>
                  <p>Atendido por: '.$cajero.'</p>
                </td>
              </tr>
            </table>
            </body>
            </html>
            ';
        $mpdf->WriteHTML($codigoHTML);
        $mpdf->Output('Ticket_'.$factura.'.pdf','D');

    }
  
?>