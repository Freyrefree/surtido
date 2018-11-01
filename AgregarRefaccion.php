<?php
session_start();
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(0);
include("host.php");
include("funciones.php");

$id_sucursal = $_SESSION['id_sucursal'];
$sucursal = $_SESSION['sucursal'];

$IdReparacion = $_POST['IdReparacion'];
$Categoria    = $_POST['categoria'];
$Codigo       = $_POST['producto'];
$TipoPrecio   = $_POST['tipo'];

if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
{
	@mysqli_query($con, "SET NAMES 'utf8'");

	if ($Categoria !="ninguna" && $Codigo !="ninguno") 
	{
		$consulta = "SELECT * FROM producto WHERE cod='$Codigo' AND id_sucursal = '$id_sucursal'";

		if ($paquete = consultar($con, $consulta))
		{
			if($dato = mysqli_fetch_array($paquete))
			{
				$NombreProducto = $dato['nom'];
				$cantidad = $dato['cantidad'];

				if($cantidad > 0)
				{

					if ($TipoPrecio==1) {
						$Precio = $dato['especial'];
					}
					if ($TipoPrecio==2) {
						$Precio = $dato['mayor'];
					}
					if ($TipoPrecio==3) {
						$Precio = $dato['venta'];
					}

					$CostoRefaccion = $dato['costo'];

					$consulta2 = "INSERT INTO reparacion_refaccion (id_reparacion, id_producto, NomProducto, TipoPrecio, Precio, CostoRefaccion)
					VALUES('$IdReparacion', '$Codigo', '$NombreProducto', $TipoPrecio, $Precio, $CostoRefaccion)";

					if($paquete = agregar($con,$consulta2))
					{
						$consulta3 = "UPDATE producto SET cantidad=cantidad-1
						WHERE cod='$Codigo' AND id_sucursal = '$id_sucursal'";

						if($paquete = actualizar($con,$consulta3)){
							echo 1;
						}else {echo 0;}	
					}
					else{echo 0;}
				}else{echo 2;}

			}

		}else{echo 0;}

	
		
	}else{
		 echo 3;
	}
}

