<?php
session_start();
include('php_conexion.php'); 
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='te' or !$_SESSION['tipo_usu']=='su'){
	header('location:error.php');
}

//obtener el nombre de la persona
$usuario=$_SESSION['username'];
$Sucursal = $_SESSION['sucursal'];
$fecha=date("Y-m-d");
$hora = date("g:i");

$b20   = $_REQUEST['b20'];
$b50   = $_REQUEST['b50'];
$b100  = $_REQUEST['b100'];
$b200  = $_REQUEST['b200'];
$b500  = $_REQUEST['b500'];
$b1000 = $_REQUEST['b1000'];
$m050  = $_REQUEST['m050'];
$m1    = $_REQUEST['m1'];
$m2    = $_REQUEST['m2'];
$m5    = $_REQUEST['m5'];
$m10   = $_REQUEST['m10'];
$m20   = $_REQUEST['m20'];


$cans=mysql_query("SELECT * FROM usuarios where usu='$usuario'");
    if($datos=mysql_fetch_array($cans)){
       $ced = $datos['ced'];
}

$sqle = mysql_query("SELECT * FROM caja WHERE id_cajero='$ced'");
if($dat=mysql_fetch_array($sqle)){
   $dinerocaja = $dat['apertura']+$dat['cantidad'];

    if (!empty($_REQUEST['cierre']) || $_REQUEST['cierre'] == "0") {
        $user = $_REQUEST['usuario'];
        $pass = $_REQUEST['password'];
        $query_p = mysql_query("SELECT * FROM usuarios WHERE usu='$user' AND con='$pass'");

        if ($rows = mysql_fetch_array($query_p)) {
            $perfil      = $rows['tipo'];
			$id_sucursal = $rows['id_sucursal'];
            if ($perfil == "su" || $perfil=="a" || $perfil == "ca") {

                $sqle = mysql_query("SELECT * FROM caja WHERE id_cajero='$ced'");
                if($dat=mysql_fetch_array($sqle)){
                    $ventas = $dat['cantidad'];
                    $hi = $dat['horainicio'];
                    $aper=$dat['apertura'];
                    $estado=$dat['estado'];
					
					if($estado==1){
						if ($_REQUEST['efectivo'] >= $_REQUEST['cierre']) {
							$cierrecaja = $_REQUEST['cierre'];
							$sqlf = "INSERT INTO detalle_caja (id_cajero,apertura,ventas,cierre,horainicio,horacierre,fecha,autoriza)
										VALUES ('$ced','$aper','$ventas','$cierrecaja','$hi','$hora','$fecha','$user')";
							mysql_query($sqlf);

							 $SQLQuery = "INSERT INTO billetes_monedas 
							 (id_cajero,
							 sucursal,
							 b20,
							 HoraCierre,
							 Fecha,
							 b50,
							 b100,
							 b200,
							 b500,
							 b1000,
							 m050,
							 m1,
							 m2,
							 m5,
							 m10,
							 m20)
							VALUES ('$ced',
									'$Sucursal',
									'$b20',
									'$hora',
									'$fecha',
									'$b50',
									'$b100',
									'$b200',
									'$b500',
									'$b1000',
									'$m050',
									'$m1',
									'$m2',
									'$m5',
									'$m10',
									'$m20')";
							mysql_query($SQLQuery) or die ((print"No se inserto el registro de monedas".mysql_error()));
						}
               
                  
						if ($_REQUEST['efectivo'] >= $_REQUEST['cierre']) {
							$reserva = $_REQUEST['efectivo']-$_REQUEST['cierre'];
							$sqla = "UPDATE caja set estado=0, apertura='$reserva',horafin='$hora',cantidad='0' WHERE id_cajero='$ced'";
							mysql_query($sqla);

							echo '
							<script>
							swal("¡Acción completada!", "Se ha cerrado la caja", "success")
							</script>';

						}
					}	
				}
                  
            }
        }
    }
}           
?>
