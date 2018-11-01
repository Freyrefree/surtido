<?php 
	session_start();
    include('php_conexion.php'); 
    $usu=$_SESSION['username'];
    $tipo_usu=$_SESSION['tipo_usu'];
    if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
        header('location:error.php');
    }
    $id_sucursal = $_SESSION['id_sucursal'];
    $sucursal = $_SESSION['sucursal'];

    function generacodigo(){
        $codig = rand(1000, 1000000);
        $can=mysql_query("SELECT * FROM reparacion WHERE cod_cliente = '$codig'");
        if($dato=mysql_fetch_array($can)){
            generacodigo();
        }else{
            return $codig;
        }
    }
#calculo de RFC

    $paterno = strtoupper($_POST['apat']);
    $materno = strtoupper($_POST['amat']);
    $nombre  = strtoupper($_POST['nom']);
    //*************************************************
    $nombreContacto = strtoupper($_POST['nom']);
    $apaternoContacto = strtoupper($_POST['apat']);
    $amaternoContacto = strtoupper($_POST['amat']);
    $nombreCompleto = $nombreContacto." ".$apaternoContacto." ".$amaternoContacto;
    $correoContacto = strtolower($_POST['correo']);
    $direccionContacto = strtolower($_POST['direccion']);
    $telefonoContacto = strtolower($_POST['telefono']);


    //*************************************************
    /*$paterno = strtoupper("PLUTARCO");
    $materno = strtoupper("TORRES");
    $nombre  = strtoupper("OSCAR");*/
    $conso = array("B","C","D","F","G","H","J","K","L","M","N","Ñ","P","Q","R","S","T","V","W","X","Y","Z");
    if (in_array(substr($paterno, 1, 1), $conso)) {
        $consonante = substr($paterno, 0, 1);
        $vocal = substr($paterno, 2, 1);
        $paterno = $consonante.$vocal;
    }else {
        $paterno = substr($paterno, 0, 2);
    }
    $materno = substr($materno, 0, 1);
    $nombre  = substr($nombre , 0, 1);
    $first_part = $paterno.$materno.$nombre;
    $fecha   = explode("-", $_POST['fechanac']);
    $secon_part = substr($fecha[0], -2).$fecha[1].$fecha[2];
    $rfc = $first_part.$secon_part;
    /*echo "primera parte rfc: ".$first_part.$secon_part."<br>";*/
#fin calculo de RFC
//************************************************************************
$buscaBase = $_POST['buscarBase'];//Insertar nuevo cluente si no se buscó en catálogo
if($buscaBase == ""){
    $insertarCliente ="INSERT INTO cliente_reparacion(rfc,nombre,ap,am,nombre_completo,direccion,correo,telefono)
    VALUES ('$rfc','$nombreContacto','$apaternoContacto','$amaternoContacto','$nombreCompleto','$direccionContacto','$correoContacto','$telefonoContacto');";
    mysql_query($insertarCliente);
}
//*************************************************************************
    $fecha_ingreso=date("Y-m-d");
    if(!empty($_POST['id'])){// and !empty($_POST['tipo'])
        
	    $id_reparacion=$_POST['id'];$imei=$_POST['imei'];$marca=strtoupper($_POST['marca']);$modelo=strtoupper($_POST['modelo']);
	    $color=strtoupper($_POST['color']);$precio=$_POST['precio'];$motivo=strtoupper($_POST['motivo']);
	    $observacion = strtoupper($_POST['observacion']);$fecha_salida = $_POST['fecha'];$abono=$_POST['abono'];
	    $cod_cliente = generacodigo();
	    $chip=$_POST['chip'];$memoria=$_POST['memoria'];
        $nombre_contacto = strtoupper($_POST['nom']." ".$_POST['apat']." ".$_POST['amat']); $telefono_contacto=$_POST['telefono'];
        $tiempo = $_POST['numer']." ".$_POST['dh'];
        if ($_POST['numer'] == "1" && $_POST['dh'] == "dias") {
            $tiempo = $_POST['numer']." dia";
        }
        if ($_POST['numer'] == "1" && $_POST['dh'] == "horas") {
            $tiempo = $_POST['numer']." hora";
        }
        $mano_obra = $_POST['mano'];
        $tipo_precio = $_POST['tprecio'];//->publico = 3, mayoreo = 2, especial = 1
        $costo=$_POST['costo'];
        //$rfccurp = $_POST['rfccurp'];
        //$cod_producto = $_POST['producto'];
        $productos = $_POST['textrefacciones'];
        $producto  = explode("\n", $productos);
        foreach ($producto as &$nombre) {
            if (!empty($nombre)) {
                $nombre = trim($nombre);
                $queryi=mysql_query("SELECT * FROM producto WHERE nom='$nombre' AND id_sucursal = '$id_sucursal'");
                if($row=mysql_fetch_array($queryi)){
                    $cod_producto = $row[0];
                }
                if ($row['cantidad'] >= '1') {
                    #insertar producto refaccion a lista de ventas
                        $sql = "INSERT INTO reparacion_refaccion (id_reparacion, id_producto, NomProducto, TipoPrecio)
                                VALUES ('$id_reparacion', $cod_producto,'$nombre', $tipo_precio)";
                        $resp =  mysql_query($sql);
                        $SQLs="UPDATE producto SET cantidad=cantidad-1
                           WHERE cod='$cod_producto' AND id_sucursal = '$id_sucursal'";
                        mysql_query($SQLs);
                    #fin insertar producto refaccion a lista de ventas
                }else{
                    echo"No hay más refacciones de ese tipo";   
                }
            }
        }
		//------------------------pendiente actualizacion reparacion----------------
		$can=mysql_query("SELECT * FROM reparacion where id_reparacion='$id_reparacion' AND id_sucursal = '$id_sucursal'");
		if($dato=mysql_fetch_array($can)){
		    $xSQL="UPDATE reparacion SET observacion='$observacion',
		                                 costo   ='$costo',
		                                 precio  ='$precio',
                                         tecnico ='$usu',
                                         tipo_precio = '$tipo_precio',
                                         mano_obra = '$mano_obra'
		           WHERE id_reparacion='$id_reparacion' AND id_sucursal = '$id_sucursal'";
                //echo $xSQL;
		        mysql_query($xSQL);
            $SQLs="UPDATE producto SET cantidad=cantidad-1
                   WHERE cod='$cod_producto' AND id_sucursal = '$id_sucursal'";
                mysql_query($SQLs);
                header('location:reparaciones.php');
		        /*echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
		                  <strong>Reparacion</strong> Actualizado con Exito</div>';*/
	    }else {
            //echo "entra al else INSERT <br>";
            $cons =mysql_query("SELECT * FROM comision WHERE nombre LIKE '%reparacion%' OR tipo LIKE '%REPARACION%'");
            if($row=mysql_fetch_array($cons)){
                $id_comision = $row['id_comision'];
            }

            //*****************************************************************************************************************************************************************************************************************************************************************************************
            $sql = "INSERT INTO reparacion (id_reparacion,id_sucursal,usuario,cod_cliente, imei,
             marca, modelo, color,precio,precio_inicial,abono,motivo,observacion,fecha_ingreso,
             fecha_salida,id_comision,estado,chip,memoria,costo,nombre_contacto,ap_contacto,
             am_contacto,telefono_contacto,rfc_curp_contacto, mano_obra,correo,direccion)
            VALUES ('$id_reparacion','$id_sucursal','$usu','$cod_cliente','$imei',
            '$marca','$modelo','$color','$precio','$precio',$abono,'$motivo','$observacion',
            '$fecha_ingreso','$fecha_salida','$id_comision','0','$chip','$memoria','$costo',
            '$nombreContacto','$apaternoContacto','$amaternoContacto','$telefono_contacto','$rfc',
            '$mano_obra','$correoContacto','$direccionContacto')";
            //*****************************************************************************************************************************************************************************************************************************************************************************************


            //echo $sql."<br>";
            $resp =  mysql_query($sql);
            $tipo = "REPARACION";
            //echo $resp."<br>";
            if ($resp == 1){
                header('location:contado.php?id_reparacion='.$id_reparacion.'&tipo='.$tipo.'&tiempo='.$tiempo);
            }
            $id_reparacion='';$imei='';$marca='';$modelo='';$color='';$precio='';
            $motivo='';$observacion='';$fecha_ingreso="";$fecha_salida="";$estatus="";
            $costo ='';$chip = ''; $memoria = ''; $nombre_contacto = ''; $telefono_contacto = '';$id_comision = '';
            $rfccurp='';
            echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                      <strong>Entrada Reparacion!</strong> Registrado con Exito.</div>';
            //$id_gasto = generaid();
            $id_reparacion = generaid();
        }

    //--------------------------------------------------------------------------
    }else{
    		/*//echo "entra al else INSERT <br>";
            $cons =mysql_query("SELECT * FROM comision WHERE nombre LIKE '%reparacion%' OR tipo LIKE '%REPARACION%'");
            if($row=mysql_fetch_array($cons)){
                $id_comision = $row['id_comision'];
            }
            $sql = "INSERT INTO reparacion (id_reparacion,id_sucursal,usuario,cod_cliente, imei, marca, modelo, color, precio,abono,motivo,observacion,fecha_ingreso,fecha_salida,id_comision,estado,chip,memoria,costo,nombre_contacto,telefono_contacto,rfc_curp_contacto)
                     VALUES ('$id_reparacion','$id_sucursal','$usu','$cod_cliente','$imei','$marca','$modelo','$color','$precio',$abono,'$motivo','$observacion','$fecha_ingreso','$fecha_salida','$id_comision','1','$chip','$memoria','$costo','$nombre_contacto','$telefono_contacto','$rfccurp')";
            //echo $sql."<br>";
            $resp =  mysql_query($sql);
            $tipo = "REPARACION";
            //echo $resp."<br>";
            if ($resp == 1){
                header('location:contado.php?id_reparacion='.$id_reparacion.'&tipo='.$tipo);
            }
            $id_reparacion='';$imei='';$marca='';$modelo='';$color='';$precio='';
            $motivo='';$observacion='';$fecha_ingreso="";$fecha_salida="";$estatus="";
            $costo ='';$chip = ''; $memoria = ''; $nombre_contacto = ''; $telefono_contacto = '';$id_comision = '';
            $rfccurp='';
            echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                      <strong>Entrada Reparacion!</strong> Registrado con Exito.</div>';
                //$id_gasto = generaid();
                $id_reparacion = generaid();*/
      }
  //}

 ?>