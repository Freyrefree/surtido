<?php
function PDFCreditoApartado($idCredito,$abono,$totalApartado,$resto,$cambio,$denominacion)
{

    //session_start();
    include('host.php');
    //include('funciones.php');
    include("MPDF/mpdf.php");

    $mpdf = new mPDF('utf-8' , 'A8','', 0, 0, 5,0, 0, 0);
	
    $Sucursal   = $_SESSION['sucursal'];
    $idSucursal = $_SESSION['id_sucursal'];
    $usuario    = $_SESSION['username'];


    //if ($_GET['factura']) {

    
    if($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
    {
        ## Datos Cajera/O ##
        $consultaCajero     = "SELECT nom FROM usuarios WHERE usu = '$usuario'";
        $paqueteCajero      = consultar($con,$consultaCajero);
        $datoCajero         = mysqli_fetch_array($paqueteCajero);

        $nombreCajero       = $datoCajero['nom'];

        ## Datos Empresa ##

        $consultaEmpresa    = "SELECT * FROM empresa where id = 1";
        $paqueteEmpresa     = consultar($con,$consultaEmpresa);
        $datoEmpresa        = mysqli_fetch_array($paqueteEmpresa);

        $empresa            = $datoEmpresa['empresa'];    
        $direccion          = $datoEmpresa['direccion'];
        $telefono           = $datoEmpresa['tel1'];      
        $nit                = $datoEmpresa['nit'];
        $fecha              = date("d-m-y H:i:s");
        $pagina             = $datoEmpresa['web'];
        $tama               = $datoEmpresa['tamano'];

        
        ## Obtener FECHA ##
        $dias   = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses  = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $hoy    = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y');

        $dia    = date("d");
        setlocale(LC_ALL,"es_ES");
        $mes    =   strtoupper(date("M"));
        $year   =   date("o");

        ## Datos del Cliente que solicitó el credito/apartado ##
        $consultaCliente    = "SELECT idCliente FROM credito WHERE id = '$idCredito'";
        $paqueteCliente     = consultar($con,$consultaCliente);
        $datoCliente        = mysqli_fetch_array($paqueteCliente);

        $idCliente  = $datoCliente[0];
        
        $consultaCliente2   = "SELECT * FROM cliente WHERE codigo = '$idCliente' ";
        $paqueteCliente2    = consultar($con,$consultaCliente2);
        $datoCliente2       = mysqli_fetch_array($paqueteCliente2);

        $codigoCliente      = $datoCliente2['codigo'];
        $nombreCliente      = utf8_encode($datoCliente2['nom']);
        $appCliente         = utf8_encode($datoCliente2['apaterno']);
        $apmCliente         = utf8_encode($datoCliente2['amaterno']);
        $correoCliente      = $datoCliente2['correo'];
        $telefonoClente     = $datoCliente2['tel'];
        $nombreCompletoC    = $nombreCliente." ".$appCliente." ".$apmCliente;



        ## Código HTML para PDF ##


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

              font-size:10px;
              width: 100%;
            }

            .nota3{

                font-size:8.5px;
                width: 100%;
                border: 1px solid #F2F2F2;
                border-collapse: collapse;
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
              <td align="right">NOTA <p><strong>N° '.$idCredito.'</strong></p></td>
            </tr>

            <tr>
              <td colspan="2" align="center"><span>SUCURSAL: '.$Sucursal.'</span></td>
            </tr>
            <tr>
              <td colspan="2" align="right">A. '.$hoy.'</td>
            </tr>
          
        </table>';

        $codigoHTML.='
        <table class = "nota2">
            <tr>
              <td colspan="4" align="left">
                NOMBRE: '.$nombreCompletoC.'<br>
                CORREO: '.$correoCliente.'<br>
                TELEFONO: '.$telefonoClente.'
              </td>
            </tr>
            <tr>
                <td><center>SISTEMA DE APARTADO</center></td>
            </tr>
        </table>';

        $codigoHTML.='
          <table>
            <tr>
              <td class="product">CA</td>
              <td class="product">ARTICULO</td>
              <td class="product">PRECIO<br>UNITARIO</td>
              <td class="product"> IMPORTE </td>
            </tr>';


        ## Consulta de productos relacionados con el id del Credito/Apartado
        $consultaDetalle    = "SELECT * FROM creditodetalle WHERE idCredito = '$idCredito'";
        if($paqueteDetalle     = consultar($con,$consultaDetalle)){

            ## Iniciar variables ##
            $total = 0;

            while($datoDetalle = mysqli_fetch_array($paqueteDetalle)){

                $precioUnitario = $datoDetalle['precioUnitario'];
                $valor          = $datoDetalle['precioProducto'];
                $total          = $total + $valor;

                $iccid = $datoDetalle['iccid'];
                $imei  = $datoDetalle['imei'];

                ## Obtener el nombre del prducto ##
                $idProducto = $datoDetalle['idProducto'];

                $consultaProd   = "SELECT nom FROM producto WHERE cod = '$idProducto' LIMIT 1";
                $paqueteProd    = consultar($con,$consultaProd);
                $datoProd       = mysqli_fetch_array($paqueteProd);

                $nombreProducto = $datoProd['nom'];
                #######################################

              ## Poner ICCID e IMMEI según el caso ##
              

              if($iccid != ""){
                $addICCID = " <br> ICCID: ".saltoCadena1($iccid);
              }else{
                 $addICCID = "";
              }

              if($imei != ""){
                $addIMEI = " <br> IMEI: ".saltoCadena1($imei);
              }else{                
                 $addIMEI = "";
              }
              ########################################

              $codigoHTML.='
              <tr>
                <td class="product" >'.$datoDetalle['cantidad'].'</td>
                <td class="product" align="left">'.saltoCadena1($nombreProducto).$addICCID.$addIMEI.'</td>
                <td class="product" align="right">$ '.number_format($precioUnitario,2).'</td>
                <td class="product" align="right">$ '.number_format($valor,2).'</td>
              </tr>
              ';
            }

            $codigoHTML.='</table>';

            $codigoHTML.='
            <br>
            <table class="nota2">

            <tr>
            <td align="right" ><b>TOTAL $</b></td>
            <td align="right" ><b>'.number_format($total,2).'</b></td>
            </tr>

            <tr>
            <td align="right" >DINERO RECIBIDO $</td>
            <td align="right" >'.number_format($denominacion,2).'</td>
            </tr>';

            $codigoHTML.='
            <tr>
            <td align="right" >USTED ABONA $</td>
            <td align="right" >'.number_format($abono,2).'</td>
            </tr>';

            $codigoHTML.='
            <tr>
            <td align="right" >CAMBIO $</td>
            <td align="right" >'.number_format($cambio,2).'</td>
            </tr>';

           
            $codigoHTML.='
            <tr>
            <td align="right" >USTED RESTA $</td>
            <td align="right" >'.number_format($resto,2).'</td>
            </tr>';

            $codigoHTML.='</tr>
            </table><hr>';


            $codigoHTML.='
            <table class="nota3">
            <tr>
            <td>
                <p><center>Le Atendio: '.$nombreCajero.'</center></p>
            </td>
            </tr>
            <tr>
            <td>     
            <p>NOTA:</p>
            <p>El sistema de apartado es a 30 días.</p>
            <p >En caso de cancelación, reembolso, cambio de equipo o de no <br>
                liquidar en la fecha pactada el ultimo pago. <br>
                Se cobrara el 10 % adicional del valor total del costo del equipo.
            </p>
            <p><center>FIRMA DE CONFORMIDAD DEL CLIENTE</center></p><br>
            <p><center>__________________________________________</center></p>
            <p><center>HE LEIDO Y ACEPTO CADA UNA DE ESTAS CLAUSULAS</center></p>
            <p><center>ACLARACIONES: 712 140 59 07 DE LUNES A DOMINGO</center></p>
            <p><center>QUEJAS: 712 140 59 07 DE LUNES A VIERNES DE 9:00 AM A 6:00 PM</center></p>
            </td>
            </tr>
            </table>';

        }

        $mpdf->WriteHTML($codigoHTML);        
        $mpdf->Output('Facturas/CA'.$idCredito."_".$idSucursal.'.pdf');
    }
}


function saltoCadena1($stirng){

  $nuevo_texto = wordwrap($stirng, 10,'@@', 1);
  $array = explode('@@',$nuevo_texto);
  $cadenaConfig = "";

  foreach($array as &$valor){

      $cadenaConfig.= $valor." <br>";
  }

  return $cadenaConfig;
}
?>