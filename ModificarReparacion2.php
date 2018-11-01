<?php
session_start();
include('host.php');
include('funciones.php'); 
$usu=$_SESSION['username'];
$tipo_usu=$_SESSION['tipo_usu'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='te'){
   header('location:error.php');
}

    $IdReparacion       = $_POST['IdReparacion'];
    $inversion          = $_POST['Inversion'];  //Archivo Anterior
    $manoObra			= $_POST['ManoObra'];
    //$total              = $_POST['total'];
    $estatus            = $_POST['estatus'];
    //$nuevoPresupuesto = $_POST['Precio2'];
    $precioPublico       = $_POST['totalPublico'];
    $anticipo           = $_POST['anticipo'];
    $comisionCajero     = $_POST['comisionCajero'];
    
    

    $invmano = $inversion + $manoObra;
    $resto = $precioPublico - $anticipo;


if($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB))
{

    // $consulta = "UPDATE reparacion SET
    // tecnico             ='$usu', 
    // costo               ='$inversion',
    // mano_obra           ='$manoObra',
    // total               ='$total',
    // estado              ='$estatus'
    // WHERE id_reparacion ='$IdReparacion'";

    //Calculo Comisión
    $porcent = "SELECT porcentaje FROM comision WHERE tipo = 'REPARACION'";
    $paq = consultar($con,$porcent);
    $dato = mysqli_fetch_array($paq);
    $porcentaje = ($dato['porcentaje'] / 100);
    $totalComisionCajero = $comisionCajero * $porcentaje;

    


    
    ##

    $consulta = "UPDATE reparacion SET 
    tecnico             ='$usu', 
    costo               ='$inversion',
    mano_obra           ='$manoObra',
    estado              ='$estatus',
    resto               ='$resto',
    total               ='$precioPublico',
    comisionCajero      ='$comisionCajero',
    totalComisionCajero ='$totalComisionCajero',
    precio              ='$precioPublico'
    WHERE id_reparacion ='$IdReparacion'";




    if ($paquete = actualizar($con, $consulta)) {

        // if($nuevoPresupuesto != ""){
        //     $consulta4 = "UPDATE reparacion SET
        //     precio_inicial = '$nuevoPresupuesto',
        //     resto = ('$nuevoPresupuesto' - abono)
        //     WHERE id_reparacion = '$IdReparacion'";
        //     $paquete4 = actualizar($con,$consulta4);
        // }

        echo "1";
    } else {
        echo "0";
    }
}


?>