<?php
function PDFLiberar($idReparacion,$totalPagar,$dineroRecibo,$cambio,$con,$hostDB, $usuarioDB, $claveDB, $baseDB)
{
    //session_start();

    $Sucursal = $_SESSION['sucursal'];
    //$idReparacion = $_GET['idReparacion'];
    $idSucursal = $_SESSION['id_sucursal'];

    setlocale(LC_ALL,"es_ES");
    include("MPDF/mpdf.php");
    
    $mpdf = new mPDF('utf-8' , 'A8','', 0, 0, 5,0, 0, 0);

    $dia = date("d");
    setlocale(LC_ALL, "es_ES");
    $mes = strtoupper(date("M"));
    $year = date("o");

    $consulta1 = "SELECT * FROM empresa WHERE id = '1'";
    $consulta2 = "SELECT * FROM reparacion WHERE id_reparacion = '$idReparacion'";

    
    
    if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) {
        $paquete1 = consultar($con, $consulta1);
        $fila1 = mysqli_fetch_array($paquete1);

        $direccion=$fila1['direccion'];
        $empresa=$fila1['empresa'];
        
        $telefono=$fila1['tel1'];
        $nit=$fila1['nit'];

        if ($paquete = consultar($con, $consulta2)) {
            $fila = mysqli_fetch_array($paquete);

            $nombre = $fila['nombre_contacto'].' '.$fila['ap_contacto'];
            $telef = $fila['telefono_contacto'];
            $marca = $fila['marca'];
            $modelo = $fila['modelo'];
            $memori =$fila['memoria'];
            $chip  = $fila['chip'];

            $codigo = $fila['cod_cliente'];
            $motivo=$fila['motivo'];

            $precio=$fila['precio'];
            $abono =$fila['abono'];
            $resto =$fila['precio']-$fila['abono'];
            $cajera=$fila['usuario'];

            $consulta3 =  "SELECT * FROM usuarios where usu='$cajera'";
            $paquete3 = consultar($con, $consulta3);
            $fila3 = mysqli_fetch_array($paquete3);
            $cajero = $fila3['nom'];
        } else {
            echo 0;
        }
    
        $codigoHTML='<html lang="es">
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
        <table class="nota2">
          <tr>
            <td colspan="2" ><center><img src="img/1.jpg"></center></td>
          </tr>

          <tr>
            <td>
            <p>'.$direccion.'</p>
            <p>SurtiditoCell</p>
            </td>
            <td>REPARACION <p>N° '.$idReparacion.'</p></td>
          </tr>

          <tr>
            <td colspan="2" align="center">SUCURSAL. '.$Sucursal.'</td>
          </tr>

          <tr>
            <td colspan="2" align="right">A. '.$dia.' DE '.$mes.' DEL '.$year.'</td>
          </tr>
        </table><br>';
        
        $codigoHTML.='<table  class="nota2">
              <tr>
              <td><center>LIBERACIÓN</center></td>
              </tr>
              <tr>
                <td>
                  <p>NOMBRE: '.$nombre.'</p>
                  <p>TEL. CONTACTO: '.$telef.'</p>
                </td>
              </tr>
              </table>';
        $codigoHTML.='<table>
            <tr>
              <td class="product">MARCA</td>
              <td class="product">MODELO</td>
              <td class="product">MEMORIA</td>
              <td class="product">CHIP</td>
            </tr>';
        $codigoHTML.='
            <tr>
              <td class="product">'.$marca.'</td>
              <td class="product">'.$modelo.'</td>
              <td class="product" align="center">'.$memori.'</td>
              <td class="product" align="center">'.$chip.'</td>
            </tr>
            ';
        $codigoHTML.='
            <tr>
              <td colspan="2" class="product">CODIGO CLIENTE: </td>
              <td colspan="2" class="product">'.$codigo.'</td>
            </tr>
            <tr>
              <td colspan="2" class="product">MOTIVO REPARACION: </td>
              <td colspan="2" class="product">'.$motivo.'</td>
            </tr>
            </table><br>';



            ##### Consulta de refacciones #####

            $consulta4 = "SELECT id_producto, NomProducto FROM reparacion_refaccion WHERE id_reparacion = '$idReparacion' ";

            if($paquete4 = consultar($con,$consulta4)){
              $contador=0;

              $codigoHTML.=
                '<table>
                <tr>
                  <td colspan="3" class="product">REFACCIONES</td>
                </tr>';

              $codigoHTML.=
                '<tr>
                  <td  class="product">#</td>
                  <td  class="product">Código</td>
                  <td  class="product">Nombre</td>
                </tr>';



              while($fila4 = mysqli_fetch_array($paquete4)){

                $contador++;
                
                $noR      = $contador;
                $codRefa  = $fila4['id_producto'];
                $nomRefa  = $fila4['NomProducto'];

                $codigoHTML.=

                '<tr>
                  <td  class="product">'.$noR.'</td>
                  <td  class="product">'.$codRefa.'</td>
                  <td  class="product">'.saltoCadena3($nomRefa).'</td>
                </tr>
                </table><br>';

              }

            }else{
              $codigoHTML.="";
            }


            ###################################

            


            







        $codigoHTML.='<table class="nota2">
              <tr>
                <td align="right"><b>Total a Pagar $</b></td>
                <td align="right"><b>'.number_format($totalPagar, 2).'</b></td>
              </tr>

               <tr>
                <td align="right">Pago $</td>
                <td align="right">'.number_format($dineroRecibo, 2).'</td>
              </tr>

              <tr>
                <td align="right">Cambio $</td>
                <td align="right">'.number_format($cambio, 2).'</td>
              </tr>

              </table> <br>

              <table class="nota3">
              <tr>             
                  <td><p>Le Atendio: '.$cajero.'</p></td>
              </tr>
              <tr>
                <td align="left">
                <hr>
                  <p>TICKET DE LIBERACIÓN.</p>
                  <p><center>PARA INFORMACIÓN DE SU REPARACIÓN COMUNIQUESE AL TELEFONO: 712 140 59 07</center></p>
                </td>
              </tr>
            </table>
            </body>
            </html>';

        //$mpdf->WriteHTML(utf8_encode($codigoHTML));
        $mpdf->WriteHTML($codigoHTML);
        //$mpdf->Output('Ticket_'.$factura.'.pdf','D');."_".$id_sucursal.'
        $mpdf->Output('Facturas/'.'RL'.$idReparacion."_".$idSucursal.'.pdf');
    }
}

function saltoCadena3($stirng){

  $nuevo_texto = wordwrap($stirng, 10,'@@', 1);
  $array = explode('@@',$nuevo_texto);
  $cadenaConfig = "";

  foreach($array as &$valor){

      $cadenaConfig.= $valor." <br>";
  }

  return $cadenaConfig;
}
?>