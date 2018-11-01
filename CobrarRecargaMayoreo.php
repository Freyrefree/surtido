<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php 
		session_start();
		include('php_conexion.php'); 
		$usuario=$_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		$id_sucursal = $_SESSION['id_sucursal'];
		
		$usuario=$_SESSION['username'];
    	$cans=mysql_query("SELECT * FROM usuarios where usu='$usuario'");
    	if($datos=mysql_fetch_array($cans)){
      	   $IdCajero = $datos['ced'];
    	}

		$can=mysql_query("SELECT MAX(factura) as maximo FROM factura  WHERE id_sucursal = '$id_sucursal'");//codigo de la factura	
        if($dato=mysql_fetch_array($can)){	$cfactura=$dato['maximo']+1;	}
		if($cfactura==1){$cfactura=1000;}//si es primera factura colocar que empieze en 1000
		
		$hoy=$fechay=date("Y-m-d");
		$venta =$_REQUEST['monto'];
		$clientrfc="";
		$nom = $_REQUEST['compania'];//codigo de producto de compania de recarga

		if($nom == "Telcel"){
			$cod = "TLM";
			$nom = "Mayoreo Telcel";
		}else{
			$cod = "MUL";
			$nom = "Multirecarga";
		}


		//$nom = "TAE MAY ". $nom;
		$ccpago=$_REQUEST['monto'];//cantidad entrante de efectivo
		$tpagar=$_REQUEST['monto'];//valor de la venta
		$cliente=$_REQUEST['client'];
		$tipo="CONTADO";
		$fpago="CONTADO";
		$cant = 1;
		$importe = $venta;


		$sqle = mysql_query("SELECT * FROM cliente WHERE empresa='$cliente'") or die(print("Error en el buscador de termino"));
		if($dat=mysql_fetch_array($sqle)){
		   $numero = $dat['cel'];
		}

		 $sqle = mysql_query("SELECT * FROM recargassucursal WHERE IdSucursal=$id_sucursal") or die(print"Error en consulta de saldo virtual");
          if($dat=mysql_fetch_array($sqle)){
                  $SaldoVirtual=$dat['Saldo'];
         }

	#fin resultados de la peticion
if($numero==""){
?>
<script type="text/javascript">
swal({
  title: "¡Error!",
  text: "Ese cliente no está registrado aún",
  type: "error",
  confirmButtonText: "Aceptar"
});
</script>
  <div id="ajax">
    <div align="center">
            <h3>Saldo disponible: <?php echo $SaldoVirtual ?></h3>
          <br>
           <form class="form-horizontal" action="CobrarRecargaMayoreo.php" method="POST" name="RecargaMayoreo" id="RecargaMayoreo" target="_self"> 
                <label for="monto">Compañia</label> 
                <select name="compania" id="compania" autofocus required>
					<option value="Telcel">Telcel</option>
                    <option value="Multirecargas">Multirecargas</option>
				</select>	

				
				<label for="monto">Monto</label>
					<input type="text" id="monto" name="monto" size="20" style="font-family: Arial;  height:30px; font-size: 20pt;" maxlength="10" required autocomplete="off" required>
					<br>
                 <div class="ui-widget">
					<label for="ccpago">Cliente</label>
					<?php echo "<input type='hidden' step='any' name='IdCajero' id='IdCajero' autocomplete='off' value='$ced'>"; ?>
					<input type="text" class="input" id="client" name="client" placeholder="Nombre del Cliente" size="20" style="font-family: Arial;  height:30px; font-size: 20pt;" maxlength="10" autocomplete="off" required>
                </div>
               <div id="ConfNum">
					<label for="">Confirmar Numero Celular</label>
					<input type="text" name="numero2" id="numero2" size="20" style="font-family: Arial;  height:30px; font-size: 20pt;" pattern="[0-9]{10}" maxlength="10" required autocomplete="off">
                </div>
					<p id="msgerror" style="color:red;"></p>
					<button type="submit" class="btn btn-success" name="EnviarRecarga" id="EnviarRecarga"> Cobrar</button>
        	</form>
            </div>
       </div>
<script type="text/javascript">
$(function (e) {
	$('#RecargaMayoreo').submit(function (e) {
	  e.preventDefault()
  $('#ajax').load('CobrarRecargaMayoreo.php?' + $('#RecargaMayoreo').serialize())
	})
})
</script>	

<script>
$(function() {
    $( "#client" ).autocomplete({
       source: 'search.php'
    });
});
</script>   


<script>
$(function() {
    $( "#numero2" ).autocomplete({
       source: 'search2.php'
    });
});
</script>

<?php
}else{
		

			$factura_sql="INSERT INTO factura (factura, cajera, fecha, estado, tipo_pago, id_sucursal) 
			VALUES ('$cfactura','$usuario','$hoy','s','$fpago','$id_sucursal')";
			mysql_query($factura_sql);
			//------------------------------------------------------------------------------------------------
			$detalle_sql="INSERT INTO detalle (factura, codigo, nombre, cantidad, valor, importe, tipo, fecha_op,usu,id_sucursal)
					VALUES ('$cfactura','$cod','$nom','$cant','$venta','$importe','$tipo',NOW(),'$usuario','$id_sucursal')";
			mysql_query($detalle_sql);

			$sqla = mysql_query("SELECT * FROM caja WHERE id_cajero='$IdCajero'");/*,horainicio='$hora'*/
			if($datos=mysql_fetch_array($sqla)){
      		$CantidadActual=$datos['cantidad'];
			//$NuevaCantidad = $CantidadActual + $Monto;
			$NuevaCantidad = $CantidadActual + $importe;

			$sqla = "UPDATE caja SET cantidad ='$NuevaCantidad' WHERE id_cajero='$IdCajero'";
            mysql_query($sqla) or die("Error en Consulta de Recargas No.3 ".mysql_error());
			}

			$sqla2 = mysql_query("SELECT * FROM recargassucursal WHERE IdSucursal=$id_sucursal") or die("Error en Consulta de Recargas No.5 ".mysql_error());
				if($datos2=mysql_fetch_array($sqla2)){
					
					$CanActVirtual=$datos2['Saldo'];  
					$NewCantVirtual = $CanActVirtual - $ccpago;

					$sqla3 = "UPDATE recargassucursal SET Saldo = $NewCantVirtual WHERE IdSucursal=$id_sucursal";
					mysql_query($sqla3) or die("Error en Consulta de Recargas No.5 ".mysql_error());
					
				}else{

					$NewCantVirtual = 0 - $ccpago;

					$sqle = mysql_query("SELECT * FROM empresa WHERE id=$id_sucursal") or die(print("Error en el buscador de termino"));
					if($dat=mysql_fetch_array($sqle)){
		   			   $NombreEmpresa = $dat['empresa'];
					}

					$sqla4="INSERT INTO recargassucursal (Sucursal, IdSucursal, Saldo) VALUES ('$NombreEmpresa',$id_sucursal,$NewCantVirtual)";
					mysql_query($sqla4) or die("Error al crear recargasucursal".mysql_error());

			    }
		

			$recarga_sql="INSERT INTO recarga (monto, numero, compania, estatus, id_sucursal, usuario, fecha_hora)
					VALUES ('$ccpago','$numero','$cod','s','$id_sucursal','$usuario',NOW())";
			mysql_query($recarga_sql);
			header('location:contado.php?tpagar='.$tpagar.'&ccpago='.$ccpago.'&factura='.$cfactura.'&tipo='.$tipo.'&rfc='.$clientrfc.'&numero='.$numero.'&confirm='.$confirm.'&nombrecliente='.$cliente);

}
?>