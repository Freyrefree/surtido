<?php
session_start();
include('php_conexion.php');

if(!empty($_POST['id_reparacion']))
{
    $id_reparacion = $_POST['id_reparacion'];
    $data = array();
    
    
    $consulta = "SELECT * FROM reparacion WHERE id_reparacion = '$id_reparacion'";
    $query = mysql_query($consulta);
    $dato = mysql_fetch_array($query);


    if($dato['estado']=='1'){
        $estado='Pendiente';
    }else if ($dato['estado'] == '2') {
      $estado='Terminado';
    }else if ($dato['estado'] == '3'){
        $estado='Entregado';
    }else if ($dato['estado'] == '0'){
        $estado='Por aceptar';
    }else if ($dato['estado'] == '4'){
        $estado='Reparación Cancelada';
    }

    $id_sucursal= $dato['id_sucursal'];
    $consultaSucursal = "SELECT empresa FROM empresa WHERE id = '$id_sucursal';";
    $query2 = mysql_query($consultaSucursal);
    $dato2 = mysql_fetch_array($query2);
    $nombreSucursal = utf8_encode($dato2['empresa']);

    if($dato['abono'] != ''){
        $abono = $dato['abono'];
    }else{
        $abono = 0;
    }
    
        $tecnico = utf8_encode($dato['tecnico']);
        $sucursal = $nombreSucursal;
        $usuario = utf8_encode($dato['usuario']);
        $fecha_ingreso = $dato['fecha_ingreso'];
        $fecha_salida = $dato['fecha_salida'];
        $cod_cliente = trim($dato['cod_cliente']);
        $nombre_contacto = utf8_encode($dato['nombre_contacto'])." ".utf8_encode($dato['ap_contacto'])." ".utf8_encode($dato['am_contacto']);
        $rfc = $dato['rfc_curp_contacto'];
        $telefono_contacto = $dato['telefono_contacto'];
        $correo = $dato['correo'];
        $direccion = utf8_encode($dato['direccion']);
        $imei = $dato['imei'];
        $marca = utf8_encode($dato['marca']);
        $modelo = utf8_encode($dato['modelo']);
        $color = utf8_encode($dato['color']);
        $chip = $dato['chip'];
        $memoria = $dato['memoria'];
        $motivo = utf8_encode($dato['motivo']);
        $observacion = utf8_encode($dato['observacion']);
        $precio_inicial = "$ ".number_format($dato['precio_inicial'],2,'.','');
        $abono = "$ ".number_format($abono,2,'.','');

        $html = '<style type="text/css">
        #detalleReparacion {
          font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        #detalleReparacion td, #detalleReparacion th {
          border: 1px solid #ddd;
          padding: 8px;
        }

        #detalleReparacion td.a {
          padding-top: 5px;
          padding-bottom: 5px;
          text-align: left;
          background-color: #F7D358;
          color: #000000;
        }

        
        #detalleReparacion th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #F7D358;
          color: #000000;
        }
      </style>
      <table id="detalleReparacion">
        <tr>
          <td class="a">Núm Reparación</td><td><strong>'.$id_reparacion.'</strong></td>
        </tr>
        <tr>
          <td class="a">Técnico</td><td>'.$tecnico.'</td>
        </tr>
        <tr>
          <td class="a">Estado Reparación</td><td>'.$estado.'</td>
        </tr>
        <tr>
          <td class="a">Sucursal Entrada</td><td>'.$sucursal.'</td>
        </tr>
        <tr>
          <td class="a">Usuario que recibe</td><td>'.$usuario.'</td>
        </tr>
        <tr>
          <td class="a">Fecha Ingreso</td><td>'.$fecha_ingreso.'</td>
        </tr>
        <tr>
          <td class="a">Fecha Salida</td><td>'.$fecha_salida.'</td>
        </tr>
        <tr>
          <td class="a">Código Cliente</td><td>'.$cod_cliente.'</td>
        </tr>
        <tr>
          <td class="a">Cliente</td><td>'.$nombre_contacto.'</td>
        </tr>
        <tr>
          <td class="a">RFC</td><td>'.$rfc.'</td>
        </tr>
        <tr>
          <td class="a">Telefono</td><td>'.$telefono_contacto.'</td>
        </tr>
        <tr>
          <td class="a">Correo</td><td>'.$correo.'</td>
        </tr>
        <tr>
          <td class="a">Dirección</td><td>'.$direccion.'</td>
        </tr>
        <tr>
          <td class="a">IMEI</td><td>'.$imei.'</td>
        </tr>
        <tr>
          <td class="a">Marca</td><td>'.$marca.'</td>
        </tr>
        <tr>
          <td class="a">Modelo</td><td>'.$modelo.'</td>
        </tr>
        <tr>
          <td class="a">Color</td><td>'.$color.'</td>
        </tr>
        <tr>
          <td class="a">Chip</td><td>'.$chip.'</td>
        </tr>
        <tr>
          <td class="a">Memoria</td><td>'.$memoria.'</td>
        </tr>
        <tr>
          <td class="a">Motivo Reparación</td><td>'.$motivo.'</td>
        </tr>
        <tr>
          <td class="a">Observaciones</td><td>'.$observacion.'</td>
        </tr>
        <tr>
          <td class="a">Presupuesto Inicial</td><td>'.$precio_inicial.'</td>
        </tr>
        <tr>
          <td class="a">Adelanto</td><td>'.$abono.'</td>
        </tr>
        
        

      </table>';

      $data['html'] = $html;



        
       
    
    echo json_encode($data);
}
?>