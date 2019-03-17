<?php
error_reporting(0);


    function conectarBase($host,$usuario,$clave,$base)
    {
        if (!$enlace = @mysqli_connect($host,$usuario,$clave,$base))
        {

            return false;

        } else 
        {
            return $enlace;
        }
    }

    function agregar($conexion, $consulta)
    {

        if (!$datos = mysqli_query($conexion,$consulta))
        {		 
            return false; // si fue rechazada la consulta por errores de sintaxis, o ningún registro coincide con lo buscado, devolvemos false

        } 
        else
        {	

            return $datos; // si se obtuvieron datos, los devolvemos al punto en que fue llamada la función		
        }
    }

    function agregarCliente($conexion,$consulta)
    {

        if (!$datos = mysqli_query($conexion,$consulta))
        {		 
            return false; // si fue rechazada la consulta por errores de sintaxis, o ningún registro coincide con lo buscado, devolvemos false

        } 
        else
        {	$dato = mysqli_query($conexion,"SELECT @@identity AS id");
            $row = mysqli_fetch_row($dato);
			$id = trim($row[0]);
			return $id;
        }

    }

    function agregarReparacion($conexion,$consulta){

        if (!$datos = mysqli_query($conexion,$consulta))
        {		 
            return false; // si fue rechazada la consulta por errores de sintaxis, o ningún registro coincide con lo buscado, devolvemos false

        } 
        else
        {	$dato = mysqli_query($conexion,"SELECT @@identity AS id");
            $row = mysqli_fetch_row($dato);
			$id = trim($row[0]);
			return $id;
        }

    }

    function agregarCreditoApartado($conexion,$consulta){

        if (!$datos = mysqli_query($conexion,$consulta))
        {		 
            return false; // si fue rechazada la consulta por errores de sintaxis, o ningún registro coincide con lo buscado, devolvemos false

        } 
        else
        {	$dato = mysqli_query($conexion,"SELECT @@identity AS id");
            $row = mysqli_fetch_row($dato);
			$id = trim($row[0]);
			return $id;
        }

    }

    function consultar($conexion, $consulta)
    {

        if (!$datos = mysqli_query($conexion,$consulta) or mysqli_num_rows($datos)<1)
        {
            
            return false; // si fue rechazada la consulta por errores de sintaxis, o ningún registro coincide con lo buscado, devolvemos false
    
        } else 
        {
    
            return $datos; // si se obtuvieron datos, los devolvemos al punto en que fue llamada la función
            
        }
    }
    function actualizar($conexion, $consulta){

        if (!$datos = mysqli_query($conexion,$consulta))
        {		 
             return false; // si fue rechazada la consulta por errores de sintaxis, o ningún registro coincide con lo buscado, devolvemos false
    
        } 
        else
        {	
    
            return $datos; // si se obtuvieron datos, los devolvemos al punto en que fue llamada la función		
        }
    }
    function eliminar($conexion, $consulta){

        if (!$datos = mysqli_query($conexion,$consulta))
        {		 
             return false; // si fue rechazada la consulta por errores de sintaxis, o ningún registro coincide con lo buscado, devolvemos false
    
        } 
        else
        {
    
            return $datos; // si se obtuvieron datos, los devolvemos al punto en que fue llamada la función		
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

    function tabularReparaciones($datos,$tipoUsuario){

        // Abrimos la etiqueta table una sola vez:
        $codigohtml = '<table width="100%" border="0" class="table">
                    <tr class="info">
                    <td colspan="17"><center><strong>Listado de Reparaciones</strong></center></td>
                    </tr>
                    <tr>
                    <td><strong>Num.</strong></td>                    
                    <td width="30%"><strong>Fecha Ingreso</strong></td>
                    <td width="20%"><strong>Cliente</strong></td>
                    <td><strong>Equipo</strong></td>
                    <td><strong>Teléfono</strong></td>
                    <td width="10%"><strong>Anticipo</strong></td>
                    <td width="10%"><strong>Precio Inicial</strong></td>
                    <td width="10%"><strong>Precio Final</strong></td>
                    <td><strong>Estatus</strong></td>
                    <td><strong>Detalle</strong></td>
                    <td><strong>Obs.</strong></td>
                    <!--<td><strong>Personal</strong></td>-->
                    </tr>';
    
        // Vamos acumulando de a una fila "tr" por vuelta:
        while ($fila = @mysqli_fetch_array($datos) )
        {
            $si="'si'";
            $no="'no'";
            $botonVermas = '<span class="label label-info">Ver más</span>';
            $botonAgregarObs = '<span class="label label-info">Obs.</span>';

            $id_sucursalR=$fila['id_sucursal'];
            
            
            if($fila['estado']=='1'){
            $estado='<a  href="#" onclick="enviar('.$fila['id_reparacion'].')"<span class="label label-warning">Proceso</span></a>';
            }else if ($fila['estado'] == '2') {
            //$estado='<a  href="#" onclick="liberarReparacion('.$fila['id_reparacion'].')"<span class="label label-info">Terminado</span></a>';
            $estado='<a  href="#" <span class="label label-info">Terminado</span></a>';
            }else if ($fila['estado'] == '3'){
            //$estado='<a  href="#" onclick="reingresoReparacion('.$fila['id_reparacion'].')"<span class="label label-success">Entregado</span></a>';
            $estado='<a  href="#" <span class="label label-success">Entregado</span></a>';
            }else if ($fila['estado'] == '0'){
                $estado = '<a  href="#" onclick="aceptarCancelarRepa('.$fila['id_reparacion'].','.$si.')"<span class="label label-important">INICIO</span>';
                $estado.= '<a  href="#" onclick="aceptarCancelarRepa('.$fila['id_reparacion'].','.$no.')"<span class="label label-important">CANCELAR</span>';
            }else if ($fila['estado'] == '4'){
                $estado = '<span class="label label-important">Cancelado</span>';
            }
            
            if ($fila['garantia'] == 's') {
            $garantia = '<span class="label label-info">Reingreso</span>';
            }

            if (($tipoUsuario == 'te' OR $tipoUsuario == 'a') AND ($fila['estado'] != '4') AND ($fila['estado'] != '3') AND ($fila['estado'] != '0')AND ($fila['estado'] != '2')) 
            {
                $agregarPieza = '<td><a href="ModificarReparacion.php?IdReparacion='.$fila['id_reparacion'].'">
                '.utf8_encode($fila['marca']).' '.utf8_encode($fila['modelo']).'</a></td>';
            }else
            {
                $agregarPieza = '<td>'.utf8_encode($fila['marca']).' '.utf8_encode($fila['modelo']).'</td>';
            }
        

            // Vamos acumulando tantos "td" como sea necesario:
            
            $codigohtml .= '<td>'.$fila['id_reparacion'].'</td>';           
            $codigohtml .= '<td>'.$fila['fecha_ingreso'].'</td>';
            $codigohtml .= '<td>'.$fila['nombre_contacto'].'</td>';
            $codigohtml .= $agregarPieza;
            $codigohtml .= '<td>'.$fila['telefono_contacto'].'</td>';

            $codigohtml .= '<td>'.number_format((float)$fila['abono'], 2, '.', '').'</td>';
            $codigohtml .= '<td>'.number_format((float)$fila['precio_inicial'], 2, '.', '').'</td>';
            $codigohtml .= '<td>'.number_format((float)$fila['precio'], 2, '.', '').'</td>';
            $codigohtml .= '<td>'.$estado.'</td>';
            $codigohtml .= '<td><a  href="#" onclick="detalleReparación('.$fila['id_reparacion'].')">'.$botonVermas.'</a></td>';
            $codigohtml .= '<td><a  href="#" onclick="observacion('.$fila['id_reparacion'].')">'.$botonAgregarObs.'</a></td>';

            $codigohtml .= '</tr>';
    
        }
    
        // Finalizado el bucle, cerramos por única vez la tabla:
        $codigohtml .= '</table>';
        
        return $codigohtml;
        
    }

    function tabularRefacciones($datos,$id_reparacion)
    {
        $No=0;
        $codigohtml = '<table id="TablaRefacciones"  class="table" border="0">
        <tr class="info"> 
            <td colspan="8"><center><strong>Listado de Refacciones</strong></center></td>
        </tr>
        <tr>
            <th>No</th>
            <th>ID Refacción</th>
            <th>Nombre Refacción</th>
            <th>Tipo de Precio</th>
            <th>Precio</th>
            <th>Quitar Refacción</th>
        </tr> ';

        while($fila = @mysqli_fetch_array($datos))
        {
            $No++;

            $codigohtml .= "<tr>";
            $codigohtml .= "<td>$No</td>";
            $codigohtml .= "<td>$fila[2]</td>";
            $codigohtml .= "<td>$fila[3]</td>";
            $TipoPrecio=$fila[4];
            $codigoProducto = '"'.$fila[2].'"';
           
           if($TipoPrecio==1){
              $TipoPrecio="Especial";
           }
           
           if($TipoPrecio==2){
              $TipoPrecio="Mayoreo";  
           }
           
           if($TipoPrecio==3){
              $TipoPrecio="Público";    
            }
            
            $codigohtml .= "<td>$TipoPrecio</td>";
            $codigohtml .= "<td>$fila[5]</td>";
            //$codigohtml .= "<td><a href='QuitarRefaccion.php?id=$fila[0]&id_producto=$fila[2]&IdReparacion=$id_reparacion' class='btn btn-warning'>Quitar</a></td>";
            $codigohtml .= "<td><a href='#' onclick='quitarRefaccion(".$fila[0].",".$codigoProducto.",".$id_reparacion.")' class='btn btn-warning'>Quitar</a></td>";
            $codigohtml .="</tr>";
        }

        $codigohtml .="</table>";
        return $codigohtml;
    }

    function tabularSucursales($datos)
    {
        $codigohtml = '<table width="80%" border="0" class="table">
        <tr class="info">
          <td colspan="6"><center><strong>Listado de Sucursales</strong></center></td>
        </tr>
        <tr>
          <td width="7%"><strong>Codigo</strong></td>
          <td width="15%"><strong>Sucursal</strong></td>
          <td width="14%"><strong>Direccion</strong></td>
          <td width="12%"><strong>Telefono</strong></td>
          <td width="13%"><strong>Web</strong></td>
          <td width="12%"><strong>Eliminar</strong></td>
        </tr>';
        // Vamos acumulando de a una fila "tr" por vuelta:
        while ($fila = @mysqli_fetch_array($datos))
        {
            if (($fila['id']) != 1) {
                $estado='<a href="#" onclick="eliminarSucursal('.$fila['id'].')";> <span class="label label-important">Eliminar</span></a>';
            }else{
                $estado='';
            }
            $codigohtml.='<tr>';
            $codigohtml.='<td>'.$fila['id'].'</td>';
            $codigohtml.='<td> <a href="AgregarSucursal.php?codigo='.$fila['id'].'">'.$fila['empresa'].'</a></td>';
            $codigohtml.='<td>'.$fila["direccion"].'</td>';
            $codigohtml.='<td>'.$fila["tel1"].'</td>';
            $codigohtml.='<td>'.$fila['web'].'</td>';
            $codigohtml.='<td>'.$estado.'</td>';
            $codigohtml.='</tr>';
        }
        $codigohtml .="</table>";
        return $codigohtml;

    }

    function tabularUsuarios($datos)
    {
        $codigohtml = '<table width="80%" border="0" class="table">
        <tr class="info">
          <td colspan="6"><center><strong>Listado de Sucursales</strong></center></td>
        </tr>
        <tr>
          <td width="7%"><strong>CURP</strong></td>
          <td width="15%"><strong>Nombre</strong></td>
          <td width="14%"><strong>Estado</strong></td>
          <td width="12%"><strong>Telefono</strong></td>
          <td width="13%"><strong>Celular</strong></td>
          <td width="12%"><strong>Tipo Empleado</strong></td>
          <td width="12%"><strong>Eliminar</strong></td>
        </tr>';

        while ($fila = @mysqli_fetch_array($datos))
        {
            if($fila['tipo']=='a'){ 
                $clase='Administrador'; 
            }else if($fila['tipo']=='ca'){ 
                $clase='Cajero/a'; 
            }else if($fila['tipo']=='te'){ 
                $clase='Tecnico'; 
            }else if($fila['tipo']=='su'){ 
                $clase='Supervisor'; 
            }
            
            if($fila['estado']=="n"){
                $estado='<span class="label label-important">Inactivo</span>';
            }else{
                $estado='<span class="label label-success">Activo</span>';
            }
            
            if (($fila['tipo']) != "a") {
                $btnEliminar="<a href='#' onclick='eliminarUsuario(".'"'.$fila['ced'].'"'.")';> <span class='label label-important'>Eliminar</span></a>";
            }else{
                $btnEliminar='';
            }

            $codigohtml.='<tr>';
            $codigohtml.='<td>'.$fila['ced'].'</td>';
            $codigohtml.='<td><a href="crear_empleado.php?codigo='.$fila['ced'].'">'.$fila['nom'].'</a></td>';
            $codigohtml.='<td><a href="php_estado_empleado.php?id='.$fila['ced'].'">'.$estado.'</a></td>';
            $codigohtml.='<td>'.$fila["tel"].'</td>';
            $codigohtml.='<td>'.$fila['cel'].'</td>';
            $codigohtml.='<td>'.$clase.'</td>';
            $codigohtml.='<td>'.$btnEliminar.'</td>';
            $codigohtml.='</tr>';
        }
        $codigohtml .="</table>";
        return $codigohtml;
    }

    function tabularProductoExistencia($datos)
    {
        include("host.php");
        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
        {
            $codigohtml = '    <style type="text/css">
            #table {
              font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
              border-collapse: collapse;
              width: 100%;
            }
            
            #table td, #table th {
              border: 1px solid #ddd;
              padding: 8px;
            }
    
            #table td.a {
              padding-top: 5px;
              padding-bottom: 5px;
              text-align: left;
              background-color: #F7D358;
              color: #000000;
            }
    
            
            #table th {
              padding-top: 12px;
              padding-bottom: 12px;
              text-align: left;
              background-color: #F7D358;
              color: #000000;
            }
          </style><table id="table">
            <tr class="info">
            <th colspan="6"><center><strong>Productos con existencias</strong></center></th>
            </tr>
            <tr>
            <th><strong>Código Producto</strong></th>
            <th><strong>Nombre</strong></th>
            <th><strong>Sucursal</strong></th>
            <th><strong>Cantidad</strong></th>
            </tr>';

            while ($fila = @mysqli_fetch_array($datos)) {
                $idSucursal = $fila['id_sucursal'];
                $consulta = "SELECT empresa FROM empresa WHERE id = '$idSucursal'";
                if ($paquete1 = consultar($con, $consulta)) {
                    $dato =  mysqli_fetch_array($paquete1);
                    $nombreSucursal = utf8_encode($dato['empresa']);
                }

                $codigohtml.='<tr>';
                $codigohtml.='<td>'.utf8_encode($fila['cod']).'</td>';
                $codigohtml.='<td>'.utf8_encode($fila['nom']).'</td>';
                $codigohtml.='<td>'.$nombreSucursal.'</td>';
                $codigohtml.='<td>'.$fila['cantidad'].'</td>';
                $codigohtml.='</tr>';
            }
            $codigohtml .="</table>";
            return $codigohtml;
        }
    }





    function tabularCorteVentas($arrayConsultas,$rango_fecha,$tipoUsuario)
    {

        include("host.php");
        ini_set('max_execution_time', 0);


        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) {

            $consultaDetalle = $arrayConsultas[0];
            $consultaCantidad = $arrayConsultas[1];
            $consultaImporte =  $arrayConsultas[2];



            if($can =  consultar($con,$consultaDetalle))
            {


                $canart         =   consultar($con,$consultaCantidad);
                $row            =   mysqli_fetch_array($canart);
                $cantidad_art   =   $row[0];
        
                $canimporte     =   consultar($con,$consultaImporte);
                $row1           =   mysqli_fetch_array($canimporte);
                $importe1       =   $row1[0];
    
    
                $codigohtml = '<table class="tblLisado">
                <tr>
                    
                    <th>Cantidad Articulos</th>
                    <th>Venta Total</th>
                    <th>Fecha Venta</th>
    
                </tr>
    
                <tr>
                    
                    <td>'.$cantidad_art.'</td>
                    <td>$'.number_format((float)$importe1, 2, '.', '').'</td>
                    <td>'.$rango_fecha.'</td>
    
                </tr>
    
                </table>
    
                <div id="divId">
                <br>
    
                <table class="tblLisado">
                    <thead>
                    <tr> 
                    
                        <th>No</th> 
                        <th>Factura</th> 
                        <th>Codigo</th> 
                        <th>Nombre</th>
    
                        <th>IMEI</th>
                        <th>Nom Chip</th>
                        <th>ICCID</th> 
                    
                        <th>Cantidad</th> 
                        <th>Valor</th> 
                        <th>Importe</th>
    
                        <th>Tipo Comision</th>
                        <th>% Comision</th>
                        <th>Total Comision</th>      
                        <th>Tipo Venta</th> 
    
                        <th>Fecha venta</th> 
                        <th>Usuario</th>
                        <th>Sucursal</th>';
    
                        if($tipoUsuario == 'a'){
    
                            $codigohtml.=
                            '<th>%Com Empresa</th>
                            <th>Total Comision</th>';
                        }
    
                        
    
                    $codigohtml.='</tr>
                    </thead>
                    <tbody>';
    
    
    
                    $contador = 0;
                    $total_comisiones = 0;
                    $totalComEmpresa = 0;
    
                    while ($dato = mysqli_fetch_array($can)) 
                    {
                        $contador++;
    
                        //......nombre sucursal inicio.........................................................
    
                        $factura = $dato['factura'];
                        $idsucursal=$dato['id_sucursal'];
    
                        if($idsucursal == ""){
                            $stop = $contador;
                        }
    
    
                        $querynombresucursal="SELECT empresa FROM empresa WHERE id = '$idsucursal'";
                        if($canempresa = consultar($con,$querynombresucursal)){
    
                            $dato2 = mysqli_fetch_array($canempresa);
                            $nombreempresa = $dato2['empresa'];
    
                        }else{
    
                            $nombreempresa = "";
                        }
    
                      
    
                           
                    
            
                        
    
                        //......nombre sucursal fin............................................................
    
                        if ($dato['tipo'] == 'CREDITO') {
                            $tipov = "Credito/Apartado";
                        } else if($dato['tipo'] == 'CONTADO') {
                            $tipov = "Contado";
                        } else if($dato['tipo'] == 'liberacion R'){
                            $tipov = "Reparación Liberada";
                        } else if($dato['tipo'] == 'refaccion R'){
                            $tipov = "Refaccion Reparación";
                        } else if($dato['tipo'] == 'abono R'){
                            $tipov = "Adelanto Reparacion";
                        } else if($dato['tipo'] == 'ABONO'){
                            $tipov = "Abono Apartado";
                        } else if($dato['tipo'] == 'mano R'){
                            $tipov = "Mano de Obra";
                        }else{
                            $tipov = "INDEFINIDO";
                        }
    
                        $precioU = $dato['valor'];
                        $precioU = number_format((float)$precioU, 2, '.', '');
                        $cantidad = $dato['cantidad'];
                        $id_producto = $dato['codigo'];
    
                        if(($dato['modulo'] != 'CR') && ($dato['modulo'] != 'R')){
    
                            $consultaProducto = "SELECT * FROM producto WHERE cod='$id_producto' LIMIT 1";
                            if($ejecutar2 = consultar($con,$consultaProducto)){
    
                                $dato2 = mysqli_fetch_array($ejecutar2);
    
                                $id_comision = $dato2['id_comision'];
                                $costo_producto = $dato2['costo'];
    
                                $consultaComision="SELECT * FROM comision WHERE id_comision = '$id_comision'";
                                $ejecutar3 = consultar($con,$consultaComision);
                                $dato3  =   mysqli_fetch_array($ejecutar3);
    
                            }
                        }
    
                        
    
    
    
                        //**************Comision mostrada en tabla*****************/
                        $tipo_comision = $dato['tipo_comision'];
                        if (($tipo_comision == "venta")) {
                            $tipo_comisionshow = "público";
                        } else if ($tipo_comision == "especial") {
                            $tipo_comisionshow = "especial";
                        } else if ($tipo_comision == "mayoreo") {
                            $tipo_comisionshow ="mayoreo";
                        }else if($tipo_comision == "reparacion"){
                            $tipo_comisionshow ="REPARACIÓN";
                        }else if($tipo_comision == "apartado"){
                            $tipo_comisionshow ="APARTADO";
                        }else if($tipo_comision == ""){
                            $tipo_comisionshow ="";
                        }
                        //************************************************************/
                        //**************************Tipo porcentaje de acuerdo al tipo de venta************************
                                                    
                        if (($tipo_comision == "venta")) {
                            $porcentaje_comision = $dato3['porcentaje'];
                        } else if ($tipo_comision == "especial") {
                            $porcentaje_comision = $dato3['porcentajeespecial'];
                        } else if ($tipo_comision == "mayoreo") {
                            $porcentaje_comision = $dato3['porcentajemayoreo'];
                        }else if($tipo_comision == "reparacion"){
    
                            $queryCom = "SELECT porcentaje FROM comision WHERE tipo = 'REPARACION'";
                            $ejecCom = consultar($con,$queryCom);
                            $datoCom  = mysqli_fetch_array($ejecCom);
                            $porcentaje_comision = $datoCom['porcentaje'];
                            $costo_producto = 0;
    
                            ## obtener precio unitario para comision del cajero ##
    
                            if($dato['tipo'] == 'liberacion R'){
                                $precioU = 0;
    
                                $finalReparacion = "SELECT comisionCajero FROM reparacion WHERE id_reparacion = '$factura'";
                                $paqueteRepa = consultar($con,$finalReparacion);
                                $datoRepa = mysqli_fetch_array($paqueteRepa);
                                $precioU = $datoRepa[0];
                            }
    
                        }else if($tipo_comision == "apartado"){
    
                            $queryCom = "SELECT porcentaje FROM comision WHERE tipo = 'APARTADO'";
                            $ejecCom = consultar($con,$queryCom);
                            $datoCom  = mysqli_fetch_array($ejecCom);
                            $porcentaje_comision = $datoCom['porcentaje'];
    
                            ///$costo_producto = 0;
    
                        
                           
                        }else if($tipo_comision == ""){
    
                          
                            $porcentaje_comision = 0;
                            $costo_producto = 0;
    
                        
                           
                        }
                        //************************************************************************************************
    
                        $esComision = $dato['esComision'];
                        if(($dato['esComision'] == 0) && ($dato['esComision'] != null) ){
    
                            $pro_comision    = "";
                            $comisionEmpresa = "";
    
                        }else{
    
                            if($precioU > 0){
    
                                if($tipo_comision == "apartado"){
    
                                    ## Obtener suma de comisiones de la tabla de creditoDetalle ##
                                    
                                    $pro_comision0 = 0;
                                    $comisionEmpresa0 = 0;
    
                                    $idCredito = $dato['factura'];
                                    $consultaCredito = "SELECT 
                                    cd.idCredito, 
                                    cd.idProducto,
                                    cd.precioUnitario,
                                    cd.cantidad,
                                    p.costo
                                    FROM creditodetalle cd INNER JOIN producto p ON cd.idProducto = p.cod
                                    WHERE idCredito = $idCredito GROUP BY p.cod";
    
                                    if($paqueteCr = consultar($con,$consultaCredito)){
                                        while($datCredito = mysqli_fetch_array($paqueteCr)){
    
                                            $precioU = $datCredito['precioUnitario'];
                                            $costo_producto = $datCredito['costo'];
                                            $cantidad = $datCredito['cantidad'];
    
                                            $pro_comision0 += (($precioU-$costo_producto)*($porcentaje_comision/100)*$cantidad);
                                            $comisionEmpresa0 += (($precioU-$costo_producto)*(2/100)*$cantidad);
    
                                        }
    
                                        $pro_comision = $pro_comision0;
                                        $comisionEmpresa = $comisionEmpresa0;
    
                                    }
    
    
                                }else{
    
                                    $pro_comision    = (($precioU-$costo_producto)*($porcentaje_comision/100)*$cantidad);
                                    $comisionEmpresa = (($precioU-$costo_producto)*(2/100)*$cantidad);
    
                                }
    
                                
    
                            }else{
    
                                $pro_comision    = "";
                                $comisionEmpresa = "";
    
                            }
    
                        }
    
                       
    
    
    
                        $pro_comision =number_format((float)$pro_comision, 2, '.', '');
                        $total_comisiones = $total_comisiones+$pro_comision;
                        $total_comisiones = number_format((float)$total_comisiones, 2, '.', '');
    
                        $totalComEmpresa = $totalComEmpresa + $comisionEmpresa;
                        $totalComEmpresa = number_format((float)$totalComEmpresa, 2, '.', '');
    
                
                        $codigohtml.='<tr>';
    
                            $codigohtml.='<td>'.$contador.'</td>';
                            $codigohtml.='<td>'.$dato['factura'].'</td>';
                            $codigohtml.='<td>'.$dato['codigo'].'</td> ';  
                            $codigohtml.='<td>'.saltoCadena($dato['nombre']).'</td>';
    
                            $codigohtml.='<td>'.$dato['IMEI'].'</td>';
                            $codigohtml.='<td>'.$dato['nombreChip'].'</td>';   
                            $codigohtml.='<td>'.$dato['ICCID'].'</td>';
                            
                            $codigohtml.='<td>'.$dato['cantidad'].'</td>';
                            $codigohtml.='<td>$ '.number_format((float)$dato['valor'], 2, '.', '').'</td>';
                            $codigohtml.='<td>$ '.number_format((float)$dato['importe'], 2, '.', '').'</td>';
    
                            $codigohtml.='<td>'.$tipo_comisionshow.'</td>';
                            
    
                            if ($tipoUsuario == 'a') {
                                $codigohtml.='<td>'.$porcentaje_comision.'%</td>';
                                
                            }else{
                                $codigohtml.='<td></td>';
                               
                            }
    
                            $codigohtml.='<td>$'.$pro_comision.'</td>';
    
                            $codigohtml.='<td>'.$tipov.'</td>';
                            $codigohtml.='<td>'.$dato['fecha_op'].'</td>'; 
                            $codigohtml.='<td>'.$dato['usu'].'</td>';
                            $codigohtml.='<td>'.$nombreempresa.'</td>';
    
                            if ($tipoUsuario == 'a') {
                                $codigohtml.='<td>2%</td>';
                                $codigohtml.='<td>$'.$comisionEmpresa.'</td>';
                            }
    
                        $codigohtml.='</tr>';
                            
                    }


                    $codigohtml .= '<tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>TOTAL COMISIONES</td>
            <td colspan="5">$'.$total_comisiones.'</td>';

            if ($tipoUsuario == 'a') {
                $codigohtml .= '<td>TOTAL COMISION EMPRESA</td>
                <td>$'.$totalComEmpresa.'</td>';
            }


            $codigohtml .= '</tr>
            </tbody>

            </table>
            </div>
            <p>&nbsp;</p>
            </body>
            </html>';
            return $codigohtml;

        }


    }
    

       
    }




    function tabularCreditoApartado($consultaCompleta){

        include("host.php");

        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB))
        {
            $codigohtml = '<table class="tblLisado">
            <thead>
            <tr> 
            
                <th>No/Ticket</th> 
                <th>Cliente</th> 
                <th>Teléfono</th> 
                <th>Correo</th>
                <th>Nombre Producto</th>
                <th>ICCID</th>
                <th>IMEI</th>
                <th>Total</th>
                <th>A cuenta</th>
                <th>Resta</th>
                <th>Detalle Productos</th>
                <th>Detalle Pagos</th>
                <th>Agregar Pago</th>
                <th>Estatus</th>  

            </tr>
            </thead>
            <tbody>';


            if($paquete = consultar($con,$consultaCompleta)){

                while($dato = mysqli_fetch_array($paquete)){
                    $abono = 0;
                    
                    $total = $dato['total'];
                    $estatus = $dato['estatus'];

                    switch ($estatus) {
                        case 0:
                            $botonEstatus = '<span class="label label-important">PENDIENTE</span>';
                            break;
                        case 1:
                            $botonEstatus = '<span class="label label-success">PAGADO</span>';
                            break;
                    }

                    ## Obtener suma total Abonos y restante ##
                    $idCA = $dato['cod'];
                   
                    $consultaAbono = "SELECT SUM(abono) AS abono FROM creditopago WHERE idCredito = '$idCA' ";
                    if($paqueteAbono = consultar($con,$consultaAbono)){

                        $datoAbono = mysqli_fetch_array($paqueteAbono);
                        $abono = $datoAbono['abono'];


                    }else{
                        $abono = 0;
                    }
                    
                    $restante = $total - $abono;
                    ##############################
                   

                    if($estatus == '0'){
                        $botonProductos = '<a  href="#" onclick="verProdcutos('.$idCA.')" <span class="label label-info ">VER<br> PRODUCTOS</span></a>';
                        $botonPagos     = '<a  href="#" onclick="verPagos('.$idCA.')" <span class="label label-info ">VER<br> PAGOS</span></a>';
                        $botonEnviar    = '<a  href="#" onclick="enviar('.$idCA.')" <span class="label label-info ">AGREGAR <br> PAGO</span>';
                       
                    }else{

                        $botonProductos = '<a  href="#" onclick="verProdcutos('.$idCA.')" <span class="label label-info">VER <br> PRODUCTOS</span></a>';
                        $botonPagos     = '<a  href="#" onclick="verPagos('.$idCA.')" <span class="label label-info">VER<br> PAGOS</span></a>';
                        $botonEnviar    = '';
                      

                    }



                    $codigohtml.='<tr>';

                        
                        $codigohtml.='<td>'.$dato['cod'].'</td>';
                        $codigohtml.='<td>'.utf8_encode($dato['nombreCliente']).'</td> ';  
                        $codigohtml.='<td>'.$dato['telefono'].'</td>';

                        $codigohtml.='<td>'.saltoCadena($dato['correo']).'</td>';
                        $codigohtml.='<td>'.saltoCadena(utf8_encode($dato['nombreProd'])).'</td>';
                        $codigohtml.='<td>'.saltoCadena($dato['iccid']).'</td>';
                        $codigohtml.='<td>'.saltoCadena($dato['imei']).'</td>';   
                        $codigohtml.='<td>$ '.number_format((float)$dato['total'], 2, '.', '').'</td>';
                            
                        $codigohtml.='<td>$ '.number_format((float)$abono, 2, '.', '').'</td>';
                        $codigohtml.='<td>$ '.number_format((float)$restante, 2, '.', '').'</td>';



                        $codigohtml.='<td>'.$botonProductos.'</td>';
                        $codigohtml.='<td>'.$botonPagos.'</td>';
                        $codigohtml.='<td>'.$botonEnviar.'</td>';
                        $codigohtml.='<td>'.$botonEstatus.'</td>';
                       

                    $codigohtml.='</tr>';

                }

            }else{
                $codigohtml = "";
            }

        }

        return $codigohtml;

    }

    // function tabularCAProdcutos($idCa)
    // {

    //     include("host.php");

    //     if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) {
    //         $codigohtml = '<table class="tblLisado">
    //         <thead>
    //         <tr> 
    //             <th>No</th> 
    //             <th>Codigo Producto</th> 
    //             <th>Nombre Producto</th>
    //             <th>ICCID</th>
    //             <th>IMEI</th>
    //             <th>Cantidad</th>
    //             <th>Precio Unitario</th>
    //             <th>Total</th>
    //         </tr>
    //         </thead>
    //         <tbody>';


    //         $consultaProd = "SELECT 
    //         cd.idProducto AS codigo,
    //         p.nom AS nombreProd,
    //         cd.precioUnitario AS precioUnitario,
    //         cd.precioProducto AS precioProducto,
    //         cd.cantidad AS cantidad,
    //         cd.iccid AS iccid,
    //         cd.imei AS imei 
    //         FROM creditodetalle cd
    //         LEFT JOIN producto p 
    //         ON cd.idProducto = p.cod
    //         WHERE cd.idCredito = '$idCa'
    //         GROUP BY cd.id";

    //         if($paqueteProd = consultar($con,$consultaProd)){
    //             $contador = 0;

    //             while($dato = mysqli_fetch_array($paqueteProd)){
    //                 $contador++;

    //                 $codigohtml.='<tr>';
                        
    //                     $codigohtml.='<td>'.$contador.'</td>';
    //                     $codigohtml.='<td>'.saltoCadena(utf8_encode($dato['codigo'])).'</td> ';  
    //                     $codigohtml.='<td>'.saltoCadena(utf8_encode($dato['nombreProd'])).'</td>';
    //                     $codigohtml.='<td>'.saltoCadena($dato['iccid']).'</td>';
    //                     $codigohtml.='<td>'.saltoCadena($dato['imei']).'</td>';   
    //                     $codigohtml.='<td>'.$dato['cantidad'].'</td>';
                            
    //                     $codigohtml.='<td>$ '.number_format((float)$dato['precioUnitario'], 2, '.', '').'</td>';
    //                     $codigohtml.='<td>$ '.number_format((float)$dato['precioProducto'], 2, '.', '').'</td>';

    //                 $codigohtml.='</tr>';

    //             }                

    //         }else{
    //             $codigohtml = "";
    //         }
    //     }
    //     return $codigohtml;

    // }

    function tabularCAPagos($idCa)
    {

        include("host.php");

        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) {
            $codigohtml = '<table class="tblLisado">
            <thead>
            <tr> 
                <th>#</th> 
                <th>No/Ticket</th> 
                <th>Abono</th>
                <th>Fecha</th>
            </tr>
            </thead>
            <tbody>';


            $consultaProd = "SELECT * FROM creditopago WHERE idCredito = '$idCa'";

            if($paqueteProd = consultar($con,$consultaProd)){
                $contador = 0;

                while($dato = mysqli_fetch_array($paqueteProd)){
                    $contador++;

                    $codigohtml.='<tr>';
                        
                        $codigohtml.='<td>'.$contador.'</td>';
                        $codigohtml.='<td>'.$idCa.'</td> ';  
                        $codigohtml.='<td>$ '.number_format((float)$dato['abono'], 2, '.', '').'</td>';  
                        $codigohtml.='<td>'.$dato['fechaPago'].'</td>';

                    $codigohtml.='</tr>';

                }                

            }else{
                $codigohtml = "";
            }
        }
        return $codigohtml;

    }




    

function tabularCAProdcutos($idCa, $ti_usu)
    {

        include("host.php");
        $jo="";

        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) {
            $codigohtml = '<table class="tblLisado">
            <thead>
            <tr> 
                <th>No</th> 
                <th>Codigo Producto</th>
                <th>Codigo Producto Chip</th>
                <th>Nombre Producto</th>
                <th>ICCID</th>
                <th>IMEI</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
                <th>Cancelar</th>
                <th>Estatus</th>
                <th>Cambiar</th>
            </tr>
            </thead>
            <tbody>';


            $consultaProd = "SELECT 
            cd.idProducto AS codigo,
            cd.idProductoChip AS codigoChip,
            cd.idCredito AS credito,
            cd.estatus AS estatuscd,
            p.nom AS nombreProd,
            cd.precioUnitario AS precioUnitario,
            cd.precioProducto AS precioProducto,
            cd.cantidad AS cantidad,
            cd.iccid AS iccid,
            cd.imei AS imei,
            cd.estatus AS Estatuscd,
            cr.estatus AS estatus
            FROM creditodetalle cd
            LEFT JOIN producto p 
            ON cd.idProducto = p.cod
            LEFT JOIN credito cr
            ON  cd.idCredito = cr.id 
            WHERE cd.idCredito = '$idCa'
            GROUP BY cd.id";

            if($paqueteProd = consultar($con,$consultaProd)){
                $contador = 0;

                while($dato = mysqli_fetch_array($paqueteProd)){
                   
                    $contador++;
                    $iccidenviar=$dato['iccid'];
                    $imeienviar=$dato['imei'];
                    $esta=$dato['estatus'];
                    $estacd=$dato['estatuscd'];
                    $idp=$dato['codigo'];
                    $idc=$dato['credito'];
                    $idusu=$ti_usu;
                    // $iccidenviar = (string) $iccidenviar;
                    // echo "<br>".$idp;
                    if($esta==0 and $estacd=="En Lista")
                    {
                        // $encabezado='<th>Cancelar</th>';
                    $botonCancelar = "<a  href=\"#\" onclick=\"CancelarProducto1('".$idp."','".$idc."','".$idusu."','".$imeienviar."','".$iccidenviar."')\" <span class=\"label label-info\">Cancelar<br> PRODUCTO</span></a>";
                      // $botonCancelar = <span onClick="dataUser(3,'admin');" style="cursor: pointer">Ver Usuario</span>;
                     
                    // escapar las comillas dobles para poder ponerlas dentro de las comillas del onclick y poder enviar cadena  y las otras comillas simples las puedes dejar igual o escaparlas también
                    $botonCambiar = "<a  href=\"#\" onclick=\"CambiarProducto('".$idp."','".$idc."','".$idusu."','".$imeienviar."','".$iccidenviar."')\" <span class=\"label label-info\">Cambiar<br> PRODUCTO</span></a>";
                    // $botonCambiar="<input type=\"button\" name=\"agregar\" id=\"agregar\" value=\"Agregar\" class=\"boton\" onClick=\"CambiarProducto('".$idp."','".$idc."','".$idusu."','".$imeienviar."','".$iccidenviar."')\" />";
                    $btncancelartodos= "<a  href='#' onclick='Cancelartodos(".$idc.",".$idusu.")' <span class='label label-info'>Cancelar<br> PRODUCTO</span></a>";
                    } 
                    else
                    {
                        // $encabezado='';
                        $botonCancelar = '';
                        $checks = '';  
                        $botonCambiar='';
                        $btncancelartodos='';
                    }

                    $codigohtml.='<tr>';
                        
                        $codigohtml.='<td>'.$contador.'</td>';
                        $codigohtml.='<td>'.saltoCadena(utf8_encode($dato['codigo'])).'</td> ';
                        $codigohtml.='<td>'.saltoCadena(utf8_encode($dato['codigoChip'])).'</td> ';

                        $codigohtml.='<td>'.saltoCadena(utf8_encode($dato['nombreProd'])).'</td>';
                        $codigohtml.='<td>'.saltoCadena($dato['iccid']).'</td>';
                        $codigohtml.='<td>'.saltoCadena($dato['imei']).'</td>';   
                        $codigohtml.='<td>'.$dato['cantidad'].'</td>';
                            
                        $codigohtml.='<td>$ '.number_format((float)$dato['precioUnitario'], 2, '.', '').'</td>';
                        $codigohtml.='<td>$ '.number_format((float)$dato['precioProducto'], 2, '.', '').'</td>';
                        $codigohtml.='<td>'.$botonCancelar.'</td>';
                      $codigohtml.='<td>'.saltoCadena($dato['Estatuscd']).'</td>';  
                      $codigohtml.='<td>'.$botonCambiar.'</td>';
                        
                    $codigohtml.='</tr>';
             
                }    
                 // $codigohtml.=$btncancelartodos;
          

                 
                             


            }else{
                $codigohtml = "";
            }
        }
        return $codigohtml;

    }


     function validarcancelar($valorcheck,$idp,$idc,$idu,$enviaicid,$enviaimei)
    {
       include("host.php");
        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
        {
             // echo $idu;
            // echo $idp;
            // echo $idc;
            $condicioncreditodet="";
            if($enviaicid !="" and  $enviaimei !="")
            {
                  $condicioncreditodet="WHERE idProducto='$idp' and idCredito='$idc' and iccid='$enviaicid' and imei='$enviaimei'";
            }
            elseif($enviaimei !="")
            {
                 $condicioncreditodet="WHERE idProducto='$idp' and idCredito='$idc' and imei='$enviaimei'";
            }
            elseif($enviaicid !="")
            {
               $condicioncreditodet="WHERE idProducto='$idp' and idCredito='$idc' and iccid='$enviaicid'"; 
            }
            elseif($enviaicid =="" and $enviaimei =="")
            {
                 $condicioncreditodet="WHERE idProducto='$idp' and idCredito='$idc'";
            }

             $consulta="SELECT * FROM creditodetalle ".$condicioncreditodet."";
             // echo $consulta."<br>";
            if($resultado = consultar($con,$consulta))
            {
                while($dato = mysqli_fetch_array($resultado))
                {

                  
                    $preunitario=$dato['precioUnitario'];
                    $preproducto=$dato['precioProducto'];
                   
       
                
                    // echo "VALOR DE CHECK:".$valorcheck."<br>";
                #************DATOS PARA REGRESAR A STOCK *******************#
                    $producto=$dato['idProducto'];
                    $imei=$dato['imei'];
                    $iccid=$dato['iccid'];
                    $idProductoChip=$dato['idProductoChip'];
                    date_default_timezone_set("America/Mexico_City");
                    $fecha= date ("Y/m/d H:i.s",time()) ;
                    $idsuc=$idu;
                    // echo "<br>"."<br>"."<br>"."<br>";
                    // echo "PRODUCTO A REGRESAR A STOCK"."<br>";
                    // echo "ID PRODCUTO:".$producto."<br>";
                    // echo "IMEI PRODUCTO:".$imei."<br>";
                    // echo "ID PRODUCTO ICCID:".$idProductoChip."<br>";
                    // echo "ICCID PRODUCTO:".$iccid."<br>";
                    // echo "PRECIO PRODUCTO:".$preproducto."<br>";
                    // echo "SUCURSAL".$idsuc."<br>";
                }
            }

            $consultaresta="SELECT * FROM credito WHERE id='$idc' and id_sucursal='$idu' ";
            if($resultadocr = consultar($con,$consultaresta))
            {
                while($dato2 = mysqli_fetch_array($resultadocr))
                {
                  

                    $totalcr=  $dato2['total'];
                    $adelantocr= $dato2['adelanto'];
                    $restocr=  $dato2['resto'];

                    if($valorcheck == "si")
                    {
                        $comision=0.1;
                        number_format($comision);
                        $restatotalcr= $totalcr - $preproducto;
                        number_format($restatotalcr);
                        $opecomosion= $preproducto * $comision;
                        number_format($opecomosion);
                        $nuevototalcr = $restatotalcr;
                    }
                    else
                    {
                        $comision=0;
                        number_format($comision);
                        $restatotalcr= $totalcr - $preproducto;
                        number_format($restatotalcr);
                        $opecomosion= $preproducto * $comision;
                        number_format($opecomosion);
                        $nuevototalcr = $restatotalcr;

                    }

                    
                    // echo "<br>"."<br>"."<br>"."<br>";
                    // echo "CREDITO SIN CAMBIOS"."<br>";
                    // echo "COMISION POR CANCELAR PRODUCTO:".$opecomosion."<br>";
                    // echo "TOTAL CREDITO:".$totalcr."<br>";
                    // echo "ADELANTO:".$adelantocr."<br>";
                    // echo "RESTO CREDITO:".$restocr."<br>"."<br>"."<br>";

                    // echo "TOTAL CREDITO - PRECIO PRODUCTO A CANCELAR:".$nuevototalcr."<br>";

                    if($nuevototalcr == 0)
                    {
                        $nuevototalcr=0;

                        // $restaopnue= $opecomosion - $nuevototalcr;
                        // echo $nuevototalcr."<br>";
                        $sumanuevototal= $nuevototalcr + $opecomosion;
                        // echo "NUEVO TOTAL:".$sumanuevototal."<br>";
                        $restaresto= $adelantocr - $sumanuevototal;
                        // echo "NUEVO RESTO CREDITO:".$restaresto."<br>";

                        $actualizatotalresto="UPDATE credito set total='$sumanuevototal', resto='$restaresto' WHERE id='$idc' AND id_sucursal='$idu'";
                        $actutores= actualizar($con,$actualizatotalresto);

                        $actualizacreddetalle="UPDATE creditodetalle set precioUnitario='$opecomosion', precioProducto='$opecomosion', estatus='Cancelado' where idCredito='$idc' and idProducto='$idp' ";
                        $actualizacredet= actualizar($con,$actualizacreddetalle);
                        
                    }
                    else
                    {
                        $sumanuevototalcr= $nuevototalcr + $opecomosion;
                         // echo "NUEVO TOTAL:".$sumanuevototalcr."<br>";
                         $restatotaladelanto= $sumanuevototalcr - $adelantocr;
                        number_format($restatotaladelanto);
                        // echo "NUEVO RESTO:".$restatotaladelanto."<br>";

                        $actualizatotalresto="UPDATE credito set total='$sumanuevototalcr', resto='$restatotaladelanto' WHERE id='$idc' AND id_sucursal='$idu'";
                        $actutores= actualizar($con,$actualizatotalresto);

                        $actualizacreddetalle="UPDATE creditodetalle set precioUnitario='$opecomosion', precioProducto='$opecomosion', estatus='Cancelado' where idCredito='$idc' and idProducto='$idp' ";
                        $actualizacredet= actualizar($con,$actualizacreddetalle);


                    }

                }
            }
         
            if($imei != "" and $iccid != "")
            {
                $sql = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                VALUES ('$producto', 'IMEI', '$imei','0','$fecha','s','$idsuc')";
                // $result2 = mysqli_query($con,$sql) or die("Couldn't execute query.".mysql_error()); 
                $agregaimei = agregar($con,$sql);
           
                $sql2 = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                VALUES ('$idProductoChip', 'ICCID', '$iccid','0','$fecha','s','$idsuc')";
                $agregaiccid = agregar($con,$sql2);
                // $result3 = mysqli_query($con,$sql2) or die("Couldn't execute query.".mysql_error()); 

                $actualizaproductoimei="UPDATE producto SET cantidad= cantidad+1 where cod='$producto' AND id_sucursal='$idsuc'";
                $actuproimei= actualizar($con,$actualizaproductoimei);

                $actualizaproductoiccid="UPDATE producto SET cantidad= cantidad+1 where cod='$idProductoChip' AND id_sucursal='$idsuc'";
                $actuproiccid= actualizar($con,$actualizaproductoiccid);

                   $finproceso="";
                    if($actuproiccid)
                    {
                        $finproceso="si";
                        return $finproceso;
                    }
                    else
                    {
                        $finproceso="no";
                        return $finproceso;
                    }
            }
            elseif ($imei != "") 
            {
                $sql3 = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                VALUES ('$producto', 'IMEI', '$imei','0','$fecha','s','$idsuc')";
                // $result2 = mysqli_query($con,$sql) or die("Couldn't execute query.".mysql_error()); 
                $agregaimei2 = agregar($con,$sql3);

                $actualizaproductoimei="UPDATE producto SET cantidad= cantidad+1 where cod='$producto' AND id_sucursal='$idsuc'";
                $actuproimei= actualizar($con,$actualizaproductoimei);
                   $finproceso="";
                    if($actuproimei)
                    {
                        $finproceso="si";
                        return $finproceso;
                    }
                    else
                    {
                        $finproceso="no";
                        return $finproceso;
                    }
                
            }
            elseif ($iccid != "") 
            {
                $idprochip=$producto;
                $sql4 = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                VALUES ('$idprochip', 'ICCID', '$iccid','0','$fecha','s','$idsuc')";
                $agregaiccid = agregar($con,$sql4);

                $actualizaproductoiccid="UPDATE producto SET cantidad= cantidad+1 where cod='$idprochip' AND id_sucursal='$idsuc'";
                $actuproiccid= actualizar($con,$actualizaproductoiccid);
                   $finproceso="";
                    if($actuproiccid)
                    {
                        $finproceso="si";
                        return $finproceso;
                    }
                    else
                    {
                        $finproceso="no";
                        return $finproceso;
                    }

            }
            elseif ($imei == "" and $iccid == "")
            {
                $actualizaproductoaccesorio="UPDATE producto SET cantidad= cantidad+1 where cod='$producto' AND id_sucursal='$idsuc'";
                $actuproaccesorio= actualizar($con,$actualizaproductoaccesorio);
                   $finproceso="";
                    if($actuproaccesorio)
                    {
                        $finproceso="si";
                        return $finproceso;
                    }
                    else
                    {
                        $finproceso="no";
                        return $finproceso;
                    }

            }
         
        }

    }

    function validarcambios($Codimei,$Codiccid,$codpronompro,$ids,$idprocam,$idcrecam,$iccidenvia,$imeenvia,$iccid2,$valorcheck)
    {
        
        if($Codimei !="" and $Codiccid !="")
        {
            $retornar= productoconiccideimei($Codimei,$Codiccid,$codpronompro,$ids,$idprocam,$idcrecam,$iccidenvia,$imeenvia,$iccid2,$valorcheck);
            
            if($retornar == "si")
            {
                return $retornar;
            }
            elseif($retornar == "no")
            {
                return $retornar;
            }
            elseif($retornar == "no hay existencia")
            {
                return $retornar;
            }

        }
        elseif($Codimei !="" and $Codiccid =="")
        {
            $retornar= productoconimei($Codimei,$Codiccid,$codpronompro,$ids,$idprocam,$idcrecam,$iccidenvia,$imeenvia,$iccid2,$valorcheck);
            
            if($retornar == "si")
            {
                return $retornar;
            }
            elseif($retornar == "no")
            {
                return $retornar;
            }
            elseif($retornar == "no hay existencia")
            {
                return $retornar;
            }
        }
        elseif($iccid2 !="")
        {
            $retornar= productochip($Codimei,$Codiccid,$codpronompro,$ids,$idprocam,$idcrecam,$iccidenvia,$imeenvia,$iccid2,$valorcheck);
            
            if($retornar == "si")
            {
                return $retornar;
            }
            elseif($retornar == "no")
            {
                return $retornar;
            }
            elseif($retornar == "no hay existencia")
            {
                return $retornar;
            }
        }
        elseif($codpronompro !="" and $Codimei =="" and $Codiccid =="")
        {
            $retornar= productoaccesorioreparacion($Codimei,$Codiccid,$codpronompro,$ids,$idprocam,$idcrecam,$iccidenvia,$imeenvia,$iccid2,$valorcheck);
            
            if($retornar == "si")
            {
                return $retornar;
            }
            elseif($retornar == "no")
            {
                return $retornar;
            }
            elseif($retornar == "no hay existencia")
            {
                return $retornar;
            }
        }

    }
function productoconiccideimei($Codimei,$Codiccid,$codpronompro,$ids,$idprocam,$idcrecam,$iccidenvia,$imeenvia,$iccid2,$valorcheck)
    {
        include("host.php");
        // echo "ENTRO EN LA PRIMERA VALIDACION:------>Codimei != and Codiccid !="."<br>"."<br>";
        // echo "VALOR DE CHECK:".$valorcheck."<br>";
        // echo "ICCI QUE ENVIA EL BOTON:".$iccidenvia."<br>";
        // echo "IMEI QUE ENVIA EL BOTON:".$imeenvia."<br>";
        // echo "IDPRODUCCTO QUE ENVIA EL BOTON:".$idprocam."<br>";
        // echo "IDCREDITO QUE ENVIA EL BOTON:".$idcrecam."<br>";
        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
        {
            $cantidad="";
            $consultaCam = "SELECT  * FROM producto WHERE cod='$codpronompro'   AND id_sucursal='$ids' ";
            if($paqueteCam = consultar($con,$consultaCam))
            {
                while($dato = mysqli_fetch_array($paqueteCam))
                { 
                    $venta=  $dato['venta']; 
                    // $nom= $dato['nom'];
                    $cantidad=  $dato['cantidad'];
                    // echo "cantidad telefono:".$cantidad."<br>";
                }
            }

            $consultachip="SELECT id_producto, COUNT(*) AS cantidadchips FROM codigo_producto WHERE identificador='$Codiccid' AND id_sucursal='$ids'"; 
            if($paquetechip = consultar($con,$consultachip))
            {
                while($datooo = mysqli_fetch_row($paquetechip))
                {    $idproductochipp= $datooo[0];
                    $cantidadchip=  $datooo[1];
                    // echo "identificadror iccid:".$Codiccid."<br>";
                    // echo "cantidad de chips:".$cantidadchip."<br>";
                }
            }
            if($cantidad > 0 and $cantidadchip > 0)
            {
                // echo "SI HAY EXISTENCIAS DE LOS DOS PRODUCTOS"."<br>";
                // echo "idSucursal:".$ids."<br>";
                // echo "Codigo Producto de nuevo producto:".$codpronompro."<br>";
                // echo "IMEI nuevo producto:".$Codimei."<br>";
                // echo "Codigo ICCID Producto de nuevo CHIP:".$idproductochipp."<br>";
                // echo "ICCID nuevo producto:".$Codiccid."<br>";
                // echo "precio nuevo producto:".$venta."<br>";

                $consultacodpro="SELECT * FROM codigo_producto WHERE id_producto='$codpronompro' and identificador='$Codimei' and id_sucursal='$ids' ";
                if($resultadocp = consultar($con,$consultacodpro))
                {
                    while($dato2 = mysqli_fetch_array($resultadocp))
                    {
                       
                        $id_producto=  $dato2['id_producto'];
                        $tipo_ident= $dato2['tipo_identificador'];
                        $identificador=  $dato2['identificador'];
                        // echo "TipoI dentificador imei:".$tipo_ident."<br>";
                    }
                }

                $consultacodprochip="SELECT * FROM codigo_producto WHERE identificador='$Codiccid' and id_sucursal='$ids' ";
                if($resultadocpchip = consultar($con,$consultacodprochip))
                {
                    while($dato3 = mysqli_fetch_array($resultadocpchip))
                    {
               
                        $id_productochip=  $dato3['id_producto'];
                        $tipo_identchip= $dato3['tipo_identificador'];
                        $identificadorchip=  $dato3['identificador'];
                        // echo "TipoI dentificador icid:".$tipo_identchip."<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
                    }
                }
                $condicioncreditodet="";
                if($iccidenvia !="" and  $imeenvia !="")
                {
                      $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam' and iccid='$iccidenvia' and imei='$imeenvia'";
                }
                elseif($imeenvia !="")
                {
                     $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam' and imei='$imeenvia'";
                }
                elseif($iccidenvia !="")
                {
                   $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam' and iccid='$iccidenvia'"; 
                }
                elseif($iccidenvia =="" and $imeenvia =="")
                {
                     $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam'";
                }
                $consultaregresarstock="SELECT * FROM creditodetalle ".$condicioncreditodet."";
                if($resultadoregrestock = consultar($con,$consultaregresarstock))
                {
                    while($dato4 = mysqli_fetch_array($resultadoregrestock))
                    {
                   
                        // $id_creditoimei=  $dato4['idCredito'];
                        $idProductoimei= $dato4['idProducto'];
                        $proime=  $dato4['imei'];
                        $idProductoiccid= $dato4['idProductoChip'];
                        $proiccid= $dato4['iccid'];
                        $precioProducto= $dato4['precioProducto'];
                        date_default_timezone_set("America/Mexico_City");
                        $fecha= date ("Y/m/d H:i.s",time());

                        // echo "TipoI dentificador icid:".$tipo_identchip."<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "PRODUCTOS A REGRESAR A ESTOCK"."<br>";
                        // echo "idproductoimei:".$idProductoimei."<br>";
                        // echo "IMEI:".$proime."<br>";
                        // echo "PRECIO PRODUCTO:".$precioProducto."<br>";

                        // echo "idproductoICCID:".$idProductoiccid."<br>";
                        // echo "ICCID:".$proiccid."<br>";
                    }
                }

                $consultaresta="SELECT * FROM credito WHERE id='$idcrecam' and id_sucursal='$ids' ";
                if($resultadocr = consultar($con,$consultaresta))
                {
                    while($dato5 = mysqli_fetch_array($resultadocr))
                    {

                      
                        $preciopro=$precioProducto;
                        $totalcr=  $dato5['total'];
                        $adelantocr= $dato5['adelanto'];
                        $restocr=  $dato5['resto'];
                        $precionuevopro=$venta;
                        // echo "total".$totalcr."<br>";
                        if($valorcheck =="si")
                        {


                        $comision=0.1;
                        number_format($comision);
                      
                        $comisioncambio= $preciopro * $comision;
                        $nuevototalcr=$totalcr - $preciopro;

                        $sumacomtotal=$nuevototalcr + $comisioncambio + $precionuevopro;

                        $nuevoresto= $sumacomtotal - $adelantocr;
                        }
                        else
                        {
                        $comision=0;
                        number_format($comision);
                        $comisioncambio= $preciopro * $comision;
                        $nuevototalcr=$totalcr - $preciopro;

                        $sumacomtotal=$nuevototalcr + $comisioncambio + $precionuevopro;

                        $nuevoresto= $sumacomtotal - $adelantocr;

                        }
                        $nuevoprecioproducto=$precionuevopro + $comisioncambio;
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "OPERACIONES:"."<br>";
                        // echo "TOTAL CREDITO SIN CAMBIOS:".$totalcr."<br>";
                        // echo "ADELANTO CREDITO SIN CAMBIOS:".$adelantocr."<br>";
                        // echo "RESTO CREDITO SIN CAMBIOS:".$restocr."<br>";
                        // echo "<br>";



                        // echo "PRECIO DEL PRODUCTO A CAMBIAR:".$preciopro."<br>";
                        // echo "COMISION DEL PRODUCTO A CAMBIAR:".$comisioncambio."<br>";
                        // echo "<br>";
                         
                        // echo "PRECIO NUEVO PRODUCTO:".$precionuevopro."<br>";
                        // echo "<br>";
                        // echo "NUEVO TOTAL1= RESTA TOTAL CREDITO - PRECIO DEL PRODUCTO A CAMBIAR :".$nuevototalcr."<br>";
                        // echo "SUMA DE NUEVO TOTAL1 +COMISION + NUEVO PRODCUTO = NUEVO TOTAL2 :".$sumacomtotal."<br>";
                        // echo "NUEVO RESTO:".$nuevoresto."<br>";
                        $actualizacredito="";
                        $actualizacredito="UPDATE credito SET total='$sumacomtotal', resto='$nuevoresto' where id='$idcrecam' AND id_sucursal='$ids'";
                        $actucredi= actualizar($con,$actualizacredito);

                        if($proime !="" and $proiccid !="")
                        {
                            // echo "los dos campos estan llenos";
                            $sql = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                            VALUES ('$idProductoimei', 'IMEI', '$proime','0','$fecha','s','$ids')";
                           
                            $agregaimei = agregar($con,$sql);
                       
                            $sql2 = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                            VALUES ('$idProductoiccid', 'ICCID', '$proiccid','0','$fecha','s','$ids')";
                            $agregaiccid = agregar($con,$sql2);

                            $actualizaproductoimei="UPDATE producto SET cantidad= cantidad+1 where cod='$idProductoimei' AND id_sucursal='$ids'";
                            $actuproimei= actualizar($con,$actualizaproductoimei);

                            $actualizaproductoiccid="UPDATE producto SET cantidad= cantidad+1 where cod='$idProductoiccid' AND id_sucursal='$ids'";
                            $actuproiccid= actualizar($con,$actualizaproductoiccid);
                        }
                        elseif($proime !="")
                        {
                            // echo "solo IMEI tiene el prodcuto";
                             $sql = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                            VALUES ('$idProductoimei', 'IMEI', '$proime','0','$fecha','s','$ids')";
                            // $result2 = mysqli_query($con,$sql) or die("Couldn't execute query.".mysql_error()); 
                            $agregaimei = agregar($con,$sql);
                            $actualizaproductoimei="UPDATE producto SET cantidad= cantidad+1 where cod='$idProductoimei' AND id_sucursal='$ids'";
                            $actuproimei= actualizar($con,$actualizaproductoimei);

                        }
                        elseif($proiccid !="")
                        {
                                $idproicid =$idProductoimei;
                            // echo "solo ICCID tiene el prodcuto";
                             $sql2 = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                            VALUES ('$idproicid', 'ICCID', '$proiccid','0','$fecha','s','$ids')";
                            $agregaiccid = agregar($con,$sql2);

                            $actualizaproductoiccid="UPDATE producto SET cantidad= cantidad+1 where cod='$idproicid' AND id_sucursal='$ids'";
                            $actuproiccid= actualizar($con,$actualizaproductoiccid);
                        }elseif($proime =="" and $proiccid =="") 
                        {
                            // echo "es un accesorio o refaccion";

                            $actualizaproductoacc="UPDATE producto SET cantidad= cantidad+1 where cod='$idprocam' AND id_sucursal='$ids'";
                            $actuproacc= actualizar($con,$actualizaproductoacc);

                        }  

             
                        

                        $actualizaproducdetalle="UPDATE creditodetalle SET idProducto='$codpronompro',precioUnitario='$nuevoprecioproducto',precioProducto='$nuevoprecioproducto',
                        iccid='$identificadorchip', imei='$Codimei', idProductoChip='$id_productochip' where idProducto='$idprocam' AND idCredito='$idcrecam'";
                        $actuprodet= actualizar($con,$actualizaproducdetalle);
                        
                        $actualizastocknuevoproductotelefono="UPDATE producto SET cantidad= cantidad-1 where cod='$codpronompro' AND id_sucursal='$ids'";
                        $actunuevostocktelefono= actualizar($con,$actualizastocknuevoproductotelefono);

                        $actualizastocknuevoproductochip="UPDATE producto SET cantidad= cantidad-1 where cod='$idproductochipp' AND id_sucursal='$ids'";
                        $actunuevostockchip= actualizar($con,$actualizastocknuevoproductochip);

                        $eliminarimei   = "DELETE FROM codigo_producto WHERE identificador  =  '$Codimei' AND id_sucursal='$ids' ";
                        $paqElimiarimei = eliminar($con,$eliminarimei);

                        $eliminariccid   = "DELETE FROM codigo_producto WHERE identificador  =  '$Codiccid' AND id_sucursal='$ids' " ;
                        $paqElimiariccid = eliminar($con,$eliminariccid);
                            
                            $finproceso="";
                            if($paqElimiariccid)
                            {
                                $finproceso="si";
                                return $finproceso;
                            }
                            else
                            {
                                $finproceso="no";
                                return $finproceso;
                            }
                                                            
                    }
                }
            }//llave de existencias
             else
            {   
                $noexistencia="";
                $noexistencia="no hay existencia";
                return $noexistencia;
            }
        }
    }

    function productoconimei($Codimei,$Codiccid,$codpronompro,$ids,$idprocam,$idcrecam,$iccidenvia,$imeenvia,$iccid2,$valorcheck)
    {
         include("host.php");
        // echo "ENTRO EN LA 2 VALIDACION: -------->Codimei != and $Codiccid == "."<br>"."<br>";
        // echo "VALOR DE CHECK:".$valorcheck."<br>";
        // echo "ICCI QUE ENVIA EL BOTON:".$iccidenvia."<br>";
        // echo "IMEI QUE ENVIA EL BOTON:".$imeenvia."<br>";
        // echo "IDPRODUCCTO QUE ENVIA EL BOTON:".$idprocam."<br>";
        // echo "IDCREDITO QUE ENVIA EL BOTON:".$idcrecam."<br>";
        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
        {
            $consultaCam = "SELECT  * FROM producto WHERE cod='$codpronompro'   AND id_sucursal='$ids' ";
            if($paqueteCam = consultar($con,$consultaCam))
            {
                while($dato = mysqli_fetch_array($paqueteCam))
                { 
                    $venta=  $dato['venta']; 
                    // $nom= $dato['nom'];
                    $cantidad=  $dato['cantidad'];
                    // echo "cantidad telefono:".$cantidad."<br>";
                }
            }
            if($cantidad > 0 )
            {
                // echo "SI HAY EXISTENCIA DEL PRODUCTO"."<br>";
                // echo "idSucursal:".$ids."<br>";
                // echo "Codigo Producto de nuevo producto:".$codpronompro."<br>";
                // echo "IMEI nuevo producto:".$Codimei."<br>";
                // echo "precio nuevo producto:".$venta."<br>";

                $condicioncreditodet="";
                if($iccidenvia !="" and  $imeenvia !="")
                {
                      $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam' and iccid='$iccidenvia' and imei='$imeenvia'";
                }
                elseif($imeenvia !="")
                {
                     $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam' and imei='$imeenvia'";
                }
                elseif($iccidenvia !="")
                {
                   $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam' and iccid='$iccidenvia'"; 
                }
                elseif($iccidenvia =="" and $imeenvia =="")
                {
                     $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam'";
                }

                $consultaregresarstock="SELECT * FROM creditodetalle ".$condicioncreditodet."";
                if($resultadoregrestock = consultar($con,$consultaregresarstock))
                {
                    while($dato4 = mysqli_fetch_array($resultadoregrestock))
                    {
                   
                        // $id_creditoimei=  $dato4['idCredito'];
                        $idProductoimei= $dato4['idProducto'];
                        $proime=  $dato4['imei'];
                        $idProductoiccid= $dato4['idProductoChip'];
                        $proiccid= $dato4['iccid'];
                        $precioProducto= $dato4['precioProducto'];
                        date_default_timezone_set("America/Mexico_City");
                        $fecha= date ("Y/m/d H:i.s",time());

                        // echo "TipoI dentificador icid:".$tipo_identchip."<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "PRODUCTOS A REGRESAR A ESTOCK"."<br>";
                        // echo "idproductoimei:".$idProductoimei."<br>";
                        // echo "IMEI:".$proime."<br>";
                        // echo "PRECIO PRODUCTO:".$precioProducto."<br>";

                        // echo "idproductoICCID:".$idProductoiccid."<br>";
                        // echo "ICCID:".$proiccid."<br>";
                    }
                }

                $consultaresta="SELECT * FROM credito WHERE id='$idcrecam' and id_sucursal='$ids' ";
                if($resultadocr = consultar($con,$consultaresta))
                {
                    while($dato5 = mysqli_fetch_array($resultadocr))
                    {

                      
                        $preciopro=$precioProducto;
                        $totalcr=  $dato5['total'];
                        $adelantocr= $dato5['adelanto'];
                        $restocr=  $dato5['resto'];
                        $precionuevopro=$venta;
                        // echo "total".$totalcr."<br>";
                        if($valorcheck =="si")
                        {


                        $comision=0.1;
                        number_format($comision);
                      
                        $comisioncambio= $preciopro * $comision;
                        $nuevototalcr=$totalcr - $preciopro;

                        $sumacomtotal=$nuevototalcr + $comisioncambio + $precionuevopro;

                        $nuevoresto= $sumacomtotal - $adelantocr;
                        }
                        else
                        {
                        $comision=0;
                        number_format($comision);
                        $comisioncambio= $preciopro * $comision;
                        $nuevototalcr=$totalcr - $preciopro;

                        $sumacomtotal=$nuevototalcr + $comisioncambio + $precionuevopro;

                        $nuevoresto= $sumacomtotal - $adelantocr;

                        }
                        $nuevoprecioproducto=$precionuevopro + $comisioncambio;
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "OPERACIONES:"."<br>";
                        // echo "TOTAL CREDITO SIN CAMBIOS:".$totalcr."<br>";
                        // echo "ADELANTO CREDITO SIN CAMBIOS:".$adelantocr."<br>";
                        // echo "RESTO CREDITO SIN CAMBIOS:".$restocr."<br>";
                        // echo "<br>";



                        // echo "PRECIO DEL PRODUCTO A CAMBIAR:".$preciopro."<br>";
                        // echo "COMISION DEL PRODUCTO A CAMBIAR:".$comisioncambio."<br>";
                        // echo "<br>";
                         
                        // echo "PRECIO NUEVO PRODUCTO:".$precionuevopro."<br>";
                        // echo "<br>";
                        // echo "NUEVO TOTAL1= RESTA TOTAL CREDITO - PRECIO DEL PRODUCTO A CAMBIAR :".$nuevototalcr."<br>";
                        // echo "SUMA DE NUEVO TOTAL1 +COMISION + NUEVO PRODCUTO = NUEVO TOTAL2 :".$sumacomtotal."<br>";
                        // echo "NUEVO RESTO:".$nuevoresto."<br>";
                        $actualizacredito="";
                        $actualizacredito="UPDATE credito SET total='$sumacomtotal', resto='$nuevoresto' where id='$idcrecam' AND id_sucursal='$ids'";
                        $actucredi= actualizar($con,$actualizacredito);

                        if($proime !="" and $proiccid !="")
                        {
                            // echo "los dos campos estan llenos";
                            $sql = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                            VALUES ('$idProductoimei', 'IMEI', '$proime','0','$fecha','s','$ids')";
                           
                            $agregaimei = agregar($con,$sql);
                       
                            $sql2 = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                            VALUES ('$idProductoiccid', 'ICCID', '$proiccid','0','$fecha','s','$ids')";
                            $agregaiccid = agregar($con,$sql2);

                            $actualizaproductoimei="UPDATE producto SET cantidad= cantidad+1 where cod='$idProductoimei' AND id_sucursal='$ids'";
                            $actuproimei= actualizar($con,$actualizaproductoimei);

                            $actualizaproductoiccid="UPDATE producto SET cantidad= cantidad+1 where cod='$idProductoiccid' AND id_sucursal='$ids'";
                            $actuproiccid= actualizar($con,$actualizaproductoiccid);
                        }
                        elseif($proime !="")
                        {
                            // echo "solo IMEI tiene el prodcuto";
                             $sql = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                            VALUES ('$idProductoimei', 'IMEI', '$proime','0','$fecha','s','$ids')";
                            // $result2 = mysqli_query($con,$sql) or die("Couldn't execute query.".mysql_error()); 
                            $agregaimei = agregar($con,$sql);
                            $actualizaproductoimei="UPDATE producto SET cantidad= cantidad+1 where cod='$idProductoimei' AND id_sucursal='$ids'";
                            $actuproimei= actualizar($con,$actualizaproductoimei);

                        }
                        elseif($proiccid !="")
                        {
                            $idproicid =$idProductoimei;
                            // echo "solo ICCID tiene el prodcuto";
                             $sql2 = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                            VALUES ('$idproicid', 'ICCID', '$proiccid','0','$fecha','s','$ids')";
                            $agregaiccid = agregar($con,$sql2);

                            $actualizaproductoiccid="UPDATE producto SET cantidad= cantidad+1 where cod='$idproicid' AND id_sucursal='$ids'";
                            $actuproiccid= actualizar($con,$actualizaproductoiccid);
                        }elseif($proime =="" and $proiccid =="") 
                        {
                            // echo "es un accesorio o refaccion";

                            $actualizaproductoacc="UPDATE producto SET cantidad= cantidad+1 where cod='$idprocam' AND id_sucursal='$ids'";
                            $actuproacc= actualizar($con,$actualizaproductoacc);

                        }  

             
                        

                        $actualizaproducdetalle="UPDATE creditodetalle SET idProducto='$codpronompro',precioUnitario='$nuevoprecioproducto',precioProducto='$nuevoprecioproducto',iccid='',
                        imei='$Codimei',idProductoChip='' where idProducto='$idprocam' AND idCredito='$idcrecam'";
                        $actuprodet= actualizar($con,$actualizaproducdetalle);
                        
                        $actualizastocknuevoproductotelefono="UPDATE producto SET cantidad= cantidad-1 where cod='$codpronompro' AND id_sucursal='$ids'";
                        $actunuevostocktelefono= actualizar($con,$actualizastocknuevoproductotelefono);

                        

                        $eliminarimei   = "DELETE FROM codigo_producto WHERE identificador  ='$Codimei' AND id_sucursal='$ids' ";
                        $paqElimiarimei = eliminar($con,$eliminarimei);

                         $finproceso="";
                            if($paqElimiarimei)
                            {
                                $finproceso="si";
                                return $finproceso;
                            }
                            else
                            {
                                $finproceso="no";
                                return $finproceso;
                            }

                                                            
                    }
                }


            }//llave de existencias
             else
            {   
                $noexistencia="";
                $noexistencia="no hay existencia";
                return $noexistencia;
            }
        }

    }

    function productochip($Codimei,$Codiccid,$codpronompro,$ids,$idprocam,$idcrecam,$iccidenvia,$imeenvia,$iccid2,$valorcheck)
    {
        include("host.php");
        // echo "ENTRO EN LA TERCERA VALIDACION:------>iccid2 !="."<br>"."<br>";
        // echo "VALOR DE CHECK:".$valorcheck."<br>";
        // echo "ICCI QUE ENVIA EL BOTON:".$iccidenvia."<br>";
        // echo "IMEI QUE ENVIA EL BOTON:".$imeenvia."<br>";
        // echo "IDPRODUCCTO QUE ENVIA EL BOTON:".$idprocam."<br>";
        // echo "IDCREDITO QUE ENVIA EL BOTON:".$idcrecam."<br>";
        // echo "iccid2:".$iccid2."<br>";
        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
        {
            // $consultaCam = "SELECT  * FROM producto WHERE cod='$codpronompro'   AND id_sucursal='$ids' ";
            // if($paqueteCam = consultar($con,$consultaCam))
            // {
            //     while($dato = mysqli_fetch_array($paqueteCam))
            //     { 
            //         $venta=  $dato['venta']; 
            //         // $nom= $dato['nom'];
            //         $cantidad=  $dato['cantidad'];
            //         echo "cantidad telefono:".$cantidad."<br>";
            //     }
            // }


            $consultachip="SELECT id_producto, COUNT(*) AS cantidadchips FROM codigo_producto WHERE identificador='$iccid2' AND id_sucursal='$ids'"; 
            if($paquetechip = consultar($con,$consultachip))
            {
                while($datooo = mysqli_fetch_row($paquetechip))
                {   $idproductochipp= $datooo[0];
                    $cantidadchip=  $datooo[1];
                    // echo "identificadror iccid:".$Codiccid."<br>";
                    // echo "cantidad de chips:".$cantidadchip."<br>";
                }
            }
             $consultacodigochip = "SELECT  * FROM producto WHERE cod='$idproductochipp'   AND id_sucursal='$ids' ";
            if($paqueteCodChip = consultar($con,$consultacodigochip))
            {
                while($dato8 = mysqli_fetch_array($paqueteCodChip))
                { 
                    $ventachip=  $dato8['venta']; 
                }
            }

            if($cantidadchip > 0)
            {
                
                // echo "si hay existencai";
               
                // echo "idSucursal:".$ids."<br>";
                
                // echo "Codigo ICCID Producto de nuevo CHIP:".$idproductochipp."<br>";
                // echo "ICCID nuevo producto:".$iccid2."<br>";
                
                // echo "precio nuevo producto:".$ventachip."<br>";
                $consultacodprochip="SELECT * FROM codigo_producto WHERE identificador='$iccid2' and id_sucursal='$ids' ";
                if($resultadocpchip = consultar($con,$consultacodprochip))
                {
                    while($dato3 = mysqli_fetch_array($resultadocpchip))
                    {
               
                        $id_productochip=  $dato3['id_producto'];
                        $tipo_identchip= $dato3['tipo_identificador'];
                        $identificadorchip=  $dato3['identificador'];
                        // echo "TipoI dentificador icid:".$tipo_identchip."<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
                    }
                }
               $condicioncreditodet="";
                if($iccidenvia !="" and  $imeenvia !="")
                {
                      $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam' and iccid='$iccidenvia' and imei='$imeenvia'";
                }
                elseif($imeenvia !="")
                {
                     $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam' and imei='$imeenvia'";
                }
                elseif($iccidenvia !="")
                {
                   $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam' and iccid='$iccidenvia'"; 
                }
                elseif($iccidenvia =="" and $imeenvia =="")
                {
                     $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam'";
                }
                $consultaregresarstock="SELECT * FROM creditodetalle ".$condicioncreditodet."";
                if($resultadoregrestock = consultar($con,$consultaregresarstock))
                {
                    while($dato4 = mysqli_fetch_array($resultadoregrestock))
                    {
                   
                        // $id_creditoimei=  $dato4['idCredito'];
                        $idProductoimei= $dato4['idProducto'];
                        $proime=  $dato4['imei'];
                        $idProductoiccid= $dato4['idProductoChip'];
                        $proiccid= $dato4['iccid'];
                        $precioProducto= $dato4['precioProducto'];
                        date_default_timezone_set("America/Mexico_City");
                        $fecha= date ("Y/m/d H:i.s",time());

                        // echo "TipoI dentificador icid:".$tipo_identchip."<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "PRODUCTOS A REGRESAR A ESTOCK"."<br>";
                        // echo "idproductoimei:".$idProductoimei."<br>";
                        // echo "IMEI:".$proime."<br>";
                        // echo "PRECIO PRODUCTO:".$precioProducto."<br>";

                        // echo "idproductoICCID:".$idProductoiccid."<br>";
                        // echo "ICCID:".$proiccid."<br>";
                    }
                    $consultaresta="SELECT * FROM credito WHERE id='$idcrecam' and id_sucursal='$ids' ";
                    if($resultadocr = consultar($con,$consultaresta))
                    {
                        while($dato5 = mysqli_fetch_array($resultadocr))
                        {

                           
                            $preciopro=$precioProducto;
                            $totalcr=  $dato5['total'];
                            $adelantocr= $dato5['adelanto'];
                            $restocr=  $dato5['resto'];
                            $precionuevopro=$ventachip;
                            // echo "total".$totalcr."<br>";
                            if($valorcheck =="si")
                            {
                                $comision=0.1;
                                number_format($comision);
                                $comisioncambio= $preciopro * $comision;

                                $nuevototalcr=$totalcr - $preciopro;

                                $sumacomtotal=$nuevototalcr + $comisioncambio + $precionuevopro;

                                $nuevoresto= $sumacomtotal - $adelantocr;
                                $nuevoprecioproducto=$precionuevopro + $comisioncambio;

                            }
                            else
                            {
                                $comision=0;
                                number_format($comision);
                                $comisioncambio= $preciopro * $comision;

                                $nuevototalcr=$totalcr - $preciopro;

                                $sumacomtotal=$nuevototalcr + $comisioncambio + $precionuevopro;

                                $nuevoresto= $sumacomtotal - $adelantocr;
                                $nuevoprecioproducto=$precionuevopro + $comisioncambio;

                            }
                            // echo "<br>";
                            // echo "<br>";
                            // echo "<br>";
                            // echo "<br>";
                            // echo "OPERACIONES:"."<br>";
                            // echo "TOTAL CREDITO SIN CAMBIOS:".$totalcr."<br>";
                            // echo "ADELANTO CREDITO SIN CAMBIOS:".$adelantocr."<br>";
                            // echo "RESTO CREDITO SIN CAMBIOS:".$restocr."<br>";
                            // echo "<br>";



                            // echo "PRECIO DEL PRODUCTO A CAMBIAR:".$preciopro."<br>";
                            // echo "COMISION DEL PRODUCTO A CAMBIAR:".$comisioncambio."<br>";
                            // echo "<br>";
                             
                            // echo "PRECIO NUEVO PRODUCTO:".$precionuevopro."<br>";
                            // echo "<br>";
                            // echo "NUEVO TOTAL1= RESTA TOTAL CREDITO - PRECIO DEL PRODUCTO A CAMBIAR :".$nuevototalcr."<br>";
                            // echo "SUMA DE NUEVO TOTAL1 +COMISION + NUEVO PRODCUTO = NUEVO TOTAL2 :".$sumacomtotal."<br>";
                            // echo "NUEVO RESTO:".$nuevoresto."<br>";

                            $actualizacredito="";
                            $actualizacredito="UPDATE credito SET total='$sumacomtotal', resto='$nuevoresto' where id='$idcrecam' AND id_sucursal='$ids'";
                            $actucredi= actualizar($con,$actualizacredito);

                            if($proime !="" and $proiccid !="")
                            {
                                // echo "los dos campos estan llenos";
                                $sql = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                                VALUES ('$idProductoimei', 'IMEI', '$proime','0','$fecha','s','$ids')";
                               
                                $agregaimei = agregar($con,$sql);
                           
                                $sql2 = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                                VALUES ('$idProductoiccid', 'ICCID', '$proiccid','0','$fecha','s','$ids')";
                                $agregaiccid = agregar($con,$sql2);

                                $actualizaproductoimei="UPDATE producto SET cantidad= cantidad+1 where cod='$idProductoimei' AND id_sucursal='$ids'";
                                $actuproimei= actualizar($con,$actualizaproductoimei);

                                $actualizaproductoiccid="UPDATE producto SET cantidad= cantidad+1 where cod='$idProductoiccid' AND id_sucursal='$ids'";
                                $actuproiccid= actualizar($con,$actualizaproductoiccid);
                            }
                            elseif($proime !="")
                            {
                                // echo "solo IMEI tiene el prodcuto";
                                 $sql = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                                VALUES ('$idProductoimei', 'IMEI', '$proime','0','$fecha','s','$ids')";
                                // $result2 = mysqli_query($con,$sql) or die("Couldn't execute query.".mysql_error()); 
                                $agregaimei = agregar($con,$sql);
                                $actualizaproductoimei="UPDATE producto SET cantidad= cantidad+1 where cod='$idProductoimei' AND id_sucursal='$ids'";
                                $actuproimei= actualizar($con,$actualizaproductoimei);

                            }
                            elseif($proiccid !="")
                            {
                                // echo "solo ICCID tiene el prodcuto";
                                  $idproicid =$idProductoimei;
                                 $sql2 = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                                VALUES ('$idproicid', 'ICCID', '$proiccid','0','$fecha','s','$ids')";
                                $agregaiccid = agregar($con,$sql2);

                                $actualizaproductoiccid="UPDATE producto SET cantidad= cantidad+1 where cod='$idproicid' AND id_sucursal='$ids'";
                                $actuproiccid= actualizar($con,$actualizaproductoiccid);
                            }elseif($proime =="" and $proiccid =="") 
                            {
                                // echo "es un accesorio o refaccion";

                                $actualizaproductoacc="UPDATE producto SET cantidad= cantidad+1 where cod='$idprocam' AND id_sucursal='$ids'";
                                $actuproacc= actualizar($con,$actualizaproductoacc);

                            }  

                 
                            

                            $actualizaproducdetalle="UPDATE creditodetalle SET idProducto='$idproductochipp',precioUnitario='$nuevoprecioproducto',precioProducto='$nuevoprecioproducto',
                            iccid='$iccid2', imei='', idProductoChip='' where idProducto='$idprocam' AND idCredito='$idcrecam'";
                            $actuprodet= actualizar($con,$actualizaproducdetalle);
                            
                        
                            $actualizastocknuevoproductochip="UPDATE producto SET cantidad= cantidad-1 where cod='$idproductochipp' AND id_sucursal='$ids'";
                            $actunuevostockchip= actualizar($con,$actualizastocknuevoproductochip);

                            
                            $eliminariccid   = "DELETE FROM codigo_producto WHERE identificador  =  '$iccid2' AND id_sucursal='$ids'" ;
                            $paqElimiariccid = eliminar($con,$eliminariccid);

                            $finproceso="";
                            if($paqElimiariccid)
                            {
                                $finproceso="si";
                                return $finproceso;
                            }
                            else
                            {
                                $finproceso="no";
                                return $finproceso;
                            }


                        }
                    }
                }
            }
             else
            {   
                $noexistencia="";
                $noexistencia="no hay existencia";
                return $noexistencia;
            }
        }

    }

    function productoaccesorioreparacion($Codimei,$Codiccid,$codpronompro,$ids,$idprocam,$idcrecam,$iccidenvia,$imeenvia,$iccid2,$valorcheck)
    {
         include("host.php");
        // echo "ENTRO EN LA 4 VALIDACION:------>codpronompro !="."<br>"."<br>";
        //  echo "VALOR DE CHECK:".$valorcheck."<br>";
       
        // echo "ICCI QUE ENVIA EL BOTON:".$iccidenvia."<br>";
        // echo "IMEI QUE ENVIA EL BOTON:".$imeenvia."<br>";
        // echo "IDPRODUCCTO QUE ENVIA EL BOTON:".$idprocam."<br>";
        // echo "IDCREDITO QUE ENVIA EL BOTON:".$idcrecam."<br>";
        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
        {   $cantidad="";
            $consultaCam = "SELECT  * FROM producto WHERE cod='$codpronompro'   AND id_sucursal='$ids' ";
            if($paqueteCam = consultar($con,$consultaCam))
            {
                while($dato = mysqli_fetch_array($paqueteCam))
                { 
                    $venta=  $dato['venta']; 
                    // $nom= $dato['nom'];
                    $cantidad=  $dato['cantidad'];
                    // echo "cantidad accesorio o reparacion:".$cantidad."<br>";
                }
            }
            if($cantidad > 0)
            {
           
                // echo "<br>"."si hay existencias";
                // echo "idSucursal:".$ids."<br>";
                // echo "Codigo Producto de nuevo producto:".$codpronompro."<br>";
                // echo "precio nuevo producto:".$venta."<br>";

                $condicioncreditodet="";
                if($iccidenvia !="" and  $imeenvia !="")
                {
                      $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam' and iccid='$iccidenvia' and imei='$imeenvia'";
                }
                elseif($imeenvia !="")
                {
                     $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam' and imei='$imeenvia'";
                }
                elseif($iccidenvia !="")
                {
                   $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam' and iccid='$iccidenvia'"; 
                }
                elseif($iccidenvia =="" and $imeenvia =="")
                {
                     $condicioncreditodet="WHERE idProducto='$idprocam' and idCredito='$idcrecam'";
                }
                $consultaregresarstock="SELECT * FROM creditodetalle ".$condicioncreditodet."";
                if($resultadoregrestock = consultar($con,$consultaregresarstock))
                {
                    while($dato4 = mysqli_fetch_array($resultadoregrestock))
                    {
                   
                        // $id_creditoimei=  $dato4['idCredito'];
                        $idProductoimei= $dato4['idProducto'];
                        $proime=  $dato4['imei'];
                        $idProductoiccid= $dato4['idProductoChip'];
                        $proiccid= $dato4['iccid'];
                        $precioProducto= $dato4['precioProducto'];
                        date_default_timezone_set("America/Mexico_City");
                        $fecha= date ("Y/m/d H:i.s",time());

                        // echo "TipoI dentificador icid:".$tipo_identchip."<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "PRODUCTOS A REGRESAR A ESTOCK"."<br>";
                        // echo "idproductoimei:".$idProductoimei."<br>";
                        // echo "IMEI:".$proime."<br>";
                        // echo "PRECIO PRODUCTO:".$precioProducto."<br>";

                        // echo "idproductoICCID:".$idProductoiccid."<br>";
                        // echo "ICCID:".$proiccid."<br>";
                    }
                }
                $consultaresta="SELECT * FROM credito WHERE id='$idcrecam' and id_sucursal='$ids' ";
                if($resultadocr = consultar($con,$consultaresta))
                {
                    while($dato5 = mysqli_fetch_array($resultadocr))
                    {

                      
                        $preciopro=$precioProducto;
                        $totalcr=  $dato5['total'];
                        $adelantocr= $dato5['adelanto'];
                        $restocr=  $dato5['resto'];
                        $precionuevopro=$venta;
                        // echo "total".$totalcr."<br>";
                        if($valorcheck =="si")
                        {
                            $comision=0.1;
                            number_format($comision);
                            $comisioncambio= $preciopro * $comision;

                            $nuevototalcr=$totalcr - $preciopro;

                            $sumacomtotal=$nuevototalcr + $comisioncambio + $precionuevopro;

                            $nuevoresto= $sumacomtotal - $adelantocr;
                            $nuevoprecioproducto=$precionuevopro + $comisioncambio;
                        }
                        else
                        {
                            $comision=0;
                            number_format($comision);
                            $comisioncambio= $preciopro * $comision;

                            $nuevototalcr=$totalcr - $preciopro;

                            $sumacomtotal=$nuevototalcr + $comisioncambio + $precionuevopro;

                            $nuevoresto= $sumacomtotal - $adelantocr;
                            $nuevoprecioproducto=$precionuevopro + $comisioncambio;
                        }
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
                        // echo "OPERACIONES:"."<br>";
                        // echo "TOTAL CREDITO SIN CAMBIOS:".$totalcr."<br>";
                        // echo "ADELANTO CREDITO SIN CAMBIOS:".$adelantocr."<br>";
                        // echo "RESTO CREDITO SIN CAMBIOS:".$restocr."<br>";
                        // echo "<br>";



                        // echo "PRECIO DEL PRODUCTO A CAMBIAR:".$preciopro."<br>";
                        // echo "COMISION DEL PRODUCTO A CAMBIAR:".$comisioncambio."<br>";
                        // echo "<br>";
                         
                        // echo "PRECIO NUEVO PRODUCTO:".$precionuevopro."<br>";
                        // echo "<br>";
                        // echo "NUEVO TOTAL1= RESTA TOTAL CREDITO - PRECIO DEL PRODUCTO A CAMBIAR :".$nuevototalcr."<br>";
                        // echo "SUMA DE NUEVO TOTAL1 +COMISION + NUEVO PRODCUTO = NUEVO TOTAL2 :".$sumacomtotal."<br>";
                        // echo "NUEVO RESTO:".$nuevoresto."<br>";

                        $actualizacredito="";
                        $actualizacredito="UPDATE credito SET total='$sumacomtotal', resto='$nuevoresto' where id='$idcrecam' AND id_sucursal='$ids'";
                        $actucredi= actualizar($con,$actualizacredito);

                        if($proime !="" and $proiccid !="")
                        {
                            // echo "los dos campos estan llenos"."<br>";
                            $sql = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                            VALUES ('$idProductoimei', 'IMEI', '$proime','0','$fecha','s','$ids')";
                           
                            $agregaimei = agregar($con,$sql);
                       
                            $sql2 = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                            VALUES ('$idProductoiccid', 'ICCID', '$proiccid','0','$fecha','s','$ids')";
                            $agregaiccid = agregar($con,$sql2);

                            $actualizaproductoimei="UPDATE producto SET cantidad= cantidad+1 where cod='$idProductoimei' AND id_sucursal='$ids'";
                            $actuproimei= actualizar($con,$actualizaproductoimei);

                            $actualizaproductoiccid="UPDATE producto SET cantidad= cantidad+1 where cod='$idProductoiccid' AND id_sucursal='$ids'";
                            $actuproiccid= actualizar($con,$actualizaproductoiccid);
                        }
                        elseif($proime !="")
                        {
                            // echo "solo IMEI tiene el prodcuto"."<br>";
                             $sql = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                            VALUES ('$idProductoimei', 'IMEI', '$proime','0','$fecha','s','$ids')";
                             // echo $sql2."<br>";
                            // $result2 = mysqli_query($con,$sql) or die("Couldn't execute query.".mysql_error()); 
                            $agregaimei = agregar($con,$sql);
                            $actualizaproductoimei="UPDATE producto SET cantidad= cantidad+1 where cod='$idProductoimei' AND id_sucursal='$ids'";
                            $actuproimei= actualizar($con,$actualizaproductoimei);

                        }
                        elseif($proiccid !="")
                        {
                            // echo "solo ICCID tiene el prodcuto"."<br>";
                           $idproicid =$idProductoimei;
                             $sql2 = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha,estado,id_sucursal)
                            VALUES ('$idproicid', 'ICCID', '$proiccid','0','$fecha','s','$ids')";
                            // echo $sql2."<br>";
                            $agregaiccid = agregar($con,$sql2);

                            $actualizaproductoiccid="UPDATE producto SET cantidad= cantidad+1 where cod='$idproicid' AND id_sucursal='$ids'";
                            $actuproiccid= actualizar($con,$actualizaproductoiccid);
                        }elseif($proime =="" and $proiccid =="") 
                        {
                            // echo "es un accesorio o refaccion";

                            $actualizaproductoacc="UPDATE producto SET cantidad= cantidad+1 where cod='$idprocam' AND id_sucursal='$ids'";
                            $actuproacc= actualizar($con,$actualizaproductoacc);

                        }  

             
                        

                        $actualizaproducdetalle="UPDATE creditodetalle SET idProducto='$codpronompro',precioUnitario='$nuevoprecioproducto',precioProducto='$nuevoprecioproducto',
                        iccid='', imei='', idProductoChip='' where idProducto='$idprocam' AND idCredito='$idcrecam'";
                        $actuprodet= actualizar($con,$actualizaproducdetalle);

                        $actualizastock="UPDATE producto SET cantidad= cantidad-1 where cod='$codpronompro' AND id_sucursal='$ids'";
                        $actunuevostock= actualizar($con,$actualizastock);
                         
                        $finproceso="";
                        if($actunuevostock)
                            {
                                $finproceso="si";
                                return $finproceso;
                            }
                            else
                            {
                                $finproceso="no";
                                return $finproceso;
                            }
                    }
                }
            }//llave validacion existencia
            else
            {   
                $noexistencia="";
                $noexistencia="no hay existencia";
                return $noexistencia;
            }

        }

    }

    function validardescuentovigencia($idcredd,$idsucc,$valorcheck)
    {
        // echo "ID CREDITO:".$idcredd."<br>";
        // echo "ID SUCURSAL:".$idsucc."<br>";
        // echo "VALOR CHECK:".$valorcheck."<br>";
           include("host.php");
      
        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
        {   
            $consultaDesVigencia = "SELECT  * FROM credito WHERE id='$idcredd'   AND id_sucursal='$idsucc' ";
            if($paqueteCamVigencia = consultar($con,$consultaDesVigencia))
            {
                while($dato = mysqli_fetch_array($paqueteCamVigencia))
                { 
                    $total = $dato['total'];
                    $adelanto = $dato['adelanto'];
                    $resto = $dato['resto'];
                     // echo "<br>"."<br>"."<br>"."DATOS CREDITO SIN CAMBIOS";
                     //    echo "TOTAL:".$total."<br>";
                     //    echo "ADELANTO:".$adelanto."<br>";
                     //    echo "RESTO:".$resto."<br>";

                    if($valorcheck =="si")
                    {
                        $comision= 0.1;
                        number_format($comision);
                        $valorcomision= $total * $comision;

                        $suma= $total + $valorcomision;
                        $resta= $suma - $adelanto;

                       //  echo "<br>"."<br>"."<br>"."RESULTADOS OPERACIONES"."<br>"."<br>"."<br>";
                       // echo "VALOR DE COMISION POR VIGENCIA:".$valorcomision."<br>";
                       //  echo "NUEVO TOTAL:".$suma."<br>";
                       //  echo "ADELANTOL:".$adelanto."<br>";
                       //  echo "NUEVO RESTO:".$resta."<br>";
                    }
                    else
                    {
                        $comision= 0;
                        number_format($comision);
                        $valorcomision= $total * $comision;

                        $suma= $total + $valorcomision;
                        $resta= $suma - $adelanto;

                       //  echo "<br>"."<br>"."<br>"."RESULTADOS OPERACIONES"."<br>"."<br>"."<br>";
                       // echo "VALOR DE COMISION POR VIGENCIA:".$valorcomision."<br>";
                       //  echo "NUEVO TOTAL:".$suma."<br>";
                       //  echo "ADELANTOL:".$adelanto."<br>";
                       //  echo "NUEVO RESTO:".$resta."<br>";

                    }
                    $actualizacredito="UPDATE credito SET total='$suma', resto='$resta', vigenciacredito='1' where id='$idcredd' AND id_sucursal='$idsucc'";
                    $actucred= actualizar($con,$actualizacredito);

                     $finproceso="";
                        if($actucred)
                            {
                                $finproceso="si";
                                return $finproceso;
                            }
                            else
                            {
                                $finproceso="no";
                                return $finproceso;
                            }

                }
            }
        }
    }















    
?>