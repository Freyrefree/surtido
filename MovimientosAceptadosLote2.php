<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];

        $fecha_inicio = $_POST['fechainicio'];
        $fecha_fin = $_POST['fechafin'];
        $tipo = $_POST['tipo'];//1=sólo telefonos //2sólo accesorios
        if($tipo == 0)
        {
            $tipo = "";
        }
        
        if($fecha_inicio == "--")
        {
        $fecha_inicio = "";
        }else{
        $fecha_inicio = $fecha_inicio." 00:00:00";
        }
        
        if($fecha_fin == "--")
        {
        $fecha_fin = "";
        }else{
        $fecha_fin = $fecha_fin." 23:59:59";
        }

        if(($fecha_inicio == "") && ($fecha_fin == "") && ($tipo == ""))
        {
            if($tipo_usu=="a"){
                $consulta1 = "SELECT * FROM movimientosxlote WHERE recibido=1 ORDER BY FechaEntrada DESC";
                $query2=mysql_query($consulta1);
            }else{
                $consulta2 = "SELECT * FROM movimientosxlote WHERE (IdSucSalida=$id_sucursal OR IdSucEntrada=$id_sucursal) AND recibido=1
                ORDER BY FechaEntrada DESC;";
                $query2=mysql_query($consulta2);
            }
        }else if(($fecha_inicio != "") && ($fecha_fin != "") && ($tipo == ""))
        {
            if($tipo_usu=="a"){
                $consulta1 = "SELECT * FROM movimientosxlote WHERE recibido=1 AND FechaEntrada BETWEEN '$fecha_inicio' AND '$fecha_fin' ORDER BY FechaEntrada DESC;";
                $query2=mysql_query($consulta1);
            }else{
                $consulta2 = "SELECT * FROM movimientosxlote WHERE (IdSucSalida=$id_sucursal OR IdSucEntrada=$id_sucursal) AND recibido=1
                AND FechaEntrada BETWEEN '$fecha_inicio' AND '$fecha_fin'
                ORDER BY FechaEntrada DESC;";
                $query2=mysql_query($consulta2);
            }
        }else if(($fecha_inicio == "") && ($fecha_fin == "") && ($tipo == 1))
        {
            if($tipo_usu=="a"){
                $consulta1 = "SELECT * FROM movimientosxlote WHERE recibido=1 AND (ICCID <> '' OR IMEI <> '')  ORDER BY FechaEntrada DESC";
                $query2=mysql_query($consulta1);
            }else{
                $consulta2 = "SELECT * FROM movimientosxlote WHERE (IdSucSalida=$id_sucursal OR IdSucEntrada=$id_sucursal) AND recibido=1
                AND (ICCID <> '' OR IMEI <> '') ORDER BY FechaEntrada DESC;";
                $query2=mysql_query($consulta2);
            }            
        }else if(($fecha_inicio == "") && ($fecha_fin == "") && ($tipo == 2))
        {
            if($tipo_usu=="a"){
                $consulta1 = "SELECT * FROM movimientosxlote WHERE recibido=1 AND (ICCID = '' AND IMEI = '')  ORDER BY FechaEntrada DESC";
                $query2=mysql_query($consulta1);
            }else{
                $consulta2 = "SELECT * FROM movimientosxlote WHERE (IdSucSalida=$id_sucursal OR IdSucEntrada=$id_sucursal) AND recibido=1
                AND (ICCID = '' AND IMEI = '') ORDER BY FechaEntrada DESC;";
                $query2=mysql_query($consulta2);
            }            
        }else if(($fecha_inicio != "") && ($fecha_fin != "") && ($tipo == 1))
        {
            if($tipo_usu=="a"){
                $consulta1 = "SELECT * FROM movimientosxlote WHERE recibido=1 AND FechaEntrada BETWEEN '$fecha_inicio' AND '$fecha_fin' 
                AND (ICCID <> '' OR IMEI <> '')
                ORDER BY FechaEntrada DESC;";
                $query2=mysql_query($consulta1);
            }else{
                $consulta2 = "SELECT * FROM movimientosxlote WHERE (IdSucSalida=$id_sucursal OR IdSucEntrada=$id_sucursal) AND recibido=1
                AND FechaEntrada BETWEEN '$fecha_inicio' AND '$fecha_fin'
                AND (ICCID <> '' OR IMEI <> '')
                ORDER BY FechaEntrada DESC;";
                $query2=mysql_query($consulta2);
            }           
        }else if(($fecha_inicio != "") && ($fecha_fin != "") && ($tipo == 2))
        {
            if($tipo_usu=="a"){
                $consulta1 = "SELECT * FROM movimientosxlote WHERE recibido=1 AND FechaEntrada BETWEEN '$fecha_inicio' AND '$fecha_fin' 
                AND (ICCID = '' AND IMEI = '')
                ORDER BY FechaEntrada DESC;";
                $query2=mysql_query($consulta1);
            }else{
                $consulta2 = "SELECT * FROM movimientosxlote WHERE (IdSucSalida=$id_sucursal OR IdSucEntrada=$id_sucursal) AND recibido=1
                AND FechaEntrada BETWEEN '$fecha_inicio' AND '$fecha_fin'
                AND (ICCID = '' AND IMEI = '')
                ORDER BY FechaEntrada DESC;";
                $query2=mysql_query($consulta2);
            }           
        }

$html = '<table class="table" border="1">
<tbody>
    <tr class="success">
        <td colspan="13"><center><strong>Movimientos Autorizados</strong></center></td>
    </tr>
    <tr>
        <th><strong>No. Lote</strong></td>
        <th><strong>Sucursal Salida</strong></td>
        <th><strong>Usu Salida</strong></td>
        <th><strong>Sucursal Entrada</strong></td>
        <th><strong>Usu Entrada</strong></td>
        <th><strong>Código producto</strong></td>
        <th><strong>Producto</strong></td>
        <th><strong>IMEI</strong></td>
        <th><strong>ICCID</strong></td>
        <th><strong>Cantidad Enviada</strong></td>
        <th><strong>Cantidad Recibida</strong></td>
        <th><strong width="200px">Fecha Entrada</strong></td>
        <th><strong>Recibido</strong></td>
    </tr>
    </tr>';
        
        while($dato=mysql_fetch_array($query2))
        {
              $Id           =$dato['Id'];
              $IdSucSalida  =$dato['IdSucSalida'];
              $usuSalida  =$dato['UsuSalida'];
              $IdSucSalida  =$dato['IdSucSalida'];
              $IdSucEntrada =$dato['IdSucEntrada'];
              $usuEntrada  =$dato['UsuEntrada'];
              $IdProducto   =$dato['IdProducto'];
              $IMEI         =$dato['IMEI'];
              $ICCID        =$dato['ICCID'];
              $IdFicha      =$dato['IdFicha'];

              $QSucSal=mysql_query("SELECT * FROM empresa WHERE id=$IdSucSalida");
              if($DSucSal=mysql_fetch_array($QSucSal)){
                 $SucursalSalida=$DSucSal['empresa'];
              }

              $QSucEnt=mysql_query("SELECT * FROM empresa WHERE id=$IdSucEntrada");
              if($DSucEnt=mysql_fetch_array($QSucEnt)){
                 $SucursalEntrada=$DSucEnt['empresa'];     
              }

              $QProduc=mysql_query("SELECT * FROM producto WHERE cod='$IdProducto'"); 
              if($DProduc=mysql_fetch_array($QProduc)){
                 $NombreProducto=$DProduc['nom'];
              }     

        
            $html.= '<tr>
                    <td>'.$dato['IdLote'].'</td>
                    <td>'.$SucursalSalida.'</td>
                    <td>'.$usuSalida.'</td>
                    <td>'.$SucursalEntrada.'</td>
                    <td>'.$usuEntrada.'</td>
                    <td>'.$dato['IdProducto'].'</td>
                    <td>'.$NombreProducto.'</td>
                    <td>'.$IMEI.'</td>
                    <td>'.$ICCID.'</td>                    
                    <td>'.$dato['Cantidad'].'</td>
                    <td>'.$dato['CantRecibida'].'</td>
                    <td width="200px">'.$dato['FechaEntrada'].'</td>
                    <td><strong>✓</strong></td>
            </tr>';
        }
       
$html.='</tbody></table>';
echo $html;
?>