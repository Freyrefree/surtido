<?php
function PDFR($id_reparacion){

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
    //if ($id_reparacion) {
      //$factura = $_GET['factura'];
      $can=mysql_query("SELECT * FROM reparacion where id_reparacion='$id_reparacion' AND id_sucursal = '$id_sucursal'");
      if($datos=mysql_fetch_array($can)){
        $cajera       =$datos['usuario'];
        $precio       =$datos['precio'];
        $marca        = utf8_encode($datos['marca']);
        $modelo       = utf8_encode($datos['modelo']);
        $memori       =$datos['memoria'];
        $chip         =$datos['chip'];
        $motivo       = utf8_encode($datos['motivo']);
        $abono        =$datos['abono'];
        $resto        =$datos['precio']-$datos['abono'];
        $nombre       = utf8_encode($datos['nombre_contacto'])." ".utf8_encode($datos['ap_contacto']);
        $telef        =$datos['telefono_contacto'];
        $codigo       =$datos['cod_cliente'];
        $fechaEntrada = $datos['fecha_ingreso'];
        $fechaSalida  =$datos['fecha_salida'];
        $imei         =$datos['imei'];
      }
      $can=mysql_query("SELECT * FROM usuarios where usu='$cajera'"); 
        if($datos=mysql_fetch_array($can)){ 
        $cajero=$datos['nom'];
      }
      $can=mysql_query("SELECT * FROM empresa where id=1");
      if($dato=mysql_fetch_array($can)){
      $empresa=$dato['empresa'];    $direccion=$dato['direccion'];
      $telefono=$dato['tel1'];      $nit=$dato['nit'];   
      $pagina=$dato['web'];
      $tama=$dato['tamano'];
      }
        
      $dia=date("d");
      setlocale(LC_ALL,"es_ES");
      $mes=strtoupper(date("M"));
      $year=date("o");
      $hora = date("H:i:s");

      #### Obtener Fecha Límite de Entrga #####

      $fechaLimite = date('Y-m-d', strtotime($fechaEntrada . ' +30 day'));

      #########################################


        ##Telefonos
        $telCajero  = "";
        $telTecnico = "";

        #Telefono de cajero#
        $usuarioL = $_SESSION['username'];
        $consulta = "SELECT tel FROM usuarios WHERE usu = '$usuarioL'";
        $ejecuta = mysql_query($consulta);
        $dato = mysql_fetch_array($ejecuta);
        $telCajero = $dato['tel'];
        #Telefono Técnico#
        $consulta2 = "SELECT tel FROM usuarios WHERE tipo = 'te'";
        $ejecuta2 = mysql_query($consulta2);
        while($dato2 = mysql_fetch_array($ejecuta2)){
          $telTecnico.= $dato2['tel']." | ";
        }




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

              font-size:10px;
              width: 100%;
            }

            .nota2{

              font-size:9px;
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
              <td colspan="2" ><img src="img/1.jpg"></td>
            </tr>
            <tr>
              <td>              
                <p>'.$direccion.'</p>
                <p>SurtiditoCell</p>
              </td>
              <td>REPARACION <p><strong>N° '.$id_reparacion.'</strong></p></td>
            </tr>
            <tr>
              <td colspan="2" align="center">SUCURSAL. '.$Sucursal.'</td>
            </tr>
            <tr>
              <td colspan="2" align="right">'.$dia.' DE '.$mes.' DE '.$year.' '.$hora.'</td>
            </tr>
        </table>';


        $codigoHTML.=  '<table>';
            $codigoHTML.=
                  '<tr>
                    <td colspan="4" align="left">
                      <p>NOMBRE: '.$nombre.'</p>
                      <p>TEL. CONTACTO: '.$telef.'</p>
                    </td>
                  </tr>';
              $codigoHTML.='
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
                  <td colspan="2" class="product">IMEI: </td>
                  <td colspan="2" class="product">'.$imei.'</td>
                </tr>
                <tr>
                  <td colspan="2" class="product">CODIGO CLIENTE: </td>
                  <td colspan="2" class="product">'.$codigo.'</td>
                </tr>
                <tr>
                  <td colspan="2" class="product">MOTIVO REPARACION: </td>
                  <td colspan="2" class="product">'.$motivo.'</td>
                </tr>
                <tr>
                  <td colspan="2" class="product">FECHA PROMETIDA DE ENTREGA: </td>
                  <td colspan="2" class="product">'.$fechaSalida.'</td>
                </tr>
                
                </table>';


                $codigoHTML.='<table class="nota2">
                  <tr>
                  <td></td><td></td>
                    <td  align="right"><b>PRESUPUESTO APROX. $</b></td>
                    <td align="right"><b>'.number_format($precio,2).'</b></td>
                  </tr>
                  <tr>
                    <td></td><td></td>
                    <td  align="right">ANTICIPO $</td>
                    <td align="right">'.number_format($abono,2).'</td>
                  </tr>
                  <tr>
                    <td></td><td></td>
                    <td  align="right">RESTO $</td>
                    <td align="right">'.number_format($resto,2).'</td>
                  </tr>

              </table>
              <br>


              <table class="nota3">
                  <tr>
                    <td>
                      <p><center>Le Atendio: '.$cajero.'</center></p>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>
                    <hr>
                      <p>La revision tiene un costo de $30.00 pesos.</p>
                      <p>La fecha limite de entrega es: '.$fechaLimite.'.</p>
                      <p>Las entregas son de lunes a sabado de 9:00 hrs, a 19:00 hrs.</p>
                      <p><center>PARA INFORMACIÓN DE SU REPARACIÓN COMUNIQUESE AL TELEFONO:'.$telCajero.'</center></p>
                    </td>
                  </tr>

              </table>

              <hr>

              <table class="nota3">

                  <tr>
                    <td>
                      
                      <p><center>CLÁUSULAS:</center></p>
                      
                      <p>
                        *El cliente afirma que es propietario del equipo y dado el caso que el equipo sea
                        recogido porque presente algun reporte por robo tendrá que presentarse el cliente
                        al centro de atención a clientes mas cercano de la compañia correspondiente (Telcel,
                        Movistar, Iusacell, Unefon, AT&T), para acreditar la propiedad del equipo con factura o
                        ticket de compra.
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      
                      <p>
                        *No nos hacemos responsables por la perdida de informacion como son: imagenes,
                        videos, musica y aplicaciones.
                      </p>

                      <p>*En equipos mojados no hay garantia y se cobrara el servicio completo.</p>

                      <p>*El servicio de DESBLOQUEO no corrige ninguna falla adicional.</p>

                      <p>*En software no hay garantia y se borrara la información.</p>

                      <p>*El presupuesto puede variar dependiendo del daño del equipo.</p>

                      <p>
                        *SIN NOTA no se entregará ningún equipo sin excepcion alguna y deberá presentar
                        copia de su indentificación para rastrear su equipo en un lapso de 24 a 72 hrs.
                      </p>

                      <p>*El tiempo de ENTREGA puede variar dependiendo de la disponibilidad de la pieza.</p>

                      <p>
                        *Los diagnósticos seran realizados por el servicio tecnico de nosotros, No de la
                        compañia telefonica y PIERDE LA GARANTIA DEL FABRICANTE.
                      </p>

                      <p>
                        *La GARANTIA será de 15 dias naturales en mano de obra, para que pueda hacerse
                        cualquier aclaración sobre la reparación de su equipo.
                      </p>
                      
                    </td>
                  </tr>

              </table>

              <table class="nota3">
                <tr>

                <td>
                    <p><center>NOTA IMPORTANTE</center></p>

                    <p>
                      *Despues de 30 DÍAS todos los equipos que no sean reclamados, recogidos o
                      pagados se remataran para la recuperacion  de manos de obra y piezas que se
                      invirtieron para la reparacion del equipo sin excepcion alguna.
                    </p>

                    <p>
                      *Nadie del personal que labora aqui puede REVOCAR alguna de estas clausulas o dar
                      una aplicacion de garantia o hacer acuerdos.
                    </p><br>

                    <p><center>FIRMA DE CONFORMIDAD DEL CLIENTE</center></p>
                      <br>
                    <p><center>____________________________________________</center></p>
                    <p><center>HE LEÍDO Y ACEPTO CADA UNA DE LAS CLÁUSULAS</center></p>

                    <p><center>Contacto Cajero:'.$telCajero.'</center></p>
                    <p><center>Contacto Técnicos:'.$telTecnico.' </center></p>
                    <p><center>Quejas AL TEL: 712 140 59 07 </center></p>
                  </td>

                </tr>
              </table>
            </body>
            </html>
            ';//PARA INFORMACIÓN DE SU REPARACIÓN COMUNIQUESE AL TELEFONO: (712) 2830298  align="right"
        $mpdf->WriteHTML(($codigoHTML));
        //$mpdf->Output('Ticket_'.$factura.'.pdf','D');."_".$id_sucursal.'
        $mpdf->Output('Facturas/'.'R'.$id_reparacion."_".$id_sucursal.'.pdf');
    //}
}
?>