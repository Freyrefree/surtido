<?php 
session_start();

include('php_conexion.php'); 
		$act="1";
		if(!empty($_POST['usuario']) and !empty($_POST['contra'])){
			$usuario=trim($_POST['usuario']);
			$contra=trim($_POST['contra']);
			$hora = date("g:i");
			$can=mysql_query("SELECT * FROM usuarios WHERE (usu='".$usuario."' or ced='".$usuario."') and con='".$contra."'");
			if($dato=mysql_fetch_array($can)){
				$ced = $dato['ced'];
				$_SESSION['username']=$dato['usu'];
				$_SESSION['tipo_usu']=$dato['tipo'];
				//inicializa las variables de caja por defecto//
				$_SESSION['tventa']="venta";
				$_SESSION['ddes']=0;
				///////////////////////////////
				if($_SESSION['tipo_usu']=='a'or $_SESSION['tipo_usu']=='su' or $_SESSION['tipo_usu']=='ca' or $_SESSION['tipo_usu'] == "te"){
					if ($_SESSION['tipo_usu'] == "ca" or $_SESSION['tipo_usu'] == "su" or $_SESSION['tipo_usu'] == "te") {
						$_SESSION['id_sucursal']=$dato['id_sucursal'];
					}
					if ($_SESSION['tipo_usu'] == "a"){
						//echo "Tu dirección IP es: {$_SERVER['REMOTE_ADDR']}";//"Direccion IP Real: ".$_SERVER['HTTP_X_FORWARDED_FOR'];
						/*$direccionMAC = returnMacAddress();
						echo "Direccion MAC: ".$direccionMAC;*/
						/*$ip = $_SERVER['REMOTE_ADDR'];
					     $comando = exec("arp -a $ip");
					      ereg(".{1,2}-.{1,2}-.{1,2}-.{1,2}-.{1,2}-.{1,2}|.{1,2}:.{1,2}:.{1,2}:.{1,2}:.{1,2}:.{1,2}", $comando,$mac);
					       echo "La IP <b>".$ip."</b> tiene esta MAC Address <b>".$mac[0]."</b><br>";*/

						if (empty($dato['id_sucursal'])) {
							$_SESSION['id_sucursal']="";
						}else {
							$_SESSION['id_sucursal']=$dato['id_sucursal'];
						}
					}
					$hinicio = 0;$bandera = 0;
					$query=mysql_query("SELECT * FROM caja WHERE id_cajero='$ced'");
					if($row=mysql_fetch_array($query)){
						$hinicio = $row['horainicio'];
					}else {
						$sqlc = "INSERT INTO caja (id_cajero, apertura, estado)
		                VALUES ('$ced','','0')";
		                mysql_query($sqlc);
		                $bandera = 1;
					}
					if (empty($hinicio) || $bandera == 1) {
						$sqla = "UPDATE caja SET horainicio='$hora' WHERE id_cajero='$ced'";
                  		mysql_query($sqla);
					}
					//header('location:Administrador.php');
					header('location:inicio.php');
				}
				
			}else{
				if($act=="1"){echo '<div class="alert alert-error" align="center">Usuario y Contraseña Incorrecta</div>';}else{$act="0";}
			}
		}else{
			
		}
?>

<script type="text/javascript">
	  setTimeout("window.location='index.php'",1)
	   alert("No cuenta con los provilegios para entrar al sistema")
</script>
