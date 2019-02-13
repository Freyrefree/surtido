<?php
		session_start();
    //include('../php_conexion.php');
    include('../funciones.php');
    include('../host.php');
    //error_reporting(0);

    $idSucursal = $_SESSION['id_sucursal'];
    $usuarioSession      = $_SESSION['username'];
    $tipoUsuario  = $_SESSION['tipo_usu'];

		
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <script src="jquery-1.9.1.js"></script>


    <style type="text/css">
        .fila_0 { background-color: #FFFFFF;}
        .fila_1 { background-color: #E1E8F1;}
        .botone{
        background-color: #FFBF00;
        border-radius: 40px;
        border: 0px;
        }
        .botone:hover{
        background-color: #F7D358;
        }

        .tblLisado {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .tblLisado td, .tblLisado th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .tblLisado tr:nth-child(even){background-color: #f2f2f2;}

        .tblLisado tr:hover {background-color: #ddd;}

        .tblLisado th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #ffcc33;
            color: black;
        }
    </style>
</head>
<body>

<?php
$fecha_inicio = $_POST['fecha_ini11'];
if($fecha_inicio == "--")
{
$fecha_inicio = "";
}else{
$fecha_inicio = $fecha_inicio." 00:00:00";
}
$fecha_fin = $_POST['fecha_fin11'];
if($fecha_fin == "--")
{
$fecha_fin = "";
}else{
  $fecha_fin = $fecha_fin." 23:59:59";
}

###FECHA ENTRADA
$fecha_inicioen = ''; // $_POST['fechainicioen'];
if($fecha_inicioen == "--")
{
$fecha_inicioen = "";
}else{
$fecha_inicioen =''; //$fecha_inicioen." 00:00:00";
}

$fecha_finen = ''; //$_POST['fechafinen'];
if($fecha_finen == "--")
{
$fecha_finen = "";
}else{
  $fecha_finen = ''; //$fecha_finen." 23:59:59";
}


$cajero=$_POST['cajero'];
//$producto=$_POST['producto'];
$codigo = $_POST['codigo'];
$categoria = $_POST['categoria'];
$coincidencia = $_POST['coincidencia'];

if($cajero == "Todos"){
    $cajero = "";
}

$arrayQuery[0] = $fecha_inicio;
$arrayQuery[1] = $fecha_fin;
$arrayQuery[2] = $cajero;
$arrayQuery[3] = $codigo;
$arrayQuery[4] = $coincidencia;
$arrayQuery[5] = $categoria;



$rango_fecha = $fecha_inicio ." / " .$fecha_fin;

$arrayConsultas = crearConsulta($arrayQuery,$usuarioSession);

$codigoTabla = tabularCorteVentas($arrayConsultas,$rango_fecha,$tipoUsuario);

echo $codigoTabla;


function crearConsulta($arrayQuery,$usuarioSession){

    $countArray = 0;
    $queryMas = "";

    foreach ($arrayQuery as &$valor) {
        

        if($countArray == 0){

            if($valor != ""){

                $queryMas.= " WHERE fecha_op BETWEEN '$valor' ";
            }else{
                $queryMas.= "";
            }

        }

        if($countArray == 1){

            if($valor != ""){

                $queryMas.= " AND '$valor' ";
            }else{
                $queryMas.= "";
            }

        }

        if($countArray == 2){

            if($valor != ""){
                if($queryMas != ""){

                    $queryMas.= " AND usu = '$valor' ";
                }else{
                    $queryMas.= " WHERE  usu = '$valor' ";
                }
            }else{
                $queryMas.= "";
            }

        }

        if($countArray == 3){

            if($valor != ""){
                if($queryMas != ""){

                    $queryMas.= " AND factura = '$valor' ";
                }else{
                    $queryMas.= " WHERE factura = '$valor' ";
                }
            }else{
                $queryMas.= "";
            }

        }

        if($countArray == 4){

            if($valor != ""){
                if($queryMas != ""){

                    $queryMas.= " AND nombre LIKE '%$valor%' ";
                }else{
                    $queryMas.= " WHERE nombre LIKE '%$valor%' ";
                }
            }else{
                $queryMas.= "";
            }

        }

        if($countArray == 5){

            if($valor != ""){
                if($queryMas != ""){

                    if($valor == "R"){
                        $queryMas.= " AND modulo = '$valor'";

                    }else if($valor == "CR"){
                        $queryMas.= " AND modulo = '$valor'";

                    }else{

                        $queryMas.= " AND (codigo IN(SELECT cod FROM producto WHERE id_comision='$valor')                    
                        OR codigo IN(SELECT codigo FROM compania_tl WHERE id_comision IN(SELECT id_comision FROM comision WHERE tipo='$valor'))) ";
                    }              

                }else{

                    if($valor == "R"){

                        $queryMas.= " WHERE modulo = '$valor'";

                    }else if($valor == "CR"){
                        $queryMas.= " WHERE modulo = '$valor'";

                    }else{
                        
                        $queryMas.= " WHERE (codigo IN(SELECT cod FROM producto WHERE id_comision='$valor')                    
                        OR codigo IN(SELECT codigo FROM compania_tl WHERE id_comision IN(SELECT id_comision FROM comision WHERE tipo='$valor'))) ";

                    }
                }
            }else{
                $queryMas.= "";
            }

        }



        $countArray++;
    }

    $consultaDetalle    = "SELECT * from detalle ".$queryMas; 
    $consultaCantidad   = "SELECT SUM(cantidad)FROM detalle".$queryMas; 
    $consultaImporte    = "SELECT SUM(importe)FROM detalle".$queryMas; 

    $arrayConsultas[0] = $consultaDetalle;
    $arrayConsultas[1] = $consultaCantidad;
    $arrayConsultas[2] = $consultaImporte;


return $arrayConsultas;

}

?>