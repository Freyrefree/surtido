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

$html = '<table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">

<thead>
    <tr>
        <th>No. Lote</th>
        <th>Sucursal Salida</th>
        <th>Usu Salida</th>
        <th>Sucursal Entrada</th>
        <th>Usu Entrada</th>
        <th>Código producto</th>
        <th>Producto</th>
        <th>IMEI</th>
        <th>ICCID</th>
        <th>Cantidad Enviada</th>
        <th>Cantidad Recibida</th>
        <th>Fecha Entrada</th>
        <th>Recibido</th>
    </tr>
</thead>
<tbody>
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

        
            $html.= '
            <tr>
                    <td>'.$dato['IdLote'].'</td>
                    <td>'.$SucursalSalida.'</td>
                    <td>'.$usuSalida.'</td>
                    <td>'.$SucursalEntrada.'</td>
                    <td>'.$usuEntrada.'</td>
                    <td>'.$dato['IdProducto'].'</td>
                    <td>'.$NombreProducto.'</td>
                    <td>'.$IMEI.'</td>
                    <td>'.$dato['Cantidad'].'</td>
                    <td>'.$dato['CantRecibida'].'</td>
                    <td>'.$dato['FechaEntrada'].'</td>
                    <td>'.$ICCID.'</td>                    
                    <td>✓</td>
            </tr>';
        }
       
$html.='</tbody></table>';
echo $html;
?>