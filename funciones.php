<?php


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



        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) {

            $consultaDetalle = $arrayConsultas[0];
            $consultaCantidad = $arrayConsultas[1];
            $consultaImporte =  $arrayConsultas[2];



            $can =  consultar($con,$consultaDetalle);
    
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
                    $querynombresucursal="SELECT empresa FROM empresa WHERE id = '$idsucursal'";
                    $canempresa = consultar($con,$querynombresucursal);
                    $dato2 = mysqli_fetch_array($canempresa);

                    $nombreempresa = $dato2['empresa'];
                    //......nombre sucursal fin.........................................................
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
                    $precioU = number_format($precioU, 2, '.', '');
                    $cantidad = $dato['cantidad'];
                    $id_producto = $dato['codigo'];

                    if(($dato['modulo'] != 'CR') && ($dato['modulo'] != 'R')){

                        $consultaProducto = "SELECT * FROM producto WHERE cod='$id_producto' LIMIT 1";
                        $ejecutar2 = consultar($con,$consultaProducto);
                        $dato2 = mysqli_fetch_array($ejecutar2);

                        $id_comision = $dato2['id_comision'];
                        $costo_producto = $dato2['costo'];

                        $consultaComision="SELECT * FROM comision WHERE id_comision = '$id_comision'";
                        $ejecutar3 = consultar($con,$consultaComision);
                        $dato3  =   mysqli_fetch_array($ejecutar3);

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

        }

        return $codigohtml;
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
                <th>Cancelar</th>
                <th>cambio</th>
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
                        $botonCancelar    = '<a  href="#"  <span class="label label-important"> CANCELAR</span>';
                        $botonCambiar    = '<a  href="#"  <span class="label label-warning "> CAMBIAR</span>';
                    }else{

                        $botonProductos = '<a  href="#" onclick="verProdcutos('.$idCA.')" <span class="label label-info">VER <br> PRODUCTOS</span></a>';
                        $botonPagos     = '<a  href="#" onclick="verPagos('.$idCA.')" <span class="label label-info">VER<br> PAGOS</span></a>';
                        $botonEnviar    = '';
                        $botonCancelar    = '';
                        $botonCambiar    = '';

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

                        $codigohtml.='<td>'.$botonCancelar.'</td>';
                        $codigohtml.='<td>'.$botonCambiar.'</td>';

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

    function tabularCAProdcutos($idCa)
    {

        include("host.php");

        if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) {
            $codigohtml = '<table class="tblLisado">
            <thead>
            <tr> 
                <th>No</th> 
                <th>Codigo Producto</th> 
                <th>Nombre Producto</th>
                <th>ICCID</th>
                <th>IMEI</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>';


            $consultaProd = "SELECT 
            cd.idProducto AS codigo,
            p.nom AS nombreProd,
            cd.precioUnitario AS precioUnitario,
            cd.precioProducto AS precioProducto,
            cd.cantidad AS cantidad,
            cd.iccid AS iccid,
            cd.imei AS imei 
            FROM creditodetalle cd
            LEFT JOIN producto p 
            ON cd.idProducto = p.cod
            WHERE cd.idCredito = '$idCa'
            GROUP BY cd.id";

            if($paqueteProd = consultar($con,$consultaProd)){
                $contador = 0;

                while($dato = mysqli_fetch_array($paqueteProd)){
                    $contador++;

                    $codigohtml.='<tr>';
                        
                        $codigohtml.='<td>'.$contador.'</td>';
                        $codigohtml.='<td>'.saltoCadena(utf8_encode($dato['codigo'])).'</td> ';  
                        $codigohtml.='<td>'.saltoCadena(utf8_encode($dato['nombreProd'])).'</td>';
                        $codigohtml.='<td>'.saltoCadena($dato['iccid']).'</td>';
                        $codigohtml.='<td>'.saltoCadena($dato['imei']).'</td>';   
                        $codigohtml.='<td>'.$dato['cantidad'].'</td>';
                            
                        $codigohtml.='<td>$ '.number_format((float)$dato['precioUnitario'], 2, '.', '').'</td>';
                        $codigohtml.='<td>$ '.number_format((float)$dato['precioProducto'], 2, '.', '').'</td>';

                    $codigohtml.='</tr>';

                }                

            }else{
                $codigohtml = "";
            }
        }
        return $codigohtml;

    }

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






    
?>