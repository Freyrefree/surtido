<?php
include("host.php");
include("funciones.php");

$id_reparacion = $_POST['id'];
$data=array();
$consulta = "SELECT * FROM reparacion WHERE id_reparacion = '$id_reparacion'";
if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) {

    if($paquete = consultar($con,$consulta)){
        $fila = mysqli_fetch_array($paquete);
            if($fila['resto'] == ''){
                $resto = ($fila['precio_inicial']-$fila['abono']);
            }else{
                $resto = $fila['resto'];
            }  

            $data[] = array(
            'id_sucursal'           => $fila['id_sucursal'], 
            'usuario'               => $fila['usuario'] , 
            'cod_cliente'           => $fila['cod_cliente'],  
            'imei'                  => $fila['imei'], 
            'marca'                 => $fila['marca'], 
            'modelo'                => $fila['modelo'], 
            'color'                 => $fila['color'], 
            'precio'                => $fila['precio'], 
            'preciomenosAnticipo'   => $fila['preciomenosAnticipo'], 
            'precio_inicial'        => $fila['precio_inicial'], 
            'precio_final'          => $fila['precio_final'], 
            'abono'                 => $fila['abono'], 
            'resto'                 => $resto, 
            'motivo'                => utf8_encode($fila['motivo']), 
            'observacion'           => utf8_encode($fila['observacion']), 
            'fecha_ingreso'         => utf8_encode($fila['fecha_ingreso']), 
            'fecha_salida'          => $fila['fecha_salida'], 
            'id_comision'           => $fila['id_comision'], 
            'estado'                => $fila['estado'], 
            'chip'                  => $fila['chip'], 
            'memoria'               => $fila['memoria'], 
            'costo'                 => $fila['costo'], 
            'nombre_contacto'       => utf8_encode($fila['nombre_contacto']), 
            'ap_contacto'           => utf8_encode($fila['ap_contacto']), 
            'am_contacto'           => utf8_encode($fila['am_contacto']), 
            'telefono_contacto'     => $fila['telefono_contacto'], 
            'rfc_curp_contacto'     => $fila['rfc_curp_contacto'], 
            'tecnico'               => $fila['tecnico'], 
            'id_productos'          => $fila['id_productos'], 
            'garantia'              => $fila['garantia'], 
            'id_garantia'           => $fila['id_garantia'], 
            'tipo_precio'           => $fila['tipo_precio'], 
            'mano_obra'             => $fila['mano_obra'], 
            'CostoRefaccion'        => $fila['CostoRefaccion'], 
            'correo'                => $fila['correo'], 
            'direccion'             => utf8_encode($fila['direccion']), 
            'total'                 => $fila['total']
        );

        
        echo json_encode($data);
    }  

}

?>